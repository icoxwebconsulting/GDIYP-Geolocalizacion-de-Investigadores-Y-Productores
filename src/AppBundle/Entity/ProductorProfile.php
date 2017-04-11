<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductorProfile
 *
 * @ORM\Table(name="productor_profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductorProfileRepository")
 */
class ProductorProfile
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
     * @ORM\Column(name="organizationName", type="string", length=255)
     */
    private $organizationName;

    /**
     * @var string
     *
     * @ORM\Column(name="practiceMembers", type="text")
     */
    private $practiceMembers;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="graphicInformation", type="text")
     */
    private $graphicInformation;
    
    /**
     * @ORM\ManyToOne(targetEntity="GoogleMap", inversedBy="productor_profile", cascade={"all"})
     * @ORM\JoinColumn(name="address", referencedColumnName="id")
     */
    protected $address;

    /**
     * @ORM\ManyToOne(targetEntity="ContactMean", inversedBy="productor_profile", cascade={"all"})
     * @ORM\JoinColumn(name="contact_mean", referencedColumnName="id")
     */
    protected $contact_mean;

    /**
     * @ORM\ManyToOne(targetEntity="PracticeType", inversedBy="productor_profile", cascade={"all"})
     * @ORM\JoinColumn(name="practice_type", referencedColumnName="id")
     */
    protected $practice_type;

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
     * Set organizationName
     *
     * @param string $organizationName
     *
     * @return ProductorProfile
     */
    public function setOrganizationName($organizationName)
    {
        $this->organizationName = $organizationName;

        return $this;
    }

    /**
     * Get organizationName
     *
     * @return string
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * Set practiceMembers
     *
     * @param string $practiceMembers
     *
     * @return ProductorProfile
     */
    public function setPracticeMembers($practiceMembers)
    {
        $this->practiceMembers = $practiceMembers;

        return $this;
    }

    /**
     * Get practiceMembers
     *
     * @return string
     */
    public function getPracticeMembers()
    {
        return $this->practiceMembers;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ProductorProfile
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set graphicInformation
     *
     * @param string $graphicInformation
     *
     * @return ProductorProfile
     */
    public function setGraphicInformation($graphicInformation)
    {
        $this->graphicInformation = $graphicInformation;

        return $this;
    }

    /**
     * Get graphicInformation
     *
     * @return string
     */
    public function getGraphicInformation()
    {
        return $this->graphicInformation;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\GoogleMap $address
     *
     * @return ProductorProfile
     */
    public function setAddress(\AppBundle\Entity\GoogleMap $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \AppBundle\Entity\GoogleMap
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set contactMean
     *
     * @param \AppBundle\Entity\ContactMean $contactMean
     *
     * @return ProductorProfile
     */
    public function setContactMean(\AppBundle\Entity\ContactMean $contactMean = null)
    {
        $this->contact_mean = $contactMean;

        return $this;
    }

    /**
     * Get contactMean
     *
     * @return \AppBundle\Entity\ContactMean
     */
    public function getContactMean()
    {
        return $this->contact_mean;
    }

    /**
     * Set practiceType
     *
     * @param \AppBundle\Entity\PracticeType $practiceType
     *
     * @return ProductorProfile
     */
    public function setPracticeType(\AppBundle\Entity\PracticeType $practiceType = null)
    {
        $this->practice_type = $practiceType;

        return $this;
    }

    /**
     * Get practiceType
     *
     * @return \AppBundle\Entity\PracticeType
     */
    public function getPracticeType()
    {
        return $this->practice_type;
    }
}
