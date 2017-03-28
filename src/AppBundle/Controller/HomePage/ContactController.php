<?php

namespace AppBundle\Controller\HomePage;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/contact")
 */
class ContactController extends Controller
{
    /**
     * @param Request $request
     * @Route("/", name="contact_form")
     * @return array
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm('AppBundle\Form\ContactType',null,array(
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->get('email.service')->sendContactEmail($_POST['receptor'],$form->getData())){

                    // Everything OK, redirect to wherever you want ! :
                    $this->addFlash(
                        'success',
                        'Your message has been sent'
                    );
                    return $this->redirectToRoute('homepage_user_show', array('id'=>102));

                }else{
                    // An error ocurred, handle
                    $this->addFlash(
                        'danger',
                        'Your message hasn\'t been sent'
                    );
                    return $this->redirectToRoute('homepage_user_show', array('id'=>102));

                }
            }
        }

        return $this->render(':homepage/Contact:Contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data){
        $myappContactMail = 'eivanphils@gmail.com';
      return false;
    }
}
