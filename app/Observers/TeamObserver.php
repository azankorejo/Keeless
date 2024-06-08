<?php

namespace App\Observers;

use App\Models\EmailInformation;
use App\Models\Team;
use App\Models\TeamSetting;
use Illuminate\Support\Facades\DB;

class TeamObserver
{
    public function created(Team $team)
    {
        $data = [
            [
                'team_id' => $team->id,
                'code' => 'OTP',
                'template_path' => 'emails.otp',
                'name' => 'OTP verification mail',
                'answers' => json_encode([
                    'heading' => 'Verify your login',
                    'subheading' => 'Below is your one time passcode:',
                    'footer_text' => 'We are here to help if you need anything. Visit our website for more information.'
                ])
            ],
            [
                'team_id' => $team->id,
                'code' => 'MAGIC',
                'template_path' => 'emails.magic-link',
                'name' => 'Magic link verification mail',
                'answers' => json_encode([
                    'heading' => 'Verify your login',
                    'greetings' => 'Hi John,',
                    'button_text' => "Sign in",
                    'subheading' => 'You have requested an email link to sign in. To finish signing in click the the button below. If you haven\'t requested this email, please contact support at our email',
                    'footer_text' => 'We are here to help if you need it. Visit our website for more information.'
                ])
            ],
            [
                'team_id' => $team->id,
                'code' => 'REGISTERED',
                'template_path' => 'emails.registered',
                'name' => 'Welcome mail after registration',
                'answers' => json_encode([
                    'heading' => 'Welcome to {{$appName}}',
                    'greetings' => 'Hey John,',
                    'subheading' => 'Thanks for signing for {{$appName}}. We are excited to have you onboard.',
                    'footer_text' => "If you need any kind of help, please do let us know."
                ])
            ],
        ];
        DB::table('emails')->insert($data);

        DB::table('brandings')->insert([
            'team_id' => $team->id,
        ]);

        DB::table('team_settings')->insert([
            'team_id' => $team->id,
            'key' => TeamSetting::JWT_EXPIRATION_KEY,
            'value' => '1'
        ]);
        DB::table('api_keys')->insert([
            'team_id' => $team->id,
            'name' => 'keeless_auth',
            'internal_key' => 1,
            'created_at' => now(),
            'updated_at' => now(),
            'last_used' => now(),
            'key' => 'sk_' . bin2hex(random_bytes(30)), // Generate a random 128-bit key
        ]);

        EmailInformation::query()->create([
            'team_id' => $team->id,
            'use_smtp' => false,
            'use_otp' => false,
        ]);
    }
}
