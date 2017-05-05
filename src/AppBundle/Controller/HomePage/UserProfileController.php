<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\City;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

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
     * @param $city
     * @param $institution
     * @param $knowledge
     * @param $study
     * @Route("/filter/{city}/{institution}/{knowledge}/{study}", name="advance_filter")
     * @return response
     */
    public function advanceFilterAction($city, $institution, $knowledge, $study)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:UserProfile")->findByFilter($city, $institution, $knowledge, $study);
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }
}