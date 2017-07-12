<?php

namespace AV\ListeVoeuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Residence
 *
 * @ORM\Table(name="residence_poste")
 * @ORM\Entity(repositoryClass="AV\ListeVoeuBundle\Repository\ResidencePosteRepository")
 */
class ResidencePoste
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Residence")
     */
    private $residence;
	
	
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Poste")
     */
    private $poste;
    
    /**
     * Constructor
     */
    public function __construct()
    {
    }
    /*
    public function __construct($residence, $poste)
    {
        $this->residence= $residence;
        $this->poste= $poste;
    }
    */

    /**
     * Set residence
     *
     * @param \AV\ListeVoeuBundle\Entity\Residence $residence
     *
     * @return ResidencePoste
     */
    public function setResidence(\AV\ListeVoeuBundle\Entity\Residence $residence = null)
    {
        $this->residence = $residence;

        return $this;
    }

    /**
     * Get residence
     *
     * @return \AV\ListeVoeuBundle\Entity\Residence
     */
    public function getResidence()
    {
        return $this->residence;
    }

    /**
     * Set poste
     *
     * @param \AV\ListeVoeuBundle\Entity\Poste $poste
     *
     * @return ResidencePoste
     */
    public function setPoste(\AV\ListeVoeuBundle\Entity\Poste $poste = null)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return \AV\ListeVoeuBundle\Entity\Poste
     */
    public function getPoste()
    {
        return $this->poste;
    }
}
