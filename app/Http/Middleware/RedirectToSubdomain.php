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

        // Check if the host contains a subdomain
        $hostParts = explode('.', $parsedUrl['host']);
        $subdomain = count($hostParts) > 2 ? $hostParts[0] : null;
        if(!$subdomain) {
            return $next($request);
        }
        $domain = BusinessInformation::query()->withoutGlobalScopes()->where('domain', $subdomain)->first();
        if ($domain) {
            return redirect()->route('consumer.login', $domain->domain);
        }
        return redirect()->away('https://'. config('app.url'))->setStatusCode(403);
    }
}
