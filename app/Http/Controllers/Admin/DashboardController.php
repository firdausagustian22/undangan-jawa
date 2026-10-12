<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceCheckin;
use App\Models\Guest;
use App\Models\Rsvp;
use App\Models\Wedding;
use App\Models\Wish;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Admin overview dashboard with metrics & charts.
     */
    public function index(): View
    {
        $wedding = Wedding::first();

        $totalGuests = Guest::count();
        $totalInvitedPax = Guest::sum('quota');

        $hadirRsvps = Rsvp::where('status', 'hadir')->get();
        $hadirCount = $hadirRsvps->count();
        $hadirPax = $hadirRsvps->sum('attendee_count');

        $tidakHadirCount = Rsvp::where('status', 'tidak_hadir')->count();
        $raguCount = Rsvp::where('status', 'ragu')->count();
        $belumRsvpCount = max(0, $totalGuests - ($hadirCount + $tidakHadirCount + $raguCount));

        $totalCheckins = AttendanceCheckin::count();
        $actualAttendees = AttendanceCheckin::sum('actual_attendees');

        $totalWishes = Wish::count();
        $pendingWishes = Wish::where('status', 'pending')->count();

        // Group counts
        $groups = Guest::selectRaw('group_name, count(*) as count')
            ->groupBy('group_name')
            ->pluck('count', 'group_name')
            ->toArray();

        // Recent items
        $recentRsvps = Rsvp::with('guest')->latest()->take(6)->get();
        $recentCheckins = AttendanceCheckin::with(['guest', 'admin'])->latest()->take(6)->get();
        $recentWishes = Wish::latest()->take(6)->get();

        return view('admin.dashboard', [
            'wedding' => $wedding,
            'totalGuests' => $totalGuests,
            'totalInvitedPax' => $totalInvitedPax,
            'hadirCount' => $hadirCount,
            'hadirPax' => $hadirPax,
            'tidakHadirCount' => $tidakHadirCount,
            'raguCount' => $raguCount,
            'belumRsvpCount' => $belumRsvpCount,
            'totalCheckins' => $totalCheckins,
            'actualAttendees' => $actualAttendees,
            'totalWishes' => $totalWishes,
            'pendingWishes' => $pendingWishes,
            'groups' => $groups,
            'recentRsvps' => $recentRsvps,
            'recentCheckins' => $recentCheckins,
            'recentWishes' => $recentWishes,
        ]);
    }
}
