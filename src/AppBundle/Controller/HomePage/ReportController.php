<?php

namespace AppBundle\Controller\HomePage;

use AppBundle\Entity\Report;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\News;
use AppBundle\Entity\User;

/**
 * @Route("/report")
 */
class ReportController extends Controller
{
    /**
     * @param $user
     * @Route("/user/{id}", name="homepage_user_report")
     * @return response
     */
    public function userReportAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $report = $em->getRepository('AppBundle:Report')->findOneBy(array('user'=>$user, 'isOpen'=> 1));

        if ($report)
        {
            $this->addFlash(
                'danger',
                'User has already been reported'
            );
            return $this->redirectToRoute('homepage');
        }else{
            $report = new Report();
        }

        $type = $em->getRepository('AppBundle:ReportType')->find(1);

        $report->setUser($user);
        $report->setType($type);
        $report->setDescription($_POST['description']);
        $report->setIsOpen(1);

        $em->persist($user);
        $em->persist($report);
        $em->flush();
        $this->addFlash(
            'success',
            'User has been reported'
        );
        return $this->redirectToRoute('homepage');
    }
    
    /**
     * @param $news
     * @Route("/news/{id}", name="homepage_news_report")
     * @return response
     */
    public function newsReportAction(News $news)
    {
        $em = $this->getDoctrine()->getManager();

        $report = $em->getRepository('AppBundle:Report')->findOneBy(array('news'=>$news, 'isOpen'=> 1));

        if ($report)
        {
            $this->addFlash(
                'danger',
                'News has already been reported'
            );
            return $this->redirectToRoute('homepage');
        }else{
            $report = new Report();
        }

        $type = $em->getRepository('AppBundle:ReportType')->find(2);

        $report->setNews($news);
        $report->setType($type);
        $report->setDescription($_POST['description']);
        $report->setIsOpen(1);

        $em->persist($report);
        $em->flush();
        $this->addFlash(
            'success',
            'News has been reported'
        );
        return $this->redirectToRoute('homepage');
    }
}