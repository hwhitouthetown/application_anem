<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */ 
    private $nom;

    /*
     * @var string 
     */ 
    private $prenom;

    /*
     * @var string 
     */ 
    private $url;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

