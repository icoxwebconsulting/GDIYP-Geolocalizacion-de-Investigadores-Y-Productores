<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/email")
 */
class EmailController extends Controller
{
    /**
     * @param $user_from
     * @param $user_to
     * @Route("/news/{user_from}/{user_to}", options={"expose"=true}, name="homepage_email")
     * @return response
     */
    public function indexAction($user_from, $user_to)
    {
        $em1 = $this->getDoctrine()->getManager();
        
        $users = $em1->getRepository("AppBundle:User")->findAll();
        //$userCount=0;
        foreach ($users as $user) {
            if ($user->getID()>$user_from && $user->getID()<=$user_to) {
                $userEmail = $user->getEmail();
                $userEmail = str_replace(" ","",$userEmail);
                //$userEmail='aristigueta00@gmail.com'.$userCount;
                //$userCount++;
                $response = $this->forward('AppBundle:Homepage/LatestNews:index', array(
                    'email'  => $userEmail,
                ));
            }
        }
        return $response;
    }
}
