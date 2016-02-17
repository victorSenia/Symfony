<?php

namespace Leo\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\GameBundle\Entity\Game;
use Leo\GameBundle\Form\GameType;
use Leo\UserBundle\Entity\User;

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

        $players = $em->getRepository('LeoUserBundle:User')->findAllWithGames();

        return $this->render('LeoGameBundle:Player:index.html.twig', array(
                    'players' => $players,
        ));
    }

    /**
     * Finds and displays a Game entity.
     *
     */
    public function showAction(User $player) {
        return $this->render('LeoGameBundle:Player:show.html.twig', array(
                    'player' => $player,
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
