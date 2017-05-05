<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\ProductionDestinationType as ProductionDestinationTypeEntity;

class ProductionDestinationType extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $productionDestinationTypes = array(
            'Autoconsumo',
            'Venta',
            'Institucional',
            'Otro'
        );
        foreach ($productionDestinationTypes as $name) {
            $entity = new ProductionDestinationTypeEntity();
            $entity->setName($name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 61;
    }
}
