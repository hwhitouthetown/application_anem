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

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Entity\AccessToken;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Controller\SecurityController as FOSController;


/**
 * @Route("/api")
 */
class ApiController extends FOSController
{


 public function getIdByNameAction(Request $request){

  $repository = $this->getDoctrine()->getRepository('AppBundle:User');

  $identifiant = $request->get('username');

  // dynamic method names to find a single product based on a column value
  $user = $repository->findUserIdByUsername($identifiant);



  $serializer = $this->container->get('serializer');
  $reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);

  }  


  public function getLoginAction(Request $request){

    $response = ""; 

     $username = $request->get("username"); 
     $password = $request->get("password"); 

     
     $userManager = $this->get('fos_user.user_manager');
     $user = $userManager->createUser();
     $user = $userManager->findUserByUsername($username);

     if($user!=null){

        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($password, $user->getSalt());


        if($encoded_pass == $user->getPassword()){
          // Mot de passe ok, on génère un token // 

          $tokenObject = new AccessToken(); 
          $token = bin2hex(random_bytes(86));

          $tokenObject->setUser($user);

          $tokenObject->setToken($token);

          var_dump($tokenObject);
          $em = $this->getDoctrine()->getManager();
          $em->persist($tokenObject);
          $em->flush(); 


          $response = $token;   

        } else {
          $response = "Incorrect password";
        }

    
     } else {
       $response = "Unknow username"; 
     }

      return new JsonResponse($response,200);
  }


  public function getCheckIdentificationAction(Request $request){

    $token = $request->get('token');

  $repository = $this
  ->getDoctrine()
  ->getManager()
  ->getRepository('UserBundle:AccessToken');

    $statusCode = 200; 
    $response = "ok"; 
    $object = $repository->findOneByToken($token);

    if($object ==null){

      $statusCode = 406;
      $response = "invalid token";

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
      $user->setEnabled(false);
      $userManager->updateUser($user);

      $em = $this->getDoctrine()->getManager();
      $user = $em->getRepository('AppBundle:User')->findOneByUsername($username);

      $user->setNom($nom);
      $user->setPrenom($prenom);
      $user->setEnabled(false);
      $em->flush();

      // Envoi message // 
      
    $message = \Swift_Message::newInstance()
    ->setSubject('Confirmation demande création de compte')
    ->setFrom('donotreply@anem.com')
    ->setReplyTo('anemnantes@gmail.com')
    ->setTo($user->getEmail())
    ->setContentType('text/html')
    ->setBody('Chèr(e)'. $user->getPrenom() .' ton compte a bien été crée, il sera actif dès lors que les administrateurs auront validé ton inscription, tu receveras une confirmation d\'activation à cet e-mail');

      $response = $user->getEmail();
 
    if (! $this->get('mailer')->send($message)) {
    // Il y a eu un problème donc on traite l'erreur
      $response = ('Le mail n\'a pas pu être envoyé');
      $code = 500;
    }


    //EngineInterface $engine = $this->get('templating');
    }

 

    return new JsonResponse($response, $statusCode); 

  }  
}
