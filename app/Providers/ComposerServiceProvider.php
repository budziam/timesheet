<?php
namespace App\Providers;

use App\Bases\BaseServiceProvider;
use App\Builders\Breadcrumb\BreadcrumbBuilder;
use Illuminate\View\View;

class ComposerServiceProvider extends BaseServiceProvider
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
    }
}
