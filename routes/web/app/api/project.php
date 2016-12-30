<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\ProjectSearchController;
use App\Http\Controllers\App\Api\ProjectWorkLogController;

$router->get('search/projects/default', [
    'as'   => 'search.projects.default',
    'uses' => ProjectSearchController::class . '@default',
]);

$router->get('search/projects/select2', [
    'as'   => 'search.projects.select2',
    'uses' => ProjectSearchController::class . '@select2',
]);

$router->get('projects/{project}/work-logs', [
    'as'   => 'projects.work-logs.index',
    'uses' => ProjectWorkLogController::class . '@index',
]);

$router->post('projects/{project}/work-logs/sync', [
    'as'   => 'projects.work-logs.sync',
    'uses' => ProjectWorkLogController::class . '@sync',
]);