<?php

namespace App\Http\Middleware;

use App\Models\PermittedDomains;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermittedDomains
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the domain from the request
        $domain = parse_url($request->headers->get('origin'), PHP_URL_HOST);

        // Check if the domain exists in the permitted_domains table
        $permittedDomain = PermittedDomains::query()->withoutGlobalScopes()->where('domain', $domain)->first();

        // If domain is not permitted, return 403 Forbidden
        if (!$permittedDomain) {
            // Use the configured APP_URL for redirects (works for both http and https)
            return redirect()->away(config('app.url'))->setStatusCode(403);
        }

        // Pass the request to the next middleware
        return $next($request);
    }
}
