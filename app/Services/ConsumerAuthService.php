<?php

namespace App\Services;

use App\Actions\ConsumerEmailAction;
use App\Models\ApiKey;
use App\Models\BusinessInformation;
use App\Models\Consumer;
use App\Models\EmailInformation;
use Illuminate\Http\Request;

class ConsumerAuthService
{

    public function __construct(private ConsumerEmailAction $consumerEmailAction)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function handle(Request $request, array $fields, BusinessInformation $businessInfo, ApiKey $api, bool $create = false)
    {
        $emailInfo = EmailInformation::query()->where('team_id', $api->team_id)->firstOrFail();

        $payload = $request->only($fields);

        if ($create) {
            $consumer = Consumer::query()->create(array_merge($payload, ['team_id' => $emailInfo->team_id]));
            if (!$consumer) {
                return back()->withErrors(['error' => 'Something went wrong. Please try again or contact support.']);
            }
        } else {
            $consumer = Consumer::query()->where('team_id', $api->team_id)->where($payload)->first();
            if(!$consumer->active) {
                return back()->withErrors(['error' => 'Your account has been disabled by the app owner.']);
            }
            if (!$consumer) {
                return back()->withErrors(['error' => 'Invalid login credentials. Please check and re-enter your credentials.']);
            }
        }

        $this->consumerEmailAction->handle($api->team_id, $consumer->email, $businessInfo->name, $consumer, $businessInfo->domain, $create);

        if($businessInfo->use_api) {

            if ($emailInfo->use_otp) {
                return response()->json(['message' => 'Success! Your login attempt has been recognized. Check your email for the OTP (One-Time Password) we\'ve sent to ensure secure access.']);
            }
            return response()->json(['message' => 'An email containing a magic link for verification has been sent to your registered email address. Please check your inbox (and spam/junk folder) and click on the magic link to complete the verification process. If you haven\'t received the email within a few minutes, please contact our support team for assistance.']);
        }

        if ($emailInfo->use_otp) {
            return redirect('consumer/otp');
        }
        return redirect('consumer/email-sent');
    }
}
