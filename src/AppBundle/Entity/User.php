<?php
namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Traits\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class User extends BaseUser
{
    use TimestampableTrait;

    /**
    * @ORM\Id
    * @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    protected $id;

    /**
     * @var string $first_name
     * @Assert\NotBlank()
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    protected $first_name;

    /**
     * @var string $last_name
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    protected $last_name;

    /**
     * @var $reported
     * @ORM\Column(name="reported", type="boolean")
     */
    protected $reported = 0;

    /**
     * @ORM\OneToOne(targetEntity="UserProfile")
     * @ORM\JoinColumn(name="user_profile", referencedColumnName="id")
     */
    protected $user_profile;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;

        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set reported
     *
     * @param boolean $reported
     * @return User
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
     * Set user_profile
     *
     * @param \AppBundle\Entity\UserProfile $userProfile
     * @return User
     */
    public function setUserProfile(\AppBundle\Entity\UserProfile $userProfile = null)
    {
        $this->user_profile = $userProfile;

        return $this;
    }

    /**
     * Get user_profile
     *
     * @return \AppBundle\Entity\UserProfile 
     */
    public function getUserProfile()
    {
        return $this->user_profile;
    }
}
