<?php

namespace AppBundle\Entity;

/**
 * Message
 */
class Message
{
 /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $message;

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
     * @return Message
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
     * Set Message
     *
     * @param string $message
     *
     * @return Stage
     */
    public function setMessage($message)
    {
        $this->intitule = $intitule;

        return $this;
    }

    /**
     * Get Message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
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
}
