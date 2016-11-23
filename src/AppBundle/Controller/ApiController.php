<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use JMS\Serializer\SerializationContext;




/**
 * @Route("/api")
 */
class ApiController extends Controller
{

    public function getContenuAction(){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:Contenu');
      $user = $repository->findAll();
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }

    public function getContenAction($id){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:Contenu');
      $user = $repository->findById($id);
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }

    
}
