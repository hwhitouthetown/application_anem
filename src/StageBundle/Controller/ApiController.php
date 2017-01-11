<?php

namespace StageBundle\Controller;

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
 * @Route("/api/stage")
 */
class ApiController extends Controller
{
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