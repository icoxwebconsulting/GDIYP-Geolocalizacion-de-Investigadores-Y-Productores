<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PromotionGroup
 *
 * @ORM\Table(name="promotion_group")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PromotionGroupRepository")
 */
class PromotionGroup
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
     * @var array
     *
     * @ORM\Column(name="type", type="array", length=255, nullable=true)
     */
    private $type = null;

    /**
     * @var string
     *
     * @ORM\Column(name="modality", type="text", nullable=true)
     */
    private $modality = null;

    /**
     * @var string
     *
     * @ORM\Column(name="articulations", type="text", nullable=true)
     */
    private $articulations = null;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment = null;


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
     * @return PromotionGroup
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
     * Set modality
     *
     * @param string $modality
     *
     * @return PromotionGroup
     */
    public function setModality($modality)
    {
        $this->modality = $modality;

        return $this;
    }

    /**
     * Get modality
     *
     * @return string
     */
    public function getModality()
    {
        return $this->modality;
    }

    /**
     * Set articulations
     *
     * @param string $articulations
     *
     * @return PromotionGroup
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
     * @return PromotionGroup
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
