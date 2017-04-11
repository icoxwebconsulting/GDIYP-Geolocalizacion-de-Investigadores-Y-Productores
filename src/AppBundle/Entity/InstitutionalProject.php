<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InstitutionalProject
 *
 * @ORM\Table(name="institutional_project")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InstitutionalProjectRepository")
 */
class InstitutionalProject
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="population", type="text")
     */
    private $population;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="text")
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="articulations", type="text")
     */
    private $articulations;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;


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
     * Set type
     *
     * @param string $type
     *
     * @return InstitutionalProject
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set population
     *
     * @param string $population
     *
     * @return InstitutionalProject
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return string
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return InstitutionalProject
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set articulations
     *
     * @param string $articulations
     *
     * @return InstitutionalProject
     */
    public function setArticulations($articulations)
    {
        $this->articulations = $articulations;

        return $this;
    }

    /**
     * Get articulations
     *
     * @return string
     */
    public function getArticulations()
    {
        return $this->articulations;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return InstitutionalProject
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }
}
