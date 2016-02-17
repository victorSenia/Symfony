<?php

namespace Leo\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\BlogBundle\Entity\Post;
use Leo\BlogBundle\Form\PostType;
use Leo\UserBundle\Entity\User;

/**
 * Author controller.
 *
 */
class AuthorController extends Controller {

    /**
     * Lists all Author entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $authors = $em->getRepository('LeoUserBundle:User')->findAllWithPosts();

        return $this->render('LeoBlogBundle:Author:index.html.twig', array(
                    'authors' => $authors,
        ));
    }

    /**
     * Finds and displays a Post entity.
     *
     */
    public function showAction(User $player) {
        return $this->render('LeoBlogBundle:Author:show.html.twig', array(
                    'author' => $player,
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editAction(Request $request, User $author) {
        $editForm = $this->createFormBuilder($author)
                ->add("post")
                ->add("comment")
                ->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('author_edit', array('id' => $author->getId()));
        }

        return $this->render('LeoBlogBundle:Author:edit.html.twig', array(
                    'author' => $author,
                    'edit_form' => $editForm->createView(),
        ));
    }

}
