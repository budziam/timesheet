<?php

use App\Http\Controllers\Dashboard\Api\ProjectController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('projects', ProjectController::class, [
    'only' => ['show', 'update'],
]);

$router->get('datatable/projects', [
    'as'   => 'datatable.projects',
    'uses' => ProjectController::class . '@datatable',
]);