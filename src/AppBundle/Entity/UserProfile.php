<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_profile")
 * @Vich\Uploadable
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
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    protected $summary;

    /**
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumn(name="location", referencedColumnName="id")
     */
    protected $location;

    /**
     * @Assert\File(
     *     maxSize="10000k",
     *     mimeTypes={"image/png", "image/jpeg", "image/gif", "image/jpg"},
     *     mimeTypesMessage = "El tipo de archivo ({{ type }}) no es válido. Los tipos de archivos permitidos son {{ types }}"
     * )
     *
     * @Vich\UploadableField(mapping="image_profile", fileNameProperty="imageName")
     *
     * @var File
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

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
     * Set address
     *
     * @param string $address
     * @return UserProfile
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
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
     * Set location
     *
     * @param \AppBundle\Entity\Location $location
     * @return UserProfile
     */
    public function setLocation(\AppBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \AppBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return Media
     */
    public function setImage(File $file = null)
    {
        $this->image = $file;

        if ($file instanceof UploadedFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $fileName
     *
     * @return User
     */
    public function setImageName($fileName)
    {
        $this->imageName = $fileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }
}
