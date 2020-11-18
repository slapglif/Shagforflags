<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/profile")
 * @author Ali Gencer <a.e.gencer@hotmail.de>
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile_view")
     */
    public function index(ContainerInterface $container) {
        $quick_helper = $container->get("quick");
        $user_helper = $container->get("user");

        $user = $user_helper->getActiveUser();

        return $this->render('Profile/index.html.php', array(
            'user'  => $user
        ));
    }

    /**
     * @Route("/edit", name="profile_edit")
     */
    public function editAction(ContainerInterface $container, Request $request, UserManagerInterface $userManager) {
        $quick_helper = $container->get("quick");
        $user_helper = $container->get("user");
        $user = $user_helper->getActiveUser();

        if ($request->getMethod() == 'POST') {
            $post = $request->request->all();

            $error = 0;
            foreach ($post as $key => $item) {
                if (empty($item)) {
                    $error = $error + 1;
                }else {
                    $post[$key] = htmlspecialchars(strip_tags($item));
                }
            }

            if ($error == 0) {
                // Check if user is saving an alias for first time
                $save_alias = FALSE;
                if (!$user->getAlias()) {
                    // Check if alias used by another user
                    $new_alias = $post['form_alias'];
                    if ($user_helper->existsAliasValidation($new_alias, $user->getId())) {
                        $error = $error + 1;
                    }else {
                        $save_alias = TRUE;
                    }
                }

                if ($error == 0) {
                    // Age +18 check
                    if ($quick_helper->checkAgeValidation(18, $post['form_birth'])) {
                        // Promote user to ROLE_FULLUSER
                        if ($user_helper->getActiveUserRole() == "ROLE_USER") {
                            $user_helper->promoteUser($user->getId(), "ROLE_FULLUSER");
                        }

                        // Make profile_confirmed = 1
                        if (!$user->getProfileConfirmed()) {
                            $user->setProfileConfirmed("1");
                        }

                        if($save_alias == TRUE){
                            $user->setAlias($post['form_alias']);
                        }

                        $user->setName($post['form_name']);
                        $user->setBirthdate($post['form_birth']);
                        $user->setCountry($post['form_country']);
                        $user->setLocation($post['form_location']);
                        $user->setGender($post['form_gender']);
                        $user->setSexorient($post['form_sexorient']);

                        $userManager->updateUser($user);
                        $quick_helper->addAlert("success", true, "Profile has been successfully saved");

                        //$url = $this->container->get('router')->generate('profile_view');
                        //return new RedirectResponse($url);

                    }else {
                        $quick_helper->addAlert("danger", true, "Selected age must be 18 or above");
                    }

                }else {
                    $quick_helper->addAlert("danger", true, "Alias <strong>$new_alias</strong> is already in use");
                }
            }else {
                $quick_helper->addAlert("danger", true, "Please fill all fields");
            }
        }

        $flags_url = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . '/build/images/flags';
        $selected_country = $user->getCountry();
        return $this->render('Profile/edit.html.php', array(
            'user'              => $user,
            'flags_url'         => $flags_url,
            'selected_country'  => $selected_country
        ));
    }

    /**
     * @Route("/alias-check", methods={"POST"}, name="profile_alias_check")
     */
    public function aliasCheckAction(Request $request, ContainerInterface $container)
    {
        if(!$request->isXmlHttpRequest() || !strstr($_SERVER['HTTP_HOST'], 'shagforflags')){
            throw new AccessDeniedException('Access Denied');
        }

        $alias = htmlspecialchars(strip_tags($_POST['alias']));
        if (!empty($alias)) {
            $user_helper = $container->get("user");
            $user = $user_helper->getActiveUser();

            if($user_helper->existsAliasValidation($alias, $user->getId())) {
                echo "true";
            }else {
                echo "false";
            }
        }
        exit();
    }

    /**
     * @Route("/change-password", name="profile_change_password")
     */
    public function changePasswordAction(ContainerInterface $container, Request $request, UserManagerInterface $userManager) {
        $quick_helper = $container->get("quick");
        $user_helper = $container->get("user");
        $user = $user_helper->getActiveUser();

        if ($request->getMethod() == 'POST') {
            $post = $request->request->all();

            $error = 0;
            foreach ($post as $key => $item) {
                if (empty($item)) {
                    $error = $error + 1;
                }else {
                    $post[$key] = htmlspecialchars(strip_tags($item));
                }
            }

            if ($error == 0) {
                $old_pw = $post['form_old_pw'];
                $new_pw = $post['form_new_pw'];
                $confirm_new_pw = $post['form_confirm_new_pw'];

                // Check if password is valid
                if ($user_helper->validPassword($user->getUsername(), $old_pw)) {
                    // Check if new-password and new-password-confirmation is equal
                    if ($new_pw == $confirm_new_pw) {
                        // Update new password
                        $user_helper->updatePw($user->getUsername(), $new_pw);

                        $quick_helper->addAlert("success", true, "Password has been successfully changed");

                        $url = $this->container->get('router')->generate('profile_view');
                        return new RedirectResponse($url);

                    }else {
                        $quick_helper->addAlert("danger", true, "You repeated the password incorrectly");
                    }

                }else {
                    $quick_helper->addAlert("danger", true, "Current password incorrect");
                }
            }else {
                $quick_helper->addAlert("danger", true, "Please fill all fields");
            }
        }

        return $this->render('Profile/change-password.html.php', array(
            'user'              => $user
        ));
    }
}