@extends('layouts.admin')

@section('title', 'Log Aktivitas Keamanan')
@section('page_title', 'Catatan Aktivitas Sistem & Audit Trail')

@section('content')

    <div style="margin-bottom: 1.5rem;">
        <h4 style="font-size: 1.2rem; color: #FFF1D0; font-weight: 700;">
            Log Aktivitas &amp; Keamanan Sistem
        </h4>
        <p style="font-size: 0.85rem; color: var(--c-beige);">
            Riwayat lengkap interaksi pengguna admin, perubahan data tamu, login/logout, dan check-in hari-H
        </p>
    </div>

    <div class="panel-card" style="padding: 0; overflow: hidden;">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Waktu (WIB)</th>
                        <th>Aksi</th>
                        <th>Deskripsi Aktivitas</th>
                        <th>User Admin</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td style="font-size: 0.8rem; font-family: monospace; color: var(--c-gold-light);">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $log->action }}</span>
                            </td>
                            <td style="color: var(--c-ivory); font-size: 0.85rem;">
                                {{ $log->description }}
                            </td>
                            <td>
                                <strong style="color: #FFF1D0; font-size: 0.85rem;">
                                    {{ $log->user->name ?? 'Sistem Otomatis' }}
                                </strong>
                            </td>
                            <td style="font-size: 0.8rem; font-family: monospace; color: var(--c-beige);">
                                {{ $log->ip_address ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 3rem; color: var(--c-beige);">
                                Belum ada catatan aktivitas sistem.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 1.25rem;">
            {{ $logs->links() }}
        </div>
    </div>

@endsection
