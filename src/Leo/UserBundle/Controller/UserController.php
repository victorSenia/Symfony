<?php
namespace Leo\UserBundle\Controller;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\UserBundle\Entity\User;
use Leo\UserBundle\Entity\Role;

/**
 * User controller.
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('LeoUserBundle:User')->findAll();
        return $this->render('LeoUserBundle:user:index.html.twig', array('users' => $users,));
    }

    /**
     * Creates a new User entity.
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('Leo\UserBundle\Form\UserType', $user, array('validation_groups' => array('registration', 'Default'))//                , array("locale" => "en")
        );
        $form->remove("oldPassword");
        if(!$this->isGranted("ROLE_ADMIN")) {
            $form->remove("role")->remove("isActive");
            $user->setIsActive(TRUE);
            $role = $this->getDoctrine()->getManager()->find(Role::class, '1');
            $user->setRole($role);
        }
//        if (!$this->isGranted("ROLE_SUPER_ADMIN")) {
//            $role = $this->getDoctrine()->getManager()->find(Role::class, '3');
//            $form->get("role")->remove($role);
//            die();
//            var_dump($form->get("role")->count());
//            die();
//        }
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $encoded = $this->container->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }
        return $this->render('LeoUserBundle:user:new.html.twig', array('user' => $user, 'form' => $form->createView(),));
    }

    /**
     * Finds and displays a User entity.
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        return $this->render('LeoUserBundle:user:show.html.twig', array('user' => $user, 'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Creates a form to delete a User entity.
     *
     * @param User $user The User entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))->setMethod('DELETE')->getForm();
    }

    /**
     * Displays a form to edit an existing User entity.
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('Leo\UserBundle\Form\UserType', $user);
//        if($this->isGranted("ROLE_ADMIN"))
//            $editForm->remove("oldPassword");
        if(!$this->isGranted("ROLE_SUPER_ADMIN"))
            $editForm->remove("role");
        if(!$this->isGranted("ROLE_ADMIN"))
            $editForm->remove("isActive");
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            if($user->getPlainPassword() != NULL) {
                $oldPassword = $editForm->get('oldPassword');
                $encoder = $this->container->get('security.password_encoder');
                if(!$encoder->isPasswordValid($user, $oldPassword->getData())) {
                    $oldPassword->addError(new FormError("You have entered wrong password"));
                    return $this->render('LeoUserBundle:user:edit.html.twig', array('user' => $user, 'edit_form' => $editForm->createView(), 'delete_form' => $deleteForm->createView(),));
                }
                $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($encoded);
                $this->addFlash('info', 'Password is changed');
            }
            $em = $this->getDoctrine()->getManager();
//            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }
        return $this->render('LeoUserBundle:user:edit.html.twig', array('user' => $user, 'edit_form' => $editForm->createView(), 'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Deletes a User entity.
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }
        return $this->redirectToRoute('user_index');
    }
}
