<?php

namespace App\Jobs;

use App\Mail\GenericEmail;
use App\Models\EmailLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        public EmailLog $emailLog,
        public int $sendIteration,
    ) {}

    public function handle(): void
    {
        $addresses = $this->emailLog->email_addresses_array;
        $mailable  = new GenericEmail(
            $this->emailLog->subject,
            $this->emailLog->email_content,
        );

        foreach ($addresses as $address) {
            if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
                Mail::to($address)->send(clone $mailable);
            }
        }

        $this->emailLog->refresh()->recordSend();
    }
}