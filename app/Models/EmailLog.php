<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'type',
        'subject',
        'email_content',
        'email_addresses',
        'total_sends',
        'sent_count',
        'status',
    ];

    protected $casts = [
        'total_sends' => 'integer',
        'sent_count'  => 'integer',
    ];

   
    public function getEmailAddressesArrayAttribute(): array
    {
        return array_map('trim', explode(',', $this->email_addresses));
    }

    public function recordSend(): void
    {
        $this->increment('sent_count');
        $this->refresh();

        if ($this->sent_count >= $this->total_sends) {
            $this->update(['status' => 'completed']);
        }
    }
}