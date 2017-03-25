<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MailController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }
}