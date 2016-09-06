<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends UserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('account')
          ->add('plain_password', RepeatedType::class , [
            'type' => PasswordType::class,
          ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
          'data_class' => 'BlogBundle\Entity\User',
          'validation_groups' => ['Default', 'Registration']
        ));
    }

    public function getName()
    {
        return 'blog_bundle_register_type';
    }
}
