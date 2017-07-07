<?php

namespace AppBundle\Controller\HomePage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Controller\HomePage\UserProfileController;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        /*$em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("AppBundle:User")->findAllUsers();

        return $this->render('homepage/index.html.twig', array(
            'users' => $users,
        ));*/        
        return $this->render('homepage/index.html.twig');
    }    
    
    /**     
     * @Route("/periurban_info", name="homepage_periurban_info")
     * @return response
     */
    public function periurbanInfoAction()
    {
        return $this->render('homepage/periurbaninfo.html.twig');
    }      
    
    /**     
     * @Route("/practices_info", name="homepage_practices_info")
     * @return response
     */
    public function practicesInfoAction()
    {
        return $this->render('homepage/practicesinfo.html.twig');
    }    
}