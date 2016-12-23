<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\WorkLogController;

$router->resource('work-logs', WorkLogController::class, [
    'only' => ['store'],
]);