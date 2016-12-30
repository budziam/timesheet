<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\WorkLogSearchController;

$router->get('search/work-logs/fullcalendar', [
    'as'   => 'search.work-logs.fullcalendar',
    'uses' => WorkLogSearchController::class . '@fullcalendar',
]);