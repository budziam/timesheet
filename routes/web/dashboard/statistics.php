<?php

use App\Http\Controllers\Dashboard\StatisticsController;

/** @var \Illuminate\Routing\Router $router */

$router->get('statistics/projects', [
    'as'   => 'statistics.projects',
    'uses' => StatisticsController::class . '@projects',
]);

$router->get('statistics/project-groups', [
    'as'   => 'statistics.project-groups',
    'uses' => StatisticsController::class . '@projectGroups',
]);

$router->get('statistics/customers', [
    'as'   => 'statistics.customers',
    'uses' => StatisticsController::class . '@customers',
]);