<?php

namespace App\Providers;

use Illuminate\Http\Request;
use App\Settings\GlobalSettings;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
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
    public function boot(GlobalSettings $settings, Request $request): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();
        View::share('settings', $settings);
        View::share('isMobile', checkIsMobile($request));

        Request::macro('getDefaultOnEachSide', function () {
            return 2; // Or any other default value you prefer
        });

        if(env('APP_ENV') !== 'local')
        {
            URL::forceScheme('https');
        }

    }
}
