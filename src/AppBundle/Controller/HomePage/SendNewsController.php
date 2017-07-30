<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/send")
 * 
 */
class SendNewsController extends Controller
{
    /**
     * @Route("/news", options={"expose"=true}, name="homepage_send_news")
     * @return response
     * 
     */
    public function indexAction()
    {
        $em0 = $this->getDoctrine()->getManager();

        $usersList = $em0->getRepository("AppBundle:User")->findAll();
        $userCounter=1;
        $currentUser=1;
        $userFrom=0;
        $userTo=0;

        $fs = new FileSystem();
        $fs->remove($this->container->getParameter('kernel.cache_dir'));

        foreach ($usersList as $user) {
            if ($userCounter==1) {
                $userFrom = $user->getID();
            } 
            $userCounter++;
            if ($userCounter==10 || $currentUser==count($usersList)) {
                $userTo = $user->getID();
                $url = "http://redperiurban.com/email/news/".$userFrom."/".$userTo;
                echo $url;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($curl);
                curl_close($curl);
                sleep(20);
                echo $result;
                $userCounter=1; 
    
                $fs = new FileSystem();
                $fs->remove($this->container->getParameter('kernel.cache_dir'));
            }
            $currentUser++;
        }

        return new Response();
    }
}
