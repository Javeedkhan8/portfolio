<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'sort_order',
        'is_deleted',
    ];

    protected $casts = [
        'proficiency' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_deleted', 0);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
