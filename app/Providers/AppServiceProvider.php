<?php

namespace App\Providers;

use App\Models\Availability;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $availability = Availability::firstOrCreate(['user_id' => auth()->id()]);
                $view->with('availability', $availability);
            }
        });
    }
}
