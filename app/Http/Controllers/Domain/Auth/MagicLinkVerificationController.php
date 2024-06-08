<?php

namespace App\Http\Controllers\Domain\Auth;

use App\Http\Controllers\Controller;
use App\Models\Branding;
use App\Models\BusinessInformation;
use App\Models\ConsumerAuthentication;
use App\Models\ConsumerToken;
use App\Models\RedirectionInformation;
use App\Models\TeamSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;
use STS\JWT\Facades\JWT;

class MagicLinkVerificationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $subdomain, string $token)
    {
        $consumerAuth = ConsumerAuthentication::query()->with('consumer')
            ->valid()
            ->where('otp', false)
            ->where('token', $token)
            ->first();
        $businessInfo = BusinessInformation::query()->where(['domain' => $subdomain])->first();
        if (!$businessInfo) {
            return;
        }
        $branding = Branding::query()->where(['team_id' => $businessInfo->team_id])->first();
        if (!$consumerAuth || Jwt::parse($token)->isExpired()) {
            return Inertia::render('Consumer/LoginError', [
                'error' => 'Sorry, the link expired. Please try again.',
                'data' => [
                    'logo' => $branding->logo,
                    'favicon' => $branding->favicon,
                    'name' => $businessInfo->name
                ]
            ]);
        }
        $consumerAuth->expires_at = now();
        $consumerAuth->save();

        $redirectionInfo = RedirectionInformation::query()->where('team_id', $consumerAuth->consumer->team_id)->first();

        if ($redirectionInfo) {
            $signingKey = Str::random(32);
            $setting = TeamSetting::query()->where('team_id', $consumerAuth->consumer->team_id)->where('key', TeamSetting::JWT_EXPIRATION_KEY)->first();

            $jwt = JWT::get(
                'authentication_keeless_id_token',
                Arr::only($consumerAuth->consumer->toArray(), ['email', 'username', 'phone']),
                now()->addDays((int)$setting->value ?? 1),
                $signingKey
            );

            ConsumerToken::query()->create([
                'consumer_id' => $consumerAuth->consumer->id,
                'token' => $jwt,
                'signing_key' => $signingKey,
                'valid' => true
            ]);

            return Redirect::to($redirectionInfo->login . '?token=' . $jwt);
        }
        return Inertia::render('Consumer/LoginError', [
            'error' => 'If you are the application owner, please add login redirection information in setup section.',
            'data' => [
                'logo' => $branding->logo,
                'favicon' => $branding->favicon,
                'name' => $businessInfo->name
            ]
        ]);
    }
}
