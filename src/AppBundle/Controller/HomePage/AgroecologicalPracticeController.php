<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\City;
use AppBundle\Entity\News;
use AppBundle\Entity\AgroecologicalPractice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

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
        return JsonResponse::create( $entities , 200);
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
        return JsonResponse::create( $entities , 200);
    }    

    /**
     * @param $country
     * @param $region
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
     * @Route("/filter/{country}/{region}/{city}/{practice_type}/{productionCategory}/{productionType}/{productionDestination}/{whereTheySell}/{productiveSurface}/{marketWhereSold}/{type}/{periodicity}/{serviceType}/{projectType}/{promotionType}", name="practice_advance_filter")
     * @return response
     */
    public function advanceFilterAction($country, $region, $city, $practice_type, $productionCategory, $productionType, $productionDestination, $whereTheySell, $productiveSurface, $marketWhereSold, $type, $periodicity, $serviceType, $projectType, $promotionType)
    {
        //$session = $this->container->get('session');
        $session = $this->get('session');
        $session->set('usertype','producer');
        $session->set('country', $country);
        $session->set('region', $region);
        $session->set('city', $city);
        $session->set('practice_type', $practice_type);
        $session->set('productionCategory', $productionCategory);
        $session->set('productionType', $productionType);
        $session->set('productionDestination', $productionDestination);
        $session->set('whereTheySell', $whereTheySell);
        $session->set('productiveSurface', $productiveSurface);
        $session->set('marketWhereSold', $marketWhereSold);
        $session->set('type', $type);
        $session->set('periodicity', $periodicity);
        $session->set('serviceType', $serviceType);
        $session->set('projectType', $projectType);
        $session->set('promotionType', $promotionType);
        
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findByFilter($city, $practice_type, $productionCategory, $productionType, $productionDestination, $whereTheySell, $productiveSurface, $marketWhereSold, $type, $periodicity, $serviceType, $projectType, $promotionType);
        return JsonResponse::create( $entities , 200);
    }    
}