<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class HelloController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    public function indexAction($name = "My name") {

//        return $this->redirectToRoute('lucky_number', array(), 301);//using nickname of action
//        return $this->redirect($this->generateUrl('lucky_number'), 301); //or such way
//        return new RedirectResponse($this->generateUrl('lucky_number'));//or such way
//        
//        //throwing exception
//        $product=null;
//        if (!$product) {
//            throw $this->createNotFoundException('The product does not exist');
//        }

        return new Response('<html><body>Hello ' . $name . '!</body></html>');
    }

    public function indexRequestAction(Request $request) {
        //operation with Request
        $request->isXmlHttpRequest(); // is it an Ajax request?
        $request->getPreferredLanguage(array('en', 'fr'));
        $request->query->get('page'); // get a $_GET parameter
        $request->request->get('page'); // get a $_POST parameter
        //sub-request as analog of redirect
        $response = $this->forward('AppBundle:Something:fancy', array(
            'name' => $name,
            'color' => 'green',
        ));
// ... further modify the response or return it directly
        return $response;

// using CSRF protection
        if ($this->isCsrfTokenValid('token_id', $submittedToken)) {
// ... do something, like deleting an object
        }
// isCsrfTokenValid() is equivalent to:
// $this->get('security.csrf.token_manager')->isTokenValid(
// new \Symfony\Component\Security\Csrf\CsrfToken\CsrfToken('token_id', $token)
// );
    }

}
