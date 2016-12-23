<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\ProjectSearchController;

$router->get('search/projects/default', [
    'as'   => 'search.projects.default',
    'uses' => ProjectSearchController::class . '@default',
]);

$router->get('search/projects/select2', [
    'as'   => 'search.projects.select2',
    'uses' => ProjectSearchController::class . '@select2',
]);