<?php

namespace App\Http\Middleware;

use App\Models\BusinessInformation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsingCustomAuthenticationPagesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $subdomain = $request->route('subdomain');
        $domainExists = BusinessInformation::query()->withoutGlobalScopes()->where('domain', $subdomain)->first();
        if (!$domainExists->use_api) {
            return $next($request);
        }
        
        // Parse the APP_URL to extract just the host
        $appUrl = config('app.url');
        $parsedUrl = parse_url($appUrl);
        $scheme = $parsedUrl['scheme'] ?? $request->getScheme();
        $host = $parsedUrl['host'] ?? $parsedUrl['path'] ?? 'localhost';
        
        // Build the correct URL without double slashes
        $redirectUrl = rtrim($scheme . '://' . $host, '/') . '/dashboard';
        
        return redirect()->away($redirectUrl)->setStatusCode(302);
    }
}
