<?php
namespace App\Providers;

use App\Bases\ServiceProvider;
use App\Builders\NavbarBuilder;
use Illuminate\View\View;

class NavbarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->singleton();
        $this->view();
    }

    protected function singleton()
    {
        $this->app->singleton(NavbarBuilder::class, function () {
            return new NavbarBuilder;
        });
    }

    protected function view()
    {
        \View::composer(['app.layout.includes.navbar', 'dashboard.layout.includes.sidebar'], function (View $view) {
            $view->with([
                'user' => auth()->user(),
            ]);
        });

        \View::composer(['app.layout.includes.navbar-user', 'dashboard.layout.includes.sidebar'],
            function (View $view) {
                $view->with([
                    'navbar' => app(NavbarBuilder::class),
                ]);
            });
    }
}
