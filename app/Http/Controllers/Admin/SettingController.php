<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\CoupleProfile;
use App\Models\Event;
use App\Models\GiftAccount;
use App\Models\Wedding;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display settings page for wedding configuration, couple, events, & gifts.
     */
    public function index(): View
    {
        $wedding = Wedding::with(['groom', 'bride', 'events', 'giftAccounts'])->firstOrFail();

        return view('admin.settings.index', [
            'wedding' => $wedding,
            'groom' => $wedding->groom,
            'bride' => $wedding->bride,
            'events' => $wedding->events,
            'giftAccounts' => $wedding->giftAccounts,
        ]);
    }

    /**
     * Update main wedding settings.
     */
    public function updateWedding(Request $request): RedirectResponse
    {
        $wedding = Wedding::firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'couple_short_names' => 'required|string|max:100',
            'wedding_date' => 'required|date',
            'quote_arabic' => 'nullable|string',
            'quote_translation' => 'nullable|string',
            'quote_source' => 'nullable|string',
            'javanese_quote' => 'nullable|string',
            'introduction_text' => 'nullable|string',
            'closing_text' => 'nullable|string',
            'music_title' => 'nullable|string|max:150',
            'music_url' => 'nullable|string|max:255',
            'is_music_enabled' => 'boolean',
            'is_rsvp_enabled' => 'boolean',
            'is_wishes_enabled' => 'boolean',
            'is_gift_enabled' => 'boolean',
            'require_wishes_approval' => 'boolean',
        ]);

        $wedding->update([
            'title' => $validated['title'],
            'couple_short_names' => $validated['couple_short_names'],
            'wedding_date' => $validated['wedding_date'],
            'quote_arabic' => $validated['quote_arabic'],
            'quote_translation' => $validated['quote_translation'],
            'quote_source' => $validated['quote_source'],
            'javanese_quote' => $validated['javanese_quote'],
            'introduction_text' => $validated['introduction_text'],
            'closing_text' => $validated['closing_text'],
            'music_title' => $validated['music_title'],
            'music_url' => $validated['music_url'],
            'is_music_enabled' => $request->boolean('is_music_enabled'),
            'is_rsvp_enabled' => $request->boolean('is_rsvp_enabled'),
            'is_wishes_enabled' => $request->boolean('is_wishes_enabled'),
            'is_gift_enabled' => $request->boolean('is_gift_enabled'),
            'require_wishes_approval' => $request->boolean('require_wishes_approval'),
        ]);

        AuditLog::record('UPDATE_SETTINGS', 'Memperbarui konfigurasi utama pernikahan.');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan pernikahan berhasil disimpan!');
    }

    /**
     * Update couple profiles (groom & bride).
     */
    public function updateCouple(Request $request): RedirectResponse
    {
        $wedding = Wedding::firstOrFail();

        $validated = $request->validate([
            'groom_name' => 'required|string|max:150',
            'groom_nickname' => 'required|string|max:50',
            'groom_father' => 'nullable|string|max:150',
            'groom_mother' => 'nullable|string|max:150',
            'groom_child_order' => 'nullable|string|max:100',
            'groom_bio' => 'nullable|string|max:500',
            'groom_instagram' => 'nullable|string|max:100',

            'bride_name' => 'required|string|max:150',
            'bride_nickname' => 'required|string|max:50',
            'bride_father' => 'nullable|string|max:150',
            'bride_mother' => 'nullable|string|max:150',
            'bride_child_order' => 'nullable|string|max:100',
            'bride_bio' => 'nullable|string|max:500',
            'bride_instagram' => 'nullable|string|max:100',
        ]);

        // Update Groom
        CoupleProfile::updateOrCreate(
            ['wedding_id' => $wedding->id, 'role' => 'groom'],
            [
                'full_name' => $validated['groom_name'],
                'nickname' => $validated['groom_nickname'],
                'father_name' => $validated['groom_father'],
                'mother_name' => $validated['groom_mother'],
                'child_order' => $validated['groom_child_order'],
                'bio' => $validated['groom_bio'],
                'instagram_username' => $validated['groom_instagram'],
            ]
        );

        // Update Bride
        CoupleProfile::updateOrCreate(
            ['wedding_id' => $wedding->id, 'role' => 'bride'],
            [
                'full_name' => $validated['bride_name'],
                'nickname' => $validated['bride_nickname'],
                'father_name' => $validated['bride_father'],
                'mother_name' => $validated['bride_mother'],
                'child_order' => $validated['bride_child_order'],
                'bio' => $validated['bride_bio'],
                'instagram_username' => $validated['bride_instagram'],
            ]
        );

        AuditLog::record('UPDATE_COUPLE', 'Memperbarui profil mempelai Kakung dan Putri.');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Profil mempelai pengantin berhasil diperbarui!');
    }

    /**
     * Update an event schedule.
     */
    public function updateEvent(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'event_date' => 'required|date',
            'start_time' => 'required|string',
            'end_time' => 'nullable|string',
            'venue_name' => 'required|string|max:150',
            'address' => 'required|string',
            'maps_url' => 'nullable|url',
        ]);

        $event->update($validated);

        AuditLog::record('UPDATE_EVENT', 'Memperbarui jadwal acara: ' . $event->title);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Jadwal acara ' . $event->title . ' berhasil diperbarui!');
    }
}
