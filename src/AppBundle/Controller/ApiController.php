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


use AppBundle\Entity\Message;

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

    public function postSendMessageAction(Request $request){
      $em = $this->getDoctrine()->getManager();
      $utilisateur = $em->getRepository('AppBundle:User')->findOneById(intval($request->get('idutilisateur')));
      $message = new Message();
      $message->setMessage($request->get('message'));
      $message->setDate(new \DateTime());
      $message->setIdetudiant($utilisateur);
      $em->persist($message);
      $em->flush();
      $serializer = $this->container->get('serializer');
      return new Response($serializer->serialize($utilisateur, 'json', SerializationContext::create()->enableMaxDepthChecks()));
    }  

    public function getMessageAction(){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:Message');
      $user = $repository->findAll();
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }   
}
