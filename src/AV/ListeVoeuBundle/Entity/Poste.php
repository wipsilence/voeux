<?php

namespace AV\ListeVoeuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poste
 *
 * @ORM\Table(name="poste")
 * @ORM\Entity(repositoryClass="AV\ListeVoeuBundle\Repository\PosteRepository")
 */
class Poste
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
     * @ORM\Column(name="nom", type="text", length=255, unique=true)
     */
    private $nom;

    /**
     * @ORM\ManyToMany(targetEntity="AV\ListeVoeuBundle\Entity\Qualification")
     */

    private $qualification;


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
     * @return Poste
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return text
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set qualification
     *
     * @param \AV\ListeVoeuBundle\Entity\Qualification $qualification
     *
     * @return Poste
     */
    public function setQualification(\AV\ListeVoeuBundle\Entity\Qualification $qualification = null)
    {
        $this->qualification = $qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return \AV\ListeVoeuBundle\Entity\Qualification
     */
    public function getQualification()
    {
        return $this->qualification;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->qualification = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add qualification
     *
     * @param \AV\ListeVoeuBundle\Entity\Qualification $qualification
     *
     * @return Poste
     */
    public function addQualification(\AV\ListeVoeuBundle\Entity\Qualification $qualification)
    {
        $this->qualification[] = $qualification;

        return $this;
    }

    /**
     * Remove qualification
     *
     * @param \AV\ListeVoeuBundle\Entity\Qualification $qualification
     */
    public function removeQualification(\AV\ListeVoeuBundle\Entity\Qualification $qualification)
    {
        $this->qualification->removeElement($qualification);
    }
}
