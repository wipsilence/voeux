<?php

namespace AV\ListeVoeuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Agent
 *
 * @ORM\Table(name="agent")
 * @ORM\Entity(repositoryClass="AV\ListeVoeuBundle\Repository\AgentRepository")
 */
class Agent extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="grade", type="string", length=255)
     */
    private $grade;

    /**
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Ville")
     */
    private $domicile;

    /**
     * @ORM\OneToMany(targetEntity="AV\ListeVoeuBundle\Entity\Liste", mappedBy="agent")
     */
    private $listes;

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
     * @return Agent
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Agent
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set grade
     *
     * @param string $grade
     *
     * @return Agent
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set domicile
     *
     * @param \AV\ListeVoeuBundle\Entity\Ville $domicile
     *
     * @return Agent
     */
    public function setDomicile(\AV\ListeVoeuBundle\Entity\Ville $domicile = null)
    {
        $this->domicile = $domicile;

        return $this;
    }

    /**
     * Get domicile
     *
     * @return \AV\ListeVoeuBundle\Entity\Ville
     */
    public function getDomicile()
    {
        return $this->domicile;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->listes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enabled = 't';
    }

    /**
     * Add liste
     *
     * @param \AV\ListeVoeuBundle\Entity\Liste $liste
     *
     * @return Agent
     */
    public function addListe(\AV\ListeVoeuBundle\Entity\Liste $liste)
    {
        $this->listes[] = $liste;

        return $this;
    }

    /**
     * Remove liste
     *
     * @param \AV\ListeVoeuBundle\Entity\Liste $liste
     */
    public function removeListe(\AV\ListeVoeuBundle\Entity\Liste $liste)
    {
        $this->listes->removeElement($liste);
    }

    /**
     * Get listes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListes()
    {
        return $this->listes;
    }
}
