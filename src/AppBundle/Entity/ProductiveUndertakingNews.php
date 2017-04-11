<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductiveUndertakingNews
 *
 * @ORM\Table(name="productive_undertaking_news")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductiveUndertakingNewsRepository")
 */
class ProductiveUndertakingNews
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
     * @ORM\ManyToOne(targetEntity="ProductiveUndertaking", inversedBy="productive_undertaking_news", cascade={"all"})
     * @ORM\JoinColumn(name="productive_undertaking", referencedColumnName="id")
     */
    protected $productive_undertaking;

    /**
     * @ORM\ManyToOne(targetEntity="News", inversedBy="productive_undertaking_news", cascade={"all"})
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
     * Set productiveUndertaking
     *
     * @param \AppBundle\Entity\ProductiveUndertaking $productiveUndertaking
     *
     * @return ProductiveUndertakingNews
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
     * Set news
     *
     * @param \AppBundle\Entity\News $news
     *
     * @return ProductiveUndertakingNews
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
}
