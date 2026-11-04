<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('select-roles-1', function (User $user, Role $role) {

            return $user->role_id === 1 && $user->role_id === $role->id;
        });
        Gate::define('select-roles-2', function (User $user, Role $role) {
            return $user->role_id === 2 && $user->role_id === $role->id;
        });
        Gate::define('select-roles-3', function (User $user, Role $role) {
            return $user->role_id === 3 && $user->role_id === $role->id;
        });

        Gate::define('admin-panel', function (User $user) {
            return $user->role_id === 2 || $user->role_id === 3;
        });
    }
}
