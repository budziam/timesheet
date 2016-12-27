<?php
namespace App\Providers;

use App\Bases\BaseServiceProvider;
use Illuminate\View\View;

class ComposerServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->app();
        $this->auth();
    }

    protected function app()
    {
        $this->navbar();
    }

    protected function navbar()
    {
        \View::composer('app.layout.includes.navbar', function (View $view) {
            $view->with([
                'homeUrl' => route('app.home.index'),
                'user'    => auth()->user(),
            ]);
        });

        \View::composer('app.layout.includes.navbar-user', function (View $view) {
            $view->with([
                'logoutUrl'   => route('auth.logout'),
                'projectsUrl' => route('app.projects.index'),
                'workLogsUrl' => route('app.work-logs.index'),
            ]);
        });
    }

    protected function auth()
    {
        \View::composer('auth.login', function (View $view) {
            $view->with([
                'loginUrl' => route('auth.login'),
            ]);
        });
    }
}
