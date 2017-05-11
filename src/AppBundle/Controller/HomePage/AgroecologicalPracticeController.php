<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\City;
use AppBundle\Entity\News;
use AppBundle\Entity\AgroecologicalPractice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/agroecologicalPractice")
 */
class AgroecologicalPracticeController extends Controller
{
    /**
     * @param AgroecologicalPractice $practice
     * @Route("/{id}", options={"expose"=true}, name="homepage_practice_show")
     * @return response
     */
    public function showAction(AgroecologicalPractice $practice)
    {
        $em = $this->getDoctrine()->getManager();
        $practice_news = $em->getRepository("AppBundle:AgroecologicalPractice")->findAllNewsByPractice($practice);

        $form = $this->createForm('AppBundle\Form\ContactType',null,array(
            'method' => 'POST'
        ));
        
        return $this->render(':homepage/practice:show.html.twig', array(
            'practice' => $practice,
            'practiceNews' => $practice_news,
            'form' => $form->createView()
        ));
    }    
    
    /**
     * @param AgroecologicalPractice $practice
     * @Route("/info/{id}", options={"expose"=true}, name="homepage_practice_profile_show")
     * @return response
     */
    public function showProfileAction(AgroecologicalPractice $practice)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findOneBy(array('id'=>$practice));
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');
        return new Response($serializedEntity);
    }

    /**
     * @param City $city
     * @Route("/city/{id}", options={"expose"=true}, name="homepage_practice_profile_city_show")
     * @return response
     */
    public function practiceCityAction(City $city)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findAllPracticesByCity($city);
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }    

    /**
     * @param $city
     * @param $practice_type
     * @param $productionCategory
     * @param $productionType
     * @param $productionDestination
     * @param $whereTheySell
     * @param $productiveSurface
     * @param $marketWhereSold
     * @param $type
     * @param $periodicity
     * @param $serviceType
     * @param $projectType
     * @param $promotionType
     * @Route("/filter/{city}/{practice_type}/{productionCategory}/{productionType}/{productionDestination}/{whereTheySell}/{productiveSurface}/{marketWhereSold}/{type}/{periodicity}/{serviceType}/{projectType}/{promotionType}", name="practice_advance_filter")
     * @return response
     */
    public function advanceFilterAction($city, $practice_type, $productionCategory, $productionType, $productionDestination, $whereTheySell, $productiveSurface, $marketWhereSold, $type, $periodicity, $serviceType, $projectType, $promotionType)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findByFilter($city, $practice_type, $productionCategory, $productionType, $productionDestination, $whereTheySell, $productiveSurface, $marketWhereSold, $type, $periodicity, $serviceType, $projectType, $promotionType);
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }    
}