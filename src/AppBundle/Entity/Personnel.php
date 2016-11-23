<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Personnel
 */
class Personnel
{
    /**
     * @var integer
     */
    private $idpersonnel;


    /**
     * Get idpersonnel
     *
     * @return integer 
     */
    public function getIdpersonnel()
    {
        return $this->idpersonnel;
    }
}
