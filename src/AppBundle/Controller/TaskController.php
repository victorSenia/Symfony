<?php

namespace AppBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskController extends Controller {

    /**
     * @Route("task")
     * @param Request $request
     * @return type Response
     */
    public function newAction(Request $request) {
// create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
        $form = $this->createFormBuilder($task, array('validation_groups' => array('create'),))
//                ->setAction($this->generateUrl('homepage'))
//                ->setMethod('GET')
                ->add('task', TextType::class)
// If you use PHP 5.3 or 5.4 you must use
// ->add('task', 'Symfony\Component\Form\Extension\Core\Type\TextType')
                ->add('dueDate', DateType::class, array("label" => "Dead line"))
//                ->add('nextStep', SubmitType::class)
//                ->add('previousStep', SubmitType::class, array('validation_groups' => false,))
//                ->add('saveAndAdd', SubmitType::class, array('label' => 'Save and Add'))
                ->add('save', SubmitType::class, array('label' => 'Create Task'))
                ->getForm();

// handling forms
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
// ... perform some action, such as saving the task to the database
//            return $this->redirectToRoute('homepage');
            $nextAction = $form->get('save')->isClicked() ? 'homepage' : 'homepage';
            return $this->redirectToRoute($nextAction);
        }

        return $this->render('AppBundle:task:new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("taskclass")
     * @param Request $request
     * @return type Response
     */
    public function usingClassAction(Request $request) {
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));
        $form = $this->createForm(\AppBundle\Form\Type\TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
// ... perform some action, such as saving the task to the database
//            return $this->redirectToRoute('homepage');
            $nextAction = $form->get('save')->isClicked() ? 'homepage' : 'homepage';
            return $this->redirectToRoute($nextAction);
        }

        return $this->render('AppBundle:task:new.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("contact")
     * @param Request $request
     * @return type Response
     */
    public function contactAction(Request $request) {
        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
                ->add('name', TextType::class)
                ->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class)
                ->add('message', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
                ->add('firstName', TextType::class, array(
                    'constraints' => new \Symfony\Component\Validator\Constraints\Length(array('min' => 3)),
                ))
                ->add('lastName', TextType::class, array(
                    'constraints' => array(
                        new \Symfony\Component\Validator\Constraints\NotBlank(),
                        new \Symfony\Component\Validator\Constraints\Length(array('min' => 3)),
                    ),
                ))
                ->add('send', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
// data is an array with "name", "email", and "message" keys
            $data = $form->getData();
        }
        return $this->render('AppBundle:task:newStart.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

}
