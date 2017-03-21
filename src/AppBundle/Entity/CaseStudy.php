<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CaseStudy
 *
 * @ORM\Table(name="case_study")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CaseStudyRepository")
 */
class CaseStudy
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=255, nullable=true)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="graphic_information", type="text", nullable=true)
     */
    private $graphicInformation;

    /**
     * @var string
     *
     * @ORM\Column(name="investigation_lines", type="text", nullable=true)
     */
    private $investigationLines;

    /**
     * @var string
     *
     * @ORM\Column(name="research_group", type="text", nullable=true)
     */
    private $researchGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="related_institution", type="text", nullable=true)
     */
    private $relatedInstitution;

    /**
     * @var string
     *
     * @ORM\Column(name="links", type="text", nullable=true)
     */
    private $links;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_info", type="text", nullable=true)
     */
    private $contactInfo;

    /**
     * @ORM\ManyToOne(targetEntity="GoogleMap")
     * @ORM\JoinColumn(name="address", referencedColumnName="id")
     */
    protected $address;

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
     * @return CaseStudy
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
     * Set description
     *
     * @param string $description
     *
     * @return CaseStudy
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
     * Set keywords
     *
     * @param string $keywords
     *
     * @return CaseStudy
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set graphicInformation
     *
     * @param string $graphicInformation
     *
     * @return CaseStudy
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
     * Set investigationLines
     *
     * @param string $investigationLines
     *
     * @return CaseStudy
     */
    public function setInvestigationLines($investigationLines)
    {
        $this->investigationLines = $investigationLines;

        return $this;
    }

    /**
     * Get investigationLines
     *
     * @return string
     */
    public function getInvestigationLines()
    {
        return $this->investigationLines;
    }

    /**
     * Set researchGroup
     *
     * @param string $researchGroup
     *
     * @return CaseStudy
     */
    public function setResearchGroup($researchGroup)
    {
        $this->researchGroup = $researchGroup;

        return $this;
    }

    /**
     * Get researchGroup
     *
     * @return string
     */
    public function getResearchGroup()
    {
        return $this->researchGroup;
    }

    /**
     * Set relatedInstitution
     *
     * @param string $relatedInstitution
     *
     * @return CaseStudy
     */
    public function setRelatedInstitution($relatedInstitution)
    {
        $this->relatedInstitution = $relatedInstitution;

        return $this;
    }

    /**
     * Get relatedInstitution
     *
     * @return string
     */
    public function getRelatedInstitution()
    {
        return $this->relatedInstitution;
    }

    /**
     * Set links
     *
     * @param string $links
     *
     * @return CaseStudy
     */
    public function setLinks($links)
    {
        $this->links = $links;

        return $this;
    }

    /**
     * Get links
     *
     * @return string
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set contactInfo
     *
     * @param string $contactInfo
     *
     * @return CaseStudy
     */
    public function setContactInfo($contactInfo)
    {
        $this->contactInfo = $contactInfo;

        return $this;
    }

    /**
     * Get contactInfo
     *
     * @return string
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\GoogleMap $address
     *
     * @return CaseStudy
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
}
