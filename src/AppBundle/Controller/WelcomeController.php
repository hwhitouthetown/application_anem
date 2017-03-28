<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Welcome controller.
 *
 * @Route("/")
 */
class WelcomeController extends Controller
{

	  /**
     * Lists all User entities.
     *
     * @Route("/", name="welcome")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('base.html.twig');
    }


      /**
     * Lists all User entities.
     *
     * @Route("/redirect", name="forbidden")
     * @Method("GET")
     */
    public function redirectAction()
    {
        return $this->render('accessDenied.html.twig');
    }

}    
