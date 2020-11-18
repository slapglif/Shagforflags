<?php

namespace App\Helper;

use App\Entity\Actionchips;
use App\Entity\Partners;
use App\Entity\Stories;
use App\Entity\StoryComments;
use App\Entity\StoryImages;
use App\Entity\StoryVotings;
use App\Repository\ActionchipsRepository;
use App\Repository\PartnersRepository;
use App\Repository\StoryCommentsRepository;
use App\Repository\StoryImagesRepository;
use App\Repository\StoryRepository;
use App\Repository\StoryVotingsRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Templating\Helper\Helper;

class Story extends Helper{

    private $_doctrine;

    private $_container;

    private $_templating;

    private $story_repository;
    private $story_images_repository;
    private $partners_repository;
    private $actionchips_repository;
    private $votings_repository;
    private $comments_repository;


    public function __construct($container, $doctrine, EngineInterface $templating, StoryRepository $story_repository, StoryImagesRepository $story_images_repository, PartnersRepository $partners_repository, ActionchipsRepository $actionchips_repository, StoryVotingsRepository $votings_repository, StoryCommentsRepository $comments_repository)
    {
        $this->_doctrine = $doctrine;
        $this->_container = $container;
        $this->_templating = $templating;

        $this->story_repository = $story_repository;
        $this->story_images_repository = $story_images_repository;
        $this->partners_repository = $partners_repository;
        $this->actionchips_repository = $actionchips_repository;

        $this->votings_repository = $votings_repository;
        $this->comments_repository = $comments_repository;

        return $this;
    }

    public function addStory($story_content) {
        $story = new Stories();
        $story->setUserId($story_content['user_id']);
        $story->setLocation($story_content['location']);
        $story->setCountry($story_content['country']);
        $story->setDate($story_content['date']);
        $story->setStory($story_content['story']);

        $entity_manager = $this->getEntityManager();
        $entity_manager->persist($story);
        $entity_manager->flush();

        return $story->getId();
    }

    public function addPartners($story_id, $partners) {
        $entity_manager = $this->getEntityManager();

        foreach ($partners as $partner) {
            $new_partner = new Partners();
            $new_partner->setStoryId($story_id);
            $new_partner->setName($partner['name']);
            $new_partner->setCountry($partner['country']);
            $new_partner->setGender($partner['gender']);
            $new_partner->setAges($partner['ages']);
            $new_partner->setShape($partner['shape']);
            $new_partner->setBirthcontrol($partner['birthcontrol']);
            $new_partner->setMet($partner['met']);
            $new_partner->setSexualOrientation($partner['sexorient']);

            $entity_manager->persist($new_partner);
            $entity_manager->flush();

            $new_partner_id = $new_partner->getId();
            foreach ($partner['actionchips'] as $actionchip) {
                $new_partner_actionchip = new Actionchips();
                $new_partner_actionchip->setPartnerId($new_partner_id);
                $new_partner_actionchip->setChip($actionchip);

                $entity_manager->persist($new_partner_actionchip);
            }
            $entity_manager->flush();
        }

        return TRUE;
    }

    public function addImages($story_id, $images) {
        $entity_manager = $this->getEntityManager();

        foreach ($images as $image) {
            $file_name = $image['serverFileName'];
            $file_path_actual = "build/files/upload/prestory/";
            $file_path_new = "build/files/upload/story/";

            if (file_exists($file_path_actual.$file_name)) {
                rename($file_path_actual.$file_name, $file_path_new.$file_name);

                $story_image = new StoryImages();
                $story_image->setStoryId($story_id);
                $story_image->setImageName($image['serverFileName']);
                $entity_manager->persist($story_image);
                $entity_manager->flush();
            }
        }
        return TRUE;
    }

    public function getStoriesPreviewQuery($filter, $user) {
        $stories = $this->story_repository->getStoriesPreview($filter, $user);

        return $stories;
    }

    public function getFlagFromCountry($country) {
        $search = array(" ", "'", "ô");
        $replace = array("-", "-", "o");

        // Lowercase and replace
        $country = str_replace($search, $replace, $country);

        return strtolower($country);
    }

    public function cutStoryContent($content) {
        $out = strlen($content) > 250 ? substr($content,0,250)."..." : $content;

        return $out;
    }

    public function getTimeDifference($time) {
        $time = $time->format("Y-m-d H:i:s");
        return $this->time_elapsed_string($time);
    }

    public function time_elapsed_string($datetime, $full = false) {
        $now = new \DateTime;
        $ago = new \DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function getPartners($story_id) {
        $partners = $this->partners_repository->findBy(array(
            'storyId' => $story_id
        ));

        if ($partners) {
            return $partners;
        }

        return FALSE;
    }

    public function getActionchips($partner_id) {
        $actionchips = $this->actionchips_repository->findBy(array(
            'partnerId' => $partner_id
        ));

        if ($actionchips) {
            return $actionchips;
        }

        return FALSE;
    }

    public function getPartnerFlags($story_id) {
        $partners = $this->getPartners($story_id);
        $flags = array(
            'flags'         => array(),
            'additional'    => 0
        );

        if ($partners) {
            $count = count($partners);
            for($i = 0; $i < $count; $i++) {
                $flags['flags'][] = $this->getFlagFromCountry($partners[$i]->getCountry());

                if ($i == 2) {
                    break;
                }
            }

            if($count > 3) {
                $flags['additional'] = $count - 3;
            }
        }

        return $flags;
    }

    public function getVotes($story_id) {
        $up_votes = $this->votings_repository->getStoryVotesUp($story_id);
        $down_votes = $this->votings_repository->getStoryVotesDown($story_id);

        return array(
            'up'    => $up_votes,
            'down'  => $down_votes
        );
    }

    public function existsVote($user_id, $story_id) {
        return $this->votings_repository->getVote($user_id, $story_id);
    }

    public function addChangeVote($user_id, $story_id, $vote) {
        $entity_manager = $this->getEntityManager();
        $data = "";

        $exists_vote = $this->existsVote($user_id, $story_id);
        if (!$exists_vote) {
            $add_vote = new StoryVotings();
            $add_vote->setUserId($user_id);
            $add_vote->setStoryId($story_id);
            $add_vote->setVote($vote);
            $entity_manager->persist($add_vote);
            $entity_manager->flush();

            $data = "added";

        }else {
            // Remove or change vote
            if ($exists_vote->getVote() == $vote) {
                $entity_manager->remove($exists_vote);
                $entity_manager->flush();

                $data = "removed";

            }else {
                $exists_vote->setVote($vote);
                $entity_manager->persist($exists_vote);
                $entity_manager->flush();

                $data = "changed";
            }
        }

        return $data;
    }

    public function addComment($user_id, $story_id, $comment) {
        $entity_manager = $this->getEntityManager();
        $new_comment = new StoryComments();
        $new_comment->setUserId($user_id);
        $new_comment->setStoryId($story_id);
        $new_comment->setComment($comment);
        $entity_manager->persist($new_comment);
        $entity_manager->flush();

        return $new_comment;
    }

    public function getCommentCount($story_id) {
        $comment_number = $this->comments_repository->getCommentCount($story_id);

        return $comment_number;
    }

    public function getStory($story_id) {
        $story = $this->story_repository->getStory($story_id);

        return $story;
    }

    public function getPhotos($story_id) {
        $photos = $this->story_images_repository->getPhotos($story_id);

        return $photos;
    }

    public function getStoryComments($story_id) {
        $comments = $this->comments_repository->getStoryComments($story_id);

        return $comments;
    }

    public function getName(){}

    /**
     * @return Registry
     */
    public function getDoctrine(){
        return $this->_doctrine;
    }

    public function getEntityManager(){
        return $this->getDoctrine()->getManager();
    }

    /**
     * @return Container
     */
    public function getContainer(){
        return $this->_container;
    }

    public function getHelper($name){
        return $this->getContainer()->get($name);
    }
}
