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
     * Lists all Player entities.
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
     * Finds and displays a Player entity.
     *
     */
    public function showAction(User $player) {
        return $this->render('LeoGameBundle:Player:show.html.twig', array(
                    'player' => $player,
        ));
    }

    /**
     * Displays a form to edit an existing Player entity.
     *
     */
    public function editAction(Request $request, User $player) {
        $editForm = $this->createFormBuilder($player)->add("play")->add("watch")->getForm();
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->refresh($player);
            foreach (array_diff_key($this->arrayWithKey($player->getWatch()), $this->arrayWithKey($editForm->get("watch")->getData())) as $value) {
                $player->removeWatch($value);
            }
            foreach (array_diff_key($this->arrayWithKey($editForm->get("watch")->getData()), $this->arrayWithKey($player->getWatch())) as $value) {
                $player->addWatch($value);
            }
            foreach (array_diff_key($this->arrayWithKey($player->getPlay()), $this->arrayWithKey($editForm->get("play")->getData())) as $value) {
                $player->removePlay($value);
            }
            foreach (array_diff_key($this->arrayWithKey($editForm->get("play")->getData()), $this->arrayWithKey($player->getPlay())) as $value) {
                $player->addPlay($value);
            }
//            $em->persist($player);
            $em->flush();

            return $this->redirectToRoute('player_show', array('id' => $player->getId()));
        }

        return $this->render('LeoGameBundle:Player:edit.html.twig', array(
                    'player' => $player,
                    'edit_form' => $editForm->createView(),
        ));
    }

    public function deleteAction(Request $request, $user_id, $type, $game_id) {

        $em = $this->getDoctrine()->getManager();
        $player = $em->find(User::class, $user_id);
        $game = $em->find(Game::class, $game_id);

        if ($this->isGranted("ROLE_ADMIN") || $player == $this->getUser())
            switch ($type) {
                case "play":
                    $player->removePlay($game);
                    break;
                case "watch":
                    $player->removeWatch($game);
                    break;
            }
        $em->flush();

        return $this->redirectToRoute('player_show', array('id' => $player->getId()));
    }

    private function arrayWithKey($array) {
        $temp_array = array();
        foreach ($array as $element)
            $temp_array[$element->getId()] = $element;
        return $temp_array;
    }

}
