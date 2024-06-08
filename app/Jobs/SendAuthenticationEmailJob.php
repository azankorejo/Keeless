<?php

namespace App\Jobs;

use App\Mail\ConsumerMagicLinkMail;
use App\Mail\ConsumerOPTMail;
use App\Mail\ConsumerWelcomeMail;
use App\Models\Branding;
use App\Models\BusinessInformation;
use App\Models\Consumer;
use App\Models\ConsumerAuthentication;
use App\Models\Email;
use App\Models\RedirectionInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use STS\JWT\Facades\JWT;

class SendAuthenticationEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private $logo;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private array    $config,
        private bool     $usingOtp,
        private string   $appName,
        private Email    $email,
        private Consumer $consumer,
        private string   $domain,
        private bool     $create
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        config(['mail.from' => [
            'name' => $this->config['from_name'],
            'address' => config('mail.from.address')
        ]]);
        if ($this->useSMTP()) {
            config(['mail.mailers.consumer' => Arr::except($this->config, ['to', 'from_name'])]);
            config(['mail.from' => [
                'address' => $this->config['username'],
                'name' => $this->config['from_name'],
            ]]);
        }

        if ($this->usingOtp) {
            $key = random_int(0, 999999);
            $key = str_pad($key, 6, 0, STR_PAD_LEFT);

            ConsumerAuthentication::query()->create([
                'consumer_id' => $this->consumer->id,
                'token' => $key,
                'otp' => true,
                'expires_at' => now()->addHour()
            ]);
            $this->logo = $this->getTeamLogo();
            $this->sendEmail('consumer', new ConsumerOPTMail($this->appName, json_decode($this->email->answers, true), $key, $this->logo));
        } else {
            $token = JWT::get(
                'authentication_keeless_id_token',
                Arr::only($this->consumer->toArray(), ['email', 'username', 'phone']),
                now()->addHour()
            );
            $magicUrl = route("consumer.magic-verify", ['token' => $token, 'subdomain' => $this->domain]);

            ConsumerAuthentication::query()->create([
                'consumer_id' => $this->consumer->id,
                'token' => $token,
                'otp' => false,
                'expires_at' => now()->addHour()
            ]);
            $this->logo = $this->getTeamLogo();
            $this->sendEmail('consumer', new ConsumerMagicLinkMail($this->appName, json_decode($this->email->answers, true), $magicUrl, $this->logo));
        }
    }

    private function sendEmail(string $mailer, $mail)
    {
        if ($this->useSMTP()) {
            Mail::mailer($mailer)->to($this->config['to'])->send($mail);
        } else {
            Mail::to($this->config['to'])->send($mail);
        }
        $this->sendWelcomeEmail($mailer);
    }

    private function useSMTP(): bool
    {
        return array_key_exists('transport', $this->config) && $this->config['transport'] === 'smtp';
    }

    private function sendWelcomeEmail(string $mailer)
    {
        if (!$this->create) {
            return;
        }
        if ($this->useSMTP()) {
            Mail::mailer($mailer)->to($this->config['to'])->send(new ConsumerWelcomeMail());
        } else {
            Mail::to($this->config['to'])->send(new ConsumerWelcomeMail($this->appName, json_decode($this->email->answers, true), $this->logo));
        }
    }

    private function getTeamLogo(): string|null
    {
        $branding = DB::table('brandings')->where('team_id', $this->consumer->team_id)->first();
        if($branding) {
            $url = route('uploads.show', ['filename' => $branding->logo]);
            // Remove any base URL prefix if present
            return preg_replace('/^(https?:\/\/[^\/]+)\//', '', $url);
        }
        return null;
    }
}
