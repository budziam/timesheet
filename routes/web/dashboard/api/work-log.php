<?php

use App\Http\Controllers\Dashboard\Api\WorkLogController;

/** @var \Illuminate\Routing\Router $router */

$router->resource('work-logs', WorkLogController::class, [
    'only' => ['show', 'store', 'update', 'destroy'],
]);

$router->get('datatable/work-logs', [
    'as'   => 'datatable.work-logs',
    'uses' => WorkLogController::class . '@datatable',
]);