<?php

namespace App\Providers;

use App\Models\WorkLog;
use App\Policies\DashboardPolicy;
use App\Policies\WorkLogPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'dashboard'    => DashboardPolicy::class,
        WorkLog::class => WorkLogPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
