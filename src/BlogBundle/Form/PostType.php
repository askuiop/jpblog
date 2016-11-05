<?php

namespace BlogBundle\Form;

use Jims\EditorHubBundle\Form\UmeditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Jims\EditorHubBundle\Form\UeditorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use BlogBundle\Entity\Post;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    /**
     * @var
     */
    private $fileSavePath;

    public function __construct($fileSavePath)
    {
        $this->fileSavePath = $fileSavePath;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [

            ])
            ->add('summary', TextareaType::class)
            ->add('content' , UeditorType::class, array(
                "attr" => array(
                    "style" => "height:400px;width:100%;", //editor转换成编辑器编辑空间尺寸
                    "class"=>"jims",
                ),
                //通过自定义js, 控制editor toolbars
                //'js_script' => "window.UEDITOR_CONFIG.toolbars=[['fullscreen', 'source', 'undo', 'redo', 'bold']]",
            ))
            //->add('content' , UmeditorType::class, array(
            //    "attr" => array(
            //        "style" => "width:555px;",
            //        "class"=>"jims",
            //        "script"=>'console.log("This is a ueditor bundle!")'
            //    ),
            //))
            ->add('img', FileType::class, [
                'mapped' => false,
                'constraints' => new File([
                    'maxSize'=>'100k',
                    'mimeTypes' => [
                      'image/jpeg',
                      'image/png',
                      'image/bmp',
                    ],
                    'groups' => 'v_new_post'
                ]),
            ])
            ->add('tags')
            ->add('couldComment', CheckboxType::class, [

            ])
            ->add('isVisible', CheckboxType::class, [

            ])
            ->add('sourceType', ChoiceType::class, [
                'choices' => Post::$postSourceType,
                'expanded' => true
            ])
            ->add('priority')
            ->add('submit', SubmitType::class, [
                'label' => 'post it'
            ])
            #->add('categories')

            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'onPreSubmit'])
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit'])
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Post',
            'attr' => array('novalidate'=>'novalidate'),
            'validation_groups' => 'v_new_post'
        ));
    }

    public function onPreSubmit(FormEvent $event)
    {
        $form = $event->getForm();

        // 如果 字段名字不同，可以这样处理：
        $data = $event->getData();
        $file = $data['img'];
        if ($file ) {
            $form->add('thumbnail', null);
            $data['thumbnail'] = $file;
            $event->setData($data);
            unset($file);
        } else {
            $form->remove('thumbnail');
            unset($data['thumbnail']);
            $event->setData($data);

        }

        $summary = $data['summary'];
        if (empty($summary)) {
            $summary = strip_tags($data['content']);
            preg_match('/.{200}/u', $summary, $mth);
            $summary = $mth[0];
            $data['summary'] = !empty($summary)?$summary:'';
            $event->setData($data);
        }

        dump($data);


    }

  /**
   * @param FormEvent $event
   */
  public function onPostSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $post = $data = $event->getData();


      /**
       * @var $file UploadedFile
       */
        $file = $post->getThumbnail();

        if (!$file) {
            return ;
        }

        dump($file);

        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $nowDate = date("Ymd");
        $fileSaveRealPath = $this->fileSavePath. '/' .$nowDate;
        $fileSaveRelativePath = Post::FILE_SAVA_PATH .'/'. $nowDate ;
        $file->move(
          $fileSaveRealPath ,
          $fileName
        );

        $post->setThumbnail($fileSaveRelativePath. '/' .$fileName);
        dump($event);
        //die();

    }

    public function uploadImage()
    {

    }
}
