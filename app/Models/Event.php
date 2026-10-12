<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'wedding_id',
        'title',
        'category',
        'event_date',
        'start_time',
        'end_time',
        'time_zone',
        'venue_name',
        'address',
        'maps_url',
        'maps_embed',
        'is_active',
        'is_countdown_target',
        'order_num',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
        'is_countdown_target' => 'boolean',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }
}
