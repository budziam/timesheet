<?php

use App\Http\Controllers\Dashboard\Api\StatisticsController;

/** @var \Illuminate\Routing\Router $router */

$router->get('statistics/project-work-logs/{project}', [
    'as'   => 'statistics.project-work-logs',
    'uses' => StatisticsController::class . '@projectWorkLogs',
]);

$router->get('statistics/project-groups', [
    'as'   => 'statistics.project-groups',
    'uses' => StatisticsController::class . '@projectGroups',
]);