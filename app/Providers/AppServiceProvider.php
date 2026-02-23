<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Services\SpamDetectionService;
use App\Services\SupabaseAuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SupabaseAuthService::class, function ($app) {
            return new SupabaseAuthService();
        });

        $this->app->singleton(SpamDetectionService::class, function ($app) {
            return new SpamDetectionService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       View::share('recaptchaSiteKey', config('services.recaptcha.site_key'));
    }
}
