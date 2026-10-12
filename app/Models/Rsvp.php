<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    protected $fillable = [
        'wedding_id',
        'guest_id',
        'guest_name',
        'status',
        'attendee_count',
        'phone',
        'notes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'attendee_count' => 'integer',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }
}
