<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AgroecologicalPractice;
use AppBundle\Entity\AgroecologicalPracticeNews;
use AppBundle\Entity\ContactMean;
use AppBundle\Entity\GoogleMap;
use AppBundle\Entity\City;
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
        $entities = $em->getRepository("AppBundle:AgroecologicalPractice")->findBy(array('user' => $this->getUser()));
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

        if ($form->handleRequest($request)->isValid()) {
            $members = $_POST['data']['member'];
            $serialized_members = json_encode($members);
            $institutions = $_POST['data']['related_institution'];
            $serialized_institutions = json_encode($institutions);

            $googleMap = new GoogleMap();
            $googleMap->setLatitude($_POST['latitude']);
            $googleMap->setLongitude($_POST['longitude']);
            $googleMap->setAddress($_POST['address']);

            $region = $em->getRepository("AppBundle:Region")->find($_POST['appbundle_agroecologicalpractice_region']);
            $practice->setRegion($region);

            if (!empty($_POST['appbundle_agroecologicalpractice_city_name'])) {
                $city = new City();
                $city->setName($_POST['appbundle_agroecologicalpractice_city_name']);
                $region = $em->getRepository("AppBundle:Region")->find($_POST['appbundle_agroecologicalpractice_region']);
                $city->setRegion($region);
            } else {
                $city = $em->getRepository("AppBundle:City")->find($_POST['appbundle_agroecologicalpractice_city']);
            }
            $practice->setCity($city);

            if (isset($_POST['data']['related_news'])) {
                foreach ($_POST['data']['related_news'] as $obj) {
                    $agroecologicalPracticeNews = new AgroecologicalPracticeNews();
                    $news = $em->getRepository("AppBundle:News")->findOneBy(array('id' => $obj));
                    $agroecologicalPracticeNews->setNews($news);
                    $agroecologicalPracticeNews->setAgroecologicalPractice($practice);
                    $em->persist($agroecologicalPracticeNews);
                }
            }

            $em->persist($googleMap);

            $practice->setPracticeMembers($serialized_members);
            $practice->setAddress($googleMap);
            $practice->setRelatedInstitutions($serialized_institutions);
            $practice->setUser($this->getUser());

            //Contact Means
            $contactMean = new ContactMean();
            if (array_filter($_POST['appbundle_agroecologicalpractice']['contact_mean'])) {
                $contactMean->setFirstName($_POST['appbundle_agroecologicalpractice']['contact_mean']['firstName']);
                $contactMean->setLastName($_POST['appbundle_agroecologicalpractice']['contact_mean']['lastName']);
                $contactMean->setPhone($_POST['appbundle_agroecologicalpractice']['contact_mean']['phone']);
                $contactMean->setCellPhone($_POST['appbundle_agroecologicalpractice']['contact_mean']['cell_phone']);
                $contactMean->setEmail($_POST['appbundle_agroecologicalpractice']['contact_mean']['email']);
                $contactMean->setFacebook($_POST['appbundle_agroecologicalpractice']['contact_mean']['facebook']);
                $contactMean->setWebsite($_POST['appbundle_agroecologicalpractice']['contact_mean']['website']);
                $contactMean->setComment($_POST['appbundle_agroecologicalpractice']['contact_mean']['comment']);

                $practice->setContactMean($contactMean);
                $em->persist($contactMean);
            } else {
                $practice->setContactMean(NULL);
            }

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
                    $marketingSpaces->setMarketWhereSold(isset($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['marketWhereSold']));
                    $marketingSpaces->setType(isset($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['type']));
                    $marketingSpaces->setPeriodicity(isset($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['periodicity']));
                    $marketingSpaces->setPeopleInvolved(isset($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['peopleInvolved']));
                    $marketingSpaces->setComment(isset($_POST['appbundle_agroecologicalpractice']['marketing_spaces']['comment']));

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
            'entity' => $practice,
            'news' => $news
        ));
    }

    /**
     * @param Request $request
     * @param AgroecologicalPractice $practice entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{id}", name="agroecological_practice_edit")
     * @return array
     */
    public function putAction(Request $request, AgroecologicalPractice $practice)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('agroecological_practice_list');
        }

        $request->setMethod('PATCH');
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new AgroecologicalPracticeType(), $practice, ["method" => $request->getMethod()]);
        $news = $em->getRepository("AppBundle:News")->findBy(array('created_by' => $this->getUser()));
        $practiceNews = $em->getRepository("AppBundle:AgroecologicalPractice")->findAllNewsByPractice($practice);

        if ($form->handleRequest($request)->isValid()) {

            /* echo "<pre>",print_r($_POST, true),"</pre>";
            die(); */
            $members = $_POST['data']['member'];
            $serialized_members = json_encode($members);
            $institutions = $_POST['data']['related_institution'];
            $serialized_institutions = json_encode($institutions);

            $googleMap = new GoogleMap();
            $googleMap->setLatitude($_POST['latitude']);
            $googleMap->setLongitude($_POST['longitude']);
            $googleMap->setAddress($_POST['address']);

            $region = $em->getRepository("AppBundle:Region")->find($_POST['appbundle_agroecologicalpractice_region']);
            $practice->setRegion($region);

            if (!empty($_POST['appbundle_agroecologicalpractice_city_name'])) {
                $city = new City();
                $city->setName($_POST['appbundle_agroecologicalpractice_city_name']);
                $region = $em->getRepository("AppBundle:Region")->find($_POST['appbundle_agroecologicalpractice_region']);
                $city->setRegion($region);
            } else {
                $city = $em->getRepository("AppBundle:City")->find($_POST['appbundle_agroecologicalpractice_city']);
            }
            $practice->setCity($city);

            $deleteNews = $em->getRepository("AppBundle:AgroecologicalPractice")->deleteAllNewsByPractice($practice);

            if (isset($_POST['data']['related_news'])) {
                foreach ($_POST['data']['related_news'] as $obj) {
                    $agroecologicalPracticeNews = new AgroecologicalPracticeNews();
                    $news = $em->getRepository("AppBundle:News")->findOneBy(array('id' => $obj));
                    $agroecologicalPracticeNews->setNews($news);
                    $agroecologicalPracticeNews->setAgroecologicalPractice($practice);
                    $em->persist($agroecologicalPracticeNews);
                }
            }

            $em->persist($googleMap);

            $practice->setPracticeMembers($serialized_members);
            $practice->setAddress($googleMap);
            $practice->setRelatedInstitutions($serialized_institutions);
            $practice->setUser($this->getUser());

            //Contact Means
            $contactMean = new ContactMean();
            if (array_filter($_POST['appbundle_agroecologicalpractice']['contact_mean'])) {
                $contactMean->setFirstName($_POST['appbundle_agroecologicalpractice']['contact_mean']['firstName']);
                $contactMean->setLastName($_POST['appbundle_agroecologicalpractice']['contact_mean']['lastName']);
                $contactMean->setPhone($_POST['appbundle_agroecologicalpractice']['contact_mean']['phone']);
                $contactMean->setCellPhone($_POST['appbundle_agroecologicalpractice']['contact_mean']['cell_phone']);
                $contactMean->setEmail($_POST['appbundle_agroecologicalpractice']['contact_mean']['email']);
                $contactMean->setFacebook($_POST['appbundle_agroecologicalpractice']['contact_mean']['facebook']);
                $contactMean->setWebsite($_POST['appbundle_agroecologicalpractice']['contact_mean']['website']);
                $contactMean->setComment($_POST['appbundle_agroecologicalpractice']['contact_mean']['comment']);

                $practice->setContactMean($contactMean);
                $em->persist($contactMean);
            } else {
                $practice->setContactMean(NULL);
            }

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
                $this->get('translator')->trans('Agroecological Practice has been successfully updated!')
            );
            return $this->redirectToRoute('agroecological_practice_list');

        }

        if (is_object($practice->getMarketingSpaces()))
            $practiceTypeId = $practice->getMarketingSpaces()->getType()->getId();

        if (is_object($practice->getProductiveUndertaking()))
            $practiceTypeId = $practice->getProductiveUndertaking()->getType()->getId();

        if (is_object($practice->getProfessionalServices()))
            $practiceTypeId = $practice->getProfessionalServices()->getType()->getId();

        if (is_object($practice->getInstitutionalProject()))
            $practiceTypeId = $practice->getInstitutionalProject()->getType()->getId();

        if (is_object($practice->getPromotionGroup()))
            $practiceTypeId = $practice->getPromotionGroup()->getType()->getId();


        return $this->render('agroindustrial_practice/form.html.twig', array(
            'form' => $form->createView(),
            'entity' => $practice,
            'practiceTypeId' => $practiceTypeId,
            'news' => $news,
            'practicenews' => $practiceNews
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
