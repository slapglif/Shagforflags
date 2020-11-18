<?php

namespace App\Event;

use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $security;
    protected $container;
    protected $userManager;
    protected $tokenStorage;

    public function __construct(Router $router, AuthorizationChecker $security, Container $container, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage)
    {
        $this->router   = $router;
        $this->security = $security;
        $this->container = $container;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $user_helper = $this->container->get("user");
        $quick_helper = $this->container->get("quick");
        $user = $token->getUser();

        // Check if user has confirmed e-mail address
        if (!$user->getConfirmed()) {
            // Resend mail
            $user_helper->resendConfirmation($user->getEmail(), false);

            // Set message that mail has been sent
            $quick_helper->addAlert("warning", true, "Your e-mail address has not been confirmed. A new activation link has been sent to your e-mail address");

            // logout, if logged-in
            $this->tokenStorage->setToken(null);

            $redirect_path = "fos_user_security_login";

        // Check if user has requested to reset password
        }elseif($user->getPasswordRequestedAt()) {
            // Set message that mail has been sent
            $quick_helper->addAlert("warning", true, "An email has been sent to reset your password");

            // logout, if logged-in
            $this->tokenStorage->setToken(null);

            $redirect_path = "fos_user_security_login";

        }else {
            $redirect_path = "dashboard_homepage";
        }

        $response = new RedirectResponse($this->router->generate($redirect_path));
        return $response;
    }
}