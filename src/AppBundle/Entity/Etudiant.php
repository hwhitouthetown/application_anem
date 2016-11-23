<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etudiant
 */
class Etudiant
{
    /**
     * @var string
     */
    private $numetudiant;

    /**
     * @var integer
     */
    private $idutilisateur;


    /**
     * Set numetudiant
     *
     * @param string $numetudiant
     * @return Etudiant
     */
    public function setNumetudiant($numetudiant)
    {
        $this->numetudiant = $numetudiant;

        return $this;
    }

    /**
     * Get numetudiant
     *
     * @return string 
     */
    public function getNumetudiant()
    {
        return $this->numetudiant;
    }

    /**
     * Get idutilisateur
     *
     * @return integer 
     */
    public function getIdutilisateur()
    {
        return $this->idutilisateur;
    }
}
