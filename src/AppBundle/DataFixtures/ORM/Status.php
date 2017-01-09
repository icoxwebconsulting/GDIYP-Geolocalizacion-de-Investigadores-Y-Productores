<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\Status as StatusEntity;

class Status extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $statuses = array(
            'Active',
            'Draft',
            'Blocked',
            'Inactive'
        );
        foreach ($statuses as $name) {
            $entity = new StatusEntity();
            $entity->setName($name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}