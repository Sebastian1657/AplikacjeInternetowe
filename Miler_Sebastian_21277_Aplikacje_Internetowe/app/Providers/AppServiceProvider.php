<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('is-employee', function (User $user) {
            return $user->isEmployee();
        });
        Gate::define('is-manager', function (User $user) {
            return $user->isManager();
        });
        Gate::define('is-supervisor', function (User $user) {
            return $user->isSupervisor();
        });
        Gate::define('is-admin', function (User $user) {
            return $user->isAdministrator();
        });
    }
}
