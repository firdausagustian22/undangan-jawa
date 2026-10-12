@extends('layouts.admin')

@section('title', 'Meja Check-in Hari-H')
@section('page_title', 'Meja Penerimaan Tamu & Check-in QR Code (Hari-H)')

@section('content')

    <!-- Top Live Stat Counters -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem; margin-bottom: 2rem;">
        <div class="stat-card" style="border-left: 4px solid var(--c-gold);">
            <span style="font-size: 0.8rem; text-transform: uppercase; color: var(--c-gold-light);">Total Meja Check-in</span>
            <h3 id="statTotalCheckins" class="font-serif" style="font-size: 2.2rem; color: #FFF1D0; font-weight: 700; margin-top: 4px;">
                {{ $totalCheckins }} <span style="font-size: 0.9rem; font-family: var(--font-sans); color: var(--c-beige);">Keluarga</span>
            </h3>
            <p style="font-size: 0.8rem; color: var(--c-beige);">Dari total {{ $totalGuests }} undangan</p>
        </div>

        <div class="stat-card" style="border-left: 4px solid #68D391;">
            <span style="font-size: 0.8rem; text-transform: uppercase; color: #9AE6B4;">Tamu Riil Hadir</span>
            <h3 id="statActualAttendees" class="font-serif" style="font-size: 2.2rem; color: #9AE6B4; font-weight: 700; margin-top: 4px;">
                {{ $totalActualAttendees }} <span style="font-size: 0.9rem; font-family: var(--font-sans);">Orang</span>
            </h3>
            <p style="font-size: 0.8rem; color: var(--c-beige);">Dihitung berdasarkan kehadiran fisik</p>
        </div>
    </div>

    <!-- Alert / Feedback Banner -->
    <div id="checkinAlert" style="display: none; padding: 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; animation: fadeIn 0.3s ease;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <i id="checkinAlertIcon" style="font-size: 1.8rem;"></i>
            <div>
                <h4 id="checkinAlertTitle" style="font-size: 1.05rem; font-weight: 700; margin-bottom: 2px;"></h4>
                <p id="checkinAlertMsg" style="font-size: 0.9rem;"></p>
            </div>
        </div>
    </div>

    <!-- Dual Check-in Interface (QR Camera Scanner & Manual Fast Search) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        
        <!-- Column 1: QR Code Camera Scanner -->
        <div class="panel-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <h4 style="font-size: 1.15rem; color: #FFF1D0; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-camera" style="color: var(--c-gold);"></i> Scanner Kamera QR Code
                </h4>
                <button id="toggleScannerBtn" onclick="toggleQrScanner()" class="btn-outline-gold" style="padding: 4px 12px; font-size: 0.8rem;">
                    <i class="fa-solid fa-power-off"></i> Mulai Kamera
                </button>
            </div>

            <p style="font-size: 0.85rem; color: var(--c-beige); margin-bottom: 1rem;">
                Arahkan kamera ke QR Code undangan tamu untuk validasi kehadiran otomatis seketika.
            </p>

            <!-- Video Viewport Container -->
            <div id="qrReader" style="width: 100%; border-radius: 12px; overflow: hidden; border: 2px dashed rgba(198,161,91,0.4); min-height: 280px; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.4); text-align: center;">
                <div id="scannerPlaceholder" style="padding: 2rem;">
                    <i class="fa-solid fa-qrcode" style="font-size: 4rem; color: var(--c-gold); opacity: 0.5; margin-bottom: 0.75rem; display: block;"></i>
                    <p style="font-size: 0.85rem; color: var(--c-beige);">
                        Kamera dalam keadaan tidak aktif.<br>Klik tombol <strong>"Mulai Kamera"</strong> di atas.
                    </p>
                </div>
            </div>

            <!-- Pax Count Selector for QR Scan -->
            <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 1rem; background: rgba(0,0,0,0.3); padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(198,161,91,0.2);">
                <label style="font-size: 0.85rem; color: var(--c-gold-light); font-weight: 600;">
                    Default Pax per QR Scan:
                </label>
                <select id="qrPaxSelect" class="form-select" style="width: 110px; padding: 4px 8px; font-size: 0.85rem;">
                    <option value="1">1 Orang</option>
                    <option value="2" selected>2 Orang</option>
                    <option value="3">3 Orang</option>
                    <option value="4">4 Orang</option>
                </select>
            </div>
        </div>

        <!-- Column 2: Manual Search & 1-Click Check-in -->
        <div class="panel-card">
            <h4 style="font-size: 1.15rem; color: #FFF1D0; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--c-gold);"></i> Pencarian Cepat &amp; Check-in Manual
            </h4>

            <p style="font-size: 0.85rem; color: var(--c-beige); margin-bottom: 1rem;">
                Ketik nama tamu, grup, atau kode undangan untuk check-in tanpa scan QR.
            </p>

            <div style="position: relative; margin-bottom: 1rem;">
                <input type="text" id="manualSearchInput" oninput="searchGuests(this.value)" class="form-input" placeholder="Ketik minimal 2 huruf nama tamu..." autocomplete="off">
            </div>

            <!-- Instant Search Results Dropdown List -->
            <div id="searchResultsList" style="display: flex; flex-direction: column; gap: 8px; max-height: 320px; overflow-y: auto;">
                <div style="text-align: center; padding: 2rem 1rem; color: rgba(248, 241, 229, 0.5);">
                    <i class="fa-solid fa-keyboard" style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block; opacity: 0.3;"></i>
                    Mulai ketik nama atau kode undangan tamu di atas
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Check-ins Table with Undo -->
    <div class="panel-card" style="padding: 0; overflow: hidden;">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--c-border); display: flex; justify-content: space-between; align-items: center;">
            <h4 style="font-size: 1.1rem; color: #FFF1D0; font-weight: 600;">
                Riwayat Kedatangan Hari-H (Terbaru)
            </h4>
            <span style="font-size: 0.8rem; color: var(--c-beige);">Otomatis Diperbarui</span>
        </div>

        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Nama Tamu</th>
                        <th>Kode Undangan</th>
                        <th>Grup</th>
                        <th>Jumlah Hadir</th>
                        <th>Metode</th>
                        <th>Penerima</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="recentCheckinsBody">
                    @forelse($recentCheckins as $chk)
                        <tr id="checkinRow_{{ $chk->id }}">
                            <td style="font-size: 0.85rem; font-weight: 600; color: var(--c-gold-light);">
                                {{ $chk->checkin_time->format('H:i:s') }} WIB
                            </td>
                            <td>
                                <strong style="color: #FFF1D0;">{{ $chk->guest->name ?? 'Tamu' }}</strong>
                            </td>
                            <td>
                                <code style="color: var(--c-gold-light);">{{ $chk->guest->invitation_code ?? '-' }}</code>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $chk->guest->group_name ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $chk->actual_attendees }} Orang</span>
                            </td>
                            <td>
                                <span class="badge badge-warning">{{ strtoupper($chk->method) }}</span>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--c-beige);">
                                {{ $chk->admin->name ?? 'Admin' }}
                            </td>
                            <td style="text-align: right;">
                                <form action="{{ route('admin.checkin.undo', $chk->id) }}" method="POST" onsubmit="return confirm('Batalkan check-in tamu {{ addslashes($chk->guest->name ?? '') }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger-outline" style="font-size: 0.75rem; padding: 4px 8px;" title="Batalkan Check-in">
                                        <i class="fa-solid fa-rotate-left"></i> Batalkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr id="emptyCheckinRow">
                            <td colspan="8" style="text-align: center; padding: 2.5rem; color: var(--c-beige);">
                                Belum ada tamu yang melakukan check-in pada hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let html5QrScanner = null;
    let isScannerRunning = false;

    // Display Alert Function
    function showCheckinBanner(isSuccess, title, msg) {
        const banner = document.getElementById('checkinAlert');
        const icon = document.getElementById('checkinAlertIcon');
        const titleEl = document.getElementById('checkinAlertTitle');
        const msgEl = document.getElementById('checkinAlertMsg');

        banner.style.display = 'block';
        titleEl.textContent = title;
        msgEl.textContent = msg;

        if (isSuccess) {
            banner.style.background = 'rgba(72, 187, 120, 0.2)';
            banner.style.border = '1px solid rgba(72, 187, 120, 0.6)';
            banner.style.color = '#9AE6B4';
            icon.className = 'fa-solid fa-circle-check';
        } else {
            banner.style.background = 'rgba(245, 101, 101, 0.25)';
            banner.style.border = '1px solid rgba(245, 101, 101, 0.7)';
            banner.style.color = '#FEB2B2';
            icon.className = 'fa-solid fa-triangle-exclamation';
        }

        // Scroll into view
        banner.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Process Check-in POST
    function submitCheckin(guestId, code, attendees, method) {
        fetch("{{ route('admin.checkin.process') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                guest_id: guestId,
                code: code,
                actual_attendees: attendees,
                method: method
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showCheckinBanner(true, 'CHECK-IN BERHASIL!', data.message);
                // Update live counters
                document.getElementById('statTotalCheckins').innerHTML = `${data.total_checkins} <span style="font-size: 0.9rem; font-family: var(--font-sans); color: var(--c-beige);">Keluarga</span>`;
                document.getElementById('statActualAttendees').innerHTML = `${data.total_actual_attendees} <span style="font-size: 0.9rem; font-family: var(--font-sans);">Orang</span>`;

                // Add to table
                const tbody = document.getElementById('recentCheckinsBody');
                const empty = document.getElementById('emptyCheckinRow');
                if (empty) empty.remove();

                const tr = document.createElement('tr');
                tr.style.animation = 'fadeIn 0.5s ease';
                tr.innerHTML = `
                    <td style="font-size: 0.85rem; font-weight: 600; color: var(--c-gold-light);">${data.checkin.time} WIB</td>
                    <td><strong style="color: #FFF1D0;">${data.checkin.guest_name}</strong></td>
                    <td><code style="color: var(--c-gold-light);">${data.checkin.code}</code></td>
                    <td><span class="badge badge-info">${data.checkin.group}</span></td>
                    <td><span class="badge badge-success">${data.checkin.actual_attendees} Orang</span></td>
                    <td><span class="badge badge-warning">${data.checkin.method}</span></td>
                    <td style="font-size: 0.8rem; color: var(--c-beige);">{{ auth()->user()->name }}</td>
                    <td style="text-align: right;"><span class="badge badge-success">Selesai</span></td>
                `;
                tbody.prepend(tr);

                // Refresh search list if open
                const input = document.getElementById('manualSearchInput');
                if (input.value) searchGuests(input.value);
            } else {
                showCheckinBanner(false, data.is_duplicate ? 'PERINGATAN DUPLIKAT!' : 'GAGAL CHECK-IN!', data.message);
            }
        })
        .catch(err => {
            showCheckinBanner(false, 'KESALAHAN JARINGAN', 'Gagal memproses check-in. Periksa koneksi internet.');
        });
    }

    // Toggle QR Camera Scanner
    function toggleQrScanner() {
        const btn = document.getElementById('toggleScannerBtn');
        const placeholder = document.getElementById('scannerPlaceholder');

        if (!isScannerRunning) {
            placeholder.style.display = 'none';
            btn.innerHTML = '<i class="fa-solid fa-stop"></i> Hentikan Kamera';
            btn.style.color = '#FEB2B2';

            html5QrScanner = new Html5Qrcode("qrReader");
            html5QrScanner.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (decodedText) => {
                    // QR Code successfully scanned!
                    const attendees = parseInt(document.getElementById('qrPaxSelect').value) || 2;
                    // Play short audio beep
                    const beep = new AudioContext();
                    const osc = beep.createOscillator();
                    osc.connect(beep.destination);
                    osc.frequency.value = 800;
                    osc.start();
                    osc.stop(beep.currentTime + 0.15);

                    submitCheckin(null, decodedText, attendees, 'qr');

                    // Temporary pause to prevent rapid re-scans
                    html5QrScanner.pause();
                    setTimeout(() => { html5QrScanner.resume(); }, 2500);
                },
                (errorMessage) => {
                    // Ignore continuous scan misses
                }
            ).catch(err => {
                alert('Gagal mengakses kamera: ' + err);
                toggleQrScanner();
            });

            isScannerRunning = true;
        } else {
            if (html5QrScanner) {
                html5QrScanner.stop().then(() => {
                    html5QrScanner.clear();
                    placeholder.style.display = 'block';
                    btn.innerHTML = '<i class="fa-solid fa-power-off"></i> Mulai Kamera';
                    btn.style.color = 'var(--c-gold-light)';
                    isScannerRunning = false;
                });
            }
        }
    }

    // Manual Search Autocomplete
    let searchDebounce = null;
    function searchGuests(keyword) {
        clearTimeout(searchDebounce);
        const container = document.getElementById('searchResultsList');

        if (keyword.trim().length < 2) {
            container.innerHTML = `
                <div style="text-align: center; padding: 2rem 1rem; color: rgba(248, 241, 229, 0.5);">
                    <i class="fa-solid fa-keyboard" style="font-size: 2.5rem; margin-bottom: 0.5rem; display: block; opacity: 0.3;"></i>
                    Mulai ketik nama atau kode undangan tamu di atas
                </div>
            `;
            return;
        }

        searchDebounce = setTimeout(() => {
            fetch(`{{ route('admin.checkin.search') }}?q=${encodeURIComponent(keyword)}`)
            .then(res => res.json())
            .then(guests => {
                if (guests.length === 0) {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 1.5rem; color: var(--c-beige);">
                            Tidak ditemukan tamu dengan kata kunci "${keyword}".
                        </div>
                    `;
                    return;
                }

                container.innerHTML = '';
                guests.forEach(g => {
                    const card = document.createElement('div');
                    card.style.cssText = 'background: rgba(0,0,0,0.35); border: 1px solid rgba(198,161,91,0.25); border-radius: 10px; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; gap: 10px;';

                    if (g.is_checked_in) {
                        card.innerHTML = `
                            <div>
                                <div style="font-weight: 700; color: #FFF1D0;">${g.name}</div>
                                <div style="font-size: 0.75rem; color: var(--c-beige);">${g.code} &bull; ${g.group}</div>
                                <span class="badge badge-success" style="margin-top: 4px;">
                                    <i class="fa-solid fa-check"></i> Sudah Hadir (${g.actual_attendees} Orang, Pukul ${g.checkin_time})
                                </span>
                            </div>
                            <div>
                                <span class="badge badge-warning">Sudah Check-in</span>
                            </div>
                        `;
                    } else {
                        card.innerHTML = `
                            <div>
                                <div style="font-weight: 700; color: #FFF1D0;">${g.name}</div>
                                <div style="font-size: 0.75rem; color: var(--c-beige);">${g.code} &bull; ${g.group} (Kuota: ${g.quota} Pax)</div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="number" id="pax_${g.id}" value="${g.quota}" min="1" max="10" class="form-input" style="width: 60px; padding: 4px 6px; text-align: center; font-weight: 700;">
                                <button onclick="submitCheckin(${g.id}, '${g.code}', document.getElementById('pax_${g.id}').value, 'manual')" class="btn-gold" style="padding: 6px 12px; font-size: 0.8rem; white-space: nowrap;">
                                    <i class="fa-solid fa-user-check"></i> Hadir
                                </button>
                            </div>
                        `;
                    }
                    container.appendChild(card);
                });
            });
        }, 300);
    }
</script>
@endpush
