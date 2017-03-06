<?php

use App\Http\Controllers\Dashboard\HomeController;

/** @var \Illuminate\Routing\Router $router */

$router->get('/', [
    'as'   => 'home.index',
    'uses' => HomeController::class . '@index',
]);