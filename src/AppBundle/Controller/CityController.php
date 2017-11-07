<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *@Route("/city")
 */
class CityController extends Controller
{

    /**
     * @Route("/{id}", name="city_list", options={"expose"=true})
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:City")->findBy(array('region'=>$id));
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

        return new Response($serializedEntity);
    }
}
