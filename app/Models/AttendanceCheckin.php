<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceCheckin extends Model
{
    protected $fillable = [
        'wedding_id',
        'guest_id',
        'checked_in_by',
        'actual_attendees',
        'checkin_time',
        'method',
        'notes',
    ];

    protected $casts = [
        'checkin_time' => 'datetime',
        'actual_attendees' => 'integer',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(Guest::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}
