<?php

namespace Leo\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Leo\UserBundle\Repository\UserRepository")
 */
class User implements AdvancedUserInterface {

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
     * @ORM\Column(name="name", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean", options={"default"=true})
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)
     */
    private $role;

    public function __construct() {
        $this->setIsActive(TRUE);
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username) {
        $this->username = $username;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set Role
     *
     * @param Role $role
     * @return User
     */
    public function setRole($role) {
        $this->role = $role;

        return $this;
    }

    /**
     * Get Role
     *
     * @return Role
     */
    public function getRole() {
        return $this->role;
    }

    public function eraseCredentials() {
//TODO
    }

    public function getRoles() {
        return array($this->getRole());
    }

    public function getSalt() {
        return NULL;
    }

    public function isAccountNonExpired() {

//TODO
    }

    public function isAccountNonLocked() {
        return $this->getIsActive();
    }

    public function isCredentialsNonExpired() {

//TODO
    }

    public function isEnabled() {
        return $this->getIsActive();
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive) {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive() {
        return $this->isActive;
    }

}
