<?php

namespace P6\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('P6UserBundle:Default:index.html.twig');
    }
}
