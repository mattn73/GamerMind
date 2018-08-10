<?php

namespace GM\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GMUserBundle:Default:index.html.twig');
    }
}
