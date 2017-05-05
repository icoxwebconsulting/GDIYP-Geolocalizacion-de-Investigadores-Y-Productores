<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Form\CategoryType;

/**
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/", name="category_list")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository("AppBundle:Category")->findAll();
        return $this->render('category/list.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * @param Request $request
     * @Security("has_role('ROLE_USER')")
     * @Route("/new", name="category_new")
     * @return array
     */
    public function newAcion(Request $request)
    {
        $entity = new Category();
        $form = $this->createForm(new CategoryType(), $entity);


        if($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $status = $em->getRepository("AppBundle:Status")->find(1);
            $entity->setStatus($status);
            $em->persist($entity);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('Category has been successfully added!')
            );
            return $this->redirectToRoute('category_list');
        }
        return $this->render('category/form.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity
        ));
    }

    /**
     * @param Request $request
     * @param Category $entity entity
     * @Security("has_role('ROLE_USER')")
     * @Route("/edit/{id}", name="category_edit")
     * @return array
     */
    public function putAction(Request $request, Category $entity)
    {
        $request->setMethod('PATCH');

        $form = $this->createForm(new CategoryType(), $entity, ["method" => $request->getMethod()]);
        if ($form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('Category has been succesfully updated!')
            );
            return $this->redirectToRoute('category_list');
        }
        return $this->render('category/form.html.twig', array(
            'form' => $form->createView(),
            'entity' => $entity
        ));
    }
}