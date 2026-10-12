<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GuestController extends Controller
{
    /**
     * Display a listing of wedding guests with search & filters.
     */
    public function index(Request $request): View
    {
        $query = Guest::with(['rsvp', 'checkin'])->latest();

        // Search by name, code, or phone
        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('invitation_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by group
        if ($request->filled('group')) {
            $query->where('group_name', $request->query('group'));
        }

        // Filter by RSVP status
        if ($request->filled('rsvp')) {
            $rsvpStatus = $request->query('rsvp');
            if ($rsvpStatus === 'belum') {
                $query->doesntHave('rsvp');
            } else {
                $query->whereHas('rsvp', fn($q) => $q->where('status', $rsvpStatus));
            }
        }

        // Filter by Attendance Checkin status
        if ($request->filled('checkin')) {
            if ($request->query('checkin') === 'sudah') {
                $query->has('checkin');
            } else {
                $query->doesntHave('checkin');
            }
        }

        $guests = $query->paginate(15)->withQueryString();

        $groupList = Guest::select('group_name')
            ->distinct()
            ->whereNotNull('group_name')
            ->pluck('group_name')
            ->toArray();

        $wedding = Wedding::first();

        return view('admin.guests.index', [
            'guests' => $guests,
            'groupList' => $groupList,
            'wedding' => $wedding,
            'totalCount' => Guest::count(),
        ]);
    }

    /**
     * Store a newly created guest.
     */
    public function store(Request $request): RedirectResponse
    {
        $wedding = Wedding::firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'group_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:25',
            'quota' => 'required|integer|min:1|max:20',
        ]);

        $guest = Guest::create([
            'wedding_id' => $wedding->id,
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'invitation_code' => Guest::generateInvitationCode(),
            'token' => Guest::generateSecureToken(),
            'group_name' => $validated['group_name'],
            'phone' => $validated['phone'],
            'quota' => $validated['quota'],
        ]);

        AuditLog::record(
            'CREATE_GUEST',
            'Menambahkan tamu undangan baru: ' . $guest->name . ' (' . $guest->invitation_code . ')'
        );

        return redirect()->route('admin.guests.index')
            ->with('success', 'Tamu ' . $guest->name . ' berhasil ditambahkan!');
    }

    /**
     * Update the specified guest.
     */
    public function update(Request $request, Guest $guest): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'group_name' => 'required|string|max:50',
            'phone' => 'nullable|string|max:25',
            'quota' => 'required|integer|min:1|max:20',
        ]);

        $guest->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'group_name' => $validated['group_name'],
            'phone' => $validated['phone'],
            'quota' => $validated['quota'],
        ]);

        AuditLog::record(
            'UPDATE_GUEST',
            'Memperbarui data tamu: ' . $guest->name . ' (' . $guest->invitation_code . ')'
        );

        return redirect()->route('admin.guests.index')
            ->with('success', 'Data tamu ' . $guest->name . ' berhasil diperbarui!');
    }

    /**
     * Remove the specified guest.
     */
    public function destroy(Guest $guest): RedirectResponse
    {
        $name = $guest->name;
        $guest->delete();

        AuditLog::record(
            'DELETE_GUEST',
            'Menghapus tamu undangan: ' . $name
        );

        return redirect()->route('admin.guests.index')
            ->with('success', 'Tamu ' . $name . ' berhasil dihapus.');
    }

    /**
     * Export all guests to downloadable CSV file.
     */
    public function exportCsv(): StreamedResponse
    {
        AuditLog::record('EXPORT_GUESTS', 'Mengekspor daftar tamu undangan ke CSV.');

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="daftar-tamu-pawiwahan-' . date('Y-m-d') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');
            // Write UTF-8 BOM for Microsoft Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'Kode Undangan',
                'Nama Tamu',
                'Grup / Kategori',
                'Nomor Telepon',
                'Kuota Pax',
                'Status RSVP',
                'Jumlah Hadir RSVP',
                'Catatan RSVP',
                'Sudah Check-in',
                'Waktu Check-in',
                'Tautan Undangan Web',
            ]);

            Guest::with(['rsvp', 'checkin'])->chunk(100, function ($guests) use ($handle) {
                foreach ($guests as $g) {
                    $url = url('/undangan/' . $g->token);
                    $rsvpStatus = $g->rsvp ? ucfirst($g->rsvp->status) : 'Belum Konfirmasi';
                    $checkinStatus = $g->checkin ? 'Sudah Hadir (' . $g->checkin->actual_attendees . ' orang)' : 'Belum';

                    fputcsv($handle, [
                        $g->invitation_code,
                        $g->name,
                        $g->group_name,
                        $g->phone ?? '-',
                        $g->quota,
                        $rsvpStatus,
                        $g->rsvp?->attendee_count ?? 0,
                        $g->rsvp?->notes ?? '-',
                        $checkinStatus,
                        $g->checkin?->checkin_time?->format('d/m/Y H:i') ?? '-',
                        $url,
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Import guests from uploaded CSV file.
     */
    public function importCsv(Request $request): RedirectResponse
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:4096',
        ]);

        $wedding = Wedding::firstOrFail();
        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $count = 0;
        if (($handle = fopen($path, 'r')) !== false) {
            // Read header
            $header = fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if (empty($data[0])) continue;

                $name = trim($data[0]);
                $group = !empty($data[1]) ? trim($data[1]) : 'Tamu Undangan';
                $phone = !empty($data[2]) ? trim($data[2]) : null;
                $quota = !empty($data[3]) && is_numeric($data[3]) ? (int) $data[3] : 2;

                Guest::create([
                    'wedding_id' => $wedding->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'invitation_code' => Guest::generateInvitationCode(),
                    'token' => Guest::generateSecureToken(),
                    'group_name' => $group,
                    'phone' => $phone,
                    'quota' => $quota,
                ]);

                $count++;
            }
            fclose($handle);
        }

        AuditLog::record(
            'IMPORT_GUESTS',
            'Berhasil mengimpor ' . $count . ' tamu undangan via CSV.'
        );

        return redirect()->route('admin.guests.index')
            ->with('success', 'Berhasil mengimpor ' . $count . ' tamu undangan!');
    }
}
