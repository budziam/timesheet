<?php

use App\Http\Controllers\Dashboard\Api\ProjectController;

/** @var \Illuminate\Routing\Router $router */

$router->get('datatable/projects', [
    'as'   => 'datatable.projects',
    'uses' => ProjectController::class . '@datatable',
]);