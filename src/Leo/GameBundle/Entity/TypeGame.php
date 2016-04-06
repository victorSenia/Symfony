<?php
namespace Leo\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Leo\GameBundle\Entity\Game;

/**
 * Game
 * @ORM\Table(name="type_game")
 * @ORM\Entity(repositoryClass="Leo\GameBundle\Repository\TypeGameRepository")
 */
class TypeGame
{

    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(min=4, max=25)
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=30, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Game", mappedBy="typeGame", cascade={"persist"})
     * @var array(Game)
     */
    private $games;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Game
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->games = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add games
     *
     * @param \Leo\GameBundle\Entity\Game $games
     * @return TypeGame
     */
    public function addGame(Game $games)
    {
        $this->games[] = $games;
        return $this;
    }

    /**
     * Remove games
     *
     * @param Game $games
     */
    public function removeGame(Game $games)
    {
        $this->games->removeElement($games);
    }

    /**
     * Get games
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGames()
    {
        return $this->games;
    }

    public function __toString()
    {
        return $this->getName();
    }

}
