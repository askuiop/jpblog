<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 16-10-15
 * Time: 上午8:19
 */

namespace BlogBundle\Listener;


use BlogBundle\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class AuthenticationSubcriber implements EventSubscriberInterface
{
  /**
   * @var LoggerInterface
   */
  private $logger;

  public function __construct(LoggerInterface $logger)
  {

    $this->logger = $logger;
  }
  public static function getSubscribedEvents()
  {
    return [
      AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccess',
      AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
      SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
      SecurityEvents::SWITCH_USER => 'onSwitchUser',
    ];
  }

  public function onAuthenticationSuccess(AuthenticationEvent $event)
  {
  }

  public function onAuthenticationFailure(AuthenticationFailureEvent $event)
  {
  }

  public function onInteractiveLogin(InteractiveLoginEvent $event)
  {

    /**
     * @var $user User
     */
    $user = $event->getAuthenticationToken()->getUser();


    dump($event->getRequest()->getClientIp());
    dump($event->getRequest()->server->get('REMOTE_ADDR'));
    $ip = $event->getRequest()->getClientIp();

    $recordStr = sprintf('Login %s %s ',
       $user->getUsername(),
       $ip
      );

    $this->logger->info($recordStr, [1,2,'xxx']);

  }

  public function onSwitchUser(SwitchUserEvent $event)
  {

  }

}