<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Author {

    /**
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @Assert\Choice(
     * choices = { "male", "female", "other" },
     * message = "Choose a valid gender."
     * )
     */
    private $gender;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $firstName;

    /**
     * @Assert\IsTrue(message = "The password cannot match your first name")
     */
    public function isPasswordLegal() {
        return $this->firstName !== $this->password;
    }

}
