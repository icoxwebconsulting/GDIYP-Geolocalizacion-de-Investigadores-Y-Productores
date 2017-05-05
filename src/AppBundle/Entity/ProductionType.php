<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductionType
 *
 * @ORM\Table(name="production_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductionTypeRepository")
 */
class ProductionType
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
     * @ORM\ManyToOne(targetEntity="ProductionCategory", inversedBy="production_type", cascade={"all"})
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    protected $category;


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
     * @return ProductionType
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
     * Set category
     *
     * @param \AppBundle\Entity\ProductionCategory $category
     *
     * @return ProductionType
     */
    public function setCategory(\AppBundle\Entity\ProductionCategory $category = null)
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
}
