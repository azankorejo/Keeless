<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Branding;
use App\Models\BusinessInformation;
use App\Models\Consumer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Webmozart\Assert\Assert;

class LoginOtpIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('Auth/Otp');
    }
}
