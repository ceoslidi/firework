<?php

require './app/bootstrap.php';

use Firework\Router;

use App\Controllers\HomeController;

$router = new Router();

$router->get('/home', [HomeController::class, 'render']);
$router->post('/home', [HomeController::class, 'filer']);