<?php

use App\Http\Controllers\Dashboard\Api\ProjectGroupController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('project-groups', ProjectGroupController::class, [
    'only' => ['show', 'store', 'update', 'destroy'],
]);

$router->get('datatable/project-groups', [
    'as'   => 'datatable.project-groups',
    'uses' => ProjectGroupController::class . '@datatable',
]);

$router->get('select2/project-groups', [
    'as'   => 'select2.project-groups',
    'uses' => ProjectGroupController::class . '@select2',
]);