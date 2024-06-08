<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use App\Models\BusinessInformation;
use App\Models\PermittedDomains;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the access token from the request
        $accessToken = $request->get('access_token');
        $subdomain = $request->route('subdomain');

        $apiKey = ApiKey::query()->where('key', $accessToken)->first();
        if(!$apiKey || !$subdomain) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $domainExists = BusinessInformation::query()->where('domain', $subdomain)->where('team_id', $apiKey->team_id)->first();
        if(!$domainExists) {
            return response()->json(['error' => 'Unauthorized, make sure to correct your api keys or fix any typos in your domain url.'], 401);
        }
        if (str_contains($request->url(), 'api/v1/') && !$domainExists->use_api) {
            return response()->json(['error' => 'Make sure to set your settings to use the api from setup page.'], 401);
        }
        $permittedDomains = PermittedDomains::query()->where('team_id', $apiKey->team_id)->pluck('domain')->toArray();
        $referer = $request->headers->get('referer');
        $refererUrl = rtrim(url($referer), '/');

        if ($apiKey->key !== $accessToken || !$domainExists || !in_array($refererUrl, $permittedDomains)) {
            if (!in_array($refererUrl, $permittedDomains) && $domainExists->use_api) {
                return response()->json(['error' => 'Unauthorized, make sure to add your domain into permitted domains section in Setup section of your app.'], 401);
            }
            if (!$domainExists->use_api && $this->checkIfReqComingFromAuthScreens($refererUrl, $request->url())) {
                return $next($request);
            }
            return response()->json(['error' => 'Unauthorized, check if your api key is set.'], 401);
        }

        return $next($request);
    }

    /**
     * @param string $refererUrl
     * @param string $url
     * @return bool
     */
    private function checkIfReqComingFromAuthScreens(string $refererUrl, string $url): bool
    {
        $refererDomain = $this->getDomainUpToTest($refererUrl);
        $urlDomain = $this->getDomainUpToTest($url);
        // Compare
        if (($refererDomain && $urlDomain) && $refererDomain === $urlDomain) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $url
     * @return string
     */
    private function getDomainUpToTest(string $url): string {
        $parsed = parse_url($url);
        return $parsed['host'];
    }
}
