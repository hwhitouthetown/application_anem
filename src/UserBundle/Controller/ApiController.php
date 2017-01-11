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


  public function postRegisterAction(Request $request)
  {
    $userManager = $this->get('fos_user.user_manager');
    $entityManager = $this->get('doctrine')->getManager();
    $data = $request->request->all();

    // Do a check for existing user with userManager->findByUsername

    $user = $userManager->createUser();
    $user->setUsername($data['username']);
    // ...
    $user->setPlainPassword($data['password']);
    $user->setEnabled(true);

    $userManager->updateUser($user);

    return $this->generateToken($user, 201);
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


  public function postUserAction(\Symfony\Component\HttpFoundation\Request $request) {


        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new \FOS\UserBundle\Event\GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(\FOS\UserBundle\FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new \FOS\UserBundle\Event\FormEvent($form, $request);
            $dispatcher->dispatch(\FOS\UserBundle\FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new \Symfony\Component\HttpFoundation\RedirectResponse($url);
            }

            $dispatcher->dispatch(\FOS\UserBundle\FOSUserEvents::REGISTRATION_COMPLETED, new \FOS\UserBundle\Event\FilterUserResponseEvent($user, $request, $response));

            $view = $this->view(array('token' => $this->get("lexik_jwt_authentication.jwt_manager")->create($user)), Codes::HTTP_CREATED);

            return $this->handleView($view);
        }

        $view = $this->view($form, Codes::HTTP_BAD_REQUEST);
        return $this->handleView($view);
    }


    public function postLogInAction(){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:User');
      $user = $repository->findAll();
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }
    
    public function postLogOutAction(){
      $repository = $this
      ->getDoctrine()
      ->getManager()
      ->getRepository('AppBundle:User');
      $user = $repository->findAll();
      $serializer = $this->container->get('serializer');
      $reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
      return new Response($reports);
    }
}
