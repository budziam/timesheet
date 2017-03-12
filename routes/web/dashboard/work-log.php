<?php

use App\Http\Controllers\Dashboard\WorkLogController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('work-logs', WorkLogController::class, [
    'only' => ['index', 'show', 'edit'],
]);