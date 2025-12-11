<?php

namespace App\Http\Middleware;

use App\Models\BusinessInformation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current URL
        $currentUrl = $request->url();

        // Parse the URL
        $parsedUrl = parse_url($currentUrl);
        $host = $parsedUrl['host'] ?? '';

        // Check if the host is an IP address (not a domain name)
        // IP addresses should not be processed for subdomain logic
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $next($request);
        }

        // Check if the host contains a subdomain
        $hostParts = explode('.', $host);
        
        // For localhost, check if there are 2 parts (subdomain.localhost)
        // For other domains, check if there are more than 2 parts (subdomain.domain.com)
        $isLocalhost = in_array('localhost', $hostParts) || $host === 'localhost';
        $hasSubdomain = $isLocalhost ? count($hostParts) >= 2 && $hostParts[0] !== 'localhost' 
                                      : count($hostParts) > 2;
        
        if (!$hasSubdomain) {
            return $next($request);
        }
        
        $subdomain = $hostParts[0];
        $domain = BusinessInformation::query()->withoutGlobalScopes()->where('domain', $subdomain)->first();
        if ($domain) {
            return redirect()->route('consumer.login', $domain->domain);
        }
        // Use the configured APP_URL scheme (http/https) for redirects
        $appUrl = config('app.url');
        return redirect()->away($appUrl)->setStatusCode(403);
    }
}
