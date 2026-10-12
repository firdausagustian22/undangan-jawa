<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftAccount extends Model
{
    protected $fillable = [
        'wedding_id',
        'bank_name',
        'account_number',
        'account_holder',
        'qr_code_image',
        'gift_address',
        'recipient_name',
        'recipient_phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }
}
