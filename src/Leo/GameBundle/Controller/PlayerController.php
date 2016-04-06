<?php
namespace Leo\GameBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\UserBundle\Entity\User;

/**
 * Player controller.
 */
class PlayerController extends Controller
{

    /**
     * Lists all Player entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $players = $em->getRepository('LeoUserBundle:User')->findAllWithGames();
        return $this->render('LeoGameBundle:Player:index.html.twig', array(
            'players' => $players,
        ));
    }

    /**
     * Finds and displays a Player entity.
     */
    public function showAction(User $player)
    {
        return $this->render('LeoGameBundle:Player:show.html.twig', array(
            'player' => $player,
        ));
    }

    /**
     * Displays a form to edit an existing Player entity.
     */
    public function editAction(Request $request, User $player)
    {
        $editForm = $this->createForm('Leo\GameBundle\Form\PlayerType', $player);
        $play = new ArrayCollection();
        foreach($player->getPlay() as $item)
            $play->add($item);
        $watch = new ArrayCollection();
        foreach($player->getWatch() as $item)
            $watch->add($item);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($play as $item)
                if($player->getPlay()->contains($item) === FALSE)
                    $item->removePlayer($player);
            foreach($watch as $item)
                if($player->getWatch()->contains($item) === FALSE)
                    $item->removeWatcher($player);
            foreach($player->getPlay() as $item)
                if($play->contains($item) === FALSE)
                    $item->addPlayer($player);
            foreach($player->getWatch() as $item)
                if($watch->contains($item) === FALSE)
                    $item->addWatcher($player);
            $em->flush();
            return $this->redirectToRoute('player_edit', array('id' => $player->getId()));
        }
        return $this->render('LeoGameBundle:Player:edit.html.twig', array(
            'player' => $player,
            'edit_form' => $editForm->createView(),
        ));
    }
//
//    public function deleteAction(Request $request, $user_id, $type, $game_id)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $player = $em->find(User::class, $user_id);
//        $game = $em->find(Game::class, $game_id);
//        if($this->isGranted("ROLE_ADMIN") || $player == $this->getUser())
//            switch($type) {
//                case "play":
//                    $player->removePlay($game);
//                    break;
//                case "watch":
//                    $player->removeWatch($game);
//                    break;
//            }
//        $em->flush();
//        return $this->redirectToRoute('player_show', array('id' => $player->getId()));
//    }
}
