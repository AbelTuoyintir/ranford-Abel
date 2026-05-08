<?php

namespace App\Providers;

use App\Models\RouteMap;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
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
        //
       // Force HTTP in local environment
    // if ($this->app->environment('local')) {
    //     Log::info('forcing http scheme');
    //     URL::forceScheme('http');
    //     URL::forceRootUrl(config('app.url'));
    //     $this->app['request']->server->set('HTTPS', false);
    // }

        app()->terminating(function () {
            Log::info('Request Time: ' . (microtime(true) - LARAVEL_START) . ' seconds');
        });
           // Add a custom URL generator for obfuscated routes
        //    URL::forceScheme('http');
           URL::macro('obfuscated', function ($routeName, $parameters = [], $absolute = true) {
            $uuid = RouteMap::getUuidForRoute($routeName);
        
            if (!$uuid) {
                Log::error("UUID not found for route: {$routeName}");
                throw new \Exception("UUID not found for route: {$routeName}");
            }
        
            
            return url($uuid, $parameters, $absolute);
        });

        Paginator::useTailwind();
    }
}
