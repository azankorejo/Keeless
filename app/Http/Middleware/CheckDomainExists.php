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
            return redirect()->away('https://'. config('app.url'). '/dashboard')->setStatusCode(302);
        }
        $domainExists = BusinessInformation::query()->withoutGlobalScopes()->where('domain', $subdomain)->exists();
        if ($domainExists) {
            return $next($request);
        }

        return redirect()->away('https://'. config('app.url'))->setStatusCode(403);
    }
}
