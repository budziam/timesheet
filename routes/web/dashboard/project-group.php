<?php

use App\Http\Controllers\Dashboard\ProjectGroupController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('project-groups', ProjectGroupController::class, [
    'only' => ['index', 'create', 'edit'],
]);