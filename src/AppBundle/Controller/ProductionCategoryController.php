<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 *@Route("/production_category")
 */
class ProductionCategoryController extends Controller
{
    /**
     * @Route("/", name="production_category_list")
     * @return response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:ProductionCategory")->findAll();
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }
}
