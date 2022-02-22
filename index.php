<?php

require './app/bootstrap.php';

use Firework\Router;

use App\Controllers\FirstController;

$router = new Router();

$router->get('/', [FirstController::class, 'render']);