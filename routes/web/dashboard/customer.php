<?php

use App\Http\Controllers\Dashboard\CustomerController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('customers', CustomerController::class, [
    'only' => ['index', 'create', 'edit'],
]);