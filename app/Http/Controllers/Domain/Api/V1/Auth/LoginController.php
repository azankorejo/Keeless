<?php

namespace App\Http\Controllers\Domain\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsumerLoginRequest;
use App\Models\ApiKey;
use App\Models\BusinessInformation;
use App\Services\ConsumerAuthService;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function __construct(private ConsumerAuthService $authService)
    {
    }

    public function __invoke(ConsumerLoginRequest $request)
    {
        $api = ApiKey::query()->where('key', $request->access_token)->first();
        if (!$api) {
            return abort(403, 'Something gone wrong, please contact support.');
        }
        $businessInfo = BusinessInformation::query()->where('team_id', $api->team_id)->firstOrFail();
        $fields = [];

        if ($businessInfo->use_email_for_login) {
            $fields[] = 'email';
        }
        if ($businessInfo->use_username_for_login) {
            $fields[] = 'username';
        }
        if ($businessInfo->use_phone_for_login) {
            $fields[] = 'phone';
        }

        return $this->authService->handle($request, $fields, $businessInfo, $api, false);
    }
}
