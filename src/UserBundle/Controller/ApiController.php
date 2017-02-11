<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use JMS\Serializer\SerializationContext;


use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\OAuthServerBundle\Model;


use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{


    public function getDemosAction()
    {
        $data = array("hello" => "world");
        $view = $this->view($data);
        return $this->handleView($view);
    }


 public function getIdByNameAction(Request $request){

  $repository = $this->getDoctrine()->getRepository('AppBundle:User');

  $identifiant = $request->get('username');

  // dynamic method names to find a single product based on a column value
  $user = $repository->findUserIdByUsername($identifiant);



  $serializer = $this->container->get('serializer');
  $reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);

  }  

  public function getCheckClientIdentificationAction(Request $request){


  $repository = $this->getDoctrine()->getRepository('UserBundle:Client');
  $identifiant = $request->get('identifiant');
  $random_id = $request->get('random');
  $secret = $request->get('secret');

  $response = "ok"; 
  $statusCode = "200";

  $client = $repository->findOneById($identifiant);

  if($client == null){
     $response = "Invalid client informations";
     $statusCode = 206; 
  } else {

    if($client->getRandomId() == $random_id && $client->getSecret() == $secret){
      $response = "ok"; 
    } else {

     $response = "Invalid client informations ";
     $statusCode = 206; 

    }

  }

  return new JsonResponse($response, $statusCode);
  }  


 public function postRegisterAction(Request $request){

    $response = "Ok";
    $statusCode = 200; 

    $username = $request->get('username');
    $password = $request->get('password');
    $nom = $request->get('nom');
    $prenom = $request->get('prenom');


    $userManager = $this->get('fos_user.user_manager');
    $entityManager = $this->get('doctrine')->getManager();

    // Do a check for existing user with userManager->findByUsername
    if($userManager->findUserByUsername($username)!=null){
      $response = "User already exists"; 
      $statusCode = 469; 
    } else {
      $user = $userManager->createUser();
      $user->setUsername($username);
      $user->setEmail($username);
      $user->setPlainPassword($password);
      $user->setEnabled(true);
      $userManager->updateUser($user);
    } 

    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('AppBundle:User')->findOneByUsername($username);

    $user->setNom($nom);
    $user->setPrenom($prenom);
    $em->flush();



    return new JsonResponse($response, $statusCode); 

  }  



  public function getClientIdentificationAction(){


  $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
  $client = $clientManager->createClient();
  $client->setRedirectUris(array('http://www.example.com'));
  $client->setAllowedGrantTypes(array('token', 'authorization_code','password'));
  $clientManager->updateClient($client);


   $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($client, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);

  }  



  


  protected function generateToken($user, $statusCode = 200)
  {
      // Generate the token
      $token = $this->get('lexik_jwt_authentication.jwt_manager')->create($user);

      $response = array(
          'token' => $token,
          'user'  => $user // Assuming $user is serialized, else you can call getters manually
      );

      return new JsonResponse($response, $statusCode); // Return a 201 Created with the JWT.
  }


}
