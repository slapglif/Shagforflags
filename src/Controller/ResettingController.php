<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseNullableUserEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Mailer\MailerInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

/**
 * Controller managing the resetting of the password.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class ResettingController extends Controller
{
    private $eventDispatcher;
    private $formFactory;
    private $userManager;
    private $tokenGenerator;
    private $mailer;

    /**
     * @var int
     */
    private $retryTtl;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param FactoryInterface         $formFactory
     * @param UserManagerInterface     $userManager
     * @param TokenGeneratorInterface  $tokenGenerator
     * @param MailerInterface          $mailer
     * @param int                      $retryTtl
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenGeneratorInterface $tokenGenerator, MailerInterface $mailer, $retryTtl)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->mailer = $mailer;
        $this->retryTtl = $retryTtl;
    }

    /**
     * Request reset user password: show form.
     */
    public function requestAction(Security $security)
    {
        ##############################################
        # REDIRECT AFTER LOGIN
        ##############################################
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard_homepage');
        }

        return $this->render('Resetting/request.html.php');
    }

    /**
     * Request reset user password: submit form and send email.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function sendEmailAction(Request $request, Security $security)
    {
        ##############################################
        # REDIRECT AFTER LOGIN
        ##############################################
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard_homepage');
        }

        $quick_helper = $this->container->get("quick");
        $username = $request->request->get('username');

        $user = $this->userManager->findUserByUsernameOrEmail($username);

        $event = new GetResponseNullableUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        if (null === $user) {
            $quick_helper->addAlert("danger", true, "Invalid email address");
            return $this->render('Resetting/request.html.php');
        }

        if (!$user->getConfirmed()) {
            $quick_helper->addAlert("danger", true, "You need to activate your account to change your password. An email has already been sent to your email address.");
            return $this->render('Resetting/request.html.php');
        }

        if ($user->isPasswordRequestNonExpired($this->retryTtl)) {
            $quick_helper->addAlert("danger", true, "An email has already been sent to your email address.");
            return $this->render('Resetting/request.html.php');
        }

        if (!$user->isPasswordRequestNonExpired($this->retryTtl)) {
            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_REQUEST, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($this->tokenGenerator->generateToken());
            }

            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_CONFIRM, $event);

            if (null !== $event->getResponse()) {
                return $event->getResponse();
            }

            #=================================
            # Send Custom Mail
            #=================================
            $toEmail = $user->getEmail();
            $subject = 'Reset Password';
            $template = 'Emails\reset-pw.html.php';
            $params = array(
                'mail_title'    => "Reset Password",
                'conftoken'     => $user->getConfirmationToken()
            );
            $quick_helper->mail($toEmail, $subject, $template, $params);
            $user->setPasswordRequestedAt(new \DateTime());
            $this->userManager->updateUser($user);

            $event = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_SEND_EMAIL_COMPLETED, $event);

            $quick_helper->addAlert("success", true, "An email has been sent to your email address.");
            return $this->render('Resetting/request.html.php', array('pw_reset_email_send' => '1'));

            /*if (null !== $event->getResponse()) {
                return $event->getResponse();
            }*/
        }
        #return new RedirectResponse($this->generateUrl('fos_user_resetting_check_email', array('username' => $username)));
    }

    /**
     * Tell the user to check his email provider.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function checkEmailAction(Request $request)
    {
        # No need for this action on this project! Therefore redirect direct to homepage
        return $this->redirectToRoute('frontend_homepage');

        $username = $request->query->get('username');

        if (empty($username)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('fos_user_resetting_request'));
        }

        return $this->render('@FOSUser/Resetting/check_email.html.twig', array(
            'tokenLifetime' => ceil($this->retryTtl / 3600),
        ));
    }

    /**
     * Reset user password.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function resetAction(Request $request, $token, Security $security)
    {
        ##############################################
        # REDIRECT AFTER LOGIN
        ##############################################
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard_homepage');
        }

        $quick_helper = $this->container->get("quick");
        $user = $this->userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
        }

        $event = new GetResponseUserEvent($user, $request);

        $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::RESETTING_RESET_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('dashboard_homepage');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(
                FOSUserEvents::RESETTING_RESET_COMPLETED,
                new FilterUserResponseEvent($user, $request, $response)
            );

            return $response;
        }elseif($form->isSubmitted() && !$form->isValid()) {
            $quick_helper->addAlert("danger", true, "You repeated the password incorrectly");
        }

        return $this->render('Resetting/reset.html.php', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
}
