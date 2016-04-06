<?php
namespace Leo\BlogBundle\Form;

use Leo\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("post"/*, EntityType::class, array('class' => 'Leo\BlogBundle\Entity\Post')*/)
            ->add("comment"/*, EntityType::class, array('class' => 'Leo\BlogBundle\Entity\Comment')*/);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Leo\UserBundle\Entity\User',
            'translation_domain' => 'LeoBlogBundle',
            'validation_groups' => false,
        ));
    }

}
