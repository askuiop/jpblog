<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-31
 * Time: 下午5:27
 */

namespace BlogBundle\Captcha;


use Symfony\Component\Routing\RouterInterface;

class Generator
{
  public $canvas;
  public $bg;
  public $draw;

  public $imageExtension;

  /**
   * @var RouterInterface
   */
  private $router;

  public function __construct( RouterInterface $router)
  {
    /* Create Imagick object */
    $this->canvas = new \Imagick();

    
    /* Create the ImagickPixel object (used to set the background color on image) */
    $this->bg = new \ImagickPixel();

    /* Set the pixel color to white */
    $this->bg->setColor( 'white' );


    $this->router = $router;
  }

  public function generate($options)
  {
    header('Content-Type: text/html; charset=utf-8');
    mb_internal_encoding('utf-8');
    $extension = $options['extension'] ? $options['extension'] : 'png';
    $quality  = !empty($options['quality']) ? $options['quality'] : 90;
    $width    = !empty($options['width']) ? $options['width'] : 80;
    $height   = !empty($options['height']) ? $options['height'] : 30;
    $length   = !empty($options['length']) ? $options['length'] : 4;
    $fontSize   = !empty($options['font_size']) ? $options['font_size'] : 24;
    //$ttf   = !empty($options['length']) ? $options['length'] : 4;



    /* Create a drawing object and set the font size */
    $this->draw = new \ImagickDraw();

    $this->draw->setTextEncoding('utf-8');

    /* Set font and font size. You can also specify /path/to/font.ttf */
    $this->draw->setFont( '/usr/share/fonts/liberation/LiberationMono-Regular.ttf' );

    $this->draw->setFontSize( $fontSize );

    $this->draw->setGravity(\Imagick::GRAVITY_CENTER);  //设置书写位置为画布中央
    $this->draw->setTextKerning(2);        //设置字体间距


    /* Create the text */
    $alphanum = 'ABXZRMHTL23456789';
    $string = substr( str_shuffle( $alphanum ), 2, $length );

    /* Create new empty image */
    $this->canvas->newImage( $width, $height, $this->bg );

    /* Give the image a format */
    $this->canvas->setImageFormat( $extension );
    $this->imageExtension = $this->canvas->getImageFormat();

    /* Add some swirl */
    $this->canvas->swirlImage( 30 );

    $this->canvas->addNoiseImage(\Imagick::NOISE_POISSON, \Imagick::CHANNEL_OPACITY);
    $this->canvas->addNoiseImage(\Imagick::NOISE_MULTIPLICATIVEGAUSSIAN);
    $this->canvas->addNoiseImage(\Imagick::NOISE_GAUSSIAN);
    $this->canvas->addNoiseImage(\Imagick::NOISE_IMPULSE, \Imagick::CHANNEL_OPACITY);


    /* Write the text on the image */
    $this->draw->setFillColor( "#444" );
    $this->draw->setTextEncoding ('GBK');

    $text = '你';
    //$text = mb_convert_encoding($text, 'UTF-8', 'BIG-5');
    //$text = \mb_convert_encoding($text, 'UTF-8', 'GBK');
    $text = \mb_convert_encoding(utf8_decode($text), 'GBK', 'UTF-8');
    //$this->canvas->annotateImage( $this->draw, 0, 0, 0, iconv("UTF-8", "GBK",'你好，hello') );
    $this->canvas->annotateImage( $this->draw, 0, 0, 0, $text);

    //for ($i=0; $i<strlen($string); $i++) {
    //  $this->imagick->annotateImage( $this->draw, $fontSize/2*($i+1), 20, 0, $string{$i} );
    //}



    /* Create a few random lines */
    $this->draw->line( rand( 0, 10 ), rand( 0, 40 ), rand( 80, 120 ), rand( 0, 40 ) );

    $this->draw->setStrokeWidth(1.5);
    //$this->draw->setStrokeColor( $this->get_random_color() );

    $this->draw->line( 0, ($height/2+mt_rand(-$height/2, $height/2)), 80, ($height/2+mt_rand(-$height/2, $height/2)) );
    $this->draw->line( 0, ($height/2+mt_rand(-$height/2, $height/2)), 80, ($height/2+mt_rand(-$height/2, $height/2)) );
    $this->draw->line( 0, ($height/2+mt_rand(-15, 15)), 80, ($height/2+mt_rand(-15, 15)) );
    $this->draw->line( 0, ($height/2+mt_rand(-15, 15)), 80, ($height/2+mt_rand(-15, 15)) );

    //$this->draw->circle(0,0,10,10);
    //$this->draw->circle(100,100,100,100);

    /* Draw the draw object contents to the image. */
    $this->canvas->drawImage( $this->draw );

    $this->canvas->setImageCompressionQuality($quality);

    return $this->canvas->getImageBlob();

    ob_start();
    echo $this->canvas->getImageBlob();
    return ob_get_clean();

  }


  public function getCaptchaCode(array &$options)
  {
    //$this->builder->setPhrase($this->getPhrase($options));
    //// Randomly execute garbage collection and returns the image filename
    //if ($options['as_file']) {
    //  $this->imageFileHandler->collectGarbage();
    //  return $this->generate($options);
    //}
    //// Returns the image generation URL
    if ($options['as_url']) {
      return $this->router->generate('gregwar_captcha.generate_captcha',
        array('key' => $options['session_key'], 'n' => md5(microtime(true).mt_rand())));
    }
    return 'data:image/jpeg;base64,' . base64_encode($this->generate($options));
  }


  public function getImageExtension()
  {
    return 'image/' . $this->imageExtension;
  }

  function get_random_color()        // Thanks to Greg R. for this nice little function.
  {
    $c = '';
    for ($i = 0; $i<6; $i++)
    {
      $c .=  dechex(rand(0,15));
    }
    return "#$c";
  }

}