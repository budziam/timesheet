<?php

use App\Http\Controllers\Dashboard\UserController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('users', UserController::class, [
    'only' => ['index', 'create', 'edit'],
]);