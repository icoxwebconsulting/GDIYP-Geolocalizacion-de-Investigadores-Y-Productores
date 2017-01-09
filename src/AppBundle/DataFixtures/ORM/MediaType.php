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
                'name' => 'Pdf',
                'description' => 'pdf file'
            ],
            [
                'name' => 'Image',
                'description' => 'image file'
            ],
            [
                'name' => 'Video',
                'description' => 'video url or file'
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