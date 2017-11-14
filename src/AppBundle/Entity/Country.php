<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="countries")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CountryRepository")
 */
class Country
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
     * @ORM\Column(name="sortName", type="string", length=10)
     */
    private $sortName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="phonecode", type="integer")
     */
    private $phonecode;

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
     * @return Country
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
     * Set phonecode
     *
     * @param integer $phonecode
     *
     * @return Country
     */
    public function setPhonecode($phonecode)
    {
        $this->phonecode = $phonecode;

        return $this;
    }

    /**
     * Get phonecode
     *
     * @return integer
     */
    public function getPhonecode()
    {
        return $this->phonecode;
    }

    /**
     * Set sortName
     *
     * @param string $sortName
     *
     * @return Country
     */
    public function setSortName($sortName)
    {
        $this->sortName = $sortName;

        return $this;
    }

    /**
     * Get sortName
     *
     * @return string
     */
    public function getSortName()
    {
        return $this->sortName;
    }
}
