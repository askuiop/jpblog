<?php

namespace Jims\MsgQueueBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Jims\MsgQueueBundle\Service\DaemonOs;
use Jims\MsgQueueBundle\Service\OS\DaemonOSArch;

class DefaultController extends Controller
{
    public function indexAction()
    {
        var_dump(DaemonOs::factory());
        die();
    }
}
