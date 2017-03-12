<?php
namespace App\Providers;

use App\Bases\BaseServiceProvider;
use App\Builders\NavbarBuilder;
use Illuminate\View\View;

class NavbarServiceProvider extends BaseServiceProvider
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
        \View::composer('app.layout.includes.navbar', function (View $view) {
            $view->with([
                'user' => auth()->user(),
            ]);
        });

        \View::composer('app.layout.includes.navbar-user', function (View $view) {
            $view->with([
                'navbar' => app(NavbarBuilder::class),
            ]);
        });
    }
}
