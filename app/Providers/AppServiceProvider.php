<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->route();

        require_once(app_path('helpers.php'));
    }

    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Modifies how route system works
     */
    protected function route()
    {
        $this->app->bind(\Illuminate\Routing\ResourceRegistrar::class, function () {
            return $this->app->make(\App\ResourceNoPrefixRegistrar::class);
        });
    }
}
