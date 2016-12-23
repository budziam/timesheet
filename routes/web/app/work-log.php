<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\WorkLogController;

$router->resource('work-logs', WorkLogController::class, [
    'only' => ['create'],
]);