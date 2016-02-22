<?php

namespace Leo\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\UserBundle\Entity\Role;
use Leo\UserBundle\Form\RoleType;

/**
 * Role controller.
 *
 */
class RoleController extends Controller {

    /**
     * Lists all Role entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $roles = $em->getRepository('LeoUserBundle:Role')->findAll();

        return $this->render('LeoUserBundle:Role:index.html.twig', array(
                    'roles' => $roles,
        ));
    }

    /**
     * Creates a new Role entity.
     *
     */
    public function newAction(Request $request) {
        $role = new Role();
        $form = $this->createForm('Leo\UserBundle\Form\RoleType', $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role_show', array('id' => $role->getId()));
        }

        return $this->render('LeoUserBundle:Role:new.html.twig', array(
                    'role' => $role,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Role entity.
     *
     */
    public function showAction(Role $role) {
        $deleteForm = $this->createDeleteForm($role);

        return $this->render('LeoUserBundle:Role:show.html.twig', array(
                    'role' => $role,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Role entity.
     *
     */
    public function editAction(Request $request, Role $role) {
        $deleteForm = $this->createDeleteForm($role);
        $editForm = $this->createForm('Leo\UserBundle\Form\RoleType', $role);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $em->persist($role);
            $em->flush();

            return $this->redirectToRoute('role_edit', array('id' => $role->getId()));
        }

        return $this->render('LeoUserBundle:Role:edit.html.twig', array(
                    'role' => $role,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Role entity.
     *
     */
    public function deleteAction(Request $request, Role $role) {
        $form = $this->createDeleteForm($role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($role);
            $em->flush();
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * Creates a form to delete a Role entity.
     *
     * @param Role $role The Role entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Role $role) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('role_delete', array('id' => $role->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
