<?php

namespace Leo\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('comment', NULL, array('attr' => array('placeholder' => 'Enter text of comment')))
//                ->add('author')
//                ->add('post')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Leo\BlogBundle\Entity\Comment',
            'translation_domain' => 'LeoBlogBundle'
        ));
    }

}
