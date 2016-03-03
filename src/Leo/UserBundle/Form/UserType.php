<?php

namespace Leo\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', NULL, array('attr' => array('placeholder' => 'Enter your username')))
                ->add('email', NULL, array('attr' => array('placeholder' => 'Enter your e-mail')))
                ->add('password', \Symfony\Component\Form\Extension\Core\Type\RepeatedType::class, array(
                    'type' => \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'Password', 'attr' => array('placeholder' => 'Enter your password')),
                    'second_options' => array('label' => 'Repeat Password', 'attr' => array('placeholder' => 'Repead your password')),))
                ->add('isActive')
                ->add('role', NULL //array('preferred_choices' => array("ROLE_USER"))
                        , array('choice_label' => ($options["locale"] == "en" ? "role" : 'id'),
                    'choice_translation_domain' => 'LeoUserBundle',
                        )
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Leo\UserBundle\Entity\User',
            'locale' => 'en',
            'translation_domain' => 'LeoUserBundle',
        ));
    }

}
