<?php

namespace StageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('StageBundle:Default:index.html.twig');
    }
    public function getEntrepriseAction(){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:Entreprise');
      $entreprises = $repository->findAll();
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($entreprises, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }
}
