<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceCheckin;
use App\Models\AuditLog;
use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckinController extends Controller
{
    /**
     * Display the Hari-H check-in desk interface with QR camera scanner & manual search.
     */
    public function index(Request $request): View
    {
        $wedding = Wedding::first();

        $recentCheckins = AttendanceCheckin::with(['guest', 'admin'])
            ->latest('checkin_time')
            ->take(20)
            ->get();

        $totalCheckins = AttendanceCheckin::count();
        $totalActualAttendees = AttendanceCheckin::sum('actual_attendees');
        $totalGuests = Guest::count();

        return view('admin.checkin.index', [
            'wedding' => $wedding,
            'recentCheckins' => $recentCheckins,
            'totalCheckins' => $totalCheckins,
            'totalActualAttendees' => $totalActualAttendees,
            'totalGuests' => $totalGuests,
        ]);
    }

    /**
     * Search guest for manual check-in autocomplete via AJAX.
     */
    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q'));
        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $guests = Guest::with(['checkin', 'rsvp'])
            ->where('name', 'like', "%{$q}%")
            ->orWhere('invitation_code', 'like', "%{$q}%")
            ->orWhere('phone', 'like', "%{$q}%")
            ->take(10)
            ->get()
            ->map(function ($g) {
                return [
                    'id' => $g->id,
                    'name' => $g->name,
                    'code' => $g->invitation_code,
                    'group' => $g->group_name,
                    'quota' => $g->quota,
                    'phone' => $g->phone ?? '-',
                    'is_checked_in' => $g->checkin !== null,
                    'actual_attendees' => $g->checkin?->actual_attendees ?? $g->quota,
                    'checkin_time' => $g->checkin?->checkin_time?->format('H:i:s'),
                ];
            });

        return response()->json($guests);
    }

    /**
     * Process check-in (via QR Code or manual button) via AJAX.
     */
    public function process(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'guest_id' => 'nullable|integer',
            'code' => 'nullable|string',
            'actual_attendees' => 'required|integer|min:1|max:20',
            'method' => 'required|in:qr,manual',
            'notes' => 'nullable|string|max:500',
        ]);

        $wedding = Wedding::firstOrFail();

        // Find guest by ID or Invitation Code or Token
        $guest = null;
        if (!empty($validated['guest_id'])) {
            $guest = Guest::find($validated['guest_id']);
        } elseif (!empty($validated['code'])) {
            $code = trim($validated['code']);
            $guest = Guest::where('invitation_code', $code)
                ->orWhere('token', $code)
                ->first();
        }

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Data tamu undangan tidak ditemukan! Periksa kembali kode atau nama tamu.',
            ], 404);
        }

        // Check if already checked in
        $existing = AttendanceCheckin::where('guest_id', $guest->id)->first();
        if ($existing) {
            return response()->json([
                'success' => false,
                'is_duplicate' => true,
                'message' => 'PERINGATAN: Tamu ' . $guest->name . ' SUDAH check-in sebelumnya pada pukul ' . $existing->checkin_time->format('H:i') . ' WIB dengan ' . $existing->actual_attendees . ' orang.',
                'guest' => [
                    'name' => $guest->name,
                    'code' => $guest->invitation_code,
                    'checked_in_at' => $existing->checkin_time->format('d/m/Y H:i:s'),
                ],
            ], 409);
        }

        // Create new check-in record
        $checkin = AttendanceCheckin::create([
            'wedding_id' => $wedding->id,
            'guest_id' => $guest->id,
            'checked_in_by' => Auth::id(),
            'actual_attendees' => $validated['actual_attendees'],
            'checkin_time' => now(),
            'method' => $validated['method'],
            'notes' => $validated['notes'],
        ]);

        AuditLog::record(
            'ATTENDANCE_CHECKIN',
            'Check-in tamu ' . $guest->name . ' (' . $guest->invitation_code . ') sebanyak ' . $validated['actual_attendees'] . ' orang via ' . strtoupper($validated['method'])
        );

        return response()->json([
            'success' => true,
            'message' => 'Check-in BERHASIL! Sugeng rawuh kagem ' . $guest->name . ' (' . $validated['actual_attendees'] . ' orang).',
            'checkin' => [
                'id' => $checkin->id,
                'guest_name' => $guest->name,
                'code' => $guest->invitation_code,
                'group' => $guest->group_name,
                'actual_attendees' => $checkin->actual_attendees,
                'time' => $checkin->checkin_time->format('H:i:s'),
                'method' => strtoupper($checkin->method),
            ],
            'total_checkins' => AttendanceCheckin::count(),
            'total_actual_attendees' => AttendanceCheckin::sum('actual_attendees'),
        ]);
    }

    /**
     * Cancel / Undo check-in record.
     */
    public function undo(AttendanceCheckin $checkin): RedirectResponse
    {
        $guestName = $checkin->guest?->name ?? 'Tamu';
        $checkin->delete();

        AuditLog::record('UNDO_CHECKIN', 'Membatalkan status check-in untuk ' . $guestName);

        return redirect()->route('admin.checkin.index')
            ->with('info', 'Check-in untuk ' . $guestName . ' berhasil dibatalkan.');
    }
}
