<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            base_path('database/migrations'),
            
            base_path('database/migrations/drivers'),
            base_path('database/migrations/delivery-categories'),
            base_path('database/migrations/drivers-delivery-categories'),

            base_path('database/migrations/vehicles'),
            base_path('database/migrations/customers'),
            base_path('database/migrations/orders'),
            base_path('database/migrations/services'),
        ]);
    }
}
