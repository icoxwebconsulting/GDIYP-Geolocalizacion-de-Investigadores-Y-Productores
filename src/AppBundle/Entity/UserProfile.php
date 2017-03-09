<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_profile")
 */
class UserProfile
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="job_title", type="string", length=255, nullable=true)
     */
    protected $job_title;

    /**
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    protected $summary;

    /**
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Institution")
     * @ORM\JoinColumn(name="institution", referencedColumnName="id")
     */
    protected $institution;

    /**
     * @ORM\OneToOne(targetEntity="Knowledge")
     * @ORM\JoinColumn(name="knowlegde", referencedColumnName="id")
     */
    protected $knowledge;

    /**
     * @ORM\ManyToOne(targetEntity="GoogleMap")
     * @ORM\JoinColumn(name="address", referencedColumnName="id")
     */
    protected $address;

    /**
     * @ORM\OneToOne(targetEntity="StudyTopic")
     * @ORM\JoinColumn(name="study_topic", referencedColumnName="id")
     */
    protected $study_topic;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="research_place", referencedColumnName="id")
     */
    protected $research_place;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="residence_place", referencedColumnName="id")
     */
    protected $residence_place;

    /**
     * @ORM\ManyToOne(targetEntity="CaseStudy")
     * @ORM\JoinColumn(name="case_study", referencedColumnName="id")
     */
    protected $case_study;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set job_title
     *
     * @param string $jobTitle
     * @return UserProfile
     */
    public function setJobTitle($jobTitle)
    {
        $this->job_title = $jobTitle;

        return $this;
    }

    /**
     * Get job_title
     *
     * @return string 
     */
    public function getJobTitle()
    {
        return $this->job_title;
    }

    /**
     * Set summary
     *
     * @param string $summary
     * @return UserProfile
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string 
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return UserProfile
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
     * Set institution
     *
     * @param \AppBundle\Entity\Institution $institution
     *
     * @return UserProfile
     */
    public function setInstitution(\AppBundle\Entity\Institution $institution = null)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return \AppBundle\Entity\Institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set knowledge
     *
     * @param \AppBundle\Entity\Knowledge $knowledge
     *
     * @return UserProfile
     */
    public function setKnowledge(\AppBundle\Entity\Knowledge $knowledge = null)
    {
        $this->knowledge = $knowledge;

        return $this;
    }

    /**
     * Get knowledge
     *
     * @return \AppBundle\Entity\Knowledge
     */
    public function getKnowledge()
    {
        return $this->knowledge;
    }

    /**
     * Set address
     *
     * @param \AppBundle\Entity\GoogleMap $address
     *
     * @return UserProfile
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
     * Set studyTopic
     *
     * @param \AppBundle\Entity\StudyTopic $studyTopic
     *
     * @return UserProfile
     */
    public function setStudyTopic(\AppBundle\Entity\StudyTopic $studyTopic = null)
    {
        $this->study_topic = $studyTopic;

        return $this;
    }

    /**
     * Get studyTopic
     *
     * @return \AppBundle\Entity\StudyTopic
     */
    public function getStudyTopic()
    {
        return $this->study_topic;
    }

    /**
     * Set researchPlace
     *
     * @param \AppBundle\Entity\City $researchPlace
     *
     * @return UserProfile
     */
    public function setResearchPlace(\AppBundle\Entity\City $researchPlace = null)
    {
        $this->research_place = $researchPlace;

        return $this;
    }

    /**
     * Get researchPlace
     *
     * @return \AppBundle\Entity\City
     */
    public function getResearchPlace()
    {
        return $this->research_place;
    }

    /**
     * Set residencePlace
     *
     * @param \AppBundle\Entity\City $residencePlace
     *
     * @return UserProfile
     */
    public function setResidencePlace(\AppBundle\Entity\City $residencePlace = null)
    {
        $this->residence_place = $residencePlace;

        return $this;
    }

    /**
     * Get residencePlace
     *
     * @return \AppBundle\Entity\City
     */
    public function getResidencePlace()
    {
        return $this->residence_place;
    }

    /**
     * Set caseStudy
     *
     * @param \AppBundle\Entity\CaseStudy $caseStudy
     *
     * @return UserProfile
     */
    public function setCaseStudy(\AppBundle\Entity\CaseStudy $caseStudy = null)
    {
        $this->case_study = $caseStudy;

        return $this;
    }

    /**
     * Get caseStudy
     *
     * @return \AppBundle\Entity\CaseStudy
     */
    public function getCaseStudy()
    {
        return $this->case_study;
    }
}
