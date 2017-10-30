<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *@Route("/region")
 */
class RegionController extends Controller
{

    /**
     * @Route("/{id}", name="region_list", options={"expose"=true})
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:Region")->findBy(array('country'=>$id));
        return JsonResponse::create( $entities , 200)->setSharedMaxAge(300);
    }
}
