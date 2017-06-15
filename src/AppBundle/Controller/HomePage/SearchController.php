<?php

namespace AppBundle\Controller\HomePage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *@Route("/search")
 */
class SearchController extends Controller
{
    /**
     * @param $request
     * @Route("/", name="search")
     * @return response
     */
    public function indexAction(Request $request)
    {
        $institution = $request->get('institution');
        var_dump($institution);
//        return new Response($serializedEntity);
    }

    /**
     * @param $request
     * @Route("/searchback", name="searchback")
     */
    public function searchBackAction()
    {
        $this->get('session')->set('redefinesearch', '1'); 
        return $this->redirectToRoute('homepage');
    }
    
    
}
