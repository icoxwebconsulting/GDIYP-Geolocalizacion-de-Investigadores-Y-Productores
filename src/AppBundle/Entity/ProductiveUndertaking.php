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
     * @ORM\Column(name="whereTheySell", type="string", length=255, nullable=true)
     */
    private $whereTheySell = null;

    /**
     * @var string
     *
     * @ORM\Column(name="productiveSurface", type="string", length=255, nullable=true)
     */
    private $productiveSurface = null;

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
     * @ORM\ManyToOne(targetEntity="ProductionCategory", inversedBy="productive_undertaking", cascade={"all"})
     * @ORM\JoinColumn(name="category", referencedColumnName="id", nullable=true)
     */
    protected $category = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="ProductionType", inversedBy="productive_undertaking", cascade={"all"})
     * @ORM\JoinColumn(name="type", referencedColumnName="id", nullable=true)
     */
    protected $type = null;

    /**
     * @ORM\ManyToOne(targetEntity="ProductionDestinationType", inversedBy="productive_undertaking", cascade={"all"})
     * @ORM\JoinColumn(name="productionDestination", referencedColumnName="id", nullable=true)
     */
    protected $productionDestination = null;

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
     * @param string $peopleInvolved
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
     * Set category
     *
     * @param \AppBundle\Entity\ProductionCategory $category
     *
     * @return ProductiveUndertaking
     */
    public function setCategory (\AppBundle\Entity\ProductionCategory $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\ProductionCategory
     */
    public function getCategory()
    {
        return $this->category;
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
