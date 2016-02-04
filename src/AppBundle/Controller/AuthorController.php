<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

class AuthorController extends \Symfony\Bundle\FrameworkBundle\Controller\Controller {

    /** @Route("author") */
    public function authorAction() {
        $author = new \AppBundle\Entity\Author();
        $author->name = "";
// ... do something to the $author object
        $validator = $this->get('validator');
        $errors = $validator->validate($author);
        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
//            $errorsString = (string) $errors;
//            return new Response($errorsString);

            return $this->render('AppBundle:author:validation.html.twig', array(
                        'errors' => $errors,
            ));
        }
        return new \Symfony\Component\HttpFoundation\Response('The author is valid! Yes!');
    }

    public function updateAction(\Symfony\Component\HttpFoundation\Request $request) {
        $author = new \AppBundle\Entity\Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if ($form->isValid()) {
// the validation passed, do something with the $author object
            return $this->redirectToRoute("/");
        }
        return $this->render('author/form.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    public function addEmailAction($email) {
        $emailConstraint = new Assert\Email();
// all constraint "options" can be set this way
        $emailConstraint->message = 'Invalid email address';
// use the validator to validate the value
// If you're using the new 2.5 validation API (you probably are!)
        $errorList = $this->get('validator')->validate(
                $email, $emailConstraint
        );
// If you're using the old 2.4 validation API
        /*
          $errorList = $this->get('validator')->validateValue(
          $email,
          $emailConstraint
          );
         */
        if (0 === count($errorList)) {
// ... this IS a valid email address, do something
        } else {
// this is *not* a valid email address
            $errorMessage = $errorList[0]->getMessage();
// ... do something with the error
        }// ...
    }

}
