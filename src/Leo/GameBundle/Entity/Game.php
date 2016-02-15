<?php

namespace Leo\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Leo\GameBundle\Entity\Player;

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
     * @var \Leo\UserBundle\Entity\TypeGame
     * @ORM\ManyToOne(targetEntity="TypeGame", inversedBy="games")
     */
    private $typeGame;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Player", inversedBy="play")
     * @ORM\JoinTable(name="players")
     */
    private $players;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Player", inversedBy="watch")
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
     * @param \Leo\UserBundle\Entity\TypeGame $typeGame
     * @return Game
     */
    public function setTypeGame(\Leo\UserBundle\Entity\TypeGame $typeGame = null) {
        $this->typeGame = $typeGame;

        return $this;
    }

    /**
     * Get typeGame
     * @return \Leo\UserBundle\Entity\TypeGame
     */
    public function getTypeGame() {
        return $this->typeGame;
    }

    /**
     * Add players
     * @param \Leo\UserBundle\Entity\Player $players
     * @return Game
     */
    public function addPlayer(\Leo\UserBundle\Entity\Player $players) {
        $this->players[] = $players;

        return $this;
    }

    /**
     * Remove players
     * @param \Leo\UserBundle\Entity\Player $players
     */
    public function removePlayer(\Leo\UserBundle\Entity\Player $players) {
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
     * @param \Leo\UserBundle\Entity\Player $watchers
     * @return Game
     */
    public function addWatcher(\Leo\UserBundle\Entity\Player $watchers) {
        $this->watchers[] = $watchers;

        return $this;
    }

    /**
     * Remove watchers
     * @param \Leo\UserBundle\Entity\Player $watchers
     */
    public function removeWatcher(\Leo\UserBundle\Entity\Player $watchers) {
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
