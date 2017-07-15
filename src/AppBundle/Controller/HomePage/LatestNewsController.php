<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\News;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/latest_news")
 */
class LatestNewsController extends Controller
{
    /**
     * @Route("/email", options={"expose"=true}, name="homepage_last_show")
     * @return response
     */
    public function indexAction()
    {
        $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
        $this->get('mailer')->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));
        
        $em = $this->getDoctrine()->getManager();
        
        $user_news = $em->getRepository("AppBundle:UserProfile")->findAllLatestUserNews();
        $practice_news = $em->getRepository("AppBundle:AgroecologicalPractice")->findAllLatestPracticeNews();
        $users = $em->getRepository("AppBundle:User")->findAll();
        
        $subject = 'Red Periurban - Noticias publicadas durante la semana del '.date("d/m/Y",strtotime('-7 days')).' al '.date("d/m/Y",strtotime('-1 days'));
        foreach ($users as $user) {
            $userEmail = $user->getEmail();
            $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom('no-responder@redperiurban.com')
                    ->setTo($userEmail)
                    ->setBody($this->render(':homepage/user:mail.html.twig', array(
                            'userNews' => $user_news,
                            'practiceNews' => $practice_news
                    )),'text/html');

            $this->get('mailer')->send($message);
        }
        return $this->render(':homepage/user:mail.html.twig', array(
            'userNews' => $user_news,
            'practiceNews' => $practice_news
        ));
    }
}
