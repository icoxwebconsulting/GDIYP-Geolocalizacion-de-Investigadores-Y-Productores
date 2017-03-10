<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StudyTopic
 *
 * @ORM\Table(name="study_topics")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudyTopicRepository")
 */
class StudyTopic
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="TopicCategory")
     * @ORM\JoinColumn(name="topic_category", referencedColumnName="id")
     */
    protected $topic_category;

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
     * @return StudyTopic
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
     * Set topicCategory
     *
     * @param \AppBundle\Entity\TopicCategory $topicCategory
     *
     * @return StudyTopic
     */
    public function setTopicCategory(\AppBundle\Entity\TopicCategory $topicCategory = null)
    {
        $this->topic_category = $topicCategory;

        return $this;
    }

    /**
     * Get topicCategory
     *
     * @return \AppBundle\Entity\TopicCategory
     */
    public function getTopicCategory()
    {
        return $this->topic_category;
    }
}
