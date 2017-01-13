<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class DashboardController extends Controller
{
    /**
     * @param $request
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="dashboard")
     * @return array
     */
    public function indexAction(Request $request)
    {
        return $this->render('dashboard/index.html.twig');
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