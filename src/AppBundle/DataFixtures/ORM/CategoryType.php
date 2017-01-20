<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\Category as CategoryTypeEntity;

class CategoryType extends AbstractFixture implements  OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $category = [
            [
                'name' => 'principal',
                'parent' => NULL
            ]
        ];

        foreach ($category as $obj)
        {
            $entity = new CategoryTypeEntity();
            $status = $manager->getRepository("AppBundle:Status")->find(1);
            $entity->setName($obj['name']);
            $entity->setStatus($status);
            $entity->setParent($obj['parent']);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}