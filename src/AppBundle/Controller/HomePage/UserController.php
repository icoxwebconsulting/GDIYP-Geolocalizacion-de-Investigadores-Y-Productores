<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\News;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @return Response
     * @Route("/", name="user_list")
     * @return response
     */
    public function indexAction(Request $request)
    {        
        $em = $this->getDoctrine()->getManager();        
        $session = $this->get('session');
        $serializedEntity = "";
        $usertype = $request->query->get('usertype');
        
        if ($usertype=='producer') {
            if ($session->get('redefinesearch')=='1') {                
                $city = $session->get('city');
                $practice_type = $session->get('practice_type');
                $productionCategory = $session->get('productionCategory');
                $productionType = $session->get('productionType');
                $productionDestination = $session->get('productionDestination');
                $whereTheySell = $session->get('whereTheySell');
                $productiveSurface = $session->get('productiveSurface');
                $marketWhereSold = $session->get('marketWhereSold');
                $type = $session->get('type');
                $periodicity = $session->get('periodicity');
                $serviceType = $session->get('serviceType');
                $projectType = $session->get('projectType');
                $promotionType = $session->get('promotionType');
            }
            else {
                $city = '0';
                $practice_type='0';
                $productionCategory='0';
                $productionType='0';
                $productionDestination='0';
                $whereTheySell='0';
                $productiveSurface='0';
                $marketWhereSold='0';
                $type='0';
                $periodicity='0';
                $serviceType='0';
                $projectType='0';
                $promotionType='0';
            }
            $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findByFilter($city, $practice_type, $productionCategory, $productionType, $productionDestination, $whereTheySell, $productiveSurface, $marketWhereSold, $type, $periodicity, $serviceType, $projectType, $promotionType);
            $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');
        }
        else if ($usertype=='investigator') {
            if ($session->get('redefinesearch')=='1') {
                $city = $session->get('city');
                $institution = $session->get('institution');
                $knowledge = $session->get('knowledge');
                $study = $session->get('study');
            }
            else {
                $city = '0';
                $institution_type='0';
                $institution='0';
                $knowledge_area='0';
                $knowledge='0';
                $topic_category='0';
                $study='0';                
            }
            $entities = $em->getRepository("AppBundle:UserProfile")->findByFilter($city, $institution, $knowledge, $study);
            $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');
        }
        else {
            $entities = $em->getRepository("AppBundle:UserProfile")->findAllUserProfiles();
            $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

            $entitiesp = $em->getRepository("AppBundle:AgroecologicalPractice")->findAllPractices();
            $serializedEntityP = $this->container->get('fos_js_routing.serializer')->serialize($entitiesp, 'json');

            $session->set('usertype', '');
            $session->set('country', '0');
            $session->set('region', '0');
            $session->set('city', '0');
            $session->set('redefinesearch', '0');

            return new Response(json_encode(array_merge(json_decode($serializedEntity, true),json_decode($serializedEntityP, true))));                
        }

        $session->set('usertype', '');
        $session->set('country', '0');
        $session->set('region', '0');
        $session->set('city', '0');
        $session->set('institution_type', '0');
        $session->set('institution', '0');
        $session->set('knowledge_area', '0');
        $session->set('knowledge', '0');
        $session->set('topic_category', '0');
        $session->set('study', '0');
        $session->set('practice_type', '0');
        $session->set('productionCategory', '0');
        $session->set('productionType', '0');
        $session->set('productionDestination', '0');
        $session->set('whereTheySell', '0');
        $session->set('productiveSurface', '0');
        $session->set('marketWhereSold', '0');
        $session->set('type', '0');
        $session->set('periodicity', '0');
        $session->set('serviceType', '0');
        $session->set('projectType', '0');
        $session->set('promotionType', '0');            
        $session->set('redefinesearch', '0');

        return new Response($serializedEntity); 
    }

    /**
     * @param User $user
     * @Route("/{id}", options={"expose"=true}, name="homepage_user_show")
     * @return response
     */
    public function showAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:News")->findBy(array('created_by' => $user->getId(), 'reported'=> 0));
        $userProfile = $em->getRepository("AppBundle:UserProfile")->findOneBy(array('user'=>$user));
        $medias = $em->getRepository('AppBundle:Media')->findBy(array('created_by' => $user->getId()),
            array('modified' => 'DESC'),
            10);

        $form = $this->createForm('AppBundle\Form\ContactType',null,array(
            'method' => 'POST'
        ));
        
        return $this->render(':homepage/user:show.html.twig', array(
            'entities' => $entities,
            'userProfile' => $userProfile,
            'medias' => $medias,
            'form' => $form->createView()
        ));
    }
}