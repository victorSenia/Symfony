<?php

namespace Leo\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Leo\UserBundle\Entity\User;
use Leo\GameBundle\Entity\TypeGame;

/**
 * Game
 *
 * @ORM\Table(name="game")
 * @ORM\Entity(repositoryClass="Leo\GameBundle\Repository\GameRepository")
 */
class Game {

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var TypeGame
     * @ORM\ManyToOne(targetEntity="TypeGame", inversedBy="games")
     * @ORM\JoinColumn(name="type_game_id", referencedColumnName="id", nullable=false)
     */
    private $typeGame;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Leo\UserBundle\Entity\User", inversedBy="play")
     * @ORM\JoinTable(name="players")
     */
    private $players;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Leo\UserBundle\Entity\User", inversedBy="watch")
     * @ORM\JoinTable(name="watchers")
     */
    private $watchers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->watchers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     * @param string $name
     * @return Game
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set typeGame
     * @param TypeGame $typeGame
     * @return Game
     */
    public function setTypeGame(TypeGame $typeGame) {
        $this->typeGame = $typeGame;

        return $this;
    }

    /**
     * Get typeGame
     * @return TypeGame
     */
    public function getTypeGame() {
        return $this->typeGame;
    }

    /**
     * Add players
     * @param \Leo\UserBundle\Entity\User $players
     * @return Game
     */
    public function addPlayer(User $players) {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     * @param \Leo\UserBundle\Entity\User $players
     */
    public function removePlayer(User $players) {
        $this->players->removeElement($players);
    }

    /**
     * Get players
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers() {
        return $this->players;
    }

    /**
     * Add watchers
     * @param Leo\UserBundle\Entity\User $watchers
     * @return Game
     */
    public function addWatcher(User $watchers) {
        $this->watchers[] = $watchers;

        return $this;
    }

    /**
     * Remove watchers
     * @param Leo\UserBundle\Entity\User $watchers
     */
    public function removeWatcher(User $watchers) {
        $this->watchers->removeElement($watchers);
    }

    /**
     * Get watchers
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWatchers() {
        return $this->watchers;
    }

}
