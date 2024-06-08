<?php

namespace App\Jobs;

use App\Mail\UserOPTMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AppOtpCodeSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $key = random_int(0, 999999);
        $key = str_pad($key, 6, 0, STR_PAD_LEFT);
        User::query()->where('id', $this->user->id)->update([
            'otp' => $key,
            'email_verified_at' => now(),
        ]);

        Mail::to($this->user->email)->send(new UserOPTMail($key, $this->user->name));
    }
}
