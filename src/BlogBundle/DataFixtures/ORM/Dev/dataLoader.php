<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-6
 * Time: 下午12:01
 */

namespace AppBundle\DataFixtures\ORM\Dev;

use Hautelook\AliceBundle\Doctrine\DataFixtures\AbstractLoader;

class DataLoader extends AbstractLoader
{
  /**
   * {@inheritdoc}
   */
  public function getFixtures()
  {
    return [
      __DIR__.'/../post.yml',
      //'@DummyBundle/DataFixtures/ORM/product.yml',
      __DIR__.'/../user.yml',
    ];
  }

  public function getNameOfRand()
  {
    $names = [
      'jims',
      'pete',
      'ask',
      'film',
      'uiop'
    ];
    return $names[array_rand($names)];
  }

  public function getExamplePic()
  {
    return '/uploads/example/'.mt_rand(1,13).".jpg";
  }
}