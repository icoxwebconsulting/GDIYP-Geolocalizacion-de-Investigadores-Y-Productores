<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductionCategory
 *
 * @ORM\Table(name="production_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductionCategoryRepository")
 */
class ProductionCategory
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
     * @var string
     *
     * @ORM\Column(name="production_destination", type="string", length=255)
     */
    private $productionDestination;


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
     * @return ProductionCategory
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
     * Set productionDestination
     *
     * @param string $productionDestination
     *
     * @return ProductionCategory
     */
    public function setProductionDestination($productionDestination)
    {
        $this->productionDestination = $productionDestination;

        return $this;
    }

    /**
     * Get productionDestination
     *
     * @return string
     */
    public function getProductionDestination()
    {
        return $this->productionDestination;
    }
}
