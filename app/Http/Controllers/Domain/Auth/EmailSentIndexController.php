<?php

namespace App\Http\Controllers\Domain\Auth;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\Branding;
use App\Models\BusinessInformation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Webmozart\Assert\Assert;

class EmailSentIndexController extends Controller
{
    public function __invoke(Request $request, $subdomain): \Inertia\Response
    {
        $businessInfo = BusinessInformation::query()->withoutGlobalScopes()->where('domain', $subdomain)->first();
        Assert::notNull($businessInfo, 'something went wrong, please contact support.');
        $branding = Branding::query()->where(['id' => $businessInfo->team_id])->first();
        Assert::notNull($branding, 'something went wrong, please contact support.');

        $data = [
            'name' => $businessInfo?->name,
            'logo' => $branding->logo,
            'favicon' => $branding->favicon,
            'primary_color' => $branding->primary_color,
            'secondary_color' => 'focus:border-[' . $branding->secondary_color. ']',
        ];
        return Inertia::render('Consumer/EmailSent', [
            'data' => $data
        ]);
    }
}
