<?php
namespace Eirian\GuitarBlog\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class DefaultControllerProvider implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $app['default.controller'] = function() use($app) {
            return new DefaultController($app['twig']);
        };

        $controllers = $app['controllers_factory'];

        $controllers->get('/', 'default.controller:indexAction');

        return $controllers;
    }
}

