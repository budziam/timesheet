<?php

namespace App\Providers;

use App\Models\User;
use App\Models\WorkLog;
use App\Utils\FileUtils;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = '';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Router $router)
    {
        $this->resourceParameters($router);

        $this->web($router);
    }

    protected function resourceParameters(Router $router)
    {
        $router->singularResourceParameters();
    }

    protected function web(Router $router)
    {
        $router->group(['middleware' => 'web'], function (Router $router) {
            $this->app($router);
            $this->dashboard($router);
            $this->auth($router);
            require routes_path('web/translation.php');
        });
    }

    protected function app(Router $router)
    {
        $router->group([
            'middleware' => 'app',
            'as'         => 'app.',
        ], function (Router $router) {
            $this->includeFiles('web/app', $router);

            $router->group([
                'prefix' => 'api',
                'as'     => 'api.',
            ], function (Router $router) {
                $this->includeFiles('web/app/api', $router);
            });
        });
    }

    protected function dashboard(Router $router)
    {
        $router->group([
            'middleware' => 'dahsboard',
            'prefix'     => 'dahsboard',
            'as'         => 'dahsboard.',
        ], function (Router $router) {
            $this->includeFiles('web/dashboard', $router);

            $router->group([
                'prefix' => 'api',
                'as'     => 'api.',
            ], function (Router $router) {
                $this->includeFiles('web/dashboard/api', $router);
            });
        });
    }

    protected function auth(Router $router)
    {
        $router->group([
            'prefix' => 'auth',
            'as'     => 'auth.',
        ], function (Router $router) {
            require routes_path('web/auth.php');
        });
    }

    protected function includeFiles($path, Router $router)
    {
        foreach (FileUtils::getPhpFilesInDirectory(routes_path($path)) as $fileInfo) {
            require $fileInfo->getRealPath();
        }
    }
}
