<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\ProjectGroupSearchController;

$router->get('search/project-groups/select2', [
    'as'   => 'search.project-groups.select2',
    'uses' => ProjectGroupSearchController::class . '@select2',
]);