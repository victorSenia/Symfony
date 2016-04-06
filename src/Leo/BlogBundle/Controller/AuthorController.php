<?php
namespace Leo\BlogBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Leo\UserBundle\Entity\User;

/**
 * Author controller.
 */
class AuthorController extends Controller
{

    /**
     * Lists all Author entities.
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $authors = $em->getRepository('LeoUserBundle:User')->findAllWithPosts();
        return $this->render('LeoBlogBundle:Author:index.html.twig', array(
            'authors' => $authors,
        ));
    }

    /**
     * Finds and displays a Post entity.
     */
    public function showAction(User $author)
    {
        return $this->render('LeoBlogBundle:Author:show.html.twig', array(
            'author' => $author,
        ));
    }

    /**
     * Displays a form to edit an existing Post entity.
     */
    public function editAction(Request $request, User $author)
    {
        $editForm = $this->createForm('Leo\BlogBundle\Form\AuthorType', $author);
        $posts = new ArrayCollection();
        foreach($author->getPost() as $item) {
            $posts->add($item);
        }
        $comments = new ArrayCollection();
        foreach($author->getComment() as $item) {
            $comments->add($item);
        }
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach($comments as $item) {
                if($author->getComment()->contains($item) === FALSE)
                    $em->remove($item);
            }
            foreach($posts as $item) {
                if($author->getPost()->contains($item) === FALSE)
                    $em->remove($item);
            }
            $em->flush();
            return $this->redirectToRoute('author_edit', array('id' => $author->getId()));
        }
        return $this->render('LeoBlogBundle:Author:edit.html.twig', array(
            'author' => $author,
            'edit_form' => $editForm->createView(),
        ));
    }

}
