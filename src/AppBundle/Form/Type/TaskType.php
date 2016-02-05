<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('task', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
                ->add('dueDate', \Symfony\Component\Form\Extension\Core\Type\DateType::class)
                ->add("checkBox", \Symfony\Component\Form\Extension\Core\Type\CheckboxType::class, array('mapped' => false, 'label' => 'Are you agred with terms?', 'required' => true))
                ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver) {
        $resolver->setDefault("data_class", "AppBundle\Entity\Task")
                ->setDefault("validation_groups", "create");
        parent::configureOptions($resolver);
    }

}
