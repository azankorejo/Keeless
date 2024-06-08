<?php

namespace App\Http\Controllers\Domain\Api\V1\Auth;

use App\Actions\ConsumerEmailAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsumerLoginRequest;
use App\Http\Requests\ConsumerRegisterRequest;
use App\Services\ConsumerAuthService;
use App\Models\ApiKey;
use App\Models\BusinessInformation;
use App\Models\Consumer;
use App\Models\EmailInformation;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RegisterController extends Controller
{

    public function __construct(private ConsumerAuthService $authService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(ConsumerRegisterRequest $request)
    {
        $api = ApiKey::query()->where('key', $request->access_token)->first();
        if (!$api) {
            return abort(403, 'Something gone wrong, please contact support.');
        }
        $businessInfo = BusinessInformation::query()->where('team_id', $api->team_id)->firstOrFail();
        $fields = [];

        if ($businessInfo->use_email) {
            $fields[] = 'email';
        }
        if ($businessInfo->use_username) {
            $fields[] = 'username';
        }
        if ($businessInfo->use_phone) {
            $fields[] = 'phone';
        }
        return $this->authService->handle($request, $fields, $businessInfo, $api, true);
    }
}
