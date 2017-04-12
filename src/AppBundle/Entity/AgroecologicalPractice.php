<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Traits\TimestampableTrait;

/**
 * AgroecologicalPractice
 *
 * @ORM\Table(name="agroecological_practice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AgroecologicalPracticeRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class AgroecologicalPractice
{
    use TimestampableTrait;

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
     * @ORM\Column(name="practice_name", type="string", length=255)
     */
    private $practiceName;

    /**
     * @var string
     *
     * @ORM\Column(name="organization_name", type="string", length=255)
     */
    private $organizationName;

    /**
     * @var string
     *
     * @ORM\Column(name="practice_members", type="text")
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
     * @ORM\Column(name="graphic_information", type="text")
     */
    private $graphicInformation;

    /**
     * @var $reported
     * @ORM\Column(name="reported", type="boolean")
     */
    protected $reported = 0;
    
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
     * @return AgroecologicalPractice
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
     * @return AgroecologicalPractice
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
     * @return AgroecologicalPractice
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
     * @return AgroecologicalPractice
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
     * @return AgroecologicalPractice
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
     * @return AgroecologicalPractice
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
     * @return AgroecologicalPractice
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

    /**
     * Set practiceName
     *
     * @param string $practiceName
     *
     * @return AgroecologicalPractice
     */
    public function setPracticeName($practiceName)
    {
        $this->practiceName = $practiceName;

        return $this;
    }

    /**
     * Get practiceName
     *
     * @return string
     */
    public function getPracticeName()
    {
        return $this->practiceName;
    }

    /**
     * Set reported
     *
     * @param boolean $reported
     *
     * @return AgroecologicalPractice
     */
    public function setReported($reported)
    {
        $this->reported = $reported;

        return $this;
    }

    /**
     * Get reported
     *
     * @return boolean
     */
    public function getReported()
    {
        return $this->reported;
    }
}
