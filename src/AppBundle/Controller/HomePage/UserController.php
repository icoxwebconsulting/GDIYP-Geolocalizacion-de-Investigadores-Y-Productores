<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\News;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

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
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:UserProfile")->findAll();
        $serializedEntity = $this->container->get('fos_js_routing.serializer')->serialize($entities, 'json');

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
        return $this->render(':homepage/user:show.html.twig', array(
            'entities' => $entities,
            'userProfile' => $userProfile,
            'medias' => $medias
        ));
    }
}