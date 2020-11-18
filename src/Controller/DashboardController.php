<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/dashboard")
 * @author Ali Gencer <a.e.gencer@hotmail.de>
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_homepage")
     */
    public function index(ContainerInterface $container) {
        $quick_helper = $container->get("quick");
        $user_helper = $container->get("user");
        $user = $user_helper->getActiveUser();

        // Redirect user to profile-edit page if profile is not confirmed
        if (!$user->getProfileConfirmed()) {
            $url = $this->container->get('router')->generate('profile_edit');
            return new RedirectResponse($url);
        }

        return $this->render('Dashboard/index.html.php');
    }
}