<?php

namespace AppBundle\Controller\HomePage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("AppBundle:User")->findAllUsers();

        $institution = $request->get('institution');

        if (!empty($institution)){
            $finder = $this->container->get('fos_elastica.finder.app.institutiontype');
            $institutionType = $finder->find($institution);
        }else{
            $institutionType = $em->getRepository("AppBundle:InstitutionType")->findAll();
        }

        return $this->render('homepage/index.html.twig', array(
            'users' => $users,
            'institutionType' => $institutionType
        ));
    }
    
}