<?php

namespace ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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