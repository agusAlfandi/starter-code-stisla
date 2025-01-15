<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public static $permissions = [
        'dashboard' => ['admin', 'user'],
        'show-user' => ['superadmin', 'admin', 'user'],
        'create-user' => ['superadmin'],
        'edit-user' => ['superadmin'],
        'delete-user' => ['superadmin'],
        'update-user' => ['superadmin'],
    ];

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
        Gate::before(function (User $user) {
            if ($user->role === 'superadmin') {
                return true;
            }
        });

        foreach (self::$permissions as $action => $roles) {
            Gate::define($action, function (User $user) use ($roles) {
                if (!in_array($user->role, $roles)) {
                    return false;
                }
                return true;
            });
        }
    }
}
