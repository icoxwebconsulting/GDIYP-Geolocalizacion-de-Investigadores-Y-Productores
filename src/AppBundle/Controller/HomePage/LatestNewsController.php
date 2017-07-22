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
     * @param $email
     * @Route("/email/{email}", options={"expose"=true}, name="homepage_last_send")
     * @return response
     */
    public function indexAction($email)
    {
        $mailLogger = new \Swift_Plugins_Loggers_ArrayLogger();
        $this->get('mailer')->registerPlugin(new \Swift_Plugins_LoggerPlugin($mailLogger));

        $em = $this->getDoctrine()->getManager();

        $user_news = $em->getRepository("AppBundle:UserProfile")->findAllLatestUserNews();
        $practice_news = $em->getRepository("AppBundle:AgroecologicalPractice")->findAllLatestPracticeNews();

        $subject = 'Red Periurban - Noticias publicadas durante la semana del '.date("d/m/Y",strtotime('-7 days')).' al '.date("d/m/Y",strtotime('-1 days'));
       
        try {
            $message = \Swift_Message::newInstance();
            $message->setSubject($subject);
            $message->setFrom('no-responder@redperiurban.com');
            $message->setTo($email);
            $message->setBody($this->render(':homepage/user:mail.html.twig', array(
                'userNews' => $user_news,
                'practiceNews' => $practice_news
                )),'text/html');
            $this->get('mailer')->send($message);
        }
        catch(Exception $e) {
            echo ("Error al enviar mensaje: ".$e->getMessage());
        }

        return $this->render(':homepage/user:mail.html.twig', array(
            'userNews' => $user_news,
            'practiceNews' => $practice_news
        ));
    }
}
