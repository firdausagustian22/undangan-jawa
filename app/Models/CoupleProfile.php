<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoupleProfile extends Model
{
    protected $fillable = [
        'wedding_id',
        'role',
        'full_name',
        'nickname',
        'title_javanese',
        'father_name',
        'mother_name',
        'child_order',
        'photo_path',
        'bio',
        'instagram_username',
        'instagram_url',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }
}
