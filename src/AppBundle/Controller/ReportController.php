<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\News;
use AppBundle\Entity\Report;
use AppBundle\Form\ReportType;

/**
 * @Route("report")
 */
class ReportController extends Controller
{
    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/user", name="user_report_list")
     * @return response
     */
    public function reportUserAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:Report")->findBy(array('type'=>1));
        $title = $this->get('translator')->trans('Users');
        return $this->render('report/list.html.twig', array(
            'entities' => $entities,
            'title' => $title
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/news", name="news_report_list")
     * @return response
     */
    public function reportNewsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:Report")->findBy(array('type'=>2));
        $title = $this->get('translator')->trans('News');
        return $this->render('report/list.html.twig', array(
            'entities' => $entities,
            'title' => $title
        ));
    }
    
    /**
     * @param Request $request
     * @param Report $report
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/user/edit/{id}", name="user_report_edit")
     * @return response
     */
    public function editReporUsertAction(Request $request, Report $report)
    {
        $request->setMethod('PATCH');
        $em = $this->getDoctrine()->getManager();
        
        $userProfile = $em->getRepository('AppBundle:UserProfile')->findOneBy(array('user'=> $report->getUser()));
        
        $form = $this->createForm(new ReportType(), $report, ["method" => $request->getMethod()]);
        if ($form->handleRequest($request)->isValid())
        {
            $status = $form->get('status')->getData();

            if ($status->getId() == 2){
                $report->getUser()->setReported(0);
            }elseif ($status->getId() == 1){
                $report->getUser()->setReported(1);
            }

            $report->setApprovedBy($this->getUser());
            $report->setIsOpen(0);
            $em->persist($report);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('Report has been done!')
            );
            return $this->redirectToRoute('user_report_list');
        }
        return $this->render('report/form.html.twig', array(
            'form' => $form->createView(),
            'report' => $report,
            'userProfile' => $userProfile
        ));
    }

    /**
     * @param Request $request
     * @param Report $report
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/news/edit/{id}", name="news_report_edit")
     * @return response
     */
    public function editReporNewstAction(Request $request, Report $report)
    {
        $request->setMethod('PATCH');
        $em = $this->getDoctrine()->getManager();

        $medias = $em->getRepository('AppBundle:Media')->findBy(array('news'=>$report->getNews()));

        $form = $this->createForm(new ReportType(), $report, ["method" => $request->getMethod()]);
        if ($form->handleRequest($request)->isValid())
        {
            $status = $form->get('status')->getData();

            if ($status->getId() == 2){
                $report->getNews()->setReported(0);
            }elseif ($status->getId() == 1){
                $report->getNews()->setReported(1);
            }

            $report->setApprovedBy($this->getUser());
            $report->setIsOpen(0);
            $em->persist($report);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('Report has been done!')
            );
            return $this->redirectToRoute('news_report_list');
        }
        return $this->render('report/form.html.twig', array(
            'form' => $form->createView(),
            'report' => $report,
            'medias' =>$medias
        ));
    }

}