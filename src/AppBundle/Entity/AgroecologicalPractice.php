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
     * @ORM\ManyToOne(targetEntity="ContactMean", inversedBy="productor_profile")
     * @ORM\JoinColumn(name="contact_mean", referencedColumnName="id", nullable=true)
     */
    protected $contact_mean;

    /**
     * @ORM\Column(name="related_institutions", type="text")
     */
    private $relatedInstitutions;

    /**
     * @ORM\ManyToOne(targetEntity="ProductiveUndertaking", inversedBy="productive_undertaking")
     * @ORM\JoinColumn(name="productive_undertaking", referencedColumnName="id", nullable=true)
     */
    protected $productive_undertaking;

    /**
     * @ORM\ManyToOne(targetEntity="ProfessionalServices", inversedBy="professional_services")
     * @ORM\JoinColumn(name="professional_services", referencedColumnName="id", nullable=true)
     */
    protected $professional_services;

    /**
     * @ORM\ManyToOne(targetEntity="MarketingSpaces", inversedBy="marketing_spaces")
     * @ORM\JoinColumn(name="marketing_spaces", referencedColumnName="id", nullable=true)
     */
    protected $marketing_spaces;

    /**
     * @ORM\ManyToOne(targetEntity="InstitutionalProject", inversedBy="institutional_project")
     * @ORM\JoinColumn(name="institutional_project", referencedColumnName="id", nullable=true)
     */
    protected $institutional_project;

    /**
     * @ORM\ManyToOne(targetEntity="PromotionGroup", inversedBy="promotion_group")
     * @ORM\JoinColumn(name="promotion_group", referencedColumnName="id", nullable=true)
     */
    protected $promotion_group;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="productor_profile", cascade={"persist"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    protected $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="country", referencedColumnName="id", nullable=true)
     */
    protected $country = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="region", referencedColumnName="id", nullable=true)
     */
    protected $region = null;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="agroecological_practice", cascade={"all"})
     * @ORM\JoinColumn(name="city", referencedColumnName="id", nullable=true)
     */
    protected $city = null;
    
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
    
     /**
     * Set country
     *
     * @param \AppBundle\Entity\Country $country
     *
     * @return AgroecologicalPractice
     */
    public function setCountry (\AppBundle\Entity\Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \AppBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->country;
    }
    
    /**
     * Set region
     *
     * @param \AppBundle\Entity\Region $region
     *
     * @return AgroecologicalPractice
     */
    public function setRegion(\AppBundle\Entity\ProductionType $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \AppBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set city
     *
     * @param \AppBundle\Entity\City $city
     *
     * @return AgroecologicalPractice
     */
    public function setCity(\AppBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \AppBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }    
}
