<?php

namespace BlogBundle\Form;

use Jims\AddonBundle\Form\UmeditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Jims\AddonBundle\Form\UeditorType;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content' , UeditorType::class, array(
                "attr" => array(
                    "style" => "height:400px;width:600px;", //editor转换成编辑器编辑空间尺寸
                    "class"=>"jims",
                    //通过自定义js, 控制editor toolbars
                    #"script" => "window.UEDITOR_CONFIG.toolbars=[['fullscreen', 'source', 'undo', 'redo', 'bold']]"
                ),
            ))
            //->add('content' , UmeditorType::class, array(
            //    "attr" => array(
            //        "style" => "width:555px;",
            //        "class"=>"jims",
            //        "script"=>'console.log("This is a ueditor bundle!")'
            //    ),
            //))
            ->add('createdAt', DateTimeType::class)
            ->add('updatedAt', DateTimeType::class)
            #->add('user')
            #->add('categories')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlogBundle\Entity\Post',
        ));
    }
}
