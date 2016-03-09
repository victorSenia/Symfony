<?php
namespace Leo\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Leo\UserBundle\Entity\User;
use Leo\BlogBundle\Entity\Comment;

/**
 * Post
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Leo\BlogBundle\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Post{
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
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(min=4)
     * @Assert\NotBlank()
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var \DateTime
     * @ORM\Column(name="create_time", type="datetimetz")
     */
    private $createTime;

    /**
     * @var \DateTime
     * @ORM\Column(name="update_time", type="datetimetz", nullable=true)
     */
    private $updateTime;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Leo\UserBundle\Entity\User", inversedBy="post")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $author;

    /**
     * @var Comment
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $comments;

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
     *
     * @return Post
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
     * Set text
     *
     * @param string $text
     *
     * @return Post
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreateTime()
    {
        $this->createTime = new \DateTime();
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdateTime()
    {
        $this->updateTime = new \DateTime();
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Post
     */
    public function setAuthor(User $author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comments
     *
     * @param \Leo\BlogBundle\Entity\Comment $comments
     *
     * @return Post
     */
    public function addComment(\Leo\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Leo\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Leo\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
