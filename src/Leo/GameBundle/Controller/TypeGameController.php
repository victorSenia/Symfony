<?php
namespace Leo\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\GameBundle\Entity\TypeGame;
use Leo\GameBundle\Form\TypeGameType;

/**
 * TypeGame controller.
 */
class TypeGameController extends Controller
{

    /**
     * Lists all TypeGame entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typeGames = $em->getRepository('LeoGameBundle:TypeGame')->findAll();
        return $this->render('LeoGameBundle:TypeGame:index.html.twig', array(
            'typeGames' => $typeGames,
        ));
    }

    /**
     * Creates a new TypeGame entity.
     */
    public function newAction(Request $request)
    {
        $typeGame = new TypeGame();
        $form = $this->createForm('Leo\GameBundle\Form\TypeGameType', $typeGame);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeGame);
            $em->flush();
            return $this->redirectToRoute('typegame_show', array('id' => $typeGame->getId()));
        }
        return $this->render('LeoGameBundle:TypeGame:new.html.twig', array(
            'typeGame' => $typeGame,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TypeGame entity.
     */
    public function showAction(TypeGame $typeGame)
    {
        $deleteForm = $this->createDeleteForm($typeGame);
        return $this->render('LeoGameBundle:TypeGame:show.html.twig', array(
            'typeGame' => $typeGame,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a TypeGame entity.
     *
     * @param TypeGame $typeGame The TypeGame entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeGame $typeGame)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typegame_delete', array('id' => $typeGame->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing TypeGame entity.
     */
    public function editAction(Request $request, TypeGame $typeGame)
    {
        $deleteForm = $this->createDeleteForm($typeGame);
        $editForm = $this->createForm('Leo\GameBundle\Form\TypeGameType', $typeGame);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $em->persist($typeGame);
            $em->flush();
//            return $this->redirectToRoute('typegame_edit', array('id' => $typeGame->getId()));
        }
        return $this->render('LeoGameBundle:TypeGame:edit.html.twig', array(
            'typeGame' => $typeGame,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TypeGame entity.
     */
    public function deleteAction(Request $request, TypeGame $typeGame)
    {
        $form = $this->createDeleteForm($typeGame);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeGame);
            $em->flush();
        }
        return $this->redirectToRoute('typegame_index');
    }

}
