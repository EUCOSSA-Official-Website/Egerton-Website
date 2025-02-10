<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

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
        Vite::prefetch(concurrency: 3);

        Password::defaults(function () {
            return Password::min(8) // Minimum 8 characters
                ->letters() // Must contain letters
                ->mixedCase() // Must contain uppercase & lowercase
                ->numbers() // Must contain numbers
                ->symbols(); // Must contain symbols (e.g., @, #, *)
        });
    }
}
