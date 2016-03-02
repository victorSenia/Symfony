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
                ->add('username')
                ->add('email')
                ->add('password', \Symfony\Component\Form\Extension\Core\Type\RepeatedType::class, array(
                    'type' => \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),))
                ->add('isActive')
                ->add('role', NULL //array('preferred_choices' => array("ROLE_USER"))
                        , array('choice_label' => ($options["locale"] == "en" ? "role" : 'id'),
                    'translation_domain' => 'LeoUserBundle',)
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Leo\UserBundle\Entity\User',
            'locale' => 'en',
            'translation_domain' => 'LeoUserBundle'
        ));
    }

}
