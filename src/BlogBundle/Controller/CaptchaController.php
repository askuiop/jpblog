<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CaptchaController extends Controller
{
    public function generateAction($options)
    {
/*      $width = 200;       //设置画布宽度

      $height = 125;      //设置画不高度

      $fontsize = 20;     //设置字体大小

      $canvas = new \Imagick();    //创建一个Imagick对象


      $canvas->newImage($width, $height, 'none', 'png');       //设置画布的宽度215,高度75,底色透明,以及png的图片格式

      $draw   = new \ImagickDraw();    //创建一个ImagickDraw对象

      $draw->setFontSize($fontsize);       //设置字体大小

      $draw->setFillColor('#5b9dd9');      //设置字体颜色

      $draw->setGravity(\Imagick::GRAVITY_CENTER);  //设置书写位置为画布中央

      $draw->setFont('font/msyh.ttf');      //设置字体,如果写中文的话,需要设置一种中文字体

      $draw->setTextKerning(2);        //设置字体间距

      $canvas->annotateImage($draw, 0, -$fontsize/2, 0, '莱阳程序员');  //往画布的(0, -$fontsize/2),位置,角度为0,写上文字"莱阳程序员"

      $draw->setFontSize($fontsize/1.4);       //设置字体大小

      $draw->setFillColor('#7D7B7B');      //设置字体颜色

      $draw->setGravity(\Imagick::GRAVITY_CENTER);      //设置书写位置为画布中央

      $canvas->annotateImage($draw, 0, $fontsize/1.5, 0, 'YuWeiXian.Com'); //往画布的(0, -$fontsize/1.5),位置,角度为0,写上文字"YuWeiXian.Com"

      header("Content-Type: image/png");      //自定义输出格式

      echo $canvas;       //输出生成图像
      die();*/




      $defaultOptions = $this->container->getParameter('captcha.config');
      //dump($defaultOptions);
      //die();



      $generator = $this->get('blog.captcha_generator');
      $options = [
        'as_url' => true ,
        'extension' => 'jpeg',
      ];

      $response = new Response($generator->generate($options));


      $response->headers->set('Content-type', $generator->getImageExtension());

      //$response->headers->set('Content-type', 'image/jpeg');
      //$response->headers->set('Content-type', 'image/png');
      $response->headers->set('Pragma', 'no-cache');
      $response->headers->set('Cache-Control', 'no-cache');
      return $response;
    }
}
