<?php

namespace Wowapps\ProxyBonanzaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WowAppsProxyBonanzaBundle:Default:index.html.twig');
    }
}
