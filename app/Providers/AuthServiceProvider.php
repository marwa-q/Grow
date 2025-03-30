<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\DashboardPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => DashboardPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Optional: Define a Gate for the dashboard
        Gate::define('access-dashboard', [DashboardPolicy::class, 'access']);
    }
}
