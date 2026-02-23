<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $rememberTokenName = false;  

    protected $fillable = [
        'id',
        'email',
        'name',
        'avatar_url',
        'provider',
        'email_verified',
        'email_verified_at',
        'metadata',
        'google_id',  
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified' => 'boolean',
        'email_verified_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get all forms belonging to the user.
     */
    public function forms()
    {
        return $this->hasMany(Form::class);
    }

    /**
     * Get total submission count across all forms.
     */
    public function getTotalSubmissionsAttribute(): int
    {
        return $this->forms()->sum('submission_count');
    }

    /**
     * Get active forms count.
     */
    public function getActiveFormsCountAttribute(): int
    {
        return $this->forms()->where('status', 'active')->count();
    }

    /**
     * Get the user's initials for avatar fallback.
     */
    public function getInitialsAttribute(): string
    {
        $name = $this->name ?? $this->email;
        $words = explode(' ', $name);
        
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        
        return strtoupper(substr($name, 0, 2));
    }
}
