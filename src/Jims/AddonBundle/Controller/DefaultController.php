<?php

namespace Jims\AddonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JimsAddonBundle:Default:index.html.twig');
    }
}
