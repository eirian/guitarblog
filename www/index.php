<?php

require_once __DIR__.'/../vendor/autoload.php';
 
use Eirian\GuitarBlog\Application;
use twitter\bootstrap;

$app = new Application(__DIR__ . '/../config/db.yml');
$app['debug'] = true;
$app->run();