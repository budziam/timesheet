<?php
namespace App\Providers;

use App\Bases\ServiceProvider;
use App\Builders\Breadcrumb\BreadcrumbBuilder;
use Illuminate\View\View;

class ComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(BreadcrumbBuilder::class, function () {
            return new BreadcrumbBuilder;
        });
    }

    public function boot()
    {
        \View::composer('dashboard.includes.breadcrumbs', function (View $view) {
            $view->with('breadcrumbs', BreadcrumbBuilder::instance()->getBreadcrumbs());
        });

        \View::composer(['app.layout.layout', 'dashboard.layout.layout'], function (View $view) {
            $view->with('pageTitle', BreadcrumbBuilder::instance()->getPageTitle());
        });
    }
}
