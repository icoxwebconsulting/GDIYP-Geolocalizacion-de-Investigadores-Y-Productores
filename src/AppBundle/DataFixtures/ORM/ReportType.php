<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\ReportType as ReportTypeEntity;

class ReportType extends AbstractFixture implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $types = array(
            'User',
            'News'
        );
        foreach ($types as $type) {
            $entity = new ReportTypeEntity();
            $entity->setName($type);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}