@extends('layouts.admin')

@section('title', 'Konfirmasi RSVP')
@section('page_title', 'Manajemen Konfirmasi Kehadiran (RSVP)')

@section('content')

    <!-- Top Action Toolbar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h4 style="font-size: 1.2rem; color: #FFF1D0; font-weight: 700;">
                Data Konfirmasi RSVP ({{ $stats['total'] }} Respon)
            </h4>
            <p style="font-size: 0.85rem; color: var(--c-beige);">
                Pantau konfirmasi kehadiran para tamu dan estimasi kebutuhan katering
            </p>
        </div>

        <a href="{{ route('admin.rsvps.export') }}" class="btn-outline-gold">
            <i class="fa-solid fa-file-export"></i> Ekspor CSV RSVP
        </a>
    </div>

    <!-- RSVP Stat Badges Ribbon -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div class="stat-card" style="padding: 1rem 1.25rem;">
            <span style="font-size: 0.75rem; text-transform: uppercase; color: #9AE6B4;">Hadir</span>
            <div style="font-size: 1.5rem; font-weight: 700; color: #9AE6B4;">
                {{ $stats['hadir_pax'] }} <span style="font-size: 0.85rem;">Pax ({{ $stats['hadir'] }} Respon)</span>
            </div>
        </div>
        <div class="stat-card" style="padding: 1rem 1.25rem;">
            <span style="font-size: 0.75rem; text-transform: uppercase; color: #FEB2B2;">Tidak Hadir</span>
            <div style="font-size: 1.5rem; font-weight: 700; color: #FEB2B2;">
                {{ $stats['tidak_hadir'] }} <span style="font-size: 0.85rem;">Undangan</span>
            </div>
        </div>
        <div class="stat-card" style="padding: 1rem 1.25rem;">
            <span style="font-size: 0.75rem; text-transform: uppercase; color: #FAF089;">Ragu-ragu</span>
            <div style="font-size: 1.5rem; font-weight: 700; color: #FAF089;">
                {{ $stats['ragu'] }} <span style="font-size: 0.85rem;">Undangan</span>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="panel-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
        <form action="{{ route('admin.rsvps.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
            <div style="flex: 2; min-width: 240px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="Cari nama tamu, nomor telepon, atau pesan doa...">
            </div>
            <div style="flex: 1; min-width: 180px;">
                <select name="status" class="form-select">
                    <option value="">Semua Status RSVP</option>
                    <option value="hadir" {{ request('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="tidak_hadir" {{ request('status') === 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    <option value="ragu" {{ request('status') === 'ragu' ? 'selected' : '' }}>Ragu-ragu</option>
                </select>
            </div>
            <button type="submit" class="btn-gold">
                <i class="fa-solid fa-filter"></i> Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.rsvps.index') }}" class="btn-outline-gold">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="panel-card" style="padding: 0; overflow: hidden;">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Tamu</th>
                        <th>Status</th>
                        <th>Pax</th>
                        <th>WhatsApp</th>
                        <th>Pesan / Doa Restu</th>
                        <th>Waktu Respon</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rsvps as $rsvp)
                        <tr>
                            <td>
                                <strong style="color: #FFF1D0; font-size: 0.95rem;">{{ $rsvp->guest_name }}</strong>
                                @if($rsvp->guest)
                                    <div style="font-size: 0.75rem; color: var(--c-beige);">
                                        Grup: {{ $rsvp->guest->group_name }} ({{ $rsvp->guest->invitation_code }})
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($rsvp->status === 'hadir')
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-circle-check"></i> Hadir
                                    </span>
                                @elseif($rsvp->status === 'tidak_hadir')
                                    <span class="badge badge-danger">
                                        <i class="fa-solid fa-circle-xmark"></i> Tidak Hadir
                                    </span>
                                @else
                                    <span class="badge badge-warning">
                                        <i class="fa-solid fa-clock"></i> Ragu-ragu
                                    </span>
                                @endif
                            </td>
                            <td>
                                <strong style="color: #ffffff;">{{ $rsvp->attendee_count }} Orang</strong>
                            </td>
                            <td>
                                {{ $rsvp->phone ?? '-' }}
                            </td>
                            <td style="max-width: 250px;">
                                <div style="font-size: 0.85rem; color: var(--c-ivory); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{ $rsvp->notes ?? '-' }}
                                </div>
                            </td>
                            <td style="font-size: 0.8rem;">
                                {{ $rsvp->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td style="text-align: right;">
                                <button onclick="openEditRsvpModal({{ json_encode($rsvp) }})" class="btn-outline-gold" style="padding: 4px 10px; font-size: 0.75rem;">
                                    <i class="fa-solid fa-pen"></i> Ubah
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem; color: var(--c-beige);">
                                Belum ada konfirmasi RSVP yang sesuai dengan pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 1.25rem;">
            {{ $rsvps->links() }}
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- MODAL: UBAH STATUS RSVP -->
    <!-- ========================================================================= -->
    <div id="editRsvpModal" class="modal-overlay">
        <div class="modal-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; color: #FFF1D0; font-weight: 700;">Ubah Respon RSVP</h3>
                <span onclick="closeModal('editRsvpModal')" style="color: var(--c-beige); cursor: pointer; font-size: 1.4rem;">&times;</span>
            </div>

            <form id="editRsvpForm" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Nama Tamu</label>
                    <input type="text" id="editRsvpName" disabled class="form-input" style="opacity: 0.7;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Status Kehadiran *</label>
                    <select name="status" id="editRsvpStatus" class="form-select" required>
                        <option value="hadir">Hadir</option>
                        <option value="tidak_hadir">Tidak Hadir</option>
                        <option value="ragu">Ragu-ragu</option>
                    </select>
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Jumlah Hadir (Pax) *</label>
                    <input type="number" name="attendee_count" id="editRsvpCount" min="0" max="10" required class="form-input">
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Catatan / Pesan</label>
                    <textarea name="notes" id="editRsvpNotes" rows="3" class="form-input"></textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeModal('editRsvpModal')" class="btn-outline-gold">Batal</button>
                    <button type="submit" class="btn-gold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openEditRsvpModal(rsvp) {
        document.getElementById('editRsvpName').value = rsvp.guest_name;
        document.getElementById('editRsvpStatus').value = rsvp.status;
        document.getElementById('editRsvpCount').value = rsvp.attendee_count;
        document.getElementById('editRsvpNotes').value = rsvp.notes || '';
        document.getElementById('editRsvpForm').action = `/admin/rsvps/${rsvp.id}`;
        openModal('editRsvpModal');
    }
</script>
@endpush
