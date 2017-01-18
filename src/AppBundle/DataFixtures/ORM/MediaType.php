<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\MediaType as MediaTypeEntity;

class MediaType extends AbstractFixture implements  FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $media_types = [
            [
                'name' => 'pdf',
                'description' => 'pdf file'
            ],
            [
                'name' => 'excel',
                'description' => 'excel file'
            ],[
                'name' => 'doc',
                'description' => 'doc file'
            ],
            [
                'name' => 'ppt',
                'description' => 'powerpoint presentation'
            ],
            [
                'name' => 'image',
                'description' => 'image file'
            ],
        ];

        foreach ($media_types as $obj)
        {
            $entity = new MediaTypeEntity();
            $entity->setName($obj['name']);
            $entity->setDescription($obj['description']);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}