<?php

namespace AppBundle\Entity;

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
     * @var \AppBundle\Entity\Promotion
     */
    private $idpromotion;

    /**
     * @var \AppBundle\Entity\User
     */
    private $idetudiant;


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
     * Set idpromotion
     *
     * @param \AppBundle\Entity\Promotion $idpromotion
     *
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

    /**
     * Set idetudiant
     *
     * @param \AppBundle\Entity\User $idetudiant
     *
     * @return Faireparti
     */
    public function setIdetudiant(\AppBundle\Entity\User $idetudiant = null)
    {
        $this->idetudiant = $idetudiant;

        return $this;
    }

    /**
     * Get idetudiant
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdetudiant()
    {
        return $this->idetudiant;
    }
}
