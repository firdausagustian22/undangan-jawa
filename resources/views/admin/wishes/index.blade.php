@extends('layouts.admin')

@section('title', 'Moderasi Doa Restu')
@section('page_title', 'Moderasi Ucapan & Doa Restu Para Tamu')

@section('content')

    <!-- Header Toolbar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h4 style="font-size: 1.2rem; color: #FFF1D0; font-weight: 700;">
                Moderasi Doa Restu ({{ $stats['total'] }} Doa)
            </h4>
            <p style="font-size: 0.85rem; color: var(--c-beige);">
                Tinjau dan setujui doa restu tamu sebelum ditampilkan pada halaman publik undangan
            </p>
        </div>
    </div>

    <!-- Status Filter Badges -->
    <div style="display: flex; gap: 10px; margin-bottom: 1.5rem; flex-wrap: wrap;">
        <a href="{{ route('admin.wishes.index') }}" class="btn-outline-gold {{ !request('status') ? 'active' : '' }}">
            Semua ({{ $stats['total'] }})
        </a>
        <a href="{{ route('admin.wishes.index', ['status' => 'pending']) }}" class="btn-outline-gold {{ request('status') === 'pending' ? 'active' : '' }}" style="color: #FAF089;">
            <i class="fa-solid fa-clock"></i> Menunggu Persetujuan ({{ $stats['pending'] }})
        </a>
        <a href="{{ route('admin.wishes.index', ['status' => 'approved']) }}" class="btn-outline-gold {{ request('status') === 'approved' ? 'active' : '' }}" style="color: #9AE6B4;">
            <i class="fa-solid fa-circle-check"></i> Disetujui ({{ $stats['approved'] }})
        </a>
        <a href="{{ route('admin.wishes.index', ['status' => 'rejected']) }}" class="btn-outline-gold {{ request('status') === 'rejected' ? 'active' : '' }}" style="color: #FEB2B2;">
            <i class="fa-solid fa-ban"></i> Ditolak ({{ $stats['rejected'] }})
        </a>
    </div>

    <!-- Table -->
    <div class="panel-card" style="padding: 0; overflow: hidden;">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th>Untaian Doa Restu</th>
                        <th>Kehadiran</th>
                        <th>Status</th>
                        <th>Waktu Kirim</th>
                        <th style="text-align: right;">Aksi Moderasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wishes as $w)
                        <tr>
                            <td>
                                <strong style="color: #FFF1D0; font-size: 0.95rem;">{{ $w->name }}</strong>
                                @if($w->guest)
                                    <div style="font-size: 0.75rem; color: var(--c-beige);">{{ $w->guest->group_name }}</div>
                                @endif
                            </td>
                            <td style="max-width: 320px;">
                                <div style="font-size: 0.85rem; line-height: 1.5; color: var(--c-ivory); white-space: pre-line;">
                                    {{ $w->message }}
                                </div>
                            </td>
                            <td>
                                @if($w->attendance_status === 'hadir')
                                    <span class="badge badge-success">Hadir</span>
                                @elseif($w->attendance_status === 'tidak_hadir')
                                    <span class="badge badge-danger">Berhalangan</span>
                                @else
                                    <span class="badge badge-warning">Ragu</span>
                                @endif
                            </td>
                            <td>
                                @if($w->status === 'approved')
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-check"></i> Disetujui
                                    </span>
                                @elseif($w->status === 'pending')
                                    <span class="badge badge-warning">
                                        <i class="fa-solid fa-clock"></i> Menunggu
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fa-solid fa-ban"></i> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td style="font-size: 0.8rem; color: var(--c-beige);">
                                {{ $w->created_at->diffForHumans() }}
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    @if($w->status !== 'approved')
                                        <form action="{{ route('admin.wishes.status', $w->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn-gold" style="padding: 4px 10px; font-size: 0.75rem;" title="Setujui Doa">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                        </form>
                                    @endif

                                    @if($w->status !== 'rejected')
                                        <form action="{{ route('admin.wishes.status', $w->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn-outline-gold" style="padding: 4px 8px; font-size: 0.75rem; color: #FEB2B2; border-color: rgba(254,178,178,0.4);" title="Tolak Tampilan">
                                                <i class="fa-solid fa-ban"></i> Tolak
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.wishes.destroy', $w->id) }}" method="POST" onsubmit="return confirm('Hapus ucapan dari {{ addslashes($w->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-outline" style="padding: 4px 8px; font-size: 0.75rem;" title="Hapus Permanen">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 3rem; color: var(--c-beige);">
                                Belum ada ucapan doa restu yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 1.25rem;">
            {{ $wishes->links() }}
        </div>
    </div>

@endsection
