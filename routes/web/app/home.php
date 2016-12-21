<?php

use App\Http\Controllers\App\HomeController;

/** @var \Illuminate\Routing\Router $router */

$router->get('/', [
    'as'   => 'home.index',
    'uses' => HomeController::class . '@index',
]);