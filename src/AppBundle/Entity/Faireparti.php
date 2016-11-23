<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Faireparti
 */
class Faireparti
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Etudiant
     */
    private $idetudiant;

    /**
     * @var \AppBundle\Entity\Promotion
     */
    private $idpromotion;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idetudiant
     *
     * @param \AppBundle\Entity\Etudiant $idetudiant
     * @return Faireparti
     */
    public function setIdetudiant(\AppBundle\Entity\Etudiant $idetudiant = null)
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    /**
     * Get idetudiant
     *
     * @return \AppBundle\Entity\Etudiant 
     */
    public function getIdetudiant()
    {
        return $this->idetudiant;
    }

    /**
     * Set idpromotion
     *
     * @param \AppBundle\Entity\Promotion $idpromotion
     * @return Faireparti
     */
    public function setIdpromotion(\AppBundle\Entity\Promotion $idpromotion = null)
    {
        $this->idpromotion = $idpromotion;

        return $this;
    }

    /**
     * Get idpromotion
     *
     * @return \AppBundle\Entity\Promotion 
     */
    public function getIdpromotion()
    {
        return $this->idpromotion;
    }
}
