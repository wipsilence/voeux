<?php

namespace AV\ListeVoeuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voeu
 *
 * @ORM\Table(name="voeu")
 * @ORM\Entity(repositoryClass="AV\ListeVoeuBundle\Repository\VoeuRepository")
 */
class Voeu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="rang", type="integer", unique=false)
     */
    private $rang;
	
	/**
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Residence")
     */

    private $residence;
    
    /**
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Poste")
     */

    private $poste;

    
    /**
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Liste")
     */

    private $liste;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     *
     * @return Voeu
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return int
     */
    public function getRang()
    {
        return $this->rang;
    }
}

