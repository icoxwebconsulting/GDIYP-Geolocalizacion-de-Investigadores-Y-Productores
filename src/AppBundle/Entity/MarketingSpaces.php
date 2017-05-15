<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarketingSpaces
 *
 * @ORM\Table(name="marketing_spaces")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarketingSpacesRepository")
 */
class MarketingSpaces
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
     * @ORM\Column(name="marketWhereSold", type="array", length=255, nullable=true)
     */
    private $marketWhereSold = null;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="array", length=255, nullable=true)
     */
    private $type = null;

    /**
     * @var string
     *
     * @ORM\Column(name="periodicity", type="array", length=255, nullable=true)
     */
    private $periodicity = null;

    /**
     * @var string
     *
     * @ORM\Column(name="peopleInvolved", type="string", length=255, nullable=true)
     */
    private $peopleInvolved = null;

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
     * Set marketWhereSold
     *
     * @param string $marketWhereSold
     *
     * @return MarketingSpaces
     */
    public function setMarketWhereSold($marketWhereSold)
    {
        $this->marketWhereSold = $marketWhereSold;

        return $this;
    }

    /**
     * Get marketWhereSold
     *
     * @return string
     */
    public function getMarketWhereSold()
    {
        return $this->marketWhereSold;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return MarketingSpaces
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
     * Set periodicity
     *
     * @param string $periodicity
     *
     * @return MarketingSpaces
     */
    public function setPeriodicity($periodicity)
    {
        $this->periodicity = $periodicity;

        return $this;
    }

    /**
     * Get periodicity
     *
     * @return string
     */
    public function getPeriodicity()
    {
        return $this->periodicity;
    }

    /**
     * Set peopleInvolved
     *
     * @param string $peopleInvolved
     *
     * @return MarketingSpaces
     */
    public function setPeopleInvolved($peopleInvolved)
    {
        $this->peopleInvolved = $peopleInvolved;

        return $this;
    }

    /**
     * Get peopleInvolved
     *
     * @return string
     */
    public function getPeopleInvolved()
    {
        return $this->peopleInvolved;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return MarketingSpaces
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
