<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use App\Models\Rsvp;
use App\Models\Wedding;
use App\Models\Wish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class WeddingController extends Controller
{
    /**
     * Display the public wedding invitation page.
     */
    public function index(Request $request): View
    {
        $wedding = Wedding::with([
            'groom',
            'bride',
            'events' => fn($q) => $q->where('is_active', true)->orderBy('order_num'),
            'galleryImages' => fn($q) => $q->where('is_active', true)->orderBy('order_num'),
            'loveStoryEntries' => fn($q) => $q->orderBy('order_num'),
            'giftAccounts' => fn($q) => $q->where('is_active', true),
        ])->first();

        if (!$wedding) {
            abort(404, 'Data pernikahan belum dikonfigurasi.');
        }

        // Identify guest if accessed via token, code, or ?to= query parameter
        $guest = null;
        $guestName = null;

        if ($request->filled('token')) {
            $guest = Guest::where('wedding_id', $wedding->id)
                ->where('token', $request->query('token'))
                ->first();
        } elseif ($request->filled('code')) {
            $guest = Guest::where('wedding_id', $wedding->id)
                ->where('invitation_code', $request->query('code'))
                ->first();
        }

        if ($guest) {
            $guestName = $guest->name;
            $guest->increment('views_count');
            $guest->update(['last_viewed_at' => now()]);
        } elseif ($request->filled('to')) {
            $guestName = trim((string) $request->query('to'));
        }

        // Fetch approved wishes for display
        $wishes = Wish::where('wedding_id', $wedding->id)
            ->where('status', 'approved')
            ->latest()
            ->take(12)
            ->get();

        $wishesCount = Wish::where('wedding_id', $wedding->id)
            ->where('status', 'approved')
            ->count();

        return view('invitation.index', [
            'wedding' => $wedding,
            'groom' => $wedding->groom,
            'bride' => $wedding->bride,
            'events' => $wedding->events,
            'gallery' => $wedding->galleryImages,
            'stories' => $wedding->loveStoryEntries,
            'gifts' => $wedding->giftAccounts,
            'guest' => $guest,
            'guestName' => $guestName,
            'wishes' => $wishes,
            'wishesCount' => $wishesCount,
        ]);
    }

    /**
     * Personalized direct route via secure token: /undangan/{token}
     */
    public function showWithToken(string $token, Request $request): View
    {
        $request->merge(['token' => $token]);
        return $this->index($request);
    }

    /**
     * Store RSVP response via AJAX.
     */
    public function storeRsvp(Request $request): JsonResponse
    {
        $wedding = Wedding::firstOrFail();

        $validated = $request->validate([
            'guest_name' => 'required|string|max:150',
            'status' => 'required|in:hadir,tidak_hadir,ragu',
            'attendee_count' => 'required|integer|min:1|max:10',
            'phone' => 'nullable|string|max:25',
            'notes' => 'nullable|string|max:1000',
            'token' => 'nullable|string',
        ]);

        $guest = null;
        if ($request->filled('token')) {
            $guest = Guest::where('wedding_id', $wedding->id)
                ->where('token', $request->token)
                ->first();
        }

        $rsvp = Rsvp::updateOrCreate(
            [
                'wedding_id' => $wedding->id,
                'guest_id' => $guest?->id,
                'guest_name' => $validated['guest_name'],
            ],
            [
                'status' => $validated['status'],
                'attendee_count' => $validated['status'] === 'hadir' ? $validated['attendee_count'] : 0,
                'phone' => $validated['phone'] ?? $guest?->phone,
                'notes' => $validated['notes'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]
        );

        // Also add wish automatically if notes provided
        if (!empty($validated['notes'])) {
            Wish::create([
                'wedding_id' => $wedding->id,
                'guest_id' => $guest?->id,
                'name' => $validated['guest_name'],
                'message' => $validated['notes'],
                'attendance_status' => $validated['status'],
                'status' => $wedding->require_wishes_approval ? 'pending' : 'approved',
                'approved_at' => $wedding->require_wishes_approval ? null : now(),
                'ip_address' => $request->ip(),
            ]);
        }

        $statusMsg = match ($validated['status']) {
            'hadir' => 'Matur nuwun sanget! Konfirmasi rawuh panjenengan sampun katampi kanthi sae. Kami sangat menantikan kehadiran Panjenengan.',
            'tidak_hadir' => 'Matur nuwun sanget atas konfirmasi dan doa tulusnya. Doa restu Panjenengan sangat berarti bagi kami.',
            'ragu' => 'Matur nuwun atas konfirmasi Panjenengan. Kami berharap Panjenengan dapat hadir bersama kami.',
        };

        return response()->json([
            'success' => true,
            'message' => $statusMsg,
            'rsvp' => $rsvp,
        ]);
    }

    /**
     * Store wedding wish / prayer via AJAX.
     */
    public function storeWish(Request $request): JsonResponse
    {
        $wedding = Wedding::firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'message' => 'required|string|min:3|max:1500',
            'attendance_status' => 'nullable|in:hadir,tidak_hadir,ragu',
            'token' => 'nullable|string',
        ]);

        $guest = null;
        if ($request->filled('token')) {
            $guest = Guest::where('wedding_id', $wedding->id)
                ->where('token', $request->token)
                ->first();
        }

        $status = $wedding->require_wishes_approval ? 'pending' : 'approved';

        $wish = Wish::create([
            'wedding_id' => $wedding->id,
            'guest_id' => $guest?->id,
            'name' => $validated['name'],
            'message' => $validated['message'],
            'attendance_status' => $validated['attendance_status'] ?? 'hadir',
            'status' => $status,
            'approved_at' => $status === 'approved' ? now() : null,
            'ip_address' => $request->ip(),
        ]);

        $msg = $wedding->require_wishes_approval
            ? 'Matur nuwun! Donga pangestu panjenengan sampun katampi lan badhe katampilaken sak sampunipun dipun review dening panitiya.'
            : 'Matur nuwun sanget! Donga pangestu panjenengan sampun katampi kanthi bingahing manah.';

        return response()->json([
            'success' => true,
            'message' => $msg,
            'wish' => [
                'id' => $wish->id,
                'name' => e($wish->name),
                'message' => nl2br(e($wish->message)),
                'attendance_status' => $wish->attendance_status,
                'time_ago' => 'Baru saja',
            ],
            'is_approved' => $status === 'approved',
        ]);
    }

    /**
     * Fetch paginated wishes for AJAX load more.
     */
    public function getWishes(Request $request): JsonResponse
    {
        $wedding = Wedding::firstOrFail();
        $offset = (int) $request->query('offset', 0);
        $limit = 10;

        $wishes = Wish::where('wedding_id', $wedding->id)
            ->where('status', 'approved')
            ->latest()
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($w) {
                return [
                    'id' => $w->id,
                    'name' => e($w->name),
                    'message' => nl2br(e($w->message)),
                    'attendance_status' => $w->attendance_status,
                    'time_ago' => $w->created_at->diffForHumans(),
                ];
            });

        $totalRemaining = Wish::where('wedding_id', $wedding->id)
            ->where('status', 'approved')
            ->count() - ($offset + $wishes->count());

        return response()->json([
            'success' => true,
            'wishes' => $wishes,
            'has_more' => $totalRemaining > 0,
            'remaining' => max(0, $totalRemaining),
        ]);
    }

    /**
     * Download calendar ICS file for wedding events.
     */
    public function downloadIcs(int $eventId): Response
    {
        $event = Event::with('wedding')->findOrFail($eventId);
        $start = \Carbon\Carbon::parse($event->event_date->format('Y-m-d') . ' ' . $event->start_time);
        $end = $event->end_time
            ? \Carbon\Carbon::parse($event->event_date->format('Y-m-d') . ' ' . $event->end_time)
            : $start->copy()->addHours(2);

        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//Pawiwahan Adat Jawa//ID\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:" . md5($event->id . $event->wedding_id) . "@wedding.com\r\n";
        $ics .= "DTSTAMP:" . gmdate('Ymd\THis\Z') . "\r\n";
        $ics .= "DTSTART:" . $start->format('Ymd\THis') . "\r\n";
        $ics .= "DTEND:" . $end->format('Ymd\THis') . "\r\n";
        $ics .= "SUMMARY:" . addcslashes($event->title . ' - ' . ($event->wedding->couple_short_names ?? 'Arya & Sekar'), ",\\;") . "\r\n";
        $ics .= "DESCRIPTION:" . addcslashes($event->wedding->title ?? 'Pernikahan Adat Jawa', ",\\;") . "\r\n";
        $ics .= "LOCATION:" . addcslashes($event->venue_name . ', ' . $event->address, ",\\;") . "\r\n";
        $ics .= "STATUS:CONFIRMED\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";

        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="wedding-' . $event->category . '.ics"',
        ]);
    }
}
