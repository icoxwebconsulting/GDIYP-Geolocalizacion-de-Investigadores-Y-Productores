<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PracticeType
 *
 * @ORM\Table(name="practice_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PracticeTypeRepository")
 */
class PracticeType
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
     * @ORM\ManyToOne(targetEntity="ProductiveUndertaking", inversedBy="practice_type", cascade={"all"})
     * @ORM\JoinColumn(name="productive_undertaking", referencedColumnName="id")
     */
    protected $productive_undertaking;

    /**
     * @ORM\ManyToOne(targetEntity="ProfessionalServices", inversedBy="practice_type", cascade={"all"})
     * @ORM\JoinColumn(name="professional_services", referencedColumnName="id")
     */
    protected $professional_services;

    /**
     * @ORM\ManyToOne(targetEntity="MarketingSpaces", inversedBy="practice_type", cascade={"all"})
     * @ORM\JoinColumn(name="marketing_spaces", referencedColumnName="id")
     */
    protected $marketing_spaces;

    /**
     * @ORM\ManyToOne(targetEntity="InstitutionalProject", inversedBy="practice_type", cascade={"all"})
     * @ORM\JoinColumn(name="institutional_project", referencedColumnName="id")
     */
    protected $institutional_project;

    /**
     * @ORM\ManyToOne(targetEntity="PromotionGroup", inversedBy="practice_type", cascade={"all"})
     * @ORM\JoinColumn(name="promotion_group", referencedColumnName="id")
     */
    protected $promotion_group;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="practice_type", cascade={"all"})
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
     * Set productiveUndertaking
     *
     * @param \AppBundle\Entity\ProductiveUndertaking $productiveUndertaking
     *
     * @return PracticeType
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
     * @return PracticeType
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
     * @return PracticeType
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
     * @return PracticeType
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
     * @return PracticeType
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
     * @return PracticeType
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
