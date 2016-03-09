<?php
namespace Leo\ValidationBundle\Utils;

/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 3/7/2016
 * Time: 10:23 AM
 */
class UserValidator
{

    private $userName;

    private $name;

    private $password;

    private $text;

    /**
     * @param mixed $text
     */
    public function validText($text)
    {
        $this->text = $text;
    }

    /**
     * @param mixed $userName
     */
    public function validUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed $name
     */
    public function validName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $password
     */
    public function validPassword($password)
    {
        $this->password = $password;
    }

}