<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\TranslationController;

$router->resource('api/translations', TranslationController::class, [
    'only' => ['index'],
]);
