<?php
namespace Leo\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LeoBlogBundle:Default:index.html.twig');
    }
}
