<?php

namespace AV\ListeVoeuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Residence
 *
 * @ORM\Table(name="residence")
 * @ORM\Entity(repositoryClass="AV\ListeVoeuBundle\Repository\ResidenceRepository")
 */
class Residence
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;
        
    /**
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Direction")
     */

    private $direction;
	
	
    /**
     * @ORM\ManyToMany(targetEntity="AV\ListeVoeuBundle\Entity\Poste")
     */

    private $poste;
    
	/**
     * @ORM\OneToOne(targetEntity="AV\ListeVoeuBundle\Entity\Ville")
     */

    private $ville;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Residence
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
     * Constructor
     */
    public function __construct()
    {
        $this->poste = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set direction
     *
     * @param \AV\ListeVoeuBundle\Entity\Direction $direction
     *
     * @return Residence
     */
    public function setDirection(\AV\ListeVoeuBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \AV\ListeVoeuBundle\Entity\Direction
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Add poste
     *
     * @param \AV\ListeVoeuBundle\Entity\Poste $poste
     *
     * @return Residence
     */
    public function addPoste(\AV\ListeVoeuBundle\Entity\Poste $poste)
    {
        $this->poste[] = $poste;

        return $this;
    }

    /**
     * Remove poste
     *
     * @param \AV\ListeVoeuBundle\Entity\Poste $poste
     */
    public function removePoste(\AV\ListeVoeuBundle\Entity\Poste $poste)
    {
        $this->poste->removeElement($poste);
    }

    /**
     * Get poste
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set ville
     *
     * @param \AV\ListeVoeuBundle\Entity\Ville $ville
     *
     * @return Residence
     */
    public function setVille(\AV\ListeVoeuBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \AV\ListeVoeuBundle\Entity\Ville
     */
    public function getVille()
    {
        return $this->ville;
    }
}
