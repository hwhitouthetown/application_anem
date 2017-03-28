<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use UserBundle\EntityManager\AccessToken;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;


class Security extends Controller
{


private $customRepository = null;


public function __construct(EntityRepository $customRepository) {
    $this->customerRepository = $customerRepository;
}


public function checkToken($token){


    $statusCode = "200"; 
    $response = "ok"; 
    $object =  $this->customerRepository->findOneByToken($token);

    if($object ==null){

      $statusCode = "406";
      $response = "invalid token";

    }
 
 return $statusCode; 

}



}

