<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Route("/story")
 * @author Ali Gencer <a.e.gencer@hotmail.de>
 */
class StoryController extends AbstractController
{
    /**
     * @Route("/", name="story_feed")
     */
    public function index(ContainerInterface $container, Request $request, PaginatorInterface $paginator) {
        $quick_helper = $container->get("quick");
        $user_helper = $container->get("user");
        $story_helper = $container->get("story");

        $user = $user_helper->getActiveUser();

        $stories = $story_helper->getStoriesPreviewQuery("worldwide", $user);
        $pagination = $paginator->paginate($stories, 1, 5);

        return $this->render('Story/index.html.php', array(
            'user'          => $user,
            'pagination'    => $pagination
        ));
    }

    /**
     * @Route("/load-more", methods={"POST"}, name="story_load_more")
     */
    public function loadMoreAction(Request $request, ContainerInterface $container, PaginatorInterface $paginator) {
        if(!$request->isXmlHttpRequest() || !strstr($_SERVER['HTTP_HOST'], 'shagforflags')){
            throw new AccessDeniedException('Access Denied');
        }
        $user_helper = $container->get("user");
        $story_helper = $container->get("story");

        $user = $user_helper->getActiveUser();

        $page_number = intval($request->get('page'));
        $page_number = $page_number + 1;

        $filter = htmlspecialchars(strip_tags($request->get('filter')));

        $stories = $story_helper->getStoriesPreviewQuery($filter, $user);
        $pagination = $paginator->paginate($stories, $page_number, 5);

        $data = array();
        if ($pagination->getItems()) {
            foreach ($pagination->getItems() as $item) {
                $reporter_data = $user_helper->getUserFromId($item->getUserId());

                $votes = $story_helper->getVotes($item->getId());
                $exists_vote = $story_helper->existsVote($user->getId(), $item->getId());
                $user_vote = '';
                if ($exists_vote) {
                    if ($exists_vote->getVote() == '1') {
                        $user_vote = 'up';
                    }else if($exists_vote->getVote() == '0') {
                        $user_vote = 'down';
                    }
                }
                $comments = $story_helper->getCommentCount($item->getId());

                $items[] = array(
                    'id'        => $item->getId(),
                    'userId'    => $item->getUserId(),
                    'location'  => $item->getLocation(),
                    'country'   => $item->getCountry(),
                    'date'      => $item->getDate()->format("Y-m-d H:i:s"),
                    'story'     => $story_helper->cutStoryContent($item->getStory()),
                    'created'   => $item->getCreated()->format("Y-m-d H:i:s"),

                    'countryFlag'  => '/build/images/flags-big/' . $story_helper->getFlagFromCountry($item->getCountry()) . '.png',
                    'storyTime'    => $story_helper->getTimeDifference($item->getCreated()),
                    'partnerFlags' => $story_helper->getPartnerFlags($item->getId()),

                    'reporter'  => array(
                        'flag'      => '/build/images/flags-big/' . $story_helper->getFlagFromCountry($reporter_data->getCountry()) . '.png',
                        'name'      => $reporter_data->getAlias(),
                        'country'   => $reporter_data->getCountry(),
                        'gender'    => $reporter_data->getGender(),
                        'age'       => $user_helper->calculateAge($reporter_data->getBirthdate()),
                        'orient'    => $reporter_data->getSexorient()
                    ),

                    'votes'     => array(
                        'up'    => $votes['up'],
                        'down'  => $votes['down'],
                        'vote'  => $user_vote
                    ),

                    'comments'  => $comments
                );
            }

            $data = array(
                'items' => $items,
                'page'  => $page_number
            );

            echo json_encode($data);
            exit();
        }

        echo 'false';
        exit();
    }

    /**
     * @Route("/vote", methods={"POST"}, name="story_vote")
     */
    public function voteAction(Request $request, ContainerInterface $container) {
        if(!$request->isXmlHttpRequest() || !strstr($_SERVER['HTTP_HOST'], 'shagforflags')){
            throw new AccessDeniedException('Access Denied');
        }
        $user_helper = $container->get("user");
        $story_helper = $container->get("story");

        $user = $user_helper->getActiveUser();

        $feed_id = intval($request->get('nr'));
        $vote = intval($request->get('vote'));

        $vote_status = $story_helper->addChangeVote($user->getId(), $feed_id, $vote);

        echo $vote_status;
        exit();
    }

    /**
     * @Route("/add-comment", methods={"POST"}, name="story_add_comment")
     */
    public function addCommentAction(Request $request, ContainerInterface $container) {
        if(!$request->isXmlHttpRequest() || !strstr($_SERVER['HTTP_HOST'], 'shagforflags')){
            throw new AccessDeniedException('Access Denied');
        }
        $user_helper = $container->get("user");
        $story_helper = $container->get("story");

        $user = $user_helper->getActiveUser();

        $feed_id = intval($request->get('nr'));
        $comment = htmlspecialchars(strip_tags($request->get('comment')));

        $data = $story_helper->addComment($user->getId(), $feed_id, $comment);
        if ($data) {
            $now = new \DateTime;

            $user_photo = $user->getProfilePhoto();
            if ($user_photo) {
                $photo = '/build/files/upload/user/thumb-265/'.$user_photo;
            }else {
                $photo = '/build/images/profile/placeholder.png';
            }

            $data_array = array(
                'photo'     => $photo,
                'comment'   => $data->getComment(),
                'created'   => $now->format("Y-m-d")
            );

            echo json_encode($data_array);
            exit();
        }

        echo 'false';
        exit();
    }

    /**
     * @Route("/create-story", name="story_create")
     */
    public function createStoryAction(ContainerInterface $container, Request $request) {
        $quick_helper = $container->get("quick");
        $user_helper = $container->get("user");

        $user = $user_helper->getActiveUser();

        // Get Onboarding-Cookie
        $cookie_name = 'onboarding-' . $user->getId();
        $cookie_hash = md5($user->getId());
        $onboarding_cookie = $request->cookies;
        if ($onboarding_cookie->has($cookie_name) && $onboarding_cookie->get($cookie_name) == $cookie_hash) {
            $onboarding_cookie = TRUE;
        }else {
            $onboarding_cookie = FALSE;
        }

        $flags_url = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . '/build/images/flags';
        return $this->render('Story/create.html.php', array(
            'user'          => $user,
            'flags_url'     => $flags_url,
            'onboarding'    => $onboarding_cookie
        ));
    }

    /**
     * @Route("/add-story", methods={"POST"}, name="story_add")
     */
    public function createStoryFunctionAction(Request $request, ContainerInterface $container) {
        if(!$request->isXmlHttpRequest() || !strstr($_SERVER['HTTP_HOST'], 'shagforflags')){
            throw new AccessDeniedException('Access Denied');
        }

        $error = 0;

        $step_1 = json_decode($_POST['step_1'], true);
        foreach ($step_1 as $key => $value) {
            if (empty($value)) {
                $error = $error + 1;
            }else {
                $step_1[$key] = htmlspecialchars(strip_tags($value));
            }
        }

        $step_2 = json_decode($_POST['step_2'], true);
        $partners = array();
        foreach ($step_2 as $partner) {
            foreach ($partner as $key => $value) {
                if ($key != "actionchips") {
                    if (empty($value)) {
                        $error = $error + 1;
                    }else {
                        $partner[$key] = htmlspecialchars(strip_tags($value));
                    }
                }else {
                    if (empty($partner["actionchips"])) {
                        $error = $error + 1;
                    }
                }
            }
            $partners[] = $partner;
        }

        $step_3 = json_decode($_POST['step_3'], true);
        foreach ($step_3 as $key => $value) {
            if (empty($value)) {
                $error = $error + 1;
            }else {
                $step_3[$key] = htmlspecialchars(strip_tags($value));
            }
        }

        if ($error == 0) {
            $story_helper = $container->get("story");
            $user_helper = $container->get("user");
            $user = $user_helper->getActiveUser();

            $story = array(
                'user_id'   => $user->getId(),
                'location'  => $step_1['location'],
                'country'   => $step_1['country'],
                'date'      => new \DateTime($step_1['date']),
                'story'     => $step_3['story']
            );
            // Add Story
            $story_id = $story_helper->addStory($story);

            // Add Partners to Story
            $story_helper->addPartners($story_id, $partners);

            // Add Images (if exists) to Story
            $step_4 = json_decode($_POST['step_4'], true);
            if (!empty($step_4)) {
                $story_helper->addImages($story_id, $step_4);
            }
            echo 'true';
        }
        exit();
    }

    /**
     * @Route("/detail/{story_id}", name="story_feed_detail")
     */
    public function detailAction(ContainerInterface $container, Request $request, $story_id) {
        $user_helper = $container->get("user");
        $story_helper = $container->get("story");

        $story_id = intval($story_id);
        if (!$story_id) {
            throw new AccessDeniedException();
        }

        $story = $story_helper->getStory($story_id);
        if (!$story) {
            throw new AccessDeniedException();
        }


        $user = $user_helper->getActiveUser();

        return $this->render('Story/detail.html.php', array(
            'user'  => $user,
            'story' => $story
        ));
    }

    /**
     * @Route("/close-onboard", methods={"POST"}, name="story_close_onboard")
     */
    public function closeOnboardAction(Request $request, ContainerInterface $container) {
        if(!$request->isXmlHttpRequest() || !strstr($_SERVER['HTTP_HOST'], 'shagforflags')){
            throw new AccessDeniedException('Access Denied');
        }

        $user_helper = $container->get("user");
        $user = $user_helper->getActiveUser();

        // Set Cookie
        $response = new Response();
        $cookie_name = 'onboarding-' . $user->getId();
        $response->headers->setCookie(Cookie::create($cookie_name, md5($user->getId()), time() + 31536000));
        $response->send();

        echo 'true';
        exit();
    }
}