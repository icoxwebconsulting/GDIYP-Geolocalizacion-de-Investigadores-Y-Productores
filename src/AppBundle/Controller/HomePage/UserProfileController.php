<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\City;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/userProfile")
 */
class UserProfileController extends Controller
{
    /**
     * @param User $user
     * @Route("/{id}", options={"expose"=true}, name="homepage_user_profile_show")
     * @return response
     */
    public function showAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:UserProfile")->findOneBy(array('user'=>$user));
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }

    /**
     * @param City $city
     * @Route("/city/{id}", options={"expose"=true}, name="homepage_user_profile_city_show")
     * @return response
     */
    public function userCityAction(City $city)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:UserProfile")->findAllUsersByCity($city);
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }
    
    /**
     * @param City $city
     * @Route("/all/city/{id}", options={"expose"=true}, name="homepage_all_profile_city_show")
     * @return response
     */
    public function userAllCityAction(City $city)
    {
        $em = $this->getDoctrine()->getManager();
        
        $entities = $em->getRepository("AppBundle:UserProfile")->findAllUsersByCity($city);
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        $entitiesp = $em->getRepository("AppBundle:AgroecologicalPractice")->findAllPracticesByCity($city);
        $serializedEntityP = $this->container->get('fos_js_routing.serializer')->serialize($entitiesp, 'json');

        return new Response(json_encode(array_merge(json_decode($serializedEntity, true),json_decode($serializedEntityP, true))));
    }
    


    /**
     * @param $city
     * @param $institution
     * @param $knowledge
     * @param $study
     * @Route("/filter/{country}/{region}/{city}/{institution_type}/{institution}/{knowledge_area}/{knowledge}/{topic_category}/{study}", name="advance_filter")
     * @return response
     */
    public function advanceFilterAction($country, $region, $city, $institution_type, $institution, $knowledge_area, $knowledge, $topic_category, $study)
    {
        //$session = $this->container->get('session'); 
        $session = $this->get('session');
        $session->set('usertype', 'investigator');
        $session->set('country', $country);
        $session->set('region', $region);
        $session->set('city', $city);
        $session->set('institution_type', $institution_type);
        $session->set('institution', $institution);
        $session->set('knowledge_area', $knowledge_area);
        $session->set('knowledge', $knowledge);
        $session->set('topic_category', $topic_category);
        $session->set('study', $study);
        
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:UserProfile")->findByFilter($city, $institution, $knowledge, $study);
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }
}