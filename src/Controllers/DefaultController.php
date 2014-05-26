<?php

namespace Eirian\GuitarBlog\Controllers;

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    private
        $twig;
    
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }
    
    public function indexAction()
    {
        $html = $this->twig->render('index.twig');
        
        return new Response($html);
    }
}