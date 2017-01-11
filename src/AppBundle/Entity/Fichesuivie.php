<?php

namespace AppBundle\Entity;

/**
 * Fichesuivie
 */
class Fichesuivie
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $entreprise;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\User
     */
    private $idetudiant;


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Fichesuivie
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Fichesuivie
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set entreprise
     *
     * @param string $entreprise
     *
     * @return Fichesuivie
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise
     *
     * @return string
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

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
     * @param \AppBundle\Entity\User $idetudiant
     *
     * @return Fichesuivie
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
