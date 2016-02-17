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
                    'player' => $player,
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     */
    public function editAction(Request $request, Post $post) {
        $deleteForm = $this->createDeleteForm($post);
        $editForm = $this->createForm('Leo\BlogBundle\Form\PostType', $post);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post_edit', array('id' => $post->getId()));
        }

        return $this->render('LeoBlogBundle:Post:edit.html.twig', array(
                    'post' => $post,
                    'edit_form' => $editForm->createView(),
        ));
    }

}
