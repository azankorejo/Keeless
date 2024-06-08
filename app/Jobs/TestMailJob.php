<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TestMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param array $configuration
     */
    public function __construct(private array $configuration)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        config([
            'mail.mailers.consumer' => [
                'transport' => 'smtp',
                'host' => 'smtp.gmail.com',
                'port' => $this->configuration['smtp_port'],
                'username' => $this->configuration['smtp_username'],
                'password' => 'cffz rwlk wsqa jejh',
            ],
        ]);
        Mail::mailer('consumer')
            ->to('korejoazan9@gmail.com')
            ->send(new \App\Mail\TestMailJob());
    }
}
