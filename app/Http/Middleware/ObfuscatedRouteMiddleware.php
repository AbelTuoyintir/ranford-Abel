<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RouteMap;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class ObfuscatedRouteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    
     
     public function handle(Request $request, Closure $next): Response
{
    $uuid = $request->segment(1);

    // Skip middleware for certain routes
    if ($request->is('api/*') || $request->is('_debugbar/*') || $request->is('assets/*')) {
        return $next($request);
    }
    // if (app()->environment('local')) {
    //     URL::forceScheme('http');
    // }

    // If UUID segment exists and is valid
    if ($uuid && Str::isUuid($uuid)) {
        // Retrieve actual route from database
        $actualRoute = RouteMap::getActualRoute($uuid);
        
        if ($actualRoute) {
            // Instead of creating a new request, let's modify the existing one
            $request->server->set('REQUEST_URI', '/' . $actualRoute);
            
            // Update the route parameters
            $pathInfo = '/' . $actualRoute;
            $request->server->set('PATH_INFO', $pathInfo);
            
            // This is important - update the request's internal paths
            $request->initialize(
                $request->query->all(),
                $request->request->all(),
                $request->attributes->all(),
                $request->cookies->all(),
                $request->files->all(),
                $request->server->all(),
                $request->getContent()
            );
            
            // Force Laravel to re-resolve the route
            app('router')->getRoutes()->match($request);
        }
    }

    return $next($request);
}
     


}
