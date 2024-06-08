<?php

namespace App\Http\Controllers\Domain\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConsumerToken;
use App\Models\TeamSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use STS\JWT\Facades\JWT;

class TokenAuthenticator extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $subdomain, string $token)
    {
        $consumerToken = ConsumerToken::query()->valid()->with('consumer')->where([
            'token' => $token,
        ])->first();

        return $consumerToken && !Jwt::parse($consumerToken->token)->isExpired() ?
            response()->json(['token' => $consumerToken->token]) :
            response()->json(['token_status' => 'Token expired'], 401);
    }
}
