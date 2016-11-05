<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-14
 * Time: 下午9:55
 */

namespace BlogBundle\Listener;


use BlogBundle\Entity\User;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class InteractiveLoginListener
{
  public function onInteractiveLogin(InteractiveLoginEvent $event)
  {
    $request = $event->getRequest();

    dump($event);
    die();

  }

}