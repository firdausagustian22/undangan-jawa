<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoveStoryEntry extends Model
{
    protected $fillable = [
        'wedding_id',
        'title',
        'story_date',
        'description',
        'image_path',
        'order_num',
    ];

    protected $casts = [
        'order_num' => 'integer',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }
}
