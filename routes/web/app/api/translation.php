<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\App\Api\TranslationController;

$router->resource('translations', TranslationController::class, [
    'only' => ['index'],
]);
