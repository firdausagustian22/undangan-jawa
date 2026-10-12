@extends('layouts.admin')

@section('title', 'Daftar Tamu Undangan')
@section('page_title', 'Buku Tamu & Pengelolaan Undangan')

@section('content')

    <!-- Top Action Toolbar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h4 style="font-size: 1.2rem; color: #FFF1D0; font-weight: 700;">
                Daftar Tamu Undangan ({{ $totalCount }} Tamu)
            </h4>
            <p style="font-size: 0.85rem; color: var(--c-beige);">
                Kelola tautan personalisasi, kuota kehadiran, dan pengiriman undangan digital
            </p>
        </div>

        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <button onclick="openModal('addGuestModal')" class="btn-gold">
                <i class="fa-solid fa-plus"></i> Tambah Tamu
            </button>
            <button onclick="openModal('importCsvModal')" class="btn-outline-gold">
                <i class="fa-solid fa-file-import"></i> Impor CSV
            </button>
            <a href="{{ route('admin.guests.export') }}" class="btn-outline-gold">
                <i class="fa-solid fa-file-export"></i> Ekspor CSV
            </a>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="panel-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
        <form action="{{ route('admin.guests.index') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap;">
            
            <!-- Search -->
            <div style="flex: 2; min-width: 220px;">
                <input type="text" name="search" value="{{ request('search') }}" class="form-input" placeholder="Cari nama, nomor WhatsApp, atau kode undangan...">
            </div>

            <!-- Group Filter -->
            <div style="flex: 1; min-width: 160px;">
                <select name="group" class="form-select">
                    <option value="">Semua Grup / Kategori</option>
                    @foreach($groupList as $grp)
                        <option value="{{ $grp }}" {{ request('group') == $grp ? 'selected' : '' }}>{{ $grp }}</option>
                    @endforeach
                </select>
            </div>

            <!-- RSVP Filter -->
            <div style="flex: 1; min-width: 160px;">
                <select name="rsvp" class="form-select">
                    <option value="">Semua Status RSVP</option>
                    <option value="hadir" {{ request('rsvp') == 'hadir' ? 'selected' : '' }}>Konfirmasi Hadir</option>
                    <option value="tidak_hadir" {{ request('rsvp') == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                    <option value="ragu" {{ request('rsvp') == 'ragu' ? 'selected' : '' }}>Ragu-ragu</option>
                    <option value="belum" {{ request('rsvp') == 'belum' ? 'selected' : '' }}>Belum Konfirmasi</option>
                </select>
            </div>

            <!-- Check-in Filter -->
            <div style="flex: 1; min-width: 160px;">
                <select name="checkin" class="form-select">
                    <option value="">Status Check-in Hari-H</option>
                    <option value="sudah" {{ request('checkin') == 'sudah' ? 'selected' : '' }}>Sudah Hadir</option>
                    <option value="belum" {{ request('checkin') == 'belum' ? 'selected' : '' }}>Belum Hadir</option>
                </select>
            </div>

            <button type="submit" class="btn-gold" style="padding: 0.75rem 1.25rem;">
                <i class="fa-solid fa-filter"></i> Filter
            </button>

            @if(request()->hasAny(['search', 'group', 'rsvp', 'checkin']))
                <a href="{{ route('admin.guests.index') }}" class="btn-outline-gold" style="padding: 0.75rem 1rem;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Guest Table Panel -->
    <div class="panel-card" style="padding: 0; overflow: hidden;">
        <div class="data-table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Tamu Undangan</th>
                        <th>Grup</th>
                        <th>Telepon</th>
                        <th>Pax</th>
                        <th>Status RSVP</th>
                        <th>Check-in Hari-H</th>
                        <th>Tautan Undangan</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guests as $guest)
                        <tr>
                            <td>
                                <strong style="color: var(--c-gold-light); font-family: monospace; font-size: 0.85rem;">
                                    {{ $guest->invitation_code }}
                                </strong>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #FFF1D0; font-size: 0.95rem;">
                                    {{ $guest->name }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--c-beige);">
                                    Dilihat: {{ $guest->views_count }}x
                                    @if($guest->last_viewed_at)
                                        ({{ $guest->last_viewed_at->diffForHumans() }})
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-info">{{ $guest->group_name }}</span>
                            </td>
                            <td>
                                {{ $guest->phone ?? '-' }}
                            </td>
                            <td>
                                <span style="font-weight: 700; color: #ffffff;">{{ $guest->quota }}</span>
                            </td>
                            <td>
                                @if($guest->rsvp)
                                    @if($guest->rsvp->status === 'hadir')
                                        <span class="badge badge-success">
                                            <i class="fa-solid fa-check"></i> Hadir ({{ $guest->rsvp->attendee_count }})
                                        </span>
                                    @elseif($guest->rsvp->status === 'tidak_hadir')
                                        <span class="badge badge-danger">
                                            <i class="fa-solid fa-xmark"></i> Tidak Hadir
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i class="fa-solid fa-clock"></i> Ragu-ragu
                                        </span>
                                    @endif
                                @else
                                    <span class="badge" style="background: rgba(255,255,255,0.1); color: var(--c-beige);">
                                        Belum RSVP
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($guest->checkin)
                                    <span class="badge badge-success">
                                        <i class="fa-solid fa-qrcode"></i> Hadir ({{ $guest->checkin->actual_attendees }})
                                    </span>
                                @else
                                    <span class="badge" style="background: rgba(255,255,255,0.06); color: rgba(248, 241, 229, 0.5);">
                                        Belum
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px;">
                                    <button onclick="copyToClipboard('{{ url('/undangan/' . $guest->token) }}', 'Tautan undangan kagem {{ addslashes($guest->name) }} berhasil disalin!')" class="btn-outline-gold" style="padding: 4px 10px; font-size: 0.75rem;" title="Salin Tautan">
                                        <i class="fa-solid fa-copy"></i> Salin Link
                                    </button>
                                    <button onclick="openWhatsappModal('{{ addslashes($guest->name) }}', '{{ $guest->phone }}', '{{ url('/undangan/' . $guest->token) }}')" class="btn-outline-gold" style="padding: 4px 10px; font-size: 0.75rem; color: #68D391; border-color: rgba(104,211,145,0.4);" title="Kirim WhatsApp">
                                        <i class="fa-brands fa-whatsapp"></i> WA
                                    </button>
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 6px; justify-content: flex-end;">
                                    <button onclick="openEditModal({{ json_encode($guest) }})" class="btn-outline-gold" style="padding: 4px 8px; font-size: 0.75rem;" title="Ubah Data">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.guests.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tamu {{ addslashes($guest->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger-outline" style="padding: 4px 8px; font-size: 0.75rem;" title="Hapus Tamu">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 3rem; color: var(--c-beige);">
                                <i class="fa-solid fa-user-xmark" style="font-size: 2.5rem; opacity: 0.4; margin-bottom: 0.5rem; display: block;"></i>
                                Tidak ditemukan data tamu undangan yang sesuai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div style="padding: 1.25rem;">
            {{ $guests->links() }}
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- MODAL: TAMBAH TAMU -->
    <!-- ========================================================================= -->
    <div id="addGuestModal" class="modal-overlay">
        <div class="modal-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; color: #FFF1D0; font-weight: 700;">Tambah Tamu Undangan</h3>
                <span onclick="closeModal('addGuestModal')" style="color: var(--c-beige); cursor: pointer; font-size: 1.4rem;">&times;</span>
            </div>

            <form action="{{ route('admin.guests.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Nama Lengkap Tamu *</label>
                    <input type="text" name="name" required class="form-input" placeholder="Contoh: Bpk. H. Ananto Danan & Keluarga">
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Kategori / Grup Tamu *</label>
                    <input type="text" name="group_name" required class="form-input" list="groupOptions" placeholder="Contoh: Keluarga, VIP, Sahabat, Rekan Kerja">
                    <datalist id="groupOptions">
                        <option value="Keluarga Besar">
                        <option value="Tamu VIP">
                        <option value="Sahabat Mempelai">
                        <option value="Rekan Kerja">
                        <option value="Tetangga &amp; Kerabat">
                    </datalist>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Nomer WhatsApp</label>
                        <input type="tel" name="phone" class="form-input" placeholder="081234567890">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Kuota Pax *</label>
                        <input type="number" name="quota" value="2" min="1" max="20" required class="form-input">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeModal('addGuestModal')" class="btn-outline-gold">Batal</button>
                    <button type="submit" class="btn-gold">Simpan Tamu</button>
                </div>
            </form>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- MODAL: UBAH DATA TAMU -->
    <!-- ========================================================================= -->
    <div id="editGuestModal" class="modal-overlay">
        <div class="modal-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; color: #FFF1D0; font-weight: 700;">Ubah Data Tamu Undangan</h3>
                <span onclick="closeModal('editGuestModal')" style="color: var(--c-beige); cursor: pointer; font-size: 1.4rem;">&times;</span>
            </div>

            <form id="editGuestForm" method="POST">
                @csrf
                @method('PUT')
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Nama Lengkap Tamu *</label>
                    <input type="text" id="editGuestName" name="name" required class="form-input">
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Kategori / Grup Tamu *</label>
                    <input type="text" id="editGuestGroup" name="group_name" required class="form-input">
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 12px; margin-bottom: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Nomer WhatsApp</label>
                        <input type="tel" id="editGuestPhone" name="phone" class="form-input">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Kuota Pax *</label>
                        <input type="number" id="editGuestQuota" name="quota" min="1" max="20" required class="form-input">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeModal('editGuestModal')" class="btn-outline-gold">Batal</button>
                    <button type="submit" class="btn-gold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- MODAL: IMPOR CSV -->
    <!-- ========================================================================= -->
    <div id="importCsvModal" class="modal-overlay">
        <div class="modal-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; color: #FFF1D0; font-weight: 700;">Impor Tamu Masal via CSV</h3>
                <span onclick="closeModal('importCsvModal')" style="color: var(--c-beige); cursor: pointer; font-size: 1.4rem;">&times;</span>
            </div>

            <p style="font-size: 0.85rem; color: var(--c-beige); line-height: 1.5; margin-bottom: 1rem;">
                Pastikan format file CSV memiliki urutan kolom sebagai berikut:<br>
                <code style="color: var(--c-gold-light); background: rgba(0,0,0,0.4); padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 4px;">Nama, Grup, Nomor Telepon, Kuota Pax</code>
            </p>

            <form action="{{ route('admin.guests.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 1.5rem;">
                    <input type="file" name="csv_file" accept=".csv, .txt" required class="form-input" style="padding: 0.6rem;">
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="closeModal('importCsvModal')" class="btn-outline-gold">Batal</button>
                    <button type="submit" class="btn-gold">Mulai Unggah &amp; Impor</button>
                </div>
            </form>
        </div>
    </div>


    <!-- ========================================================================= -->
    <!-- MODAL: GENERATOR PESAN WHATSAPP -->
    <!-- ========================================================================= -->
    <div id="waModal" class="modal-overlay">
        <div class="modal-box" style="max-width: 580px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <h3 style="font-size: 1.25rem; color: #FFF1D0; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-brands fa-whatsapp" style="color: #68D391;"></i> Kirim Undangan WhatsApp
                </h3>
                <span onclick="closeModal('waModal')" style="color: var(--c-beige); cursor: pointer; font-size: 1.4rem;">&times;</span>
            </div>

            <p style="font-size: 0.85rem; color: var(--c-beige); margin-bottom: 1rem;">
                Teks template undangan telah disesuaikan secara personal kagem: <strong id="waGuestNameDisplay" style="color: #FFF1D0;"></strong>
            </p>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Pratinjau Pesan Undangan:</label>
                <textarea id="waMessageText" rows="9" class="form-input" style="font-size: 0.85rem; line-height: 1.6; font-family: monospace;"></textarea>
            </div>

            <div style="display: flex; justify-content: space-between; gap: 10px;">
                <button type="button" onclick="copyWaText()" class="btn-outline-gold">
                    <i class="fa-solid fa-copy"></i> Salin Teks
                </button>
                <a id="waDirectSendBtn" href="#" target="_blank" class="btn-gold" style="background: linear-gradient(135deg, #48BB78 0%, #2F855A 100%); border-color: #9AE6B4; color: #ffffff;">
                    <i class="fa-brands fa-whatsapp"></i> Buka WhatsApp &amp; Kirim
                </a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function openEditModal(guest) {
        document.getElementById('editGuestName').value = guest.name;
        document.getElementById('editGuestGroup').value = guest.group_name;
        document.getElementById('editGuestPhone').value = guest.phone || '';
        document.getElementById('editGuestQuota').value = guest.quota;
        document.getElementById('editGuestForm').action = `/admin/guests/${guest.id}`;
        openModal('editGuestModal');
    }

    function openWhatsappModal(name, phone, url) {
        document.getElementById('waGuestNameDisplay').innerText = name;
        
        const template = `Assalamu'alaikum Warahmatullahi Wabarakatuh\nSugeng Siang / Rahayu,\n\nKatur dhumateng Panjenenganipun:\n*${name}*\n\nKanthi hangajab berkah lan pangestu Gusti Ingkang Maha Agung, keparenga kulo sakulawarga ngaturi rawuh panjenengan ing adicara Pawiwahan Pernikahan putra-putri kito:\n\n*Raden Mas Arya Daniswara & Raden Ajeng Sekar Kinanti*\n\nKagem informasi jangkep reroncening adicara, donga pangestu, saha konfirmasi rawuh (RSVP), keparenga mbikak serat sedhahan digital lumantar tautan ing ngandhap menika:\n\n👉 ${url}\n\nMaturnuwun sanget awit saking sih kawigatosan saha donga pangestu panjenengan sedaya.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.\n_Keluarga Besar Arya & Sekar_`;

        document.getElementById('waMessageText').value = template;

        let cleanPhone = (phone || '').replace(/[^0-9]/g, '');
        if (cleanPhone.startsWith('0')) {
            cleanPhone = '62' + cleanPhone.substring(1);
        }

        const encoded = encodeURIComponent(template);
        const waLink = cleanPhone ? `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encoded}` : `https://api.whatsapp.com/send?text=${encoded}`;
        
        document.getElementById('waDirectSendBtn').href = waLink;
        openModal('waModal');
    }

    function copyWaText() {
        const text = document.getElementById('waMessageText').value;
        copyToClipboard(text, 'Teks pesan WhatsApp berhasil disalin!');
    }
</script>
@endpush
