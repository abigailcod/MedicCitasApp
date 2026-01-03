<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        Broadcast::routes();
        
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        
        require base_path('routes/channels.php');
        require base_path('routes/web.php');
    }
}
