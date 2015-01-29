<?php

namespace ISL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ISLBlogBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function helloAction(){
        return new Response('<h1>Hello world</h1>');
    }
}
