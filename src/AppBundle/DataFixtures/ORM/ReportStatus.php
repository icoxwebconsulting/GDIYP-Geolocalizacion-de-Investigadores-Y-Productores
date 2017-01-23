<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\ReportStatus as ReportStatusEntity;

class ReportStatus extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $statuses = array(
            'Valid',
            'Invalid'
        );
        foreach ($statuses as $name) {
            $entity = new ReportStatusEntity();
            $entity->setName($name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}