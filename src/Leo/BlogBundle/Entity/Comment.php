<?php

namespace Leo\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Leo\UserBundle\Entity\User;
use Leo\BlogBundle\Entity\Post;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Leo\BlogBundle\Repository\CommentRepository")
 */
class Comment {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var Leo\UserBundle\Entity\User
     * @ORM\ManyToOne(targetEntity="Leo\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     */
    private $author;

    /**
     * @var Post
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment) {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment() {
        return $this->comment;
    }

    /**
     * Set author
     *
     * @param Leo\UserBundle\Entity\User $author
     * @return Comment
     */
    public function setAuthor(User $author) {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return User
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * Set post
     *
     * @param Post $post
     * @return Comment
     */
    public function setPost(Post $post) {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return Post
     */
    public function getPost() {
        return $this->post;
    }

}
