<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Category {

    /**
     * @Assert\NotBlank()
     */
    public $name;

}
