<?php

namespace AppBundle\Controller\User;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * @Route("/register")
 */
class RegistrationController extends BaseController
{
    /**
     * Register user
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/", name="user_new")
     */
    public function registerAction()
    {
        $form = $this->container->get('fos_user.registration.form');
        $formHandler = $this->container->get('fos_user.registration.form.handler');
        $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

        $process = $formHandler->process($confirmationEnabled);
        if ($process) {
            $user = $form->getData();
            $role = $form->get('roles')->getData();

            $userManager = $this->container->get('fos_user.user_manager');
            $user->setRoles(array($role));

            $userManager->updateUser($user);

            if ($confirmationEnabled) {
                $route = 'fos_user_security_login';
                $this->setFlash(
                    'success',
                    'Por favor revise su correo electrónico. Contiene un enlace de activación al que debe hacer clic para activar su cuenta.'
                );
            } else {
                $this->_authenticateAccount($user);
                $route = 'fos_user_registration_confirmed';
            }

            $this->setFlash('fos_user_success', 'registration.flash.user_created');
            $url = $this->container->get('router')->generate($route);

            return new RedirectResponse($url);
        }

        return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function _authenticateAccount($user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_main', serialize($token));
    }

    /**
     * @param $token
     * @Route("/confirm/{token}", name="registration_confirm")
     * @return response
     */
    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        $router = $this->container->get('router');
        if (null === $user) {
            return new RedirectResponse($router->generate('dashboard'));
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $user->setLastLogin(new \DateTime());

        $this->container->get('fos_user.user_manager')->updateUser($user);

        $response = new RedirectResponse($this->container->get('router')->generate('fos_user_registration_confirmed'));        
        $this->authenticateUser($user, $response);
        
        $securityContext = $this->container->get('security.context');
        $router = $this->container->get('router');
        if ($securityContext->isGranted('ROLE_INVESTIGATOR')) {
            $response = new RedirectResponse($this->container->get('router')->generate('user_edit', array('id' => $user->getId())));
        }elseif ($securityContext->isGranted('ROLE_PRODUCER')){
            $response = new RedirectResponse($this->container->get('router')->generate('user_producer_edit', array('id' => $user->getId())));
        }


        return $response;
    }
}