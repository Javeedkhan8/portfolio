<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'headline',
        'bio',
        'location',
        'email',
        'phone',
        'avatar',
        'resume',
        'github_url',
        'linkedin_url',
        'twitter_url',
        'website_url',
        'availability',
        'is_deleted',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_deleted', 0);
    }

    public static function current(): ?self
    {
        return static::query()->active()->latest('id')->first();
    }

    public function socialLinks(): array
    {
        return array_filter([
            'github' => $this->github_url,
            'linkedin' => $this->linkedin_url,
            'twitter' => $this->twitter_url,
            'website' => $this->website_url,
        ]);
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar ? asset($this->avatar) : null;
    }

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume ? asset($this->resume) : null;
    }
}
