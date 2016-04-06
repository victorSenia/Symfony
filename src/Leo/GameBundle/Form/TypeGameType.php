<?php
namespace Leo\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypeGameType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', NULL, array('attr' => array('placeholder' => 'Enter name of game type')))
            ->add('games', CollectionType::class, array(
                'entry_type' => GameType::class,
                'allow_add' => TRUE,
                'by_reference' => FALSE,
                'allow_delete' => TRUE,
            ))
            ->add('add_button', ButtonType::class, array('label' => 'Add game',
                'attr' => array('class' => 'prototype-add',
                    'data-id' => $builder->getName() . '_' . $builder->get('games')->getName())));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Leo\GameBundle\Entity\TypeGame',
            'translation_domain' => 'LeoGameBundle',
        ));
    }

}
