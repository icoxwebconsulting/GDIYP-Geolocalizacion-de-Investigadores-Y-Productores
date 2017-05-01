<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AgroecologicalPractice;
use AppBundle\Entity\AgroecologicalPracticeNews;
use AppBundle\Entity\ContactMean;
use AppBundle\Entity\GoogleMap;
use AppBundle\Entity\ProductiveUndertaking;
use AppBundle\Entity\MarketingSpaces;
use AppBundle\Entity\ProfessionalServices;
use AppBundle\Entity\InstitutionalProject;
use AppBundle\Entity\ProductionCategory;
use AppBundle\Entity\ProductionType;
use AppBundle\Entity\ProductionDestinationType;
use AppBundle\Entity\PromotionGroup;
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
            /* echo "<pre>",print_r($_POST, true),"</pre>";
            die(); */
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
                        
            foreach($_POST['data']['related_news'] as $obj)
            {
                $agroecologicalPracticeNews = new AgroecologicalPracticeNews();
                $news = $em->getRepository("AppBundle:News")->findOneBy(array('id' => $obj));
                $agroecologicalPracticeNews->setNews($news);
                $agroecologicalPracticeNews->setAgroecologicalPractice($practice);
                $em->persist($agroecologicalPracticeNews);
            }

            $em->persist($googleMap);
            $em->persist($contact);
            
            $practice->setPracticeMembers($serialized_members);
            $practice->setAddress($googleMap);
            $practice->setContactMean($contact);
            $practice->setRelatedInstitutions($serialized_institutions);
            $practice->setUser($this->getUser());            

            //Questionnaires
            switch ($_POST['data']['type_practice']) {
                case "productive_undertaking":
                    $category = $em->getRepository("AppBundle:ProductionCategory")->find($_POST['appbundle_agroecologicalpractice']['productive_undertaking']['category']);
                    $type = $em->getRepository("AppBundle:ProductionType")->find($_POST['appbundle_agroecologicalpractice']['productive_undertaking']['type']);
                    $destination = $em->getRepository("AppBundle:ProductionDestinationType")->find($_POST['appbundle_agroecologicalpractice']['productive_undertaking']['productionDestination']);
                    
                    $productiveUndertaking = new ProductiveUndertaking();
                    $productiveUndertaking->setCategory($category);
                    $productiveUndertaking->setType($type);
                    $productiveUndertaking->setWhereTheySell($_POST['appbundle_agroecologicalpractice']['productive_undertaking']['whereTheySell']);
                    $productiveUndertaking->setProductiveSurface($_POST['appbundle_agroecologicalpractice']['productive_undertaking']['productiveSurface']);
                    $productiveUndertaking->setPeopleInvolved($_POST['appbundle_agroecologicalpractice']['productive_undertaking']['peopleInvolved']);
                    $productiveUndertaking->setComment($_POST['appbundle_agroecologicalpractice']['productive_undertaking']['comment']);
                    $productiveUndertaking->setProductionDestination($destination);
                    
                    $practice->setMarketingSpaces(NULL);
                    $practice->setProfessionalServices(NULL);
                    $practice->setInstitutionalProject(NULL);
                    $practice->setPromotionGroup(NULL);
                    
                    $em->persist($productiveUndertaking);
                    $practice->setProductiveUndertaking($productiveUndertaking);
                    break;
                case "marketing_spaces":
                    $marketingSpaces = new MarketingSpaces();
                    $marketingSpaces->setMarketWhereSold($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['marketWhereSold']);
                    $marketingSpaces->setType($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['type']);
                    $marketingSpaces->setPeriodicity($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['periodicity']);
                    $marketingSpaces->setPeopleInvolved($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['peopleInvolved']);
                    $marketingSpaces->setComment($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['comment']);
                    
                    $practice->setProductiveUndertaking(NULL);
                    $practice->setProfessionalServices(NULL);
                    $practice->setInstitutionalProject(NULL);
                    $practice->setPromotionGroup(NULL);  
                    
                    $em->persist($marketingSpaces);
                    $practice->setMarketingSpaces($marketingSpaces);
                    break;
                case "professional_services":
                    $professionalServices = new ProfessionalServices();
                    $professionalServices->setType($_POST['appbundle_agroecologicalpractice']['professional_services']['type']);
                    $professionalServices->setComment($_POST['appbundle_agroecologicalpractice']['professional_services']['comment']);
                    
                    $practice->setProductiveUndertaking(NULL);
                    $practice->setMarketingSpaces(NULL);
                    $practice->setInstitutionalProject(NULL);
                    $practice->setPromotionGroup(NULL);
                    
                    $em->persist($professionalServices);
                    $practice->setProfessionalServices($professionalServices);
                    break;
                case "institutional_project":
                    $institutionalProject = new InstitutionalProject();
                    $institutionalProject->setType($_POST['appbundle_agroecologicalpractice']['institutional_project']['type']);
                    $institutionalProject->setPopulation($_POST['appbundle_agroecologicalpractice']['institutional_project']['population']);
                    $institutionalProject->setDuration($_POST['appbundle_agroecologicalpractice']['institutional_project']['duration']);
                    $institutionalProject->setArticulations($_POST['appbundle_agroecologicalpractice']['institutional_project']['articulations']);
                    $institutionalProject->setComment($_POST['appbundle_agroecologicalpractice']['institutional_project']['comment']);
                    
                    $practice->setProductiveUndertaking(NULL);
                    $practice->setMarketingSpaces(NULL);
                    $practice->setProfessionalServices(NULL);
                    $practice->setPromotionGroup(NULL);
                    
                    $em->persist($institutionalProject);
                    $practice->setInstitutionalProject($institutionalProject);
                    break;
                case "promotion_group":
                    $promotionGroup = new PromotionGroup();
                    $promotionGroup->setType($_POST['appbundle_agroecologicalpractice']['promotion_group']['type']);
                    $promotionGroup->setModality($_POST['appbundle_agroecologicalpractice']['promotion_group']['modality']);
                    $promotionGroup->setArticulations($_POST['appbundle_agroecologicalpractice']['promotion_group']['articulations']);
                    $promotionGroup->setComment($_POST['appbundle_agroecologicalpractice']['promotion_group']['comment']);
                    
                    $practice->setProductiveUndertaking(NULL);
                    $practice->setMarketingSpaces(NULL);
                    $practice->setInstitutionalProject(NULL);
                    $practice->setProfessionalServices(NULL);
                    
                    $em->persist($promotionGroup);
                    $practice->setPromotionGroup($promotionGroup);
                    break;
            }
                        
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
     * @param Request $request
     * @param AgroecologicalPractice $entity entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{id}", name="agroecological_practice_edit")
     * @return array
     */
    public function putAction(Request $request, AgroecologicalPractice $entity)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('agroecological_practice_list');
        }
        
        $request->setMethod('PATCH');
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createForm(new AgroecologicalPracticeType(), $entity, ["method" => $request->getMethod()]);
        $news = $em->getRepository("AppBundle:News")->findBy(array('created_by' => $this->getUser()));
        
        if ($form->handleRequest($request)->isValid())
        {            
            $em->persist($entity);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('Agroecological Practice has been successfully updated!')
            );
            return $this->redirectToRoute('agroecological_practice_list');
        }
        return $this->render('agroindustrial_practice/form.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity,
            'news' => $news
        ));
    }


    /**
     * @param AgroecologicalPractice $entity entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/delete/{id}", name="agroecological_practice_delete")
     * @return route
     */
    public function deleteAction(AgroecologicalPractice $entity)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('agroecological_practice_list');
        }
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $this->addFlash(
            'success',
            $this->get('translator')->trans('Agroecological Practice has been succesfully deleted!')
        );
        return $this->redirectToRoute('agroecological_practice_list');
    }    
}
