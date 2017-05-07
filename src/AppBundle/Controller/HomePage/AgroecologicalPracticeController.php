<?php

namespace AppBundle\Controller\HomePage;

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
}