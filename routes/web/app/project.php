<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\ProjectController;

$router->resource('projects', ProjectController::class, [
    'only' => ['index'],
]);