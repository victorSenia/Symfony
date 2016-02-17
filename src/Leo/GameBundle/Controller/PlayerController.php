<?php

namespace Leo\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\GameBundle\Entity\Game;
use Leo\GameBundle\Form\GameType;

/**
 * Player controller.
 *
 */
class PlayerController extends Controller {

    /**
     * Lists all Game entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $games = $em->getRepository('LeoUserBundle:User')->findAll();
//        $games = $em->getRepository('LeoGameBundle:Game')->findAll();

        return $this->render('LeoGameBundle:Player:index.html.twig', array(
                    'games' => $games,
        ));
    }

    /**
     * Finds and displays a Game entity.
     *
     */
    public function showAction(Game $game) {
        return $this->render('LeoGameBundle:Player:show.html.twig', array(
                    'game' => $game,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Game entity.
     *
     */
    public function editAction(Request $request, Game $game) {
        $editForm = $this->createForm('Leo\GameBundle\Form\GameType', $game);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($game);
            $em->flush();

            return $this->redirectToRoute('game_edit', array('id' => $game->getId()));
        }

        return $this->render('LeoGameBundle:Player:edit.html.twig', array(
                    'game' => $game,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

}
