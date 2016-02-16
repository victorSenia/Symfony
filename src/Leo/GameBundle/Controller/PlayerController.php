<?php

namespace Leo\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\GameBundle\Entity\Player;

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

        $players = $em->getRepository('LeoGameBundle:Player')->findAll();

        return $this->render('LeoGameBundle:Player:index.html.twig', array(
                    'players' => $players,
        ));
    }

    /**
     * Finds and displays a Player entity.
     *
     */
    public function showAction(Player $player) {

        return $this->render('LeoGameBundle:Player:show.html.twig', array(
                    'player' => $player,
        ));
    }

}
