<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wedding extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'couple_short_names',
        'wedding_date',
        'quote_arabic',
        'quote_translation',
        'quote_source',
        'javanese_quote',
        'introduction_text',
        'closing_text',
        'music_url',
        'music_title',
        'is_music_enabled',
        'is_rsvp_enabled',
        'is_wishes_enabled',
        'is_gift_enabled',
        'require_wishes_approval',
    ];

    protected $casts = [
        'wedding_date' => 'datetime',
        'is_music_enabled' => 'boolean',
        'is_rsvp_enabled' => 'boolean',
        'is_wishes_enabled' => 'boolean',
        'is_gift_enabled' => 'boolean',
        'require_wishes_approval' => 'boolean',
    ];

    public function coupleProfiles(): HasMany
    {
        return $this->hasMany(CoupleProfile::class);
    }

    public function groom()
    {
        return $this->hasOne(CoupleProfile::class)->where('role', 'groom');
    }

    public function bride()
    {
        return $this->hasOne(CoupleProfile::class)->where('role', 'bride');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class)->orderBy('order_num');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(Rsvp::class);
    }

    public function attendanceCheckins(): HasMany
    {
        return $this->hasMany(AttendanceCheckin::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class)->latest();
    }

    public function approvedWishes(): HasMany
    {
        return $this->hasMany(Wish::class)->where('status', 'approved')->latest();
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(GalleryImage::class)->where('is_active', true)->orderBy('order_num');
    }

    public function loveStoryEntries(): HasMany
    {
        return $this->hasMany(LoveStoryEntry::class)->orderBy('order_num');
    }

    public function giftAccounts(): HasMany
    {
        return $this->hasMany(GiftAccount::class)->where('is_active', true);
    }
}
