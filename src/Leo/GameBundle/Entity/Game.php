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
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $typeGame;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Player", inversedBy="play")
     * @ORM\JoinTable(name="players_test")
     */
    private $players;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Player", inversedBy="watch")
     * @ORM\JoinTable(name="watchers_test")
     */
    private $watchers;

    /**
     * Constructor
     */
    public function __construct() {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->watchers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->name;
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
     * @param Player $players
     * @return Game
     */
    public function addPlayer(Player $players) {
//        die("addPlayer");
        $this->players[] = $players;

//        $players->addPlay($this);
        return $this;
    }

    /**
     * Remove players
     * @param Player $players
     */
    public function removePlayer(Player $players) {

        die("removePlayer");
        $this->players->removeElement($players);
//        $players->removePlay($this);
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
     * @param Player $watchers
     * @return Game
     */
    public function addWatcher(Player $watchers) {
//        die("addWatcher");
        $this->watchers[] = $watchers;

//        $watchers->addPlay($this);
        return $this;
    }

    /**
     * Remove watchers
     * @param Player $watchers
     */
    public function removeWatcher(Player $watchers) {
        die("removeWatcher");
        $this->watchers->removeElement($watchers);
//        $watchers->removeWatch($this);
    }

    /**
     * Get watchers
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWatchers() {
        return $this->watchers;
    }

}
