<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Knowledge
 *
 * @ORM\Table(name="knowledges")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KnowledgeRepository")
 */
class Knowledge
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="KnowledgeArea")
     * @ORM\JoinColumn(name="knowledge_area", referencedColumnName="id")
     */
    protected $knowledge_area;

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
     * Set name
     *
     * @param string $name
     *
     * @return Knowledge
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set knowledgeArea
     *
     * @param \AppBundle\Entity\KnowledgeArea $knowledgeArea
     *
     * @return Knowledge
     */
    public function setKnowledgeArea(\AppBundle\Entity\KnowledgeArea $knowledgeArea = null)
    {
        $this->knowledge_area = $knowledgeArea;

        return $this;
    }

    /**
     * Get knowledgeArea
     *
     * @return \AppBundle\Entity\KnowledgeArea
     */
    public function getKnowledgeArea()
    {
        return $this->knowledge_area;
    }
}
