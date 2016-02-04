<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Assert\GroupSequence({"User", "Strict"})
 * @Assert\GroupSequenceProvider
 * 
 * In this example, it will first validate all constraints in the group 
 * User (which is the same as the Default group). Only if all constraints 
 * in that group are valid, the second group, Strict, will be validated.
 */
class User implements UserInterface, \Symfony\Component\Validator\GroupSequenceProviderInterface {

    /**
     * @Assert\Email(groups={"registration"})
     */
    private $email;

    /**
     * @Assert\NotBlank(groups={"registration"})
     * @Assert\Length(min=7, groups={"registration"})
     */
    private $password;

    /**
     * @Assert\Length(min=2)
     */
    private $city;

    /**
     * @Assert\CardScheme(
     * schemes={"VISA"},
     * groups={"Premium"},
     * )
     */
    private $creditCard;

    public function valid() {
        // If you're using the new 2.5 validation API (you probably are!)
        return $errors = $validator->validate($author, null, array('registration'));
// If you're using the old 2.4 validation API, pass the group names as the second argument
// $errors = $validator->validate($author, array('registration'));
    }

    /**
     * @Assert\IsTrue(message="The password cannot match your username", groups={"Strict"})
     */
    public function isPasswordLegal() {
        return ($this->username !== $this->password);
    }

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        
    }

    public function getRoles() {
        
    }

    public function getSalt() {
        
    }

    public function getUsername() {
        
    }

    public function getGroupSequence() {
        $groups = array('User');
        if ($this->isPremium()) {
            $groups[] = 'Premium';
        }
        return $groups;
    }

}
