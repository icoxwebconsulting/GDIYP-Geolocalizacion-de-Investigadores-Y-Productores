<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\News;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/homepage/news")
 */
class NewsController extends Controller
{
    /**
     * @param $new
     * @Route("/{id}", name="homepage_new_show")
     * @return array
     */
    public function showAction(News $new)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("AppBundle:News")->find($new);
        $userProfile = $em->getRepository("AppBundle:UserProfile")->findOneBy(array('user'=>$new->getCreatedBy()));
        return $this->render(':homepage/news:show.html.twig', array(
            'entity' => $entity,
            'userProfile' => $userProfile
        ));
    }
    
    /**
     * @param $new
     * @Route("/practice/{id}", name="homepage_practice_new_show")
     * @return array
     */
    public function showPracticeNewAction(News $new)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository("AppBundle:News")->find($new);
        $user = $em->getRepository("AppBundle:User")->findOneBy(array('id'=>$new->getCreatedBy()));
        return $this->render(':homepage/news:practiceshow.html.twig', array(
            'entity' => $entity,
            'user' => $user
        ));
    }
    
}