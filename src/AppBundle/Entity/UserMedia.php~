<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_medias")
 */
class UserMedia
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
     * @ORM\ManyToOne(targetEntity="Media", inversedBy="user_medias")
     * @ORM\JoinColumn(name="media", referencedColumnName="id")
     */
    protected $media;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="user_medias")
     * @ORM\JoinColumn(name="added_by", referencedColumnName="id")
     */
    protected $addedBy;

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
     * Set media
     *
     * @param \AppBundle\Entity\Media $media
     * @return UserMedia
     */
    public function setMedia(\AppBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \AppBundle\Entity\Media 
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set addedBy
     *
     * @param \AppBundle\Entity\User $addedBy
     * @return UserMedia
     */
    public function setAddedBy(\AppBundle\Entity\User $addedBy = null)
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    /**
     * Get addedBy
     *
     * @return \AppBundle\Entity\User 
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }
}
