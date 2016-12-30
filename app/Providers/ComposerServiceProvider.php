<?php
namespace App\Providers;

use App\Bases\BaseServiceProvider;
use Illuminate\View\View;

class ComposerServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->auth();
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
