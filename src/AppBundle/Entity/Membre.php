<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Membre
 */
class Membre
{
    /**
     * @var integer
     */
    private $idetudiant;

    /**
     * @var \AppBundle\Entity\Poste
     */
    private $idposte;


    /**
     * Get idetudiant
     *
     * @return integer 
     */
    public function getIdetudiant()
    {
        return $this->idetudiant;
    }

    /**
     * Set idposte
     *
     * @param \AppBundle\Entity\Poste $idposte
     * @return Membre
     */
    public function setIdposte(\AppBundle\Entity\Poste $idposte = null)
    {
        $this->idposte = $idposte;

        return $this;
    }

    /**
     * Get idposte
     *
     * @return \AppBundle\Entity\Poste 
     */
    public function getIdposte()
    {
        return $this->idposte;
    }
}
