<?php

namespace AppBundle\Controller;

use AppBundle\Form\MediaType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Media;

/**
 * @Route("/media")
 */
class MediaController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="media_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:Media")->findAll();
        return $this->render('media/list.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @param Request $request
     * @Security("has_role('ROLE_USER')")
     * @Route("/new", name="media_new")
     * @return array
     */
    public function newAcion(Request $request)
    {
        $entity = new Media();
        $form = $this->createForm(new MediaType(), $entity);


        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedBy($this->getUser());
            $em->persist($entity);
            $em->flush();
            $this->addFlash(
                'success',
                'Media has been successfully added!'
            );
            return $this->redirectToRoute('media_list');
        }
        return $this->render('media/form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param Media $entity entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{id}", name="media_edit")
     * @return array
     */
    public function putAction(Request $request, Media $entity)
    {
        $request->setMethod('PATCH');

        $form = $this->createForm(new MediaType(), $entity, ["method" => $request->getMethod()]);
        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash(
                'success',
                'Media has been succesfully updated!'
            );
            return $this->redirectToRoute('media_list');
        }
        return $this->render('media/form.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity
        ));
    }

    /**
     * @param Media $entity entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/delete/{id}", name="media_delete")
     * @return route
     */
    public function deleteAction(Media $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $this->addFlash(
            'success',
            'Media has been succesfully deleted!'
        );
        return $this->redirectToRoute('media_list');
    }
}