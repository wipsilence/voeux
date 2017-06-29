<?php

namespace AV\ListeVoeuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Liste
 *
 * @ORM\Table(name="liste")
 * @ORM\Entity(repositoryClass="AV\ListeVoeuBundle\Repository\ListeRepository")
 */
class Liste
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

	/**
     * @ORM\ManyToOne(targetEntity="AV\ListeVoeuBundle\Entity\Agent", inversedBy="listes")
     */
    private $agent;

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
     * @return Liste
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
     * Set agent
     *
     * @param \AV\ListeVoeuBundle\Entity\Agent $agent
     *
     * @return Liste
     */
    public function setAgent(\AV\ListeVoeuBundle\Entity\Agent $agent = null)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get agent
     *
     * @return \AV\ListeVoeuBundle\Entity\Agent
     */
    public function getAgent()
    {
        return $this->agent;
    }
}
