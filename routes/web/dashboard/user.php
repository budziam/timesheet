<?php

use App\Http\Controllers\Dashboard\UserController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('users', UserController::class, [
    'only' => ['index', 'create', 'edit'],
]);

$router->get('users/{user}/change-password', [
    'as'   => 'users.change-password',
    'uses' => UserController::class . '@changePassword',
]);