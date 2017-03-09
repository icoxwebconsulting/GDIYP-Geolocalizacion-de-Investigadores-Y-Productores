<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\TopicCategory as TopicCategoryEntity;

class TopicCategory extends AbstractFixture implements  OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $topicCategory = array(
            'Medio ambiente y ecología',
            'Dimensión Política',
            'Sociedad y Cultura',
            'Dimensión económica',
            'Territorio'
        );
        foreach ($topicCategory as $name) {
            $entity = new TopicCategoryEntity();
            $entity->setName($name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 11;
    }
}