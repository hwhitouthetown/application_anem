<?php

namespace AppBundle\Entity;

/**
 * Stage
 */
class Stage
{
    /**
     * @var string
     */
    private $intitule;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $etat;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Entreprise
     */
    private $identreprise;

    /**
     * @var \AppBundle\Entity\User
     */
    private $idetudiant;

    private $competences;


    /**
     * Set intitule
     *
     * @param string $intitule
     *
     * @return Stage
     */
    public function setIntitule($intitule)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get intitule
     *
     * @return string
     */
    public function getIntitule()
    {
        return $this->intitule;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Stage
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
     * Set etat
     *
     * @param string $etat
     *
     * @return Stage
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
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
     * Set identreprise
     *
     * @param \AppBundle\Entity\Entreprise $identreprise
     *
     * @return Stage
     */
    public function setIdentreprise(\AppBundle\Entity\Entreprise $identreprise = null)
    {
        $this->identreprise = $identreprise;

        return $this;
    }

    /**
     * Get identreprise
     *
     * @return \AppBundle\Entity\Entreprise
     */
    public function getIdentreprise()
    {
        return $this->identreprise;
    }

    /**
     * Set idetudiant
     *
     * @param \AppBundle\Entity\User $idetudiant
     *
     * @return Stage
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

    /**
     * Gets the value of competences.
     *
     * @return mixed
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * Sets the value of competences.
     *
     * @param mixed $competences the competences
     *
     * @return self
     */
    public function setCompetences($competences)
    {
        $this->competences = $competences;

        return $this;
    }

    public function addCompetences(\AppBundle\Entity\Competences $competences)
    {
        $this->competences[] = $competences;
    }
}
