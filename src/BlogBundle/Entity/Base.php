<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-15
 * Time: 下午10:10
 */

namespace BlogBundle\Entity;

use BlogBundle\Doctrine\CreateAndUpdateAction;


abstract class Base
{
  const AUTH = 'jims';

  const POST_FILE_SAVA_PATH = '/uploads/post';

  use  CreateAndUpdateAction;

}