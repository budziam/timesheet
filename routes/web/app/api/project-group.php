<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\ProjectGroupController;

$router->resource('project-groups', ProjectGroupController::class, [
    'only' => ['index'],
]);