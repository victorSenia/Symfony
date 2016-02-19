<?php

namespace Leo\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Leo\UserBundle\Entity\User;
use Leo\GameBundle\Entity\TypeGame;
use Leo\GameBundle\Entity\Game;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="Leo\GameBundle\Repository\PlayerRepository")
 */
class Player {

    /**
     * @var User
     * @ORM\OneToOne(targetEntity="Leo\UserBundle\Entity\User")
     * @ORM\Id
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity="\Leo\GameBundle\Entity\Game", mappedBy="players")
     * @ORM\JoinTable(name="players_test")
     */
    private $play;

    /**
     * @ORM\ManyToMany(targetEntity="\Leo\GameBundle\Entity\Game", mappedBy="watchers")
     * @ORM\JoinTable(name="watchers_test")
     */
    private $watch;

    public function __construct() {
        $this->play = new \Doctrine\Common\Collections\ArrayCollection();
        $this->watch = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add play
     *
     * @param Game $play
     * @return Player
     */
    public function addPlay(Game $play) {
//        die("addWatch");
        $this->play[] = $play;
//        $play->addPlayer($this);
        return $this;
    }

    /**
     * Remove play
     *
     * @param Game $play
     */
    public function removePlay(Game $play) {
//        die("addWatch");
        $this->play->removeElement($play);
//        $play->removePlayer($this);
    }

    /**
     * Get play
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlay() {
        return $this->play;
    }

    /**
     * Add watch
     *
     * @param Game $watch
     * @return Player
     */
    public function addWatch(Game $watch) {
//        die("addWatch");
        $this->watch[] = $watch;
//        $watch->addWatcher($this);

        return $this;
    }

    /**
     * Remove watch
     *
     * @param Game $watch
     */
    public function removeWatch(Game $watch) {
//        die("addWatch");
        $this->watch->removeElement($watch);
//        $watch->removeWatcher($this);
    }

    /**
     * Get watch
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWatch() {
        return $this->watch;
    }

    /**
     * Set User
     *
     * @param User $user
     * @return Player
     */
    public function setUser($user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser() {
        return $this->user;
    }

    public function __toString() {
        return $this->user->getUsername();
    }

}
