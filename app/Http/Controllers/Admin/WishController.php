<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Wish;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WishController extends Controller
{
    /**
     * Display a listing of wedding wishes for moderation.
     */
    public function index(Request $request): View
    {
        $query = Wish::with('guest')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $wishes = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Wish::count(),
            'pending' => Wish::where('status', 'pending')->count(),
            'approved' => Wish::where('status', 'approved')->count(),
            'rejected' => Wish::where('status', 'rejected')->count(),
        ];

        return view('admin.wishes.index', [
            'wishes' => $wishes,
            'stats' => $stats,
        ]);
    }

    /**
     * Update wish moderation status (approve / reject).
     */
    public function updateStatus(Request $request, Wish $wish): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $wish->update([
            'status' => $validated['status'],
            'approved_at' => $validated['status'] === 'approved' ? now() : null,
        ]);

        AuditLog::record(
            'MODERATE_WISH',
            'Mengubah status doa restu dari ' . $wish->name . ' menjadi ' . $validated['status']
        );

        return redirect()->back()
            ->with('success', 'Status doa dari ' . $wish->name . ' diubah menjadi ' . $validated['status'] . '.');
    }

    /**
     * Remove wish.
     */
    public function destroy(Wish $wish): RedirectResponse
    {
        $name = $wish->name;
        $wish->delete();

        AuditLog::record('DELETE_WISH', 'Menghapus doa restu dari ' . $name);

        return redirect()->back()->with('success', 'Doa dari ' . $name . ' berhasil dihapus.');
    }
}
