<?php

namespace App\Http\Middleware;

use App\Models\BusinessInformation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDomainExists
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
        if(!$subdomain) {
            // Use the configured APP_URL for redirects (works for both http and https)
            return redirect()->away(config('app.url') . '/dashboard')->setStatusCode(302);
        }
        $domainExists = BusinessInformation::query()->withoutGlobalScopes()->where('domain', $subdomain)->exists();
        if ($domainExists) {
            return $next($request);
        }

        // Use the configured APP_URL for redirects (works for both http and https)
        return redirect()->away(config('app.url'))->setStatusCode(403);
    }
}
