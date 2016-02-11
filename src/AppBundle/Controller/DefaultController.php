<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller {

    /**
     * @Route("/admin")
     */
    public function adminAction() {
        if
        (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }
        $user = $this->getUser();
// the above is a shortcut for this
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $response = new Response('<html><body>Admin page!</body></html>');
// mark the response as either public or private
        $response->setPublic();
        $response->setPrivate();
// set the private or shared max age
        $response->setMaxAge(600);
        $response->setSharedMaxAge(600);
// set a custom Cache-Control directive
        $response->headers->addCacheControlDirective('must-revalidate', true);
        
        return $response;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
//        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Unable to access this page!');
        // Old way :
// if (false ===$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
// throw $this->createAccessDeniedException('Unable to access this page!');
// }
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ));
    }

}
