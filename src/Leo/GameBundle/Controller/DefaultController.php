<?php

namespace Leo\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LeoGameBundle:Default:index.html.twig');
    }
}
