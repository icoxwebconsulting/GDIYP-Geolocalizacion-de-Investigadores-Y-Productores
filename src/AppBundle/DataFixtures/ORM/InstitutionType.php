<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\InstitutionType as InstitutionTypeEntity;

class InstitutionType extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $institutions = array(
            'Universidad Privada',
            'Universidad Pública',
            'Instituto Científico-Tecnológico público',
            'Instituto Científico-Tecnológico privado',
            'Ente Gubernamental',
            'Organización No Gubermanetal',
            'Organización Sindical',
            'Organización Empresarial',
            'Otros'
        );
        foreach ($institutions as $name) {
            $entity = new InstitutionTypeEntity();
            $entity->setName($name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 7;
    }
}