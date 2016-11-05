<?php

namespace BlogBundle\Form;

use BlogBundle\Captcha\CaptchaValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

class CaptchaType extends AbstractType
{
  public $session;
  /**
   * @var CaptchaValidator
   */
  private $validator;
  /**
   * @var TranslatorInterface
   */
  private $translator;
  /**
   * @var
   */
  private $option;

  public function __construct(Session $session, CaptchaValidator $validator, TranslatorInterface $translator, $option)
  {
    $this->session = $session;
    $this->validator = $validator;
    $this->translator = $translator;
    $this->option = $option;
  }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'blog_bundle_captcha_type';
    }

  public function getBlockPrefix()
  {
    return 'captcha';
  }

  public function getParent()
  {
    return TextType::class;
  }
}
