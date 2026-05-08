<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use App\Models\IpAddress; // Import the IpAddress model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RestrictByIPRange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get current settings
        $settings = Setting::first();
        
        // If no settings exist or normal mode is enabled, allow access without IP check
        if (!$settings || $settings->normal_mode) {
            return $next($request);
        }
        
        // If school network restriction is enabled, check IP address
        if ($settings->school_network_restriction) {
            $clientIP = $request->ip();
          
            // Log the client IP for debugging
            Log::info('Client IP detected: ' . $clientIP);
           
            // Fetch all active IP addresses from the database
            $allowedRanges = IpAddress::where('active', true)->pluck('address')->toArray();

            // Check if the client IP matches any of the allowed ranges
            $isAllowed = $this->checkIPRange($clientIP, $allowedRanges);

            if (!$isAllowed) {
                // If not allowed, abort with a 403 Forbidden response
                Log::warning('Access blocked for IP: ' . $clientIP);
                return response()->view('errors.403', ['ip' => $clientIP], 403);
            }
        }
        
        return $next($request);
    }

    /**
     * Check if an IP address falls within any of the allowed ranges
     *
     * @param string $ip The IP address to check
     * @param array $ranges Array of allowed IP ranges with wildcards
     * @return bool
     */
    protected function checkIPRange(string $ip, array $ranges): bool
    {
        foreach ($ranges as $range) {
            // Replace wildcard with regex pattern
            $pattern = str_replace('*', '\d+', $range);
            $pattern = '/^' . str_replace('.', '\.', $pattern) . '$/';

            if (preg_match($pattern, $ip)) {
                return true;
            }
        }

        return false;
    }
}