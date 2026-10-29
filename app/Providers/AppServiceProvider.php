<?php

namespace App\Providers;

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
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('projets') && !\Illuminate\Support\Facades\Schema::hasColumn('projets', 'client_email')) {
                \Illuminate\Support\Facades\Schema::table('projets', function ($table) {
                    $table->string('client_email')->nullable();
                    $table->string('client_telephone')->nullable();
                });
            }
        } catch (\Exception $e) {
            // Silently ignore if database connection is not ready yet
        }
    }
}
