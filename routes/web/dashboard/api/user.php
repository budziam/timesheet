<?php

use App\Http\Controllers\Dashboard\Api\UserController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('users', UserController::class, [
    'only' => ['show', 'store', 'update', 'destroy'],
]);

$router->get('datatable/users', [
    'as'   => 'datatable.users',
    'uses' => UserController::class . '@datatable',
]);

$router->get('select2/users', [
    'as'   => 'select2.users',
    'uses' => UserController::class . '@select2',
]);