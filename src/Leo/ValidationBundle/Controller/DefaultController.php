<?php
namespace Leo\ValidationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $valid = $this->get("leo_validator.single");
        $text = "te s-t+!.?</>,\\/%             $/";
        return new Response($valid->validate($text));
    }
}
