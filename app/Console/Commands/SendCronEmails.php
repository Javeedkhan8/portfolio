<?php

namespace App\Console\Commands;

use App\Mail\GenericEmail;
use App\Models\EmailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendCronEmails extends Command
{
    protected $signature   = 'email:send-cron';
    protected $description = 'Send pending cron emails (runs every 2 minutes; each log is sent twice, once per run)';

    public function handle(): void
    {
        $pendingLogs = EmailLog::where('type', 'cron')
            ->where('status', 'pending')
            ->get();

        if ($pendingLogs->isEmpty()) {
            $this->info('No pending cron emails.');
            return;
        }

        foreach ($pendingLogs as $log) {
            $this->sendToAll($log);
            $log->refresh()->recordSend();
            $this->info("Processed EmailLog #{$log->id} — sent_count now: {$log->sent_count}");
        }
    }

    private function sendToAll(EmailLog $log): void
    {
        $addresses = $log->email_addresses_array;
        $mailable  = new GenericEmail($log->subject, $log->email_content);

        foreach ($addresses as $address) {
            if (filter_var($address, FILTER_VALIDATE_EMAIL)) {
                Mail::to($address)->send(clone $mailable);
            }
        }
    }
}