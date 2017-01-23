<?php 

namespace AppBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{id}", name="user_edit")
     * @return array
     */
    public function updateAction(Request $request, User $user)
    {
        $request->setMethod('PATCH');
        $form = $this->createForm(new UserType(), $user, ["method" => $request->getMethod()]);
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository("AppBundle:UserProfile")->findOneBy(
            array(
                'user' => $user->getId(),
            ));

        if ($profile == null)
        {
            $profile = new UserProfile();
            //by default lat and lng t
            $profile->setLatitude(0);
            $profile->setLongitude(0);
        }

        if ($form->handleRequest($request)->isValid())
        {
            $image = $form->get('image')->getData();

            $profile->setUser($user);
            $profile->setJobTitle($_POST['job_title']);
            $profile->setAddress($_POST['address']);
            $profile->setSummary($_POST['summary']);
            $profile->setLatitude($_POST['latitude']);
            $profile->setLongitude($_POST['longitude']);

            if($image != NULL)
            {
                $user->setImageName($image);
                $em->persist($user);
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
                'User has been succesfully updated!'
            );
            return $this->redirectToRoute('fos_user_profile_show');
        }
        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
            'entity' => $user,
            'profile' => $profile
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