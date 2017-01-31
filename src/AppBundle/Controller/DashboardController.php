<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("dashboard")
 */
class DashboardController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="dashboard")
     * @return array
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findBy(array('reported' => 1),
                                                    array('modified' => 'DESC'),
                                                    10);
        $news = $em->getRepository('AppBundle:News')->findBy(array('reported' => 1),
                                                   array('modified' => 'DESC'),
                                                   10);
        $reports = $em->getRepository('AppBundle:Report')->findAllUserReportedByOtherUsers();

        return $this->render('admin/index.html.twig', array(
            'users' => $users,
            'news' => $news,
            'reports' => $reports
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/dashboard/test", name="dashboard_test")
     * @return array
     */
    public function testAction()
    {
        echo "test work";
        die('hoa');
    }
}