<?php

use App\Http\Controllers\Dashboard\Api\ProjectController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('projects', ProjectController::class, [
    'only' => ['show', 'store', 'update', 'destroy'],
]);

$router->get('datatable/projects', [
    'as'   => 'datatable.projects',
    'uses' => ProjectController::class . '@datatable',
]);

$router->get('select2/projects', [
    'as'   => 'select2.projects',
    'uses' => ProjectController::class . '@select2',
]);