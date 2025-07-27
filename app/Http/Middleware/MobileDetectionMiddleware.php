<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MobileDetectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Detect if the request is from a mobile device
        $isMobile = $this->isMobileDevice($request);
        
        // Store mobile detection in request for use in controllers
        $request->attributes->set('is_mobile', $isMobile);
        
        // Add mobile detection to view data
        view()->share('isMobile', $isMobile);
        
        return $next($request);
    }

    /**
     * Determine if the request is from a mobile device
     */
    private function isMobileDevice(Request $request): bool
    {
        $userAgent = $request->header('User-Agent', '');
        
        // Check for mobile user agent patterns
        $mobilePatterns = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 
            'Windows Phone', 'Opera Mini', 'IEMobile', 'Mobile Safari'
        ];
        
        foreach ($mobilePatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return true;
            }
        }
        
        // Check for mobile-specific headers
        if ($request->header('X-Wap-Profile') || 
            $request->header('Profile') ||
            $request->header('X-OperaMini-Features') ||
            $request->header('UA-pixels')) {
            return true;
        }
        
        // Check for mobile accept headers
        $accept = $request->header('Accept', '');
        if (stripos($accept, 'wap') !== false || 
            stripos($accept, 'mobile') !== false) {
            return true;
        }
        
        // Check viewport width (if provided)
        $viewportWidth = $request->header('Viewport-Width');
        if ($viewportWidth && (int)$viewportWidth <= 768) {
            return true;
        }
        
        // Force mobile mode via query parameter (for testing)
        if ($request->has('mobile') && $request->get('mobile') === '1') {
            return true;
        }
        
        return false;
    }
}