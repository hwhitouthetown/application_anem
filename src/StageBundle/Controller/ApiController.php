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
use AppBundle\Entity\Entreprise;



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

    public function postUpdateEntrepriseAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $entreprise = $em->getRepository('AppBundle:Entreprise')->findOneById(intval($request->get('id')));
      if (!isset($entreprise)) {
        $entreprise = new Entreprise();
      }
      $entreprise->setNom($request->get('nom'));
      $entreprise->setAdresse($request->get('adresse'));
      $entreprise->setNumtel($request->get('tel'));
      $em->persist($entreprise);
      $em->flush();
      $serializer = $this->container->get('serializer');
      return new Response($serializer->serialize($entreprise, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }
    public function getUserAction(){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:User');
      $users = $repository->findAll();
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($users, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }
    public function getStageAction(){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:Stage');
      $stages = $repository->findAll();
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($stages, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }

    public function getStagebyentrepriseAction($idEntreprise){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:Stage');
      $stages = $repository->findOneByIdentreprise((int) $idEntreprise);
      if ($stages == NULL) {
        $stages = array();
      }
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($stages, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }
}

