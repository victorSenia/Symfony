<?php
namespace Leo\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Leo\BlogBundle\Entity\Comment;
use Leo\BlogBundle\Entity\Post;
use Leo\GameBundle\Entity\Game;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Leo\UserBundle\Repository\UserRepository")
 * @UniqueEntity("username")
 * @UniqueEntity("email")
 */
class User implements AdvancedUserInterface, \Serializable
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
     * @Assert\Length(min=4, max=20)
     * @Assert\NotBlank(groups={"registration"})
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     * @Assert\Email()
     * @Assert\NotBlank(groups={"registration"})
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     * @Assert\Length(min=4, max=40)
     * @Assert\NotBlank(groups={"registration"})
     */
    private $plainPassword;

    /**
     * @var string
     * @Assert\Length(max=40)
     * @ORM\Column(name="name", type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @var string
     * @Assert\Length(max=40)
     * @ORM\Column(name="surename", type="string", length=64, nullable=true)
     */
    private $surename;

    /**
     * @var boolean
     * @ORM\Column(name="is_active", type="boolean", options={"default"=true})
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="\Leo\GameBundle\Entity\Game", mappedBy="players")
     * @ORM\JoinTable(name="players")
     */
    private $play;

    /**
     * @ORM\ManyToMany(targetEntity="\Leo\GameBundle\Entity\Game", mappedBy="watchers")
     * @ORM\JoinTable(name="watchers")
     */
    private $watch;

    /**
     * @ORM\OneToMany(targetEntity="\Leo\BlogBundle\Entity\Post", mappedBy="author")
     */
    private $post;

    /**
     * @ORM\OneToMany(targetEntity="\Leo\BlogBundle\Entity\Comment", mappedBy="author")
     */
    private $comment;

    public function __construct()
    {
        $this->setIsActive(TRUE);
        $this->play = new \Doctrine\Common\Collections\ArrayCollection();
        $this->watch = new \Doctrine\Common\Collections\ArrayCollection();
        $this->post = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurename()
    {
        return $this->surename;
    }

    /**
     * @param mixed $surename
     */
    public function setSurename($surename)
    {
        $this->surename = $surename;
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
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize(array($this->id, $this->username, $this->password));
    }

    /**
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->username, $this->password) = unserialize($serialized);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUsername();
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set name
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials()
    {
//TODO
    }

    public function getRoles()
    {
        return array($this->getRole()->getRole(),);
    }

    /**
     * Get Role
     *
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set Role
     *
     * @param Role $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    public function getSalt()
    {
        return NULL;
    }

    public function isAccountNonExpired()
    {
        return TRUE;
//TODO
    }

    public function isAccountNonLocked()
    {
        return $this->getIsActive();
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function isCredentialsNonExpired()
    {
        return TRUE;
//TODO
    }

    public function isEnabled()
    {
        return $this->getIsActive();
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * Add play
     *
     * @param Game $play
     *
     * @return User
     */
    public function addPlay(Game $play)
    {
//        die("addWatch");
        $this->play[] = $play;
        $play->addPlayer($this);
        return $this;
    }

    /**
     * Remove play
     *
     * @param Game $play
     */
    public function removePlay(Game $play)
    {
//        die("addWatch");
        $this->play->removeElement($play);
        $play->removePlayer($this);
    }

    /**
     * Get play
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlay()
    {
        return $this->play;
    }

    /**
     * Add watch
     *
     * @param Game $watch
     *
     * @return User
     */
    public function addWatch(Game $watch)
    {
//        die("addWatch");
        $this->watch[] = $watch;
        $watch->addWatcher($this);
        return $this;
    }

    /**
     * Remove watch
     *
     * @param Game $watch
     */
    public function removeWatch(Game $watch)
    {
//        die("addWatch");
        $this->watch->removeElement($watch);
        $watch->removeWatcher($this);
    }

    /**
     * Get watch
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWatch()
    {
        return $this->watch;
    }

    /**
     * Add post
     *
     * @param Post $post
     *
     * @return User
     */
    public function addPost(Post $post)
    {
        $this->post[] = $post;
        return $this;
    }

    /**
     * Remove post
     *
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        $this->post->removeElement($post);
    }

    /**
     * Get post
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return User
     */
    public function addComment(Comment $comment)
    {
        $this->comment[] = $comment;
        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comment->removeElement($comment);
    }

    /**
     * Get comment
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComment()
    {
        return $this->comment;
    }

}
