<?php

namespace AppBundle\Entity;

/**
 * Commande
 */
class Commande
{
    /**
     * @var \DateTime
     */
    private $dateachat;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Produit
     */
    private $idproduit;

    /**
     * @var \AppBundle\Entity\User
     */
    private $idutilisateur;


    /**
     * Set dateachat
     *
     * @param \DateTime $dateachat
     *
     * @return Commande
     */
    public function setDateachat($dateachat)
    {
        $this->dateachat = $dateachat;

        return $this;
    }

    /**
     * Get dateachat
     *
     * @return \DateTime
     */
    public function getDateachat()
    {
        return $this->dateachat;
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
     * Set idproduit
     *
     * @param \AppBundle\Entity\Produit $idproduit
     *
     * @return Commande
     */
    public function setIdproduit(\AppBundle\Entity\Produit $idproduit = null)
    {
        $this->idproduit = $idproduit;

        return $this;
    }

    /**
     * Get idproduit
     *
     * @return \AppBundle\Entity\Produit
     */
    public function getIdproduit()
    {
        return $this->idproduit;
    }

    /**
     * Set idutilisateur
     *
     * @param \AppBundle\Entity\User $idutilisateur
     *
     * @return Commande
     */
    public function setIdutilisateur(\AppBundle\Entity\User $idutilisateur = null)
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }

    /**
     * Get idutilisateur
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdutilisateur()
    {
        return $this->idutilisateur;
    }
}
