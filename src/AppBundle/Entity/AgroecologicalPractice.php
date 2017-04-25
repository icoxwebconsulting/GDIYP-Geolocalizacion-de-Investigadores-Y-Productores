<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

use AppBundle\Entity\ProductiveUndertaking;

/**
 * AgroecologicalPractice
 *
 * @ORM\Table(name="agroecological_practice")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AgroecologicalPracticeRepository")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * 
 *
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
     * @ORM\Column(name="related_institutions", type="text")
     */
    private $relatedInstitutions;

    /**
     * @ORM\ManyToOne(targetEntity="ProductiveUndertaking", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="productive_undertaking", referencedColumnName="id")
     */
    protected $productive_undertaking;

    /**
     * @ORM\ManyToOne(targetEntity="ProfessionalServices", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="professional_services", referencedColumnName="id")
     */
    protected $professional_services;

    /**
     * @ORM\ManyToOne(targetEntity="MarketingSpaces", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="marketing_spaces", referencedColumnName="id")
     */
    protected $marketing_spaces;

    /**
     * @ORM\ManyToOne(targetEntity="InstitutionalProject", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="institutional_project", referencedColumnName="id")
     */
    protected $institutional_project;

    /**
     * @ORM\ManyToOne(targetEntity="PromotionGroup", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="promotion_group", referencedColumnName="id")
     */
    protected $promotion_group;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    protected $user;
    
    
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

    /**
     * Set relatedInstitutions
     *
     * @param string $relatedInstitutions
     *
     * @return AgroecologicalPractice
     */
    public function setRelatedInstitutions($relatedInstitutions)
    {
        $this->relatedInstitutions = $relatedInstitutions;

        return $this;
    }

    /**
     * Get relatedInstitutions
     *
     * @return string
     */
    public function getRelatedInstitutions()
    {
        return $this->relatedInstitutions;
    }
    
    /**
     * Set productiveUndertaking
     *
     * @param \AppBundle\Entity\ProductiveUndertaking $productiveUndertaking
     *
     * @return AgroecologicalPractice
     */
    public function setProductiveUndertaking(\AppBundle\Entity\ProductiveUndertaking $productiveUndertaking = null)
    {
        $this->productive_undertaking = $productiveUndertaking;

        return $this;
    }

    /**
     * Get productiveUndertaking
     *
     * @return \AppBundle\Entity\ProductiveUndertaking
     */
    public function getProductiveUndertaking()
    {
        return $this->productive_undertaking;
    }

    /**
     * Set professionalServices
     *
     * @param \AppBundle\Entity\ProfessionalServices $professionalServices
     *
     * @return AgroecologicalPractice
     */
    public function setProfessionalServices(\AppBundle\Entity\ProfessionalServices $professionalServices = null)
    {
        $this->professional_services = $professionalServices;

        return $this;
    }

    /**
     * Get professionalServices
     *
     * @return \AppBundle\Entity\ProfessionalServices
     */
    public function getProfessionalServices()
    {
        return $this->professional_services;
    }

    /**
     * Set marketingSpaces
     *
     * @param \AppBundle\Entity\MarketingSpaces $marketingSpaces
     *
     * @return AgroecologicalPractice
     */
    public function setMarketingSpaces(\AppBundle\Entity\MarketingSpaces $marketingSpaces = null)
    {
        $this->marketing_spaces = $marketingSpaces;

        return $this;
    }

    /**
     * Get marketingSpaces
     *
     * @return \AppBundle\Entity\MarketingSpaces
     */
    public function getMarketingSpaces()
    {
        return $this->marketing_spaces;
    }

    /**
     * Set institutionalProject
     *
     * @param \AppBundle\Entity\InstitutionalProject $institutionalProject
     *
     * @return AgroecologicalPractice
     */
    public function setInstitutionalProject(\AppBundle\Entity\InstitutionalProject $institutionalProject = null)
    {
        $this->institutional_project = $institutionalProject;

        return $this;
    }

    /**
     * Get institutionalProject
     *
     * @return \AppBundle\Entity\InstitutionalProject
     */
    public function getInstitutionalProject()
    {
        return $this->institutional_project;
    }

    /**
     * Set promotionGroup
     *
     * @param \AppBundle\Entity\PromotionGroup $promotionGroup
     *
     * @return AgroecologicalPractice
     */
    public function setPromotionGroup(\AppBundle\Entity\PromotionGroup $promotionGroup = null)
    {
        $this->promotion_group = $promotionGroup;

        return $this;
    }

    /**
     * Get promotionGroup
     *
     * @return \AppBundle\Entity\PromotionGroup
     */
    public function getPromotionGroup()
    {
        return $this->promotion_group;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return AgroecologicalPractice
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }    
}
