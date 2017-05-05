<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 *@Route("/knowledge")
 */
class KnowledgeController extends Controller
{
    /**
     * @param $id
     * @Route("/{id}", name="knowledge_list")
     * @return response
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:Knowledge")->findBy(array('knowledge_area'=>$id));
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }
}
