<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AgroecologicalPractice;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/agroecologicalPractice")
 */
class AgroecologicalPracticeController extends Controller
{
    /**
     * @Security("has_role('ROLE_PRODUCER')")
     * @Route("/", name="agroecological_practice_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findAll();
        return $this->render('agroindustrial_practice/list.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @param Request $request
     * @Security("has_role('ROLE_PRODUCER')")
     * @Route("/new", name="agroecological_practice_new")
     * @return array
     */
    public function newAction(Request $request)
    {
        $entity = new AgroecologicalPractice();
//        $fo
    }

    /**
     * @Route("/edit/{id}", name="agroecological_practice_edit")
     */
    public function updateAction($id)
    {
        return $this->render(':homepage:index.html.twig');
    }

}
