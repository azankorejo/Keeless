<?php

namespace App\Http\Controllers\Domain\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsumerLoginIndexResource;
use App\Jobs\TestMailJob;
use App\Models\ApiKey;
use App\Models\Branding;
use App\Models\BusinessInformation;
use App\Models\EmailInformation;
use App\Models\Team;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Webmozart\Assert\Assert;

class LoginIndexController extends Controller
{
    public function __invoke(Request $request, $subdomain): \Inertia\Response
    {
        $businessInfo = BusinessInformation::query()->withoutGlobalScopes()->where('domain', $subdomain)->first();

        Assert::notNull($businessInfo, 'something went wrong, please contact support.');
        $team = Team::query()->with(['businessInfo', 'apiKeys'])->where('id', $businessInfo->team_id)->first();
        $apiKey = ApiKey::query()->where(['team_id' => $businessInfo->team_id, 'internal_key' => 1])->first();
        $branding = Branding::query()->where(['id' => $businessInfo->team_id])->first();

        Assert::notNull($apiKey, 'something went wrong, please contact support.');
        Assert::notNull($team, 'something went wrong, please contact support.');
        Assert::notNull($branding, 'something went wrong, please contact support.');
        $data = [
            'name' => $businessInfo?->name,
            'domain' => $businessInfo?->domain,
            'access_token' => $apiKey?->key,
            'email_needed' => $businessInfo?->use_email_for_login,
            'username_needed' => $businessInfo?->use_username_for_login,
            'phone_needed' => $businessInfo?->use_phone_for_login,
            'logo' => $branding->logo,
            'favicon' => $branding->favicon,
            'primary_color' => $branding->primary_color,
            'secondary_color' => 'focus:border-[' . $branding->secondary_color. ']',
        ];
        return Inertia::render('Consumer/Login', [
            'data' => $data
        ]);
    }
}
