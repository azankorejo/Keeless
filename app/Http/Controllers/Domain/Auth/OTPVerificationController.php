<?php

namespace App\Http\Controllers\Domain\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\BusinessInformation;
use App\Models\ConsumerAuthentication;
use App\Models\ConsumerToken;
use App\Models\RedirectionInformation;
use App\Models\TeamSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use STS\JWT\Facades\JWT;

class OTPVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['otp' => 'required', 'access_token' => 'required']);
        $api = ApiKey::query()->where('key', $request->access_token)->first();

        if (!$api) {
            return abort(403, 'Something gone wrong, please contact support.');
        }
        $token = ConsumerAuthentication::query()->with('consumer')
            ->valid()
            ->where('otp', true)
            ->where('token', $request->otp)
            ->first();

        $businessInfo = BusinessInformation::query()->where('team_id', $api->team_id)->first();
        if(!$token) {
            if ($businessInfo->use_api) {
                return response()->json([
                    'message' => 'The given OTP is invalid',
                ], 422);
            }
            return back()->withErrors(['error' => 'The given OTP is invalid']);
        }
        ConsumerAuthentication::query()->with('consumer')
            ->valid()
            ->where('otp', true)
            ->where('token', $request->otp)
            ->update(['expires_at' => now()]);

        $redirectionInfo = RedirectionInformation::query()->where('team_id', $api->team_id)->first();

        if ($redirectionInfo) {
            $signingKey = Str::random(32);
            $setting = TeamSetting::query()->where('team_id', $token->consumer->team_id)->where('key', TeamSetting::JWT_EXPIRATION_KEY)->first();

            $jwt = JWT::get(
                'authentication_keeless_id_token',
                Arr::only($token->consumer->toArray(), ['email', 'username', 'phone']),
                now()->addDays((int)$setting->value ?? 1),
                $signingKey
            );

            ConsumerToken::query()->create([
                'consumer_id' => $token->consumer->id,
                'token' => $jwt,
                'signing_key' => $signingKey,
                'valid' => true
            ]);
            if ($businessInfo->use_api) {
               return response()->json([
                   'token' => $jwt,
                   'callback_url' => $redirectionInfo->login
               ]);
            }
            return Inertia::location($redirectionInfo->login . '?token=' . $jwt);
        }
        if ($businessInfo->use_api) {
            return response()->json([
                'message' => 'If you are the application owner, please add login redirection information.',
            ], 403);
        }
        return back()->withErrors(['error' => 'If you are the application owner, please add login redirection information.']);
    }
}
