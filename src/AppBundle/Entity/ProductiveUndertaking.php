<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductiveUndertaking
 *
 * @ORM\Table(name="productive_undertaking")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductiveUndertakingRepository")
 */
class ProductiveUndertaking
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
     * @ORM\Column(name="whereTheySell", type="string", length=255)
     */
    private $whereTheySell;

    /**
     * @var string
     *
     * @ORM\Column(name="productiveSurface", type="string", length=255)
     */
    private $productiveSurface;

    /**
     * @var int
     *
     * @ORM\Column(name="peopleInvolved", type="integer")
     */
    private $peopleInvolved;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;
    /**
     * @ORM\ManyToOne(targetEntity="ProductionType", inversedBy="productive_undertaking", cascade={"all"})
     * @ORM\JoinColumn(name="type", referencedColumnName="id")
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity="ProductionDestinationType", inversedBy="productive_undertaking", cascade={"all"})
     * @ORM\JoinColumn(name="productionDestination", referencedColumnName="id")
     */
    protected $productionDestination;

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
     * Set whereTheySell
     *
     * @param string $whereTheySell
     *
     * @return ProductiveUndertaking
     */
    public function setWhereTheySell($whereTheySell)
    {
        $this->whereTheySell = $whereTheySell;

        return $this;
    }

    /**
     * Get whereTheySell
     *
     * @return string
     */
    public function getWhereTheySell()
    {
        return $this->whereTheySell;
    }

    /**
     * Set productiveSurface
     *
     * @param string $productiveSurface
     *
     * @return ProductiveUndertaking
     */
    public function setProductiveSurface($productiveSurface)
    {
        $this->productiveSurface = $productiveSurface;

        return $this;
    }

    /**
     * Get productiveSurface
     *
     * @return string
     */
    public function getProductiveSurface()
    {
        return $this->productiveSurface;
    }

    /**
     * Set peopleInvolved
     *
     * @param integer $peopleInvolved
     *
     * @return ProductiveUndertaking
     */
    public function setPeopleInvolved($peopleInvolved)
    {
        $this->peopleInvolved = $peopleInvolved;

        return $this;
    }

    /**
     * Get peopleInvolved
     *
     * @return int
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
     * @return ProductiveUndertaking
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

    /**
     * Set type
     *
     * @param \AppBundle\Entity\ProductionType $type
     *
     * @return ProductiveUndertaking
     */
    public function setType(\AppBundle\Entity\ProductionType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\ProductionType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set productionDestination
     *
     * @param \AppBundle\Entity\ProductionDestinationType $productionDestination
     *
     * @return ProductiveUndertaking
     */
    public function setProductionDestination(\AppBundle\Entity\ProductionDestinationType $productionDestination = null)
    {
        $this->productionDestination = $productionDestination;

        return $this;
    }

    /**
     * Get productionDestination
     *
     * @return \AppBundle\Entity\ProductionDestinationType
     */
    public function getProductionDestination()
    {
        return $this->productionDestination;
    }
    
}
