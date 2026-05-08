<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class RouteMap extends Model
{
    protected $fillable = ['uuid', 'actual_route'];
    
    /**
     * Get the actual route for a given UUID
     */
    public static function getActualRoute($uuid)
    {
        $map = self::where('uuid', $uuid)->first();
        return $map ? $map->actual_route : null;
    }
    
    /**
     * Get or create a UUID for a given route
     */
    public static function getUuidForRoute($route)
    {
        // Remove leading slash if present
        $route = ltrim($route, '/');
        
        $map = self::where('actual_route', $route)->first();
        
        if (!$map) {
            $map = self::create([
                'uuid' => Str::uuid(),
                'actual_route' => $route
            ]);
        }
        
        return $map->uuid;
    }
}
