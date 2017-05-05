<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AgroecologicalPracticeNews
 *
 * @ORM\Table(name="agroecological_practice_news")
 * @ORM\Entity()
 */
class AgroecologicalPracticeNews
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
     * @ORM\ManyToOne(targetEntity="AgroecologicalPractice", inversedBy="agroecological_practice_news", cascade={"all"})
     * @ORM\JoinColumn(name="agroecological_practice", referencedColumnName="id")
     */
    protected $agroecological_practice;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="agroecological_practice_news", cascade={"all"})
     * @ORM\JoinColumn(name="news", referencedColumnName="id")
     */
    protected $news;

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
     * Set news
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return AgroecologicalPracticeNews
     */
    public function setNews(\AppBundle\Entity\News $news = null)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \AppBundle\Entity\News
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set agroecologicalPractice
     *
     * @param \AppBundle\Entity\AgroecologicalPractice $agroecologicalPractice
     *
     * @return AgroecologicalPracticeNews
     */
    public function setAgroecologicalPractice(\AppBundle\Entity\AgroecologicalPractice $agroecologicalPractice = null)
    {
        $this->agroecological_practice = $agroecologicalPractice;

        return $this;
    }

    /**
     * Get agroecologicalPractice
     *
     * @return \AppBundle\Entity\AgroecologicalPractice
     */
    public function getAgroecologicalPractice()
    {
        return $this->agroecological_practice;
    }
}
