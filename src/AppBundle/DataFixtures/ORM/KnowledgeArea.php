<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\KnowledgeArea as KnowledgeAreaEntity;

class KnowledgeArea extends AbstractFixture implements  OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $knowledgeArea = array(
            'TE1 - CIENCIAS EXACTAS Y NATURALES',
            'TE2 - CIENCIAS DE LA INGENIERÍA Y ARQUITECTURA',
            'TE3 - CIENCIAS MÉDICAS',
            'TE4 - CIENCIAS AGROPECUARIAS Y VETERINARIAS',
            'TE5 - CIENCIAS SOCIALES',
            'TE6 - CIENCIAS HUMANAS'
        );
        foreach ($knowledgeArea as $name) {
            $entity = new KnowledgeAreaEntity();
            $entity->setName($name);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}