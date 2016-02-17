<?php

namespace Leo\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\GameBundle\Entity\Game;
use Leo\GameBundle\Form\GameType;

/**
 * Game controller.
 *
 */
class GameController extends Controller {

    /**
     * Lists all Game entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $games = $em->getRepository('LeoGameBundle:Game')->findAll();

        return $this->render('LeoGameBundle:Game:index.html.twig', array(
                    'games' => $games,
        ));
    }

    /**
     * Creates a new Game entity.
     *
     */
    public function newAction(Request $request) {
        $game = new Game();
        $form = $this->createForm('Leo\GameBundle\Form\GameType', $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_show', array('id' => $game->getId()));
        }

        return $this->render('LeoGameBundle:Game:new.html.twig', array(
                    'game' => $game,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Game entity.
     *
     */
    public function showAction(Game $game) {
        $deleteForm = $this->createDeleteForm($game);

        return $this->render('LeoGameBundle:Game:show.html.twig', array(
                    'game' => $game,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Game entity.
     *
     */
    public function editAction(Request $request, Game $game) {
        $deleteForm = $this->createDeleteForm($game);
        $editForm = $this->createForm('Leo\GameBundle\Form\GameType', $game);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->merge($game);
            $em->flush();

            return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
        }

        return $this->render('LeoGameBundle:Game:edit.html.twig', array(
                    'game' => $game,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Game entity.
     *
     */
    public function deleteAction(Request $request, Game $game) {
        $form = $this->createDeleteForm($game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($game);
            $em->flush();
        }

        return $this->redirectToRoute('game_index');
    }

    /**
     * Creates a form to delete a Game entity.
     *
     * @param Game $game The Game entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Game $game) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('game_delete', array('id' => $game->getId())))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

}
