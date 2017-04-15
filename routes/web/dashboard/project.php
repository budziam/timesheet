<?php

use App\Http\Controllers\Dashboard\ProjectController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('projects', ProjectController::class, [
    'only' => ['index', 'edit'],
]);