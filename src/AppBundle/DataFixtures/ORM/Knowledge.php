<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\Knowledge as KnowledgeEntity;

class Knowledge extends AbstractFixture implements  OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $knowledges = [
            ['name' => 'VARIAS CIENCIAS EXACTAS Y NATURALES', 'knowledge_area' => 1 ],
            ['name' => 'FÍSICA', 'knowledge_area' => 1 ],
            ['name' => 'QUÍMICA', 'knowledge_area' => 1 ],
            ['name' => 'BIOLOGÍA', 'knowledge_area' => 1 ],
            ['name' => 'ASTRONOMÍA', 'knowledge_area' => 1 ],
            ['name' => 'CIENCIAS DE LA TIERRA', 'knowledge_area' => 1 ],
            ['name' => 'MATEMÁTICA', 'knowledge_area' => 1 ],
            ['name' => 'INFORMÁTICA', 'knowledge_area' => 1 ],
            ['name' => 'ESTADÍSTICA', 'knowledge_area' => 1 ],
            ['name' => '2000 VARIAS CIENCIAS DE LA INGENIERÍA Y ARQUITECTURA', 'knowledge_area' => 2],
            ['name' => '21 INGENIERÍA', 'knowledge_area' => 2],
            ['name' => '22 ARQUITECTURA', 'knowledge_area' => 2],
            ['name' => '23 BIOTECNOLOGÍA', 'knowledge_area' => 2],
            ['name' => '3000 VARIAS CIENCIAS MÉDICAS', 'knowledge_area' => 3],
            ['name' => '31 MEDICINA', 'knowledge_area' => 3],
            ['name' => '32 ODONTOLOGÍA', 'knowledge_area' => 3],
            ['name' => '33 FARMACOLOGÍA', 'knowledge_area' => 3],
            ['name' => '4000 VARIAS CIENCIAS AGROPECUARIAS Y VETERINARIAS', 'knowledge_area' => 4],
            ['name' => '41 AGRONOMIA Y DASONOMÍA', 'knowledge_area' => 4],
            ['name' => '42 VETERINARIA Y ESPECIES PECUARIAS', 'knowledge_area' => 4],
            ['name' => '43 ICTIOLOGIA', 'knowledge_area' => 4],
            ['name' => '5000 VARIAS CIENCIAS SOCIALES', 'knowledge_area' => 5],
            ['name' => '51 ECONOMÍA', 'knowledge_area' => 5],
            ['name' => '52 SOCIOLOGÍA', 'knowledge_area' => 5],
            ['name' => '53 PSICOLOGÍA', 'knowledge_area' => 5],
            ['name' => '54 CIENCIAS POLÍTICAS Y ADMINISTRACIÓN PÚBLICA', 'knowledge_area' => 5],
            ['name' => '55 DERECHO', 'knowledge_area' => 5],
            ['name' => '56 EDUCACIÓN', 'knowledge_area' => 5],
            ['name' => '57 ANTROPOLOGÍA', 'knowledge_area' => 5],
            ['name' => '58 PLANEAMIENTO', 'knowledge_area' => 5],
            ['name' => '59 DEMOGRAFÍA', 'knowledge_area' => 5],
            ['name' => '6000 VARIAS CIENCIAS HUMANAS', 'knowledge_area' => 6],
            ['name' => '61 HISTORIA', 'knowledge_area' => 6],
            ['name' => '62 LINGÜÍSTICA', 'knowledge_area' => 6],
            ['name' => '63 LITERATURA Y ARTES', 'knowledge_area' => 6],
            ['name' => '64 FILOSOFÍA', 'knowledge_area' => 6],
        ];

        foreach ($knowledges as $obj)
        {
            $entity = new KnowledgeEntity();
            $area = $manager->getRepository("AppBundle:KnowledgeArea")->find($obj['knowledge_area']);
            $entity->setName($obj['name']);
            $entity->setKnowledgeArea($area);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}