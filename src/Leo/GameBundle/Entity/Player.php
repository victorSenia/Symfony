<?php

namespace Leo\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Leo\UserBundle\Entity\User;
use Leo\GameBundle\Entity\Game;
use Doctrine\Common\Collections\Collection;

/**
 * Player
 *
 * @ORM\Table(name="player")
 * @ORM\Entity(repositoryClass="Leo\GameBundle\Repository\PlayerRepository")
 */
class Player {

    /**
     * @var \Leo\UserBundle\Entity\User
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="\Leo\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="watchers")
     */
    private $watch;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Game", mappedBy="players")
     */
    private $play;

    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->watch = new ArrayCollection();
        $this->play = new ArrayCollection();
    }

    /**
     * Add watch
     *
     * @param Game $watch
     * @return Player
     */
    public function addWatch(Game $watch) {
        $this->watch[] = $watch;

        return $this;
    }

    /**
     * Remove watch
     *
     * @param Game $watch
     */
    public function removeWatch(Game $watch) {
        $this->watch->removeElement($watch);
    }

    /**
     * Get watch
     *
     * @return Collection
     */
    public function getWatch() {
        return $this->watch;
    }

    /**
     * Add play
     *
     * @param Game $play
     * @return Player
     */
    public function addPlay(Game $play) {
        $this->play[] = $play;

        return $this;
    }

    /**
     * Remove play
     *
     * @param Game $play
     */
    public function removePlay(Game $play) {
        $this->play->removeElement($play);
    }

    /**
     * Get play
     *
     * @return Collection
     */
    public function getPlay() {
        return $this->play;
    }

    /**
     * Set user
     *
     * @param \Leo\UserBundle\Entity\User $user
     * @return Player
     */
    public function setUser(\Leo\UserBundle\Entity\User $user) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Leo\UserBundle\Entity\User
     */
    public function getUser() {
        return $this->user;
    }

    public function __toString() {
        return $this->getUser()->getUsername();
    }

}
