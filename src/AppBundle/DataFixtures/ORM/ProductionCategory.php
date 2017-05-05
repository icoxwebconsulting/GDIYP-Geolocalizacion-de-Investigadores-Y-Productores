<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\ProductionCategory as ProductionCategoryEntity;

class ProductionCategory extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $productionCategories = array(
            'Animal',
            'Vegetal',
            'Valor Agregado'
        );
        foreach ($productionCategories as $name) {
            $entity = new ProductionCategoryEntity();
            $entity->setName($name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 60;
    }
}
