<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 */
class Produit
{
    /**
     * @var string
     */
    private $nom;

    /**
     * @var float
     */
    private $prix;

    /**
     * @var float
     */
    private $prixadherent;

    /**
     * @var string
     */
    private $urlimage;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nom
     *
     * @param string $nom
     * @return Produit
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prix
     *
     * @param float $prix
     * @return Produit
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set prixadherent
     *
     * @param float $prixadherent
     * @return Produit
     */
    public function setPrixadherent($prixadherent)
    {
        $this->prixadherent = $prixadherent;

        return $this;
    }

    /**
     * Get prixadherent
     *
     * @return float 
     */
    public function getPrixadherent()
    {
        return $this->prixadherent;
    }

    /**
     * Set urlimage
     *
     * @param string $urlimage
     * @return Produit
     */
    public function setUrlimage($urlimage)
    {
        $this->urlimage = $urlimage;

        return $this;
    }

    /**
     * Get urlimage
     *
     * @return string 
     */
    public function getUrlimage()
    {
        return $this->urlimage;
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
}
