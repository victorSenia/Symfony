<?php
namespace Leo\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Leo\UserBundle\Entity\User;
use Leo\BlogBundle\Entity\Post;

/**
 * Comment
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Leo\BlogBundle\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\Length(min=4)
     * @Assert\NotBlank()
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var \DateTime
     * @ORM\Column(name="create_time", type="datetimetz")
     */
    private $createTime;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_time", type="datetimetz", nullable=true)
     */
    private $updateTime;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Leo\UserBundle\Entity\User", inversedBy="comment")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $author;

    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $post;

    public function __toString()
    {
        return $this->getComment();
    }

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
     * Set comment
     *
     * @param string $comment
     *
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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
    public function setUpdateTime() {
        $this->updateTime = new \DateTime();
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime() {
        return $this->updateTime;
    }

    /**
     * Set author
     *
     * @param User $author
     *
     * @return Comment
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
     * Set post
     *
     * @param Post $post
     *
     * @return Comment
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
        return $this;
    }

    /**
     * Get post
     *
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
