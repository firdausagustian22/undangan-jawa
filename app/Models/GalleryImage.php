<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryImage extends Model
{
    protected $fillable = [
        'wedding_id',
        'title',
        'image_path',
        'category',
        'caption',
        'order_num',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_num' => 'integer',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }
}
