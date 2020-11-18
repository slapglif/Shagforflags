<?php

namespace App\Helper;

use Doctrine\Bundle\DoctrineBundle\Registry;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class User extends Helper{

    private $_doctrine;
    private $_container;
    private $_templating;
    private $userManager;
    private $tokenGenerator;
    private $tokenStorage;
    private $security;
    private $encoderFactory;

    public function __construct($container, $doctrine, EngineInterface $templating, UserManagerInterface $userManager, TokenGeneratorInterface $tokenGenerator, TokenStorageInterface $tokenStorage, Security $security, EncoderFactoryInterface $encoderFactory)
    {
        $this->_doctrine = $doctrine;
        $this->_container = $container;
        $this->_templating = $templating;
        $this->tokenGenerator = $tokenGenerator;
        $this->tokenStorage = $tokenStorage;
        $this->userManager = $userManager;
        $this->security = $security;
        $this->encoderFactory = $encoderFactory;

        return $this;
    }

    public function getActiveUser() {
        $user = $this->_container->get('security.token_storage')->getToken()->getUser();
        return $user;
    }

    public function getActiveUserRole() {
        $role = "";

        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $role = "ROLE_SUPER_ADMIN";

        }elseif ($this->security->isGranted('ROLE_ADMIN')) {
            $role = "ROLE_ADMIN";

        }elseif ($this->security->isGranted('ROLE_FULLUSER')) {
            $role = "ROLE_FULLUSER";

        }elseif ($this->security->isGranted('ROLE_USER')) {
            $role = "ROLE_USER";
        }

        return $role;
    }

    public function promoteUser($id, $role) {
        $user = $this->userManager->findUserBy(array("id" => $id));
        $user->addRole($role);
        $this->userManager->updateUser($user);

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->tokenStorage->setToken($token);

        return true;
    }

    public function checkUserConfirmation(){
        $user = $this->getActiveUser();
        if ($user->getConfirmed()) {
            return true;
        }
        return false;
    }

    public function resendConfirmation($email = "", $show_alert_message = true) {
        $quick_helper = $this->getHelper("quick");

        if ($email == "") {
            $user = $this->getActiveUser();
        }else {
            $user = $this->userManager->findUserByEmail($email);
        }

        if ($user->getConfirmed() == FALSE) {
            // Generate token and assign it to user
            $user->setConfirmationToken($this->tokenGenerator->generateToken());
            $this->userManager->updateUser($user);

            // Send mail
            $toEmail = $user->getEmail();
            $subject = "Account Activation";
            $template = 'Emails\register-confirmation.html.php';
            $params = array(
                'mail_title'    => "Account Activation",
                'conftoken'     => $user->getConfirmationToken()
            );
            $quick_helper->mail($toEmail, $subject, $template, $params);

            if ($show_alert_message == TRUE) {
                $quick_helper->addAlert("success", true, "We have sent a new activation link to your email address.");
            }
        }

        return true;
    }

    public function isUserLoggedIn() {
        if ($this->security->isGranted('ROLE_USER')) {
            return TRUE;
        }

        return FALSE;
    }

    public function existsAliasValidation($check_alias, $user_id) {
        $alias = $this->getDoctrine()
            ->getManager()
            ->createQueryBuilder()
            ->select("U.alias")
            ->from("App:User", "U")
            ->where("U.alias = '$check_alias'")
            ->andWhere("U.id != $user_id")
            ->getQuery()
            ->getResult();

        return $alias;
    }

    public function validPassword($username, $password) {
        $user = $this->userManager->findUserBy(['username' => $username]);
        $encoder = $this->encoderFactory->getEncoder($user);

        $bool = ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) ? true : false;
        return $bool;
    }

    public function updatePw($username, $password) {
        $user = $this->userManager->findUserBy(['username' => $username]);
        $user->setPlainPassword($password);

        $this->userManager->updateUser($user);

        return true;
    }

    public function updateProfilePhoto($id, $filename) {
        $user = $this->userManager->findUserBy(array("id" => $id));
        $user->setProfilePhoto($filename);
        $this->userManager->updateUser($user);

        return true;
    }

    public function removeProfilePhoto($id, $filename) {
        $user = $this->userManager->findUserBy(array("id" => $id));

        if ($user->getProfilePhoto() == $filename) {
            $user->setProfilePhoto("");
            $this->userManager->updateUser($user);

            return true;
        }else {
            return false;
        }
    }

    public function createFileHash($key, $ext, $hashnumber = "") {
        return md5(time() . $key . $hashnumber) . '.' . $ext;
    }

    public function getThumbPath($file_path, $size, $withFileName = true) {
        $file_name = $this->returnExplode($file_path, '/', "l");
        if ($withFileName) {
            return str_replace($file_name, "thumb-" . $size . "/" . $file_name, $file_path);
        }

        return str_replace($file_name, "thumb-" . $size, $file_path);
    }

    public function returnExplode($data, $delimiter, $pos = "f") {
        $var = explode($delimiter, $data);

        switch ($pos) {
            case "f":
            case "first":
                return $var[0];
                break;
            case "l":
            case "last":
                return end($var);
                break;
            default:
                return $var[$pos];
                break;
        }
    }

    public function getUserFromId($id){
        $user = $this->userManager->findUserBy(array("id" => $id));

        return $user;
    }

    public function calculateAge($date){
        $age = date_diff(date_create($date), date_create('today'))->y;

        return $age;
    }

    public function getProfilePhotoById($id) {
        $user = $this->getUserFromId($id);

        return $user->getProfilePhoto();
    }

    public function getName(){}

    /**
     * @return Registry
     */
    public function getDoctrine(){
        return $this->_doctrine;
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
