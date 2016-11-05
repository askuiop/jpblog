<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-20
 * Time: 上午10:42
 */

namespace BlogBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OauthRepository")
 * @ORM\Table(name="oauth")
 */
class Oauth extends User
{

  /**
   * @ORM\Column(type="string")
   */
  protected $openid='';

  /**
   * @return mixed
   */
  public function getOpenid()
  {
    return $this->openid;
  }

  /**
   * @param mixed $openid
   */
  public function setOpenid($openid)
  {
    $this->openid = $openid;
  }

}
