<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Guest extends Model
{
    protected $fillable = [
        'wedding_id',
        'name',
        'slug',
        'invitation_code',
        'token',
        'group_name',
        'phone',
        'quota',
        'is_sent',
        'sent_at',
        'views_count',
        'last_viewed_at',
    ];

    protected $casts = [
        'is_sent' => 'boolean',
        'sent_at' => 'datetime',
        'last_viewed_at' => 'datetime',
        'quota' => 'integer',
        'views_count' => 'integer',
    ];

    public static function generateInvitationCode(): string
    {
        do {
            $code = 'JW-' . strtoupper(Str::random(6));
        } while (static::where('invitation_code', $code)->exists());

        return $code;
    }

    public static function generateSecureToken(): string
    {
        return Str::random(40);
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function rsvp(): HasOne
    {
        return $this->hasOne(Rsvp::class);
    }

    public function checkin(): HasOne
    {
        return $this->hasOne(AttendanceCheckin::class);
    }

    public function getInvitationUrlAttribute(): string
    {
        return url('/undangan/' . $this->token);
    }

    public function getPersonalizedQueryUrlAttribute(): string
    {
        return url('/undangan?to=' . urlencode($this->name) . '&c=' . $this->invitation_code);
    }
}
