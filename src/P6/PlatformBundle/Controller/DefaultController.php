<?php

namespace P6\PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('P6PlatformBundle:Default:index.html.twig');
    }

    public function testAction()
    {
        $content = $this->renderView('@P6Platform/Platform/homepage.html.twig');
        return new Response($content);
    }
}


