<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Rsvp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RsvpController extends Controller
{
    /**
     * Display a listing of RSVP responses.
     */
    public function index(Request $request): View
    {
        $query = Rsvp::with('guest')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $rsvps = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Rsvp::count(),
            'hadir' => Rsvp::where('status', 'hadir')->count(),
            'hadir_pax' => Rsvp::where('status', 'hadir')->sum('attendee_count'),
            'tidak_hadir' => Rsvp::where('status', 'tidak_hadir')->count(),
            'ragu' => Rsvp::where('status', 'ragu')->count(),
        ];

        return view('admin.rsvps.index', [
            'rsvps' => $rsvps,
            'stats' => $stats,
        ]);
    }

    /**
     * Update an RSVP response manually.
     */
    public function update(Request $request, Rsvp $rsvp): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:hadir,tidak_hadir,ragu',
            'attendee_count' => 'required|integer|min:0|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        $rsvp->update($validated);

        AuditLog::record(
            'UPDATE_RSVP',
            'Mengubah status RSVP tamu ' . $rsvp->guest_name . ' menjadi ' . $rsvp->status
        );

        return redirect()->route('admin.rsvps.index')
            ->with('success', 'Status RSVP ' . $rsvp->guest_name . ' berhasil diperbarui!');
    }

    /**
     * Export RSVPs to CSV.
     */
    public function exportCsv(): StreamedResponse
    {
        AuditLog::record('EXPORT_RSVP', 'Mengekspor data respons RSVP ke CSV.');

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="data-rsvp-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Nama Tamu',
                'Status Kehadiran',
                'Jumlah Hadir (Pax)',
                'Nomor Telepon',
                'Pesan / Doa Restu',
                'Waktu Konfirmasi',
                'IP Address',
            ]);

            Rsvp::latest()->chunk(100, function ($rsvps) use ($handle) {
                foreach ($rsvps as $r) {
                    fputcsv($handle, [
                        $r->guest_name,
                        ucfirst(str_replace('_', ' ', $r->status)),
                        $r->attendee_count,
                        $r->phone ?? '-',
                        $r->notes ?? '-',
                        $r->created_at->format('d/m/Y H:i'),
                        $r->ip_address ?? '-',
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }
}
