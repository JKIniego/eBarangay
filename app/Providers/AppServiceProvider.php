<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; 
use App\Models\User;
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
        // Allows us to check if the user is an admin throughout the app
        Gate::define('admin-only', function (User $user) {
            return $user->role === 'admin'; 
        });
    }
}
