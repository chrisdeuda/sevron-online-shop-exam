<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Vapor\Vapor;
use Laravel\Vapor\Contracts\LambdaResponse;
use Laravel\Vapor\Http\Middleware\EnsureOnVapor;

class VaporUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
     /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->gate();
    }

    /**
     * Register the Vapor UI gate.
     *
     * This gate determines who can access Vapor UI in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewVaporUI', function ($user = null) {
            return true; // Allow all access for now
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
