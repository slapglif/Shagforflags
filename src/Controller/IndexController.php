<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 * @author Ali Gencer <a.e.gencer@hotmail.de>
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="frontend_homepage")
     */
    public function index(ContainerInterface $container) {
        #$quick_helper = $container->get("quick");

        return $this->render('Index/index.html.php');
    }

    /**
     * @Route("/access-denied", name="accessdenied")
     */
    public function accessDeniedAction() {
        return $this->render('Index/accessdenied.html.php');
    }

    /**
     * @Route("/already-confirmed", name="already_confirmed")
     */
    public function alreadyConfirmedAction() {
        return $this->render('Registration/already_confirmed.html.php');
    }

    /**
     * @Route("/terms-and-conditions", name="frontend_terms")
     */
    public function termsAction() {

        return $this->render('Index/terms.html.php');
    }

    /**
     * @Route("/privacy-policy", name="frontend_privacy")
     */
    public function privacyAction() {

        return $this->render('Index/privacy.html.php');
    }
}