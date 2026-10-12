@extends('layouts.admin')

@section('title', 'Pengaturan Konten')
@section('page_title', 'Pengaturan Konten & Informasi Pernikahan')

@section('content')

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(420px, 1fr)); gap: 1.5rem;">
        
        <!-- Column 1: Wedding Core Info & Feature Toggles -->
        <div>
            <div class="panel-card">
                <h4 style="font-size: 1.15rem; color: #FFF1D0; font-weight: 700; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-sliders" style="color: var(--c-gold);"></i> Konfigurasi Utama Pernikahan
                </h4>

                <form action="{{ route('admin.settings.wedding') }}" method="POST">
                    @csrf

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Judul Lengkap Acara *</label>
                        <input type="text" name="title" required value="{{ old('title', $wedding->title) }}" class="form-input">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Nama Panggilan Pasangan *</label>
                            <input type="text" name="couple_short_names" required value="{{ old('couple_short_names', $wedding->couple_short_names) }}" class="form-input">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Tanggal Utama Pernikahan *</label>
                            <input type="datetime-local" name="wedding_date" required value="{{ old('wedding_date', $wedding->wedding_date ? $wedding->wedding_date->format('Y-m-d\TH:i') : '') }}" class="form-input">
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Falsafah / Kutipan Adat Jawa</label>
                        <textarea name="javanese_quote" rows="2" class="form-input">{{ old('javanese_quote', $wedding->javanese_quote) }}</textarea>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Teks Prakata / Pembuka Undangan</label>
                        <textarea name="introduction_text" rows="3" class="form-input">{{ old('introduction_text', $wedding->introduction_text) }}</textarea>
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.35rem; font-weight: 600;">Teks Penutup / Atur Panuwun</label>
                        <textarea name="closing_text" rows="2" class="form-input">{{ old('closing_text', $wedding->closing_text) }}</textarea>
                    </div>

                    <!-- Feature Toggles -->
                    <div style="background: rgba(0,0,0,0.3); border: 1px solid var(--c-border); border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem;">
                        <h5 style="font-size: 0.85rem; color: var(--c-gold-light); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.75rem;">
                            Pengaturan Fitur &amp; Interaktivitas
                        </h5>

                        <div style="display: flex; flex-direction: column; gap: 10px; font-size: 0.85rem;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_music_enabled" value="1" {{ $wedding->is_music_enabled ? 'checked' : '' }} style="accent-color: var(--c-gold);">
                                <span>Aktifkan Musik Latar Gamelan Otomatis</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_rsvp_enabled" value="1" {{ $wedding->is_rsvp_enabled ? 'checked' : '' }} style="accent-color: var(--c-gold);">
                                <span>Aktifkan Formulir Konfirmasi RSVP</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_wishes_enabled" value="1" {{ $wedding->is_wishes_enabled ? 'checked' : '' }} style="accent-color: var(--c-gold);">
                                <span>Aktifkan Buku Doa &amp; Ucapan Tamu</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="require_wishes_approval" value="1" {{ $wedding->require_wishes_approval ? 'checked' : '' }} style="accent-color: var(--c-gold);">
                                <span>Wajibkan Moderasi Persetujuan Doa Restu Sebelum Tayang</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_gift_enabled" value="1" {{ $wedding->is_gift_enabled ? 'checked' : '' }} style="accent-color: var(--c-gold);">
                                <span>Aktifkan Amplop Digital &amp; Kado</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-gold" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Konfigurasi Utama
                    </button>
                </form>
            </div>
        </div>

        <!-- Column 2: Couple Profiles & Events -->
        <div>
            <!-- Couple Profile Form -->
            <div class="panel-card">
                <h4 style="font-size: 1.15rem; color: #FFF1D0; font-weight: 700; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-heart" style="color: var(--c-gold);"></i> Profil Pengantin (Kakung &amp; Putri)
                </h4>

                <form action="{{ route('admin.settings.couple') }}" method="POST">
                    @csrf

                    <!-- Groom Section -->
                    <div style="background: rgba(0,0,0,0.25); border: 1px solid var(--c-border); border-radius: 10px; padding: 1.25rem; margin-bottom: 1.5rem;">
                        <h5 style="color: var(--c-gold-light); font-size: 0.95rem; font-weight: 700; margin-bottom: 0.75rem;">
                            Mempelai Kakung (Pria)
                        </h5>

                        <div style="margin-bottom: 0.85rem;">
                            <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Lengkap &amp; Gelar *</label>
                            <input type="text" name="groom_name" required value="{{ old('groom_name', $groom->full_name ?? '') }}" class="form-input">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 0.85rem;">
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Panggilan *</label>
                                <input type="text" name="groom_nickname" required value="{{ old('groom_nickname', $groom->nickname ?? '') }}" class="form-input">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Urutan Anak</label>
                                <input type="text" name="groom_child_order" value="{{ old('groom_child_order', $groom->child_order ?? '') }}" class="form-input">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 0.85rem;">
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Ayah</label>
                                <input type="text" name="groom_father" value="{{ old('groom_father', $groom->father_name ?? '') }}" class="form-input">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Ibu</label>
                                <input type="text" name="groom_mother" value="{{ old('groom_mother', $groom->mother_name ?? '') }}" class="form-input">
                            </div>
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: var(--c-beige);">Username Instagram</label>
                            <input type="text" name="groom_instagram" value="{{ old('groom_instagram', $groom->instagram_username ?? '') }}" class="form-input">
                        </div>
                    </div>

                    <!-- Bride Section -->
                    <div style="background: rgba(0,0,0,0.25); border: 1px solid var(--c-border); border-radius: 10px; padding: 1.25rem; margin-bottom: 1.5rem;">
                        <h5 style="color: var(--c-gold-light); font-size: 0.95rem; font-weight: 700; margin-bottom: 0.75rem;">
                            Mempelai Putri (Wanita)
                        </h5>

                        <div style="margin-bottom: 0.85rem;">
                            <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Lengkap &amp; Gelar *</label>
                            <input type="text" name="bride_name" required value="{{ old('bride_name', $bride->full_name ?? '') }}" class="form-input">
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 0.85rem;">
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Panggilan *</label>
                                <input type="text" name="bride_nickname" required value="{{ old('bride_nickname', $bride->nickname ?? '') }}" class="form-input">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Urutan Anak</label>
                                <input type="text" name="bride_child_order" value="{{ old('bride_child_order', $bride->child_order ?? '') }}" class="form-input">
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 0.85rem;">
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Ayah</label>
                                <input type="text" name="bride_father" value="{{ old('bride_father', $bride->father_name ?? '') }}" class="form-input">
                            </div>
                            <div>
                                <label style="font-size: 0.8rem; color: var(--c-beige);">Nama Ibu</label>
                                <input type="text" name="bride_mother" value="{{ old('bride_mother', $bride->mother_name ?? '') }}" class="form-input">
                            </div>
                        </div>
                        <div>
                            <label style="font-size: 0.8rem; color: var(--c-beige);">Username Instagram</label>
                            <input type="text" name="bride_instagram" value="{{ old('bride_instagram', $bride->instagram_username ?? '') }}" class="form-input">
                        </div>
                    </div>

                    <button type="submit" class="btn-gold" style="width: 100%;">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data Pengantin
                    </button>
                </form>
            </div>

            <!-- Events List Quick Overview -->
            <div class="panel-card">
                <h4 style="font-size: 1.15rem; color: #FFF1D0; font-weight: 700; margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-calendar-alt" style="color: var(--c-gold);"></i> Jadwal Acara Terdaftar
                </h4>

                @foreach($events as $event)
                    <div style="background: rgba(0,0,0,0.3); border: 1px solid var(--c-border); border-radius: 10px; padding: 1rem; margin-bottom: 1rem;">
                        <h5 style="color: #FFF1D0; font-weight: 700; margin-bottom: 0.25rem;">{{ $event->title }}</h5>
                        <p style="font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.25rem;">
                            {{ $event->event_date->translatedFormat('d F Y') }} | {{ $event->start_time }} WIB
                        </p>
                        <p style="font-size: 0.8rem; color: var(--c-beige);">{{ $event->venue_name }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection
