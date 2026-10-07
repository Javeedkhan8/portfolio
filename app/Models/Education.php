<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'degree',
        'institution',
        'institution_url',
        'location',
        'start_year',
        'end_year',
        'description',
        'sort_order',
        'is_deleted',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_deleted', 0);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('end_year')->orderBy('sort_order');
    }

    public function getYearRangeAttribute(): string
    {
        return trim(($this->start_year ?? '').' — '.($this->end_year ?? ''), ' —');
    }
}
