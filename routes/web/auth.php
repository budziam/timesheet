<?php

/** @var \Illuminate\Routing\Router $router */

use App\Http\Controllers\Auth\LoginController;

$this->get('login', LoginController::class . '@showLoginForm')->name('login');
$this->post('login', LoginController::class . '@login');
$this->post('logout', LoginController::class . '@logout')->name('logout');