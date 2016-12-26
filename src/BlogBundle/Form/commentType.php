<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Gregwar\CaptchaBundle\Type\CaptchaType;

class commentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
        ->add('nickname')
        ->add('content', TextareaType::class)
        ->add('reply_to', HiddenType::class, [
          'mapped' => false,
        ])
        //->add('captcha', CaptchaType::class)
        //->add('captcha', 'innocead_captcha')
          ->add('captcha', \BlogBundle\Form\CaptchaType::class)
        ->add('submit', SubmitType::class)

        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'blog_bundlecomment_type';
    }
}
