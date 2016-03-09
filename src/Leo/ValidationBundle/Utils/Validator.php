<?php
namespace Leo\ValidationBundle\Utils;

/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 3/7/2016
 * Time: 10:23 AM
 */
class Validator
{

    private $minLength = 3;

    private $maxLength = 35;

    private $letters = TRUE;

    private $numbers = TRUE;

    private $startLetter = TRUE;

    private $allSymbols = TRUE;

    private $specSymbols = "_ -<>?!.,\\/\\\\'%$";

    /**
     * @param boolean $startLetter
     */
    public function setStartLetter($startLetter)
    {
        $this->startLetter = $startLetter;
    }

    /**
     * @param boolean $allSymbols
     */
    public function setAllSymbols($allSymbols)
    {
        $this->allSymbols = $allSymbols;
    }

    /**
     * @param mixed $minLength
     */
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;
    }

    /**
     * @param mixed $maxLength
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
    }

    /**
     * @param mixed $letters
     */
    public function setLetters($letters)
    {
        $this->letters = $letters;
    }

    /**
     * @param mixed $numbers
     */
    public function setNumbers($numbers)
    {
        $this->numbers = $numbers;
    }

    /**
     * @param mixed $specSymbols
     */
    public function setSpecSymbols($specSymbols)
    {
        $this->specSymbols = $specSymbols;
    }

    public function validate($string)
    {
        $string = trim($string);
        $length = ($this->minLength - ($this->startLetter ? 1 : 0)) . "," . ($this->maxLength - ($this->startLetter ? 1 : 0));
        $type = ($this->startLetter ? "a-z][" : "");
        if($this->allSymbols) {
            $type .= "\\w" . ($this->specSymbols ? $this->specSymbols : "");
        } else {
            $type .= ($this->letters ? "a-z" : "") . ($this->numbers ? "0-9" : "") . ($this->specSymbols ? $this->specSymbols : "");
        }
        $pattern = "/^[" . $type . "]{" . $length . "}$/i";
        if(preg_match($pattern, $string))
            return $string;
        return FALSE;
    }
}