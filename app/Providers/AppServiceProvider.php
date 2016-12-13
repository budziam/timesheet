<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
