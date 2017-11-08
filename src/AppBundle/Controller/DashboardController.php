<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $securityContext = $this->container->get('security.context');
        $router = $this->container->get('router');
        if (!$securityContext->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($router->generate('dashboard_user'), 307);
        }
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
     * @Security("has_role('ROLE_USER')")
     * @Route("/home/", name="dashboard_user")
     * @return array
     */
    public function homeAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $medias = $em->getRepository('AppBundle:Media')->findBy(array(),
            array('modified' => 'DESC'),
            10);
        $news = $em->getRepository('AppBundle:News')->findBy(array(),
            array('modified' => 'DESC'),
            10);

        return $this->render('admin/home.html.twig', array(
            'medias' => $medias,
            'news' => $news,
        ));
    }
    
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/user", name="user")
     * @return array
     */
    public function userAction()
    {
        $securityContext = $this->container->get('security.context');
        $router = $this->container->get('router');
        if (!$securityContext->isGranted('ROLE_ADMIN')) {
            return new RedirectResponse($router->generate('dashboard_user'), 307);
        }
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("AppBundle:User")->findAllUsers();

        return $this->render('admin/user.html.twig', array(
            'users' => $users
        ));
    }
}
