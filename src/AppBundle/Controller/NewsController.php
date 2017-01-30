<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Form\NewsType;

/**
 * @Route("/news")
 */
class NewsController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="news_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:News")->findAll();
        return $this->render('news/list.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @param Request $request
     * @Security("has_role('ROLE_USER')")
     * @Route("/new", name="news_new")
     * @return array
     */
    public function newAcion(Request $request)
    {
        $entity = new News();
        $form = $this->createForm(new NewsType(), $entity);


        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreatedBy($this->getUser());
            $em->persist($entity);
            $em->flush();
            $this->addFlash(
                'success',
                'News has been successfully added!'
            );
            return $this->redirectToRoute('news_list');
        }
        return $this->render('news/form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @param News $entity entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{id}", name="news_edit")
     * @return array
     */
    public function putAction(Request $request, News $entity)
    {
        $request->setMethod('PATCH');

        $form = $this->createForm(new NewsType(), $entity, ["method" => $request->getMethod()]);
        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash(
                'success',
                'News has been succesfully updated!'
            );
            return $this->redirectToRoute('news_list');
        }
        return $this->render('news/form.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity
        ));
    }

    /**
     * @param News $entity entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/delete/{id}", name="news_delete")
     * @return route
     */
    public function deleteAction(News $entity)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $this->addFlash(
            'success',
            'News has been succesfully deleted!'
        );
        return $this->redirectToRoute('news_list');
    }
}