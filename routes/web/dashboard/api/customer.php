<?php

use App\Http\Controllers\Dashboard\Api\CustomerController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('customers', CustomerController::class, [
    'only' => ['show', 'store', 'update', 'destroy'],
]);

$router->get('datatable/customers', [
    'as'   => 'datatable.customers',
    'uses' => CustomerController::class . '@datatable',
]);

$router->get('select2/customers', [
    'as'   => 'select2.customers',
    'uses' => CustomerController::class . '@select2',
]);