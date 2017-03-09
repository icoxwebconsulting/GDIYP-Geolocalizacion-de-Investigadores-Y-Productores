<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use AppBundle\Entity\StudyTopic as StudyTopicEntity;

class StudyTopic extends AbstractFixture implements  OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $studyTopics = [
            ['name' => 'Servicios ecosistémicos', 'category' => 1],
            ['name' => 'Biodiversidad', 'category' => 1],
            ['name' => 'Inundaciones', 'category' => 1],
            ['name' => 'Contaminación puntual', 'category' => 1],
            ['name' => 'Contaminación difusa', 'category' => 1],
            ['name' => 'Residuos sólidos urbanos (GIRSU)', 'category' => 1],
            ['name' => 'Monte o bosque nativo', 'category' => 1],
            ['name' => 'Ecología del paisaje', 'category' => 1],
            ['name' => 'Cambio climático', 'category' => 1],
            ['name' => 'otros', 'category' => 1],
            ['name' => 'Políticas públicas', 'category' => 2],
            ['name' => 'Coordinación supramunicipal (metropolización)', 'category' => 2],
            ['name' => 'Democracia participativa', 'category' => 2],
            ['name' => 'Marcos normativos / legales', 'category' => 2],
            ['name' => 'Actores sociales', 'category' => 2],
            ['name' => 'Soberanía alimentaria ', 'category' => 2],
            ['name' => 'Construcción de redes', 'category' => 2],
            ['name' => 'Acceso a la tierra', 'category' => 2],
            ['name' => 'Acceso al agua ', 'category' => 2],
            ['name' => 'Conflicos socio-territoriales', 'category' => 2],
            ['name' => 'Desarrollo rural', 'category' => 2],
            ['name' => 'Otros', 'category' => 2],
            ['name' => 'Salud', 'category' => 3],
            ['name' => 'Educación', 'category' => 3],
            ['name' => 'Dinámicas sociales urbano-rurales ', 'category' => 3],
            ['name' => 'Migraciones ', 'category' => 3],
            ['name' => 'Pueblos originarios', 'category' => 3],
            ['name' => 'Campesinado', 'category' => 3],
            ['name' => 'Patrimonio ', 'category' => 3],
            ['name' => 'Ruralidad', 'category' => 3],
            ['name' => 'Estudios de género', 'category' => 3],
            ['name' => 'Otros', 'category' => 3],
            ['name' => 'Agricultura familiar', 'category' => 4],
            ['name' => 'Agricultura extensiva', 'category' => 4],
            ['name' => 'Horticultura', 'category' => 4],
            ['name' => 'Fruticultura', 'category' => 4],
            ['name' => 'Floricultura', 'category' => 4],
            ['name' => 'Apicultura', 'category' => 4],
            ['name' => 'Acceso/financiación a recursos productivos', 'category' => 4],
            ['name' => 'Producción animal extensiva', 'category' => 4],
            ['name' => 'Producción animal intensiva', 'category' => 4],
            ['name' => 'producción animales de granja', 'category' => 4],
            ['name' => 'Agroecología', 'category' => 4],
            ['name' => 'Producción industrial', 'category' => 4],
            ['name' => 'valor agregado a producción primaria', 'category' => 4],
            ['name' => 'Producción ladrillera', 'category' => 4],
            ['name' => 'Extracción minerales', 'category' => 4],
            ['name' => 'Pobreza', 'category' => 4],
            ['name' => 'Mercado inmobiliario', 'category' => 4],
            ['name' => 'Ferias y mercados', 'category' => 4],
            ['name' => 'Comercialización', 'category' => 4],
            ['name' => 'Turismo', 'category' => 4],
            ['name' => 'Otros', 'category' => 4],
            ['name' => 'Interfase urbano-rural', 'category' => 5],
            ['name' => 'Interfase urbano-natural', 'category' => 5],
            ['name' => 'Interfase oasis-secano', 'category' => 5],
            ['name' => 'Paisaje', 'category' => 5],
            ['name' => 'Ordenamiento Territorial/planificación', 'category' => 5],
            ['name' => 'Infraestructura', 'category' => 5],
            ['name' => 'Áreas de regadío', 'category' => 5],
            ['name' => 'Cinturones Fruti-Hortícolas ', 'category' => 5],
            ['name' => 'Zonas de No Pulverización/zonas buffer ', 'category' => 5],
            ['name' => 'Áreas protegidas', 'category' => 5],
            ['name' => 'Crecimiento Urbano', 'category' => 5],
            ['name' => 'Otros', 'category' => 5],
        ];

        foreach ($studyTopics as $obj)
        {
            $entity = new StudyTopicEntity();
            $category = $manager->getRepository("AppBundle:TopicCategory")->find($obj['category']);
            $entity->setName($obj['name']);
            $entity->setTopicCategory($category);
            $manager->persist($entity);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 12;
    }
}