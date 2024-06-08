<?php

namespace App\Actions;

use App\Jobs\SendAuthenticationEmailJob;
use App\Models\Consumer;
use App\Models\Email;
use App\Models\EmailInformation;
use Illuminate\Support\Facades\Log;

class ConsumerEmailAction
{

    public function handle(int $teamId, string $to, string $appName, Consumer $consumer, string $domain, bool $create = false): void
    {
        $emailInfo = EmailInformation::query()->withoutGlobalScopes()->where('team_id', $teamId)->first();
        $email = Email::query()
            ->withoutGlobalScopes()
            ->where('team_id', $teamId)
            ->where('code', $emailInfo->use_otp ? Email::CODE_OTP : Email::CODE_MAGIC)
            ->first();
        if (!$email || !$emailInfo) {
            Log::error('Email or email information was not found', [
                'emailInfo' => !!$emailInfo,
                'email' => !!$email,
            ]);
            return;
        }
        $configuration = [
            'to' => $to,
            'from_name' => $emailInfo->username,
        ];

        if($emailInfo->use_smtp) {
            $configuration = [
                'transport' => 'smtp',
                'host' => $emailInfo->server,
                'port' => $emailInfo->port,
                'username' => $emailInfo->email,
                'password' => $emailInfo->password,
                'encryption' => 'ssl',

                'to' => $to,
                'from_name' => $emailInfo->username,
            ];
        }

        SendAuthenticationEmailJob::dispatch($configuration, $emailInfo->use_otp, $appName, $email, $consumer, $domain, $create);
    }
}
