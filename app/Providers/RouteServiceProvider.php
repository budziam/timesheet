<?php

namespace App\Providers;

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
        });
    }

    protected function app(Router $router)
    {
        $router->group([
            'middleware' => 'app',
            'as'         => 'app::',
        ], function (Router $router) {
            foreach (FileUtils::getPhpFilesInDirectory(routes_path('web/app')) as $fileInfo) {
                require $fileInfo->getRealPath();
            }

            $router->group([
                'prefix' => 'api',
                'as'     => 'api.',
            ], function (Router $router) {
                foreach (FileUtils::getPhpFilesInDirectory(routes_path('web/app/api')) as $fileInfo) {
                    require $fileInfo->getRealPath();
                }
            });
        });
    }

    protected function dashboard(Router $router)
    {
        $router->group([
            'middleware' => 'dahsboard',
            'prefix'     => 'dahsboard',
            'as'         => 'dahsboard::',
        ], function (Router $router) {
            foreach (FileUtils::getPhpFilesInDirectory(routes_path('web/dashboard')) as $fileInfo) {
                require $fileInfo->getRealPath();
            }

            $router->group([
                'prefix' => 'api',
                'as'     => 'api.',
            ], function (Router $router) {
                foreach (FileUtils::getPhpFilesInDirectory(routes_path('web/dashboard/api')) as $fileInfo) {
                    require $fileInfo->getRealPath();
                }
            });
        });
    }
}
