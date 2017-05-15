<?php 

namespace AppBundle\Controller\User;

use AppBundle\Entity\CaseStudy;
use AppBundle\Entity\City;
use AppBundle\Entity\GoogleMap;
use AppBundle\Entity\Institution;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\UserProfileType;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\UserProfile;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/profile")
 */
class UserController extends Controller
{
    /**
     * @param $request
     * @param $user
     * @Security("has_role('ROLE_INVESTIGATOR')")
     * @Route("/edit/{id}", name="user_edit")
     * @return array
     */
    public function updateAction(Request $request, User $user)
    {
        $securityContext = $this->container->get('security.context');
        $router = $this->container->get('router');
        if ($securityContext->isGranted('ROLE_ADMIN') || $securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            return new RedirectResponse($router->generate('dashboard'), 307);
        }elseif ($securityContext->isGranted('ROLE_PRODUCER')){
            return new RedirectResponse($router->generate('fos_user_profile_show', array('id' =>$user->getId())), 307);
        }
        $request->setMethod('PATCH');
        $form = $this->createForm(new UserType(), $user, ["method" => $request->getMethod()]);
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository("AppBundle:UserProfile")->findOneBy(
            array(
                'user' => $user->getId(),
            ));

        if ($profile == null)
        {
            $profile =  new UserProfile();
            $googleMap = new GoogleMap();
            $case_study = new CaseStudy();
        }else{
            $googleMap = $em->getRepository("AppBundle:GoogleMap")->findOneBy(
                array(
                    'id' => $profile->getAddress(),
                )
            );

            $case_study = $em->getRepository("AppBundle:CaseStudy")->findOneBy(
                array(
                    'id' => $profile->getCaseStudy(),
                ));
            if($case_study == null){
                $case_study = new CaseStudy();
                $caseStudyAddress = new GoogleMap();
            }else{
                $caseStudyAddress = $em->getRepository("AppBundle:GoogleMap")->findOneBy(
                    array(
                        'id' => $profile->getCaseStudy()->getAddress(),
                    )
                );
            }
        }

        if ($form->handleRequest($request)->isValid())
        {
            $knowledge = $em->getRepository("AppBundle:Knowledge")->find($_POST['knowledge']);
            $studyTopic = $em->getRepository("AppBundle:StudyTopic")->find($_POST['study_topic']);
            $researchPlace = $em->getRepository("AppBundle:City")->find($_POST['research_place']);

            $image = $form->get('image')->getData();
            $googleMap->setAddress($_POST['address']);
            $googleMap->setLatitude($_POST['latitude']);
            $googleMap->setLongitude($_POST['longitude']);

            if(!empty($_POST['institution'])){
                $institution = $em->getRepository("AppBundle:Institution")->find($_POST['institution']);
            }
            else {
                if(!empty($_POST['institution_name'])){
                    $institution = New Institution();
                    $institution->setName($_POST['institution_name']);
                    $type = $em->getRepository("AppBundle:InstitutionType")->find($_POST['institution_type']);
                    $institution->setType($type);
                }
            }
            
            if(!empty($_POST['city_name'])){
                $city = new City();
                $city->setName($_POST['city_name']);
                $region = $em->getRepository("AppBundle:Region")->find($_POST['region']);
                $city->setRegion($region);
                $profile->setResidencePlace($city);
            }else{
                $residencePlace = $em->getRepository("AppBundle:City")->find($_POST['residence_place']);
                $profile->setResidencePlace($residencePlace);
            }
            if(!empty($_POST['city_name2'])){
                $city2 = new City();
                $city2->setName($_POST['city_name2']);
                $region = $em->getRepository("AppBundle:Region")->find($_POST['region2']);
                $city2->setRegion($region);
                $profile->setResearchPlace($city2); 
            }else{
                $profile->setResearchPlace($researchPlace);
            }

//            $caseStudyAddress->setAddress($_POST['case_study_address']);
//            $caseStudyAddress->setLatitude($_POST['case_study_latitude']);
//            $caseStudyAddress->setLongitude($_POST['case_study_longitude']);
            if(!empty($_POST['case_study'])){ $case_study->setName($_POST['case_study']); }
            if(!empty($_POST['case_study_description'])){ $case_study->setDescription($_POST['case_study_description']); }
            if(!empty($_POST['keywords'])){ $case_study->setKeywords($_POST['keywords']); }
            if(!empty($_POST['graphic_information'])){ $case_study->setGraphicInformation($_POST['graphic_information']); }
            if(!empty($_POST['investigation_lines'])){ $case_study->setInvestigationLines($_POST['investigation_lines']); }
            if(!empty($_POST['research_group'])){ $case_study->setResearchGroup($_POST['research_group']); }
            if(!empty($_POST['related_institution'])){ $case_study->setRelatedInstitution($_POST['related_institution']); }
            if(!empty($_POST['links'])){ $case_study->setLinks($_POST['links']); }
            if(!empty($_POST['contact_info'])){ $case_study->setContactInfo($_POST['contact_info']); }
            

            $profile->setUser($user);
            $profile->setJobTitle($_POST['job_title']);
            $profile->setSummary($_POST['summary']);
            if (isset($institution)) {
                $profile->setInstitution($institution);
                $em->persist($institution);
            }
            else { 
                if (!empty($_POST['other_institution'])) {
                    $profile->setOtherInstitution($_POST['other_institution']);
                }
            }
            
            $profile->setAddress($googleMap);
            $profile->setKnowledge($knowledge);
            $profile->setStudyTopic($studyTopic);
            $profile->setCaseStudy($case_study);
            $user->setCompleteData(1);
            
            if($image != NULL)
            {
                $user->setImageName($image);
            }
            $em->persist($user);            
            $em->persist($googleMap);
            $em->persist($case_study);
            if(!empty($_POST['city_name'])){
                $em->persist($city);
            }
            if(!empty($_POST['city_name2'])){
                $em->persist($city2);
            }
            $em->persist($profile);

            $em->flush();

            /*
             * Refresh session to role
             * $token = new UsernamePasswordToken(
                $user,
                null,
                'main',
                $user->getRoles()
            );
            $this->container->get('security.context')->setToken($token);*/

            $this->get('session')->migrate();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('User has been succesfully updated!')
            );
            return $this->redirectToRoute('fos_user_profile_show');
        }
        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $user,
            'profile' => $profile,
        ));
    }

    /**
     * @param $request
     * @param $user
     * @Security("has_role('ROLE_PRODUCER')")
     * @Route("/producer/edit/{id}", name="user_producer_edit")
     * @return array
     */
    public function updateProducerAction(Request $request, User $user)
    {
        $securityContext = $this->container->get('security.context');
        $router = $this->container->get('router');
        if ($securityContext->isGranted('ROLE_ADMIN') || $securityContext->isGranted('ROLE_SUPER_ADMIN')) {
            return new RedirectResponse($router->generate('dashboard'), 307);
        }elseif ($securityContext->isGranted('ROLE_INVESTIGATOR')){
            return new RedirectResponse($router->generate('user_edit', array('id' =>$user->getId())), 307);
        }

        $request->setMethod('PATCH');
        $form = $this->createForm(new UserType(), $user, ["method" => $request->getMethod()]);
        $em = $this->getDoctrine()->getManager();

        if ($form->handleRequest($request)->isValid())
        {
            $image = $form->get('image')->getData();
            $user->setCompleteData(1);

            if($image != NULL)
            {
                $user->setImageName($image);
            }
            $em->persist($user);
            $em->flush();
            $this->get('session')->migrate();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('User has been succesfully updated!')
            );
            return $this->redirectToRoute('fos_user_profile_show');
        }
        return $this->render('FOSUserBundle:Profile/Producer:edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $user,
        ));
    }

    /**
     * Generate the redirection url when editing is completed.
     *
     * @param \FOS\UserBundle\Model\UserInterface $user
     *
     * @return string
     */
    protected function getRedirectionUrl(UserInterface $user)
    {
        return $this->container->get('router')->generate('fos_user_profile_show');
    }

    /**
     * @param string $action
     * @param string $value
     */
    protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }
}