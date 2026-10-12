@extends('layouts.admin')

@section('title', 'Ringkasan Statistik')
@section('page_title', 'Ringkasan Statistik Pawiwahan Ageng')

@section('content')

    <!-- Quick Action Ribbon -->
    <div style="display: flex; gap: 12px; margin-bottom: 2rem; flex-wrap: wrap;">
        <a href="{{ route('admin.checkin.index') }}" class="btn-gold">
            <i class="fa-solid fa-qrcode"></i> Buka Meja Check-in Hari-H
        </a>
        <a href="{{ route('admin.guests.index') }}" class="btn-outline-gold">
            <i class="fa-solid fa-user-plus"></i> Kelola &amp; Tambah Tamu
        </a>
        <a href="{{ route('admin.guests.export') }}" class="btn-outline-gold">
            <i class="fa-solid fa-file-export"></i> Ekspor CSV Tamu
        </a>
        <a href="{{ route('admin.wishes.index') }}" class="btn-outline-gold">
            <i class="fa-solid fa-comments"></i> Moderasi Doa Restu 
            @if($pendingWishes > 0)
                <span class="badge badge-warning" style="margin-left: 4px;">{{ $pendingWishes }} Baru</span>
            @endif
        </a>
    </div>

    <!-- 6 Primary Metric Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
        
        <!-- Card 1: Total Tamu Undangan -->
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--c-beige); letter-spacing: 1px;">Total Undangan</span>
                    <h3 class="font-serif" style="font-size: 2rem; color: #FFF1D0; font-weight: 700; margin-top: 4px;">
                        {{ $totalGuests }} <span style="font-size: 0.9rem; font-family: var(--font-sans); color: var(--c-gold-light);">Keluarga</span>
                    </h3>
                </div>
                <div class="icon-box">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--c-beige);">
                Target Kuota Total: <strong>{{ $totalInvitedPax }} Pax</strong>
            </p>
        </div>

        <!-- Card 2: Konfirmasi Hadir -->
        <div class="stat-card" style="border-left: 4px solid #68D391;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: #9AE6B4; letter-spacing: 1px;">Konfirmasi Hadir</span>
                    <h3 class="font-serif" style="font-size: 2rem; color: #9AE6B4; font-weight: 700; margin-top: 4px;">
                        {{ $hadirPax }} <span style="font-size: 0.9rem; font-family: var(--font-sans);">Pax</span>
                    </h3>
                </div>
                <div class="icon-box" style="background: rgba(104, 211, 145, 0.15); color: #68D391; border-color: rgba(104, 211, 145, 0.3);">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--c-beige);">
                Dari <strong>{{ $hadirCount }}</strong> respon undangan keluarga
            </p>
        </div>

        <!-- Card 3: Check-in Hari-H Riil -->
        <div class="stat-card" style="border-left: 4px solid var(--c-gold);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--c-gold-light); letter-spacing: 1px;">Kehadiran Riil (Hari-H)</span>
                    <h3 class="font-serif" style="font-size: 2rem; color: #FFF1D0; font-weight: 700; margin-top: 4px;">
                        {{ $actualAttendees }} <span style="font-size: 0.9rem; font-family: var(--font-sans); color: var(--c-gold-light);">Orang</span>
                    </h3>
                </div>
                <div class="icon-box">
                    <i class="fa-solid fa-user-check"></i>
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--c-beige);">
                Total <strong>{{ $totalCheckins }}</strong> meja check-in tervalidasi
            </p>
        </div>

        <!-- Card 4: Berhalangan Hadir -->
        <div class="stat-card" style="border-left: 4px solid #FC8181;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: #FEB2B2; letter-spacing: 1px;">Berhalangan Hadir</span>
                    <h3 class="font-serif" style="font-size: 2rem; color: #FEB2B2; font-weight: 700; margin-top: 4px;">
                        {{ $tidakHadirCount }} <span style="font-size: 0.9rem; font-family: var(--font-sans);">Undangan</span>
                    </h3>
                </div>
                <div class="icon-box" style="background: rgba(252, 129, 129, 0.15); color: #FC8181; border-color: rgba(252, 129, 129, 0.3);">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--c-beige);">
                Telah mengirimkan doa restu tulus
            </p>
        </div>

        <!-- Card 5: Belum Konfirmasi RSVP -->
        <div class="stat-card" style="border-left: 4px solid #F6E05E;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: #FAF089; letter-spacing: 1px;">Belum RSVP</span>
                    <h3 class="font-serif" style="font-size: 2rem; color: #FAF089; font-weight: 700; margin-top: 4px;">
                        {{ $belumRsvpCount }} <span style="font-size: 0.9rem; font-family: var(--font-sans);">Tamu</span>
                    </h3>
                </div>
                <div class="icon-box" style="background: rgba(246, 224, 94, 0.15); color: #F6E05E; border-color: rgba(246, 224, 94, 0.3);">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--c-beige);">
                Menunggu respon &amp; konfirmasi
            </p>
        </div>

        <!-- Card 6: Total Doa & Ucapan -->
        <div class="stat-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--c-beige); letter-spacing: 1px;">Doa Restu</span>
                    <h3 class="font-serif" style="font-size: 2rem; color: #FFF1D0; font-weight: 700; margin-top: 4px;">
                        {{ $totalWishes }} <span style="font-size: 0.9rem; font-family: var(--font-sans); color: var(--c-gold-light);">Doa</span>
                    </h3>
                </div>
                <div class="icon-box">
                    <i class="fa-solid fa-feather"></i>
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--c-beige);">
                {{ $pendingWishes }} doa menanti moderasi
            </p>
        </div>

    </div>


    <!-- 2 Graphical Analytics (Charts) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <!-- Chart 1: RSVP Breakdown -->
        <div class="panel-card">
            <h4 style="font-size: 1.1rem; color: #FFF1D0; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-chart-pie" style="color: var(--c-gold);"></i> Distribusi Konfirmasi Kehadiran (RSVP)
            </h4>
            <div style="height: 250px; position: relative; display: flex; align-items: center; justify-content: center;">
                <canvas id="rsvpPieChart"></canvas>
            </div>
        </div>

        <!-- Chart 2: Group Category Breakdown -->
        <div class="panel-card">
            <h4 style="font-size: 1.1rem; color: #FFF1D0; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-chart-column" style="color: var(--c-gold);"></i> Komposisi Kategori Tamu Undangan
            </h4>
            <div style="height: 250px; position: relative;">
                <canvas id="groupBarChart"></canvas>
            </div>
        </div>

    </div>


    <!-- Recent Activity Tables: 2 Columns -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
        
        <!-- Column 1: Check-in Terkini Hari-H -->
        <div class="panel-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="font-size: 1.1rem; color: #FFF1D0; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-qrcode" style="color: var(--c-gold);"></i> Check-in Hari-H Terkini
                </h4>
                <a href="{{ route('admin.checkin.index') }}" style="font-size: 0.8rem; color: var(--c-gold-light); text-decoration: none;">
                    Meja Check-in <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if(count($recentCheckins) > 0)
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Tamu</th>
                                <th>Pax</th>
                                <th>Waktu</th>
                                <th>Metode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentCheckins as $chk)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #FFF1D0;">{{ $chk->guest->name ?? 'Tamu' }}</div>
                                        <div style="font-size: 0.75rem; color: var(--c-beige);">{{ $chk->guest->invitation_code ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ $chk->actual_attendees }} Orang</span>
                                    </td>
                                    <td style="font-size: 0.8rem;">
                                        {{ $chk->checkin_time->format('H:i:s') }} WIB
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ strtoupper($chk->method) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 2.5rem 1rem; color: rgba(248, 241, 229, 0.6);">
                    <i class="fa-solid fa-clipboard-check" style="font-size: 2.5rem; margin-bottom: 0.5rem; opacity: 0.4;"></i>
                    <p style="font-size: 0.85rem;">Belum ada check-in kehadiran hari-H yang tercatat.</p>
                </div>
            @endif
        </div>

        <!-- Column 2: RSVP Terkini -->
        <div class="panel-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="font-size: 1.1rem; color: #FFF1D0; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-envelope-circle-check" style="color: var(--c-gold);"></i> Respon RSVP Terkini
                </h4>
                <a href="{{ route('admin.rsvps.index') }}" style="font-size: 0.8rem; color: var(--c-gold-light); text-decoration: none;">
                    Lihat Semua <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            @if(count($recentRsvps) > 0)
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Tamu</th>
                                <th>Status</th>
                                <th>Pax</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRsvps as $r)
                                <tr>
                                    <td>
                                        <div style="font-weight: 600; color: #FFF1D0;">{{ $r->guest_name }}</div>
                                    </td>
                                    <td>
                                        @if($r->status === 'hadir')
                                            <span class="badge badge-success">Hadir</span>
                                        @elseif($r->status === 'tidak_hadir')
                                            <span class="badge badge-danger">Tidak Hadir</span>
                                        @else
                                            <span class="badge badge-warning">Ragu-ragu</span>
                                        @endif
                                    </td>
                                    <td>{{ $r->attendee_count }}</td>
                                    <td style="font-size: 0.8rem;">{{ $r->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="text-align: center; padding: 2.5rem 1rem; color: rgba(248, 241, 229, 0.6);">
                    <i class="fa-solid fa-inbox" style="font-size: 2.5rem; margin-bottom: 0.5rem; opacity: 0.4;"></i>
                    <p style="font-size: 0.85rem;">Belum ada konfirmasi RSVP masuk.</p>
                </div>
            @endif
        </div>

    </div>

@endsection

@push('scripts')
<script>
    // -------------------------------------------------------------
    // Render Chart.js
    // -------------------------------------------------------------
    document.addEventListener('DOMContentLoaded', function() {
        // 1. RSVP Pie Chart
        const rsvpCtx = document.getElementById('rsvpPieChart').getContext('2d');
        new Chart(rsvpCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hadir', 'Tidak Hadir', 'Ragu-ragu', 'Belum Konfirmasi'],
                datasets: [{
                    data: [{{ $hadirCount }}, {{ $tidakHadirCount }}, {{ $raguCount }}, {{ $belumRsvpCount }}],
                    backgroundColor: [
                        '#68D391', // Hadir
                        '#FC8181', // Tidak Hadir
                        '#F6E05E', // Ragu
                        '#A0AEC0'  // Belum
                    ],
                    borderColor: '#24140D',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: '#E8D8BD', font: { family: 'Plus Jakarta Sans', size: 12 } }
                    }
                }
            }
        });

        // 2. Groups Bar Chart
        const groupLabels = {!! json_encode(array_keys($groups)) !!};
        const groupCounts = {!! json_encode(array_values($groups)) !!};

        const groupCtx = document.getElementById('groupBarChart').getContext('2d');
        new Chart(groupCtx, {
            type: 'bar',
            data: {
                labels: groupLabels,
                datasets: [{
                    label: 'Jumlah Undangan',
                    data: groupCounts,
                    backgroundColor: 'rgba(198, 161, 91, 0.6)',
                    borderColor: '#C6A15B',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#E8D8BD', stepSize: 1 },
                        grid: { color: 'rgba(198, 161, 91, 0.1)' }
                    },
                    x: {
                        ticks: { color: '#E8D8BD', font: { family: 'Plus Jakarta Sans' } },
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
@endpush
