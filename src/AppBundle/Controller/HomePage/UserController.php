<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\News;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @param User $user
     * @Route("/{id}", name="homepage_user_show")
     * @return response
     */
    public function indexAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:News")->findBy(array('created_by' => $user->getId(), 'reported'=> 0));
        return $this->render(':homepage/user:show.html.twig', array(
            'entities' => $entities
        ));
    }
}