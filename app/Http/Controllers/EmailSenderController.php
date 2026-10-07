<?php

namespace App\Http\Controllers;

use App\Jobs\SendQueueEmail;
use App\Models\EmailLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailSenderController extends Controller
{
    public function index(): View
    {
        $logs = EmailLog::latest()->get();
        return view('email-sender.index', compact('logs'));
    }

    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type'            => 'required|in:cron,queue',
            'subject'         => 'required|string|max:255',
            'email_content'   => 'required|string',
            'email_addresses' => 'required|string',
        ]);

     
        $rawAddresses = preg_split('/[\s,]+/', $validated['email_addresses']);
        $addresses    = array_filter(array_map('trim', $rawAddresses));

        if (empty($addresses)) {
            return back()->withErrors(['email_addresses' => 'Please provide at least one valid email address.']);
        }

    
        foreach ($addresses as $address) {
            if (! filter_var($address, FILTER_VALIDATE_EMAIL)) {
                return back()->withErrors(['email_addresses' => "Invalid email address: {$address}"]);
            }
        }

        $log = EmailLog::create([
            'type'            => $validated['type'],
            'subject'         => $validated['subject'],
            'email_content'   => $validated['email_content'],
            'email_addresses' => implode(', ', $addresses),
            'total_sends'     => 2,
            'sent_count'      => 0,
            'status'          => 'pending',
        ]);

        if ($validated['type'] === 'queue') {
           
            SendQueueEmail::dispatch($log, 1);
            SendQueueEmail::dispatch($log, 2);
        }

        return redirect()->route('email-sender.index')
            ->with('success', $validated['type'] === 'queue'
                ? 'Emails queued for immediate dispatch (×2).'
                : 'Email job created. The scheduler will send it twice, once every 2 minutes.');
    }
}