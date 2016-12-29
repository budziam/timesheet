<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\WorkLogController;

$router->resource('work-logs', WorkLogController::class, [
    'only' => ['index'],
]);

$router->get('work-logs/sync', [
    'as'   => 'work-logs.sync',
    'uses' => WorkLogController::class . '@sync',
]);