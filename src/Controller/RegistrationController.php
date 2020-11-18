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

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Util\TokenGenerator;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;

/**
 * Controller managing the registration.
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends Controller
{
    private $eventDispatcher;
    private $formFactory;
    private $userManager;
    private $tokenStorage;
    private $em;
    private $tokenGenerator;

    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager, TokenStorageInterface $tokenStorage, EntityManagerInterface $em, TokenGeneratorInterface $tokenGenerator)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
        $this->tokenGenerator = $tokenGenerator;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request, Security $security)
    {
        ##############################################
        # REDIRECT AFTER LOGIN
        ##############################################
        if ($security->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('dashboard_homepage');
        }

        $user_repository = $this->em->getRepository(User::class);
        $quick_helper = $this->container->get("quick");

        $user = $this->userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ('POST' === $request->getMethod()) {
            $post = $request->request->all();

            if(filter_var($post['user_registration_form']['email'], FILTER_VALIDATE_EMAIL)){
                # Check if user with equal email exists
                if($user_repository->findOneBy(array('email' => $post['user_registration_form']['email'])) == FALSE) {
                    # Check if passwords are correct
                    if($post['user_registration_form']['plainPassword']['first'] == $post['user_registration_form']['plainPassword']['second']) {
                        if (isset($post['policies'])) {
                            if ($form->isValid()) {
                                $event = new FormEvent($form, $request);
                                $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                                #===========================================
                                # generate TOKEN and set TOKEN
                                #===========================================
                                $user->setConfirmationToken($this->tokenGenerator->generateToken());

                                # Promote user to ROLE_USER
                                $user->addRole('ROLE_USER');
                                $user->setLocked(0);


                                $this->userManager->updateUser($user);

                                if (null === $response = $event->getResponse()) {
                                    $url = $this->container->get('router')->generate('frontend_homepage');
                                    $response = new RedirectResponse($url);
                                }

                                #$this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
                                #=================================
                                # Send Custom Mail
                                #=================================
                                $toEmail = $user->getEmail();
                                $subject = "Welcome to Shag For Flags";
                                $template = 'Emails\register-confirmation.html.php';
                                $params = array(
                                    'mail_title'    => "Welcome to Shag For Flags",
                                    'conftoken'     => $user->getConfirmationToken()
                                );
                                $quick_helper->mail($toEmail, $subject, $template, $params);

                                $request->getSession()->set("fos_user_send_confirmation_email/email", $user->getEmail());
                                $url = $this->container->get('router')->generate('fos_user_registration_check_email');
                                $response = new RedirectResponse($url);
                                return $response;

                            }else {
                                $quick_helper->addAlert("danger", true, "Something went wrong. Please contact our team!");
                            }
                        }else {
                            $quick_helper->addAlert("danger", true, 'You must agree to our "Terms & Conditions" and "Privacy Policy"');
                        }
                    }else {
                        $quick_helper->addAlert("danger", true, "You repeated the password incorrectly");
                    }
                }else {
                    $quick_helper->addAlert("danger", true, "E-mail is used by another user");
                }
            }else{
                $quick_helper->addAlert("danger", true, "Invalid email address");
            }
        }

        return $this->render('Registration/register.html.php', array(
            'form' => $form->createView(),
            'meta_title_controller' => 'Create Account',
            'meta_descr_controller' => 'Create Account',
            'meta_keys_controller' => 'Create Account'
        ));
    }

    /**
     * Tell the user to check their email provider.
     */
    public function checkEmailAction(Request $request)
    {
        $email = $request->getSession()->get('fos_user_send_confirmation_email/email');

        if (empty($email)) {
            return new RedirectResponse($this->generateUrl('fos_user_registration_register'));
        }

        $request->getSession()->remove('fos_user_send_confirmation_email/email');
        $user = $this->userManager->findUserByEmail($email);

        if (null === $user) {
            return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
        }

        return $this->render('Registration/check_email.html.php', array(
            'user' => $user
        ));
    }

    /**
     * Receive the confirmation token from user email provider, login the user.
     *
     * @param Request $request
     * @param string  $token
     *
     * @return Response
     */
    public function confirmAction(Request $request, $token)
    {
        $userManager = $this->userManager;

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            return new RedirectResponse($this->generateUrl('already_confirmed'));
            #throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setConfirmed(true);

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('dashboard_homepage');
            $response = new RedirectResponse($url);
        }

        $this->eventDispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    public function resendConfirmationAction(ContainerInterface $container, $email) {
        $user_helper = $container->get("user");
        $user_helper->resendConfirmation($email);

        return $this->redirectToRoute('fos_user_registration_check_email');
    }

    /**
     * Tell the user his account is now confirmed.
     */
    public function confirmedAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('Registration/confirmed.html.php');
    }

    /**
     * @return string|null
     */
    private function getTargetUrlFromSession(SessionInterface $session)
    {
        $key = sprintf('_security.%s.target_path', $this->tokenStorage->getToken()->getProviderKey());

        if ($session->has($key)) {
            return $session->get($key);
        }

        return null;
    }
}
