<?php

namespace ShopBundle\Controller;

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
 * @Route("/api/shop")
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShopBundle:Default:index.html.twig');
    }

    public function getProduitAction(){
		$repository = $this
		->getDoctrine()
		->getManager()
		->getRepository('AppBundle:Produit');
		$user = $repository->findAll();
		$serializer = $this->container->get('serializer');
		$reports = $serializer->serialize($user, 'json', SerializationContext::create()->enableMaxDepthChecks());
		return new Response($reports);
    }
}
