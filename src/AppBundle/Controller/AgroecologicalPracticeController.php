<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AgroecologicalPractice;
use AppBundle\Entity\AgroecologicalPracticeNews;
use AppBundle\Entity\ContactMean;
use AppBundle\Entity\GoogleMap;
use AppBundle\Entity\PracticeType;
use AppBundle\Form\AgroecologicalPracticeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * @Route("/agroecologicalPractice")
 */
class AgroecologicalPracticeController extends Controller
{
    /**
     * @Security("has_role('ROLE_PRODUCER')")
     * @Route("/", name="agroecological_practice_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findAll();
        return $this->render('agroindustrial_practice/list.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @param Request $request
     * @Security("has_role('ROLE_PRODUCER')")
     * @Route("/new", name="agroecological_practice_new")
     * @return array
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $practice = new AgroecologicalPractice();
        $form = $this->createForm(new AgroecologicalPracticeType(), $practice);

        $news = $em->getRepository("AppBundle:News")->findBy(array('created_by' => $this->getUser()));

        if($form->handleRequest($request)->isValid())
        {
//            echo "<pre>",print_r($_POST, true),"</pre>";
//            die();
            $members = $_POST['data']['member'];
            $serialized_members = serialize($members);
            $institutions = $_POST['data']['related_institution'];
            $serialized_institutions = serialize($institutions);

            $googleMap = new GoogleMap();
            $googleMap->setLatitude($_POST['latitude']);
            $googleMap->setLongitude($_POST['longitude']);
            $googleMap->setAddress($_POST['address']);

            $contact = new ContactMean();
            $contact->setFirstName($_POST['contact_mean']['first_name']);
            $contact->setLastName($_POST['contact_mean']['last_name']);
            $contact->setPhone($_POST['contact_mean']['phone']);
            $contact->setCellPhone($_POST['contact_mean']['cell_phone']);
            $contact->setEmail($_POST['contact_mean']['email']);
            $contact->setFacebook($_POST['contact_mean']['facebook']);
            $contact->setWebsite($_POST['contact_mean']['website']);
            $contact->setComment($_POST['contact_mean']['comments']);

            $practiceType = new PracticeType();
            $practiceType->setUser($this->getUser());

            foreach($_POST['data']['related_news'] as $obj)
            {
                $agroecologicalPracticeNews = new AgroecologicalPracticeNews();
                $news = $em->getRepository("AppBundle:News")->findOneBy(array('id' => $obj));
                $agroecologicalPracticeNews->setNews($news);
                $agroecologicalPracticeNews->setAgroecologicalPractice($practice);
                $em->persist($agroecologicalPracticeNews);
            }

            $practice->setPracticeType($practiceType);
            $practice->setPracticeMembers($serialized_members);
            $practice->setAddress($googleMap);
            $practice->setContactMean($contact);
            $practice->setRelatedInstitutions($serialized_institutions);

            $em->persist($googleMap);
            $em->persist($contact);
            $em->persist($practiceType);
            $em->persist($practice);
            $em->flush();

            $this->addFlash(
                'success',
                $this->get('translator')->trans('Agroecological Practice has been successfully added!')
            );
            return $this->redirectToRoute('agroecological_practice_list');
        }
        return $this->render('agroindustrial_practice/form.html.twig', array(
            'form' => $form->createView(),
            'news' => $news
        ));
    }

    /**
     * @Route("/edit/{id}", name="agroecological_practice_edit")
     */
    public function updateAction($id)
    {
        return $this->render(':homepage:index.html.twig');
    }

}