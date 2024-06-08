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
        return redirect()->away('https://'. config('app.url'). '/dashboard')->setStatusCode(302);
    }
}
