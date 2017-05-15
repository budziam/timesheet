<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\ProjectWorkLogController;
use App\Http\Controllers\App\Api\WorkLogController;
use App\Http\Controllers\App\Api\WorkLogSearchController;

$router->get('search/work-logs/fullcalendar', [
    'as'   => 'search.work-logs.fullcalendar',
    'uses' => WorkLogSearchController::class . '@fullcalendar',
]);

$router->get('search/work-logs/fullcalendar-sync', [
    'as'   => 'search.work-logs.fullcalendar-sync',
    'uses' => WorkLogSearchController::class . '@fullcalendarSync',
]);

$router->patch('work-logs/{workLog}', [
    'as'   => 'work-logs.update',
    'uses' => WorkLogController::class . '@update',
])
    ->middleware('can:update,workLog');

$router->delete('work-logs/{workLog}', [
    'as'   => 'work-logs.destroy',
    'uses' => WorkLogController::class . '@destroy',
]);

$router->post('projects/{project}/work-logs', [
    'as'   => 'projects.work-logs.store',
    'uses' => ProjectWorkLogController::class . '@store',
])
    ->middleware('can:store,' . \App\Models\WorkLog::class . ',project');
