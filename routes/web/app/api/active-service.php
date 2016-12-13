<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\ProjectController;

$router->resource('projects', ProjectController::class, [
    'only' => ['index'],
]);