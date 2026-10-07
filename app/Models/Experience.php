<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'company',
        'company_url',
        'location',
        'start_date',
        'end_date',
        'is_current',
        'description',
        'sort_order',
        'is_deleted',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'is_current' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_deleted', 0);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_current')->orderByDesc('start_date')->orderBy('sort_order');
    }

    public function getDateRangeAttribute(): string
    {
        $start = $this->start_date ? $this->start_date->format('M Y') : null;

        if (! $start) {
            return $this->is_current ? 'Present' : '';
        }

        return $start.' — '.($this->is_current ? 'Present' : ($this->end_date ? $this->end_date->format('M Y') : 'Present'));
    }
}
