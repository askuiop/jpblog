<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-31
 * Time: 下午5:27
 */

namespace BlogBundle\Captcha;


class Generator
{
  public $imagick;
  public $bg;
  public $imagickDraw;
  
  public function __construct()
  {
    /* Create Imagick object */
    $this->imagick = new \Imagick();
    
    /* Create the ImagickPixel object (used to set the background color on image) */
    $this->bg = new \ImagickPixel();
    /* Set the pixel color to white */
    $this->bg->setColor( 'white' );

    /* Create a drawing object and set the font size */
    $this->imagickDraw = new \ImagickDraw();
    /* Set font and font size. You can also specify /path/to/font.ttf */
    $this->imagickDraw->setFont( 'font/consola.ttf' );
    $this->imagickDraw->setFontSize( 24 );
    
  }

  public function generate()
  {

    /* Create the text */
    $alphanum = 'ABXZRMHTL23456789';
    $string = substr( str_shuffle( $alphanum ), 2, 6 );
    /* Create new empty image */
    $this->imagick->newImage( 110, 30, $this->bg );
    /* Write the text on the image */
    $this->imagick->annotateImage( $this->imagickDraw, 4, 20, 0, $string );
    /* Add some swirl */
    $this->imagick->swirlImage( 20 );
    /* Create a few random lines */
    $this->imagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
    $this->imagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
    $this->imagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
    $this->imagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
    $this->imagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
    $this->imagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );
    $this->imagickDraw->line( rand( 0, 70 ), rand( 0, 30 ), rand( 0, 70 ), rand( 0, 30 ) );

    $this->imagickDraw->circle(8,8,8,8);


    $this->imagick->addNoiseImage(\Imagick::NOISE_POISSON, \Imagick::CHANNEL_OPACITY);
    $this->imagick->addNoiseImage(\Imagick::NOISE_MULTIPLICATIVEGAUSSIAN);
    $this->imagick->addNoiseImage(\Imagick::NOISE_GAUSSIAN);
    $this->imagick->addNoiseImage(\Imagick::NOISE_IMPULSE, \Imagick::CHANNEL_OPACITY);
    /* Draw the ImagickDraw object contents to the image. */
    $this->imagick->drawImage( $this->imagickDraw );
    /* Give the image a format */
    $this->imagick->setImageFormat( 'png' );
    /* Send headers and output the image */
    header( "Content-Type: image/{$this->imagick->getImageFormat()}" );
    echo $this->imagick->getImageBlob( );

  }

}