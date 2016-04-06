<?php
namespace Leo\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', NULL, array('attr' => array('placeholder' => 'Enter title of article')))
            ->add('text', NULL, array('attr' => array('placeholder' => 'Enter text of article')))
//                ->add('author')
//                ->add('comments')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Leo\BlogBundle\Entity\Post',
            'translation_domain' => 'LeoBlogBundle',
        ));
    }

}
