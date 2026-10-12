@extends('layouts.invitation')

@section('content')

    <!-- ========================================================================= -->
    <!-- 1. FULLSCREEN OPENING COVER (Interaktif dengan Tirai Pembuka) -->
    <!-- ========================================================================= -->
    <section id="openingCover" style="position: fixed; inset: 0; z-index: 999; background: var(--c-mahogany); background-image: radial-gradient(circle at 50% 20%, rgba(198, 161, 91, 0.25) 0%, rgba(47, 27, 20, 0.98) 75%), url('{{ asset('assets/images/ornaments/batik-pattern.svg') }}'); background-size: cover, 140px; display: flex; flex-direction: column; justify-content: space-between; align-items: center; padding: 3rem 1.5rem 2.5rem; text-align: center; overflow-y: auto;">
        
        <!-- Janur Kuning Top Decorative Garland -->
        <div style="width: 100%; display: flex; justify-content: space-between; align-items: flex-start; max-width: 440px; pointer-events: none;">
            <img src="{{ asset('assets/images/ornaments/janur-kuning.svg') }}" alt="Janur Kuning Kiri" style="width: 55px; height: auto; transform: scaleX(-1); filter: drop-shadow(0 4px 8px rgba(0,0,0,0.5));">
            <div style="flex: 1; text-align: center; padding-top: 0.5rem;">
                <span style="font-size: 0.8rem; letter-spacing: 4px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                    Pawiwahan Ageng
                </span>
            </div>
            <img src="{{ asset('assets/images/ornaments/janur-kuning.svg') }}" alt="Janur Kuning Kanan" style="width: 55px; height: auto; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.5));">
        </div>

        <!-- Center Gunungan & Couple Details -->
        <div style="max-width: 420px; margin: 1.5rem 0;">
            <!-- Gunungan Kayon Motif -->
            <div style="width: 110px; height: auto; margin: 0 auto 1.25rem;">
                <img src="{{ asset('assets/images/ornaments/gunungan.svg') }}" alt="Gunungan Jawa" style="width: 100%; height: auto; filter: drop-shadow(0 6px 16px rgba(198, 161, 91, 0.3));">
            </div>

            <p class="font-serif" style="font-size: 0.95rem; color: var(--c-beige); margin-bottom: 0.5rem; letter-spacing: 1px;">
                SERAT SEDHAHAN PAWIWAHAN
            </p>

            <h1 class="font-serif gold-gradient-text" style="font-size: 2.3rem; line-height: 1.15; margin-bottom: 0.5rem; font-weight: 700;">
                {{ $wedding->couple_short_names ?? 'Arya & Sekar' }}
            </h1>

            <p style="font-size: 0.85rem; color: var(--c-ivory); opacity: 0.9; margin-bottom: 1.5rem;">
                {{ $wedding->wedding_date ? $wedding->wedding_date->translatedFormat('l, d F Y') : 'Sabtu, 28 November 2026' }}
            </p>

            <!-- Personalized Guest Box -->
            <div class="glass-card" style="padding: 1.5rem 1.25rem; margin: 0.5rem auto 1.75rem; border-color: rgba(198, 161, 91, 0.45); max-width: 380px;">
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--c-beige); margin-bottom: 0.4rem;">
                    Katur Dhumateng Panjenengan:
                </p>
                <h3 class="font-serif" style="font-size: 1.4rem; color: #FFF1D0; font-weight: 600; margin-bottom: 0.3rem;">
                    {{ $guestName ?? 'Tamu Undangan Kinasih' }}
                </h3>
                @if($guest && $guest->group_name)
                    <span style="display: inline-block; background: rgba(198, 161, 91, 0.2); border: 1px solid rgba(198, 161, 91, 0.4); border-radius: 20px; padding: 2px 14px; font-size: 0.75rem; color: var(--c-gold-light); margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-users" style="margin-right: 4px;"></i> {{ $guest->group_name }}
                    </span>
                @endif
                <p style="font-size: 0.75rem; color: rgba(248, 241, 229, 0.7); font-style: italic;">
                    *Nyuwun pangapunten bilih wonten kalepatan seratan asma utawi gelar
                </p>
            </div>

            <!-- Open Invitation Button -->
            <button onclick="openInvitation()" class="btn-gold" style="font-size: 1rem; padding: 0.9rem 2.2rem;">
                <i class="fa-solid fa-envelope-open-text" style="font-size: 1.1rem;"></i> BUKA SERAT UNDANGAN
            </button>
        </div>

        <!-- Footer Blessing -->
        <div style="font-size: 0.75rem; color: rgba(248, 241, 229, 0.6); letter-spacing: 1px;">
            Yogyakarta Hadiningrat
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 2. HERO SECTION DENGAN COUNTDOWN TIMER -->
    <!-- ========================================================================= -->
    <section id="heroSection" style="padding: 3.5rem 1.25rem 3rem; text-align: center; position: relative; background: linear-gradient(180deg, rgba(47,27,20,0.95) 0%, rgba(35,18,12,0.98) 100%);">
        
        <!-- Header Motif Kipas -->
        <div style="display: flex; justify-content: center; align-items: center; gap: 12px; margin-bottom: 1.25rem;">
            <img src="{{ asset('assets/images/ornaments/kipas-jawa.svg') }}" alt="Kipas Kiri" style="width: 36px; height: auto;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Walimatul Ursy
            </span>
            <img src="{{ asset('assets/images/ornaments/kipas-jawa.svg') }}" alt="Kipas Kanan" style="width: 36px; height: auto; transform: scaleX(-1);">
        </div>

        <!-- Couple Prewedding Hero Frame -->
        <div style="position: relative; max-width: 340px; margin: 0 auto 1.75rem;">
            <!-- Outer Gebyok Carved Frame -->
            <div style="position: relative; border-radius: 20px; overflow: hidden; border: 2px solid var(--c-gold); box-shadow: 0 15px 35px rgba(0,0,0,0.6);">
                <img src="{{ asset('assets/images/couple/hero.jpg') }}" alt="Foto Pasangan Arya dan Sekar" style="width: 100%; height: 380px; object-fit: cover; display: block;">
                <!-- Dark Gradient Overlay for text contrast -->
                <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(47, 27, 20, 0.8) 0%, transparent 60%);"></div>
                <!-- Ronce Melati Garland overlay -->
                <img src="{{ asset('assets/images/ornaments/melati.svg') }}" alt="Ronce Melati" style="position: absolute; top: 0; left: 10px; width: 40px; height: auto; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.4)); opacity: 0.95;">
                <img src="{{ asset('assets/images/ornaments/melati.svg') }}" alt="Ronce Melati" style="position: absolute; top: 0; right: 10px; width: 40px; height: auto; transform: scaleX(-1); filter: drop-shadow(0 4px 6px rgba(0,0,0,0.4)); opacity: 0.95;">
            </div>
        </div>

        <h2 class="font-serif gold-gradient-text" style="font-size: 2.2rem; margin-bottom: 0.4rem; font-weight: 700;">
            {{ $wedding->couple_short_names ?? 'Arya & Sekar' }}
        </h2>

        <p style="font-size: 0.95rem; color: var(--c-beige); margin-bottom: 2rem;">
            <i class="fa-regular fa-calendar-check" style="color: var(--c-gold); margin-right: 6px;"></i>
            {{ $wedding->wedding_date ? $wedding->wedding_date->translatedFormat('l, d F Y') : 'Sabtu, 28 November 2026' }}
        </p>

        <!-- Dynamic Countdown Timer Box -->
        <div class="glass-card" style="padding: 1.5rem 1rem; border-color: rgba(198, 161, 91, 0.4); max-width: 400px; margin: 0 auto;">
            <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--c-gold-light); margin-bottom: 1rem; font-weight: 600;">
                Menghitung Hari Bahagia
            </p>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px;">
                <div style="background: rgba(0,0,0,0.35); padding: 10px 4px; border-radius: 12px; border: 1px solid rgba(198,161,91,0.25);">
                    <span id="countdownDays" class="font-serif" style="font-size: 1.6rem; font-weight: 700; color: #FFF1D0; display: block; line-height: 1.1;">00</span>
                    <span style="font-size: 0.7rem; text-transform: uppercase; color: var(--c-beige);">Dina (Hari)</span>
                </div>
                <div style="background: rgba(0,0,0,0.35); padding: 10px 4px; border-radius: 12px; border: 1px solid rgba(198,161,91,0.25);">
                    <span id="countdownHours" class="font-serif" style="font-size: 1.6rem; font-weight: 700; color: #FFF1D0; display: block; line-height: 1.1;">00</span>
                    <span style="font-size: 0.7rem; text-transform: uppercase; color: var(--c-beige);">Jam</span>
                </div>
                <div style="background: rgba(0,0,0,0.35); padding: 10px 4px; border-radius: 12px; border: 1px solid rgba(198,161,91,0.25);">
                    <span id="countdownMinutes" class="font-serif" style="font-size: 1.6rem; font-weight: 700; color: #FFF1D0; display: block; line-height: 1.1;">00</span>
                    <span style="font-size: 0.7rem; text-transform: uppercase; color: var(--c-beige);">Menit</span>
                </div>
                <div style="background: rgba(0,0,0,0.35); padding: 10px 4px; border-radius: 12px; border: 1px solid rgba(198,161,91,0.25);">
                    <span id="countdownSeconds" class="font-serif" style="font-size: 1.6rem; font-weight: 700; color: #FFF1D0; display: block; line-height: 1.1;">00</span>
                    <span style="font-size: 0.7rem; text-transform: uppercase; color: var(--c-beige);">Detik</span>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 3. AYAT SUCI & FILOSOFI JAWA (Prakata Luhur) -->
    <!-- ========================================================================= -->
    <section id="quoteSection" style="padding: 3rem 1.25rem; background: var(--c-brown); position: relative; text-align: center;">
        
        <div class="ornament-divider">
            <span class="line"></span>
            <img src="{{ asset('assets/images/ornaments/wayang.svg') }}" alt="Wayang Kamajaya Kamaratih">
            <span class="line"></span>
        </div>

        <!-- Al-Qur'an Quote Card -->
        <div class="glass-card-light" style="padding: 2rem 1.5rem; max-width: 440px; margin: 0 auto 2rem; position: relative;">
            <i class="fa-solid fa-quote-left" style="font-size: 1.8rem; color: var(--c-gold); opacity: 0.5; margin-bottom: 0.75rem; display: block;"></i>
            
            <p style="font-family: 'Amiri', serif; font-size: 1.25rem; line-height: 2; margin-bottom: 1rem; color: #1b0e0a; direction: rtl;">
                {{ $wedding->quote_arabic ?? 'وَمِنْ ءَايَٰتِهِۦٓ أَنْ خَلَقَ لَكُم مِّنْ أَنفُسِكُمْ أَزْوَٰجًا لِّتَسْكُنُوٓا۟ إِلَيْهَا وَجَعَلَ بَيْنَكُم مَّوَدَّةً وَرَحْمَةً ۚ إِنَّ فِى ذَٰلِكَ لَءَايَٰتٍ لِّقَوْمٍ يَتَفَكَّرُونَ' }}
            </p>

            <p style="font-size: 0.85rem; line-height: 1.6; color: #4A2C20; margin-bottom: 0.75rem; font-style: italic;">
                "{{ $wedding->quote_translation ?? 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan untukmu pasangan-pasangan dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya, dan dijadikan-Nya di antaramu rasa kasih dan sayang.' }}"
            </p>

            <span style="font-size: 0.8rem; font-weight: 700; color: var(--c-gold-dark); text-transform: uppercase; letter-spacing: 1px;">
                {{ $wedding->quote_source ?? 'QS. Ar-Rum: 21' }}
            </span>
        </div>

        <!-- Javanese Wisdom & Greeting -->
        <div style="max-width: 420px; margin: 0 auto;">
            <h3 class="font-serif gold-gradient-text" style="font-size: 1.4rem; margin-bottom: 0.75rem;">
                Memayu Hayuning Bawana
            </h3>
            <p style="font-size: 0.85rem; line-height: 1.7; color: var(--c-beige); margin-bottom: 1rem;">
                {{ $wedding->introduction_text ?? 'Kanthi Asmaning Gusti Ingkang Maha Welas lan Maha Asih. Sinartan raos syukur lan hangaturaken panuwun, lumunturing sih wilasa mugi kasantosan tansah kajiwa kasarira dumateng panjenengan sedaya. Kanthi hangajab berkah lan pangestu, keparenga kulo sakulawarga ngaturi rawuh panjenengan ing adicara Pawiwahan Pernikahan putra-putri kito.' }}
            </p>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 4. PROFIL MEMPELAI KAKUNG & PUTRI -->
    <!-- ========================================================================= -->
    <section id="coupleSection" style="padding: 3.5rem 1.25rem; background: var(--c-mahogany); position: relative; text-align: center;">
        
        <div style="margin-bottom: 2rem;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Penganten Kekalih
            </span>
            <h2 class="font-serif gold-gradient-text" style="font-size: 2rem; margin-top: 0.25rem;">
                Mempelai Pengantin
            </h2>
        </div>

        <!-- Mempelai Kakung (Groom) -->
        <div class="glass-card" style="padding: 2rem 1.5rem; max-width: 420px; margin: 0 auto 2.5rem; border-color: rgba(198, 161, 91, 0.4);">
            <!-- Groom Photo with Frame -->
            <div style="width: 170px; height: 230px; margin: 0 auto 1.25rem; position: relative; border-radius: 16px; overflow: hidden; border: 2px solid var(--c-gold); box-shadow: 0 8px 24px rgba(0,0,0,0.5);">
                <img src="{{ asset($groom->photo_path ?? 'assets/images/couple/groom.jpg') }}" alt="{{ $groom->full_name ?? 'Raden Mas Arya' }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                <img src="{{ asset('assets/images/ornaments/melati.svg') }}" alt="Ronce Melati" style="position: absolute; top: -5px; right: -5px; width: 35px; height: auto;">
            </div>

            <h3 class="font-serif" style="font-size: 1.4rem; color: #FFF1D0; font-weight: 700; margin-bottom: 0.25rem;">
                {{ $groom->full_name ?? 'Raden Mas Arya Daniswara, S.T.' }}
            </h3>
            <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--c-gold-light); display: block; margin-bottom: 1rem; font-weight: 600;">
                Mempelai Kakung
            </span>

            <p style="font-size: 0.85rem; color: var(--c-beige); line-height: 1.6; margin-bottom: 0.5rem;">
                {{ $groom->child_order ?? 'Putra Pertama' }} saking Panjenenganipun:
            </p>
            <p style="font-size: 0.9rem; color: #ffffff; font-weight: 600; margin-bottom: 0.25rem;">
                {{ $groom->father_name ?? 'Bpk. K.R.T. Bambang Sutrisnohadiningrat' }}
            </p>
            <p style="font-size: 0.85rem; color: var(--c-beige); margin-bottom: 1.25rem;">
                &amp; {{ $groom->mother_name ?? 'Ibu Hj. Siti Rahayu Kusumaningrum' }}
            </p>

            @if($groom && $groom->instagram_username)
                <a href="{{ $groom->instagram_url ?? '#' }}" target="_blank" class="btn-outline-gold" style="font-size: 0.8rem; padding: 6px 16px;">
                    <i class="fa-brands fa-instagram" style="color: var(--c-gold-light);"></i> {{ $groom->instagram_username }}
                </a>
            @endif
        </div>

        <!-- Dan / Simbol Penyatuan -->
        <div style="margin: -1rem auto 1.5rem; display: flex; align-items: center; justify-content: center; gap: 1rem;">
            <span style="height: 1px; width: 60px; background: rgba(198,161,91,0.5);"></span>
            <span class="font-script" style="font-size: 3rem; color: var(--c-gold-light); line-height: 1;">&amp;</span>
            <span style="height: 1px; width: 60px; background: rgba(198,161,91,0.5);"></span>
        </div>

        <!-- Mempelai Putri (Bride) -->
        <div class="glass-card" style="padding: 2rem 1.5rem; max-width: 420px; margin: 0 auto; border-color: rgba(198, 161, 91, 0.4);">
            <!-- Bride Photo with Frame -->
            <div style="width: 170px; height: 230px; margin: 0 auto 1.25rem; position: relative; border-radius: 16px; overflow: hidden; border: 2px solid var(--c-gold); box-shadow: 0 8px 24px rgba(0,0,0,0.5);">
                <img src="{{ asset($bride->photo_path ?? 'assets/images/couple/bride.jpg') }}" alt="{{ $bride->full_name ?? 'Raden Ajeng Sekar' }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                <img src="{{ asset('assets/images/ornaments/melati.svg') }}" alt="Ronce Melati" style="position: absolute; top: -5px; left: -5px; width: 35px; height: auto; transform: scaleX(-1);">
            </div>

            <h3 class="font-serif" style="font-size: 1.4rem; color: #FFF1D0; font-weight: 700; margin-bottom: 0.25rem;">
                {{ $bride->full_name ?? 'Raden Ajeng Sekar Kinanti, S.Psi., M.Psi.' }}
            </h3>
            <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--c-gold-light); display: block; margin-bottom: 1rem; font-weight: 600;">
                Mempelai Putri
            </span>

            <p style="font-size: 0.85rem; color: var(--c-beige); line-height: 1.6; margin-bottom: 0.5rem;">
                {{ $bride->child_order ?? 'Putri Kedua' }} saking Panjenenganipun:
            </p>
            <p style="font-size: 0.9rem; color: #ffffff; font-weight: 600; margin-bottom: 0.25rem;">
                {{ $bride->father_name ?? 'Bpk. Dr. H. Haryo Tejakusuma, M.Si.' }}
            </p>
            <p style="font-size: 0.85rem; color: var(--c-beige); margin-bottom: 1.25rem;">
                &amp; {{ $bride->mother_name ?? 'Ibu Dra. Hj. Endang Sri Lestari' }}
            </p>

            @if($bride && $bride->instagram_username)
                <a href="{{ $bride->instagram_url ?? '#' }}" target="_blank" class="btn-outline-gold" style="font-size: 0.8rem; padding: 6px 16px;">
                    <i class="fa-brands fa-instagram" style="color: var(--c-gold-light);"></i> {{ $bride->instagram_username }}
                </a>
            @endif
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 5. RANGKAIAN ACARA PERNIKAHAN (Adicara Pawiwahan) -->
    <!-- ========================================================================= -->
    <section id="eventsSection" style="padding: 3.5rem 1.25rem; background: linear-gradient(180deg, var(--c-mahogany) 0%, var(--c-brown) 100%); position: relative; text-align: center;">
        
        <div class="ornament-divider">
            <span class="line"></span>
            <img src="{{ asset('assets/images/ornaments/rumah-joglo.svg') }}" alt="Rumah Joglo Pendopo" style="width: 48px;">
            <span class="line"></span>
        </div>

        <div style="margin-bottom: 2rem;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Reroncening Adicara
            </span>
            <h2 class="font-serif gold-gradient-text" style="font-size: 2rem; margin-top: 0.25rem;">
                Rangkaian Acara
            </h2>
        </div>

        @foreach($events as $event)
            <div class="glass-card" style="padding: 2rem 1.5rem; max-width: 420px; margin: 0 auto 2rem; border-color: rgba(198, 161, 91, 0.4); text-align: center;">
                <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(198, 161, 91, 0.2); border: 1px solid var(--c-gold); display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: var(--c-gold-light); font-size: 1.3rem;">
                    @if($event->category === 'akad')
                        <i class="fa-solid fa-hands-praying"></i>
                    @elseif($event->category === 'adat')
                        <i class="fa-solid fa-crown"></i>
                    @else
                        <i class="fa-solid fa-champagne-glasses"></i>
                    @endif
                </div>

                <h3 class="font-serif" style="font-size: 1.45rem; color: #FFF1D0; font-weight: 700; margin-bottom: 0.75rem;">
                    {{ $event->title }}
                </h3>

                <div style="background: rgba(0,0,0,0.25); border-radius: 12px; padding: 1rem; margin-bottom: 1.25rem; border: 1px solid rgba(198, 161, 91, 0.2);">
                    <p style="font-size: 0.9rem; color: var(--c-gold-light); font-weight: 600; margin-bottom: 0.3rem;">
                        <i class="fa-regular fa-calendar-day" style="margin-right: 6px;"></i>
                        {{ $event->event_date->translatedFormat('l, d F Y') }}
                    </p>
                    <p style="font-size: 0.95rem; color: #ffffff; font-weight: 700; margin-bottom: 0.25rem;">
                        <i class="fa-regular fa-clock" style="margin-right: 6px; color: var(--c-gold);"></i>
                        Pukul {{ $event->start_time }} {{ $event->end_time ? ' - ' . $event->end_time : 'WIB s/d Selesai' }} {{ $event->time_zone ?? 'WIB' }}
                    </p>
                </div>

                <h4 style="font-size: 1.05rem; color: #ffffff; font-weight: 600; margin-bottom: 0.35rem;">
                    {{ $event->venue_name }}
                </h4>
                <p style="font-size: 0.85rem; color: var(--c-beige); line-height: 1.5; margin-bottom: 1.5rem;">
                    {{ $event->address }}
                </p>

                <!-- Action Buttons: Google Maps, Calendar, Salin Alamat -->
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @if($event->maps_url)
                        <a href="{{ $event->maps_url }}" target="_blank" class="btn-gold" style="font-size: 0.85rem; padding: 0.7rem 1.2rem;">
                            <i class="fa-solid fa-location-dot"></i> Buka Google Maps
                        </a>
                    @endif
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('invitation.ics', $event->id) }}" class="btn-outline-gold" style="flex: 1; font-size: 0.8rem; padding: 0.65rem 0.5rem;">
                            <i class="fa-solid fa-calendar-plus"></i> Simpan Kalender
                        </a>
                        <button onclick="copyToClipboard('{{ addslashes($event->venue_name . ' - ' . $event->address) }}', 'Alamat lokasi berhasil disalin!')" class="btn-outline-gold" style="flex: 1; font-size: 0.8rem; padding: 0.65rem 0.5rem;">
                            <i class="fa-solid fa-copy"></i> Salin Alamat
                        </button>
                    </div>
                </div>

                @if($event->maps_embed)
                    <div style="margin-top: 1.5rem; border-radius: 12px; overflow: hidden; border: 1px solid var(--c-gold);">
                        <iframe src="{{ $event->maps_embed }}" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @endif
            </div>
        @endforeach
    </section>


    <!-- ========================================================================= -->
    <!-- 6. KISAH CINTA (Lelampahan Katresnan / Love Story Timeline) -->
    <!-- ========================================================================= -->
    @if(count($stories) > 0)
    <section id="storySection" style="padding: 3.5rem 1.25rem; background: var(--c-mahogany); position: relative; text-align: center;">
        
        <div style="margin-bottom: 2.5rem;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Lelampahan Katresnan
            </span>
            <h2 class="font-serif gold-gradient-text" style="font-size: 2rem; margin-top: 0.25rem;">
                Kisah Cinta Kami
            </h2>
        </div>

        <div style="position: relative; max-width: 440px; margin: 0 auto; text-align: left;">
            <!-- Vertical Timeline Line -->
            <div style="position: absolute; left: 24px; top: 15px; bottom: 15px; width: 2px; background: linear-gradient(180deg, var(--c-gold), rgba(198,161,91,0.2));"></div>

            @foreach($stories as $story)
                <div style="position: relative; padding-left: 60px; margin-bottom: 2.5rem;">
                    <!-- Timeline Node Pin -->
                    <div style="position: absolute; left: 15px; top: 0; width: 20px; height: 20px; border-radius: 50%; background: var(--c-gold); border: 3px solid var(--c-mahogany); box-shadow: 0 0 10px rgba(198,161,91,0.6);"></div>

                    <div class="glass-card" style="padding: 1.25rem; border-color: rgba(198, 161, 91, 0.3);">
                        <span style="font-size: 0.8rem; font-weight: 700; color: var(--c-gold-light); display: inline-block; margin-bottom: 0.25rem;">
                            {{ $story->story_date }}
                        </span>
                        <h4 class="font-serif" style="font-size: 1.15rem; color: #FFF1D0; margin-bottom: 0.5rem; font-weight: 600;">
                            {{ $story->title }}
                        </h4>

                        @if($story->image_path && file_exists(public_path($story->image_path)))
                            <div style="border-radius: 10px; overflow: hidden; margin-bottom: 0.75rem; border: 1px solid rgba(198,161,91,0.25); max-height: 180px;">
                                <img src="{{ asset($story->image_path) }}" alt="{{ $story->title }}" style="width: 100%; height: 180px; object-fit: cover; display: block;">
                            </div>
                        @endif

                        <p style="font-size: 0.85rem; color: var(--c-beige); line-height: 1.6;">
                            {{ $story->description }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif


    <!-- ========================================================================= -->
    <!-- 7. GALERI FOTO PREWEDDING & UPACARA ADAT -->
    <!-- ========================================================================= -->
    @if(count($gallery) > 0)
    <section id="gallerySection" style="padding: 3.5rem 1.25rem; background: var(--c-brown); position: relative; text-align: center;">
        
        <div class="ornament-divider">
            <span class="line"></span>
            <img src="{{ asset('assets/images/ornaments/kipas-jawa.svg') }}" alt="Kipas Jawa">
            <span class="line"></span>
        </div>

        <div style="margin-bottom: 2rem;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Potret Kebahagiaan
            </span>
            <h2 class="font-serif gold-gradient-text" style="font-size: 2rem; margin-top: 0.25rem;">
                Galeri Foto
            </h2>
        </div>

        <!-- Masonry Grid with Lightbox trigger -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; max-width: 440px; margin: 0 auto;">
            @foreach($gallery as $img)
                <div onclick="openLightbox('{{ asset($img->image_path) }}')" style="position: relative; border-radius: 12px; overflow: hidden; border: 1px solid rgba(198,161,91,0.4); cursor: pointer; aspect-ratio: 4/5; box-shadow: 0 6px 16px rgba(0,0,0,0.3); transition: transform 0.3s ease;">
                    <img src="{{ asset($img->image_path) }}" alt="{{ $img->title }}" style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s ease;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(0deg, rgba(47,27,20,0.85) 0%, transparent 60%); opacity: 0; transition: opacity 0.3s ease; display: flex; align-items: flex-end; padding: 10px;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'">
                        <span style="font-size: 0.75rem; color: #FFF1D0; font-weight: 600;">
                            <i class="fa-solid fa-magnifying-glass-plus" style="margin-right: 4px;"></i> {{ $img->title }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
        <p style="font-size: 0.75rem; color: var(--c-beige); margin-top: 1rem; font-style: italic;">
            *Ketuk foto untuk memperbesar tampilan
        </p>
    </section>
    @endif


    <!-- ========================================================================= -->
    <!-- 8. FORMULIR RSVP (Konfirmasi Kehadiran) -->
    <!-- ========================================================================= -->
    <section id="rsvpSection" style="padding: 3.5rem 1.25rem; background: var(--c-mahogany); position: relative; text-align: center;">
        
        <div style="margin-bottom: 2rem;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Konfirmasi Rawuh
            </span>
            <h2 class="font-serif gold-gradient-text" style="font-size: 2rem; margin-top: 0.25rem;">
                Reservasi Kehadiran
            </h2>
            <p style="font-size: 0.85rem; color: var(--c-beige); max-width: 380px; margin: 0.5rem auto 0;">
                Mugi panjenengan kepareng maringi konfirmasi rawuh supados adicara lumampah kanthi sae.
            </p>
        </div>

        <div class="glass-card" style="padding: 2rem 1.5rem; max-width: 440px; margin: 0 auto; text-align: left; border-color: rgba(198, 161, 91, 0.45);">
            <form id="rsvpForm" onsubmit="submitRsvp(event)">
                <input type="hidden" name="token" value="{{ $guest->token ?? '' }}">

                <!-- Guest Name Input -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--c-gold-light); margin-bottom: 0.4rem;">
                        <i class="fa-solid fa-user" style="margin-right: 6px;"></i> Asma Jangkep (Nama Lengkap) *
                    </label>
                    <input type="text" name="guest_name" required value="{{ $guestName ?? '' }}" placeholder="Contoh: Raden Bagus Joko Widodo" style="width: 100%; padding: 0.8rem 1rem; border-radius: 10px; background: rgba(0,0,0,0.4); border: 1px solid rgba(198,161,91,0.4); color: #ffffff; font-size: 0.9rem; outline: none;">
                </div>

                <!-- RSVP Status Radio Buttons -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--c-gold-light); margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-circle-question" style="margin-right: 6px;"></i> Konfirmasi Kehadiran *
                    </label>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.3); padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(198,161,91,0.25); cursor: pointer;">
                            <input type="radio" name="status" value="hadir" required checked style="accent-color: var(--c-gold);">
                            <span style="font-size: 0.85rem; color: #FFF1D0; font-weight: 600;">
                                <i class="fa-solid fa-circle-check" style="color: #68D391; margin-right: 4px;"></i> Inggih, Kulo Badhe Rawuh (Pasti Hadir)
                            </span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.3); padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(198,161,91,0.25); cursor: pointer;">
                            <input type="radio" name="status" value="tidak_hadir" style="accent-color: var(--c-gold);">
                            <span style="font-size: 0.85rem; color: #FEB2B2;">
                                <i class="fa-solid fa-circle-xmark" style="color: #FC8181; margin-right: 4px;"></i> Nyuwun Pangapunten, Mboten Saged Rawuh
                            </span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; background: rgba(0,0,0,0.3); padding: 10px 14px; border-radius: 8px; border: 1px solid rgba(198,161,91,0.25); cursor: pointer;">
                            <input type="radio" name="status" value="ragu" style="accent-color: var(--c-gold);">
                            <span style="font-size: 0.85rem; color: var(--c-beige);">
                                <i class="fa-solid fa-clock" style="color: #F6E05E; margin-right: 4px;"></i> Taksih Ragu (Belum Pasti)
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Number of Attendees -->
                <div id="attendeeCountGroup" style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--c-gold-light); margin-bottom: 0.4rem;">
                        <i class="fa-solid fa-users" style="margin-right: 6px;"></i> Cacahing Tamu (Jumlah Orang Hadir)
                    </label>
                    <select name="attendee_count" style="width: 100%; padding: 0.8rem 1rem; border-radius: 10px; background: rgba(30,15,10,0.9); border: 1px solid rgba(198,161,91,0.4); color: #ffffff; font-size: 0.9rem; outline: none;">
                        <option value="1">1 Orang</option>
                        <option value="2" selected>2 Orang</option>
                        <option value="3">3 Orang</option>
                        <option value="4">4 Orang</option>
                    </select>
                </div>

                <!-- WhatsApp / Phone -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--c-gold-light); margin-bottom: 0.4rem;">
                        <i class="fa-brands fa-whatsapp" style="margin-right: 6px;"></i> Nomer WhatsApp (Opsional)
                    </label>
                    <input type="tel" name="phone" value="{{ $guest->phone ?? '' }}" placeholder="Contoh: 081234567890" style="width: 100%; padding: 0.8rem 1rem; border-radius: 10px; background: rgba(0,0,0,0.4); border: 1px solid rgba(198,161,91,0.4); color: #ffffff; font-size: 0.9rem; outline: none;">
                </div>

                <!-- Message / Notes -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--c-gold-light); margin-bottom: 0.4rem;">
                        <i class="fa-solid fa-message" style="margin-right: 6px;"></i> Donga Pangestu / Catatan Kagem Penganten
                    </label>
                    <textarea name="notes" rows="3" placeholder="Tuliskan ucapan selamat atau doa restu..." style="width: 100%; padding: 0.8rem 1rem; border-radius: 10px; background: rgba(0,0,0,0.4); border: 1px solid rgba(198,161,91,0.4); color: #ffffff; font-size: 0.9rem; outline: none; resize: vertical;"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="rsvpSubmitBtn" class="btn-gold" style="width: 100%; padding: 0.9rem;">
                    <i class="fa-solid fa-paper-plane"></i> KIRIM KONFIRMASI
                </button>
            </form>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 9. BUKU TAMU & DOA RESTU (Donga Pangestu Guestbook) -->
    <!-- ========================================================================= -->
    <section id="wishesSection" style="padding: 3.5rem 1.25rem; background: var(--c-brown); position: relative; text-align: center;">
        
        <div class="ornament-divider">
            <span class="line"></span>
            <img src="{{ asset('assets/images/ornaments/wayang.svg') }}" alt="Wayang">
            <span class="line"></span>
        </div>

        <div style="margin-bottom: 2rem;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Donga Pangestu
            </span>
            <h2 class="font-serif gold-gradient-text" style="font-size: 2rem; margin-top: 0.25rem;">
                Ucapan &amp; Doa Restu
            </h2>
            <p style="font-size: 0.85rem; color: var(--c-beige); margin-top: 0.25rem;">
                Untaian doa restu tulus saking para sedherek lan kanca kinasih
            </p>
        </div>

        <!-- Quick Wish Input Box -->
        <div class="glass-card" style="padding: 1.5rem; max-width: 440px; margin: 0 auto 2rem; text-align: left; border-color: rgba(198,161,91,0.35);">
            <form id="wishForm" onsubmit="submitWish(event)">
                <input type="hidden" name="token" value="{{ $guest->token ?? '' }}">

                <div style="margin-bottom: 0.85rem;">
                    <input type="text" name="name" required value="{{ $guestName ?? '' }}" placeholder="Nama Lengkap Anda..." style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; background: rgba(0,0,0,0.4); border: 1px solid rgba(198,161,91,0.4); color: #ffffff; font-size: 0.85rem; outline: none;">
                </div>

                <div style="margin-bottom: 0.85rem;">
                    <textarea name="message" required rows="3" placeholder="Tuliskan untaian doa restu panjenengan..." style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; background: rgba(0,0,0,0.4); border: 1px solid rgba(198,161,91,0.4); color: #ffffff; font-size: 0.85rem; outline: none; resize: vertical;"></textarea>
                </div>

                <button type="submit" id="wishSubmitBtn" class="btn-gold" style="width: 100%; padding: 0.75rem; font-size: 0.85rem;">
                    <i class="fa-solid fa-feather-pointed"></i> KIRIM DOA RESTU
                </button>
            </form>
        </div>

        <!-- Wishes List Stream -->
        <div id="wishesList" style="max-width: 440px; margin: 0 auto; display: flex; flex-direction: column; gap: 12px; text-align: left;">
            @foreach($wishes as $w)
                <div class="glass-card" style="padding: 1.15rem 1.25rem; border-color: rgba(198, 161, 91, 0.25);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.4rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 700; color: #FFF1D0;">
                            {{ $w->name }}
                        </h4>
                        <span style="font-size: 0.7rem; color: rgba(248, 241, 229, 0.6);">
                            {{ $w->created_at->diffForHumans() }}
                        </span>
                    </div>

                    @if($w->attendance_status === 'hadir')
                        <span style="display: inline-block; background: rgba(72, 187, 120, 0.2); border: 1px solid rgba(72, 187, 120, 0.4); border-radius: 12px; padding: 1px 8px; font-size: 0.7rem; color: #9AE6B4; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-circle-check"></i> Hadir
                        </span>
                    @elseif($w->attendance_status === 'tidak_hadir')
                        <span style="display: inline-block; background: rgba(245, 101, 101, 0.2); border: 1px solid rgba(245, 101, 101, 0.4); border-radius: 12px; padding: 1px 8px; font-size: 0.7rem; color: #FEB2B2; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-circle-xmark"></i> Berhalangan
                        </span>
                    @endif

                    <p style="font-size: 0.85rem; color: var(--c-ivory); line-height: 1.5; white-space: pre-line;">
                        {{ $w->message }}
                    </p>
                </div>
            @endforeach
        </div>

        <!-- Load More Button -->
        @if($wishesCount > 12)
            <button id="loadMoreWishesBtn" onclick="loadMoreWishes()" class="btn-outline-gold" style="margin-top: 1.5rem;">
                <i class="fa-solid fa-rotate-right"></i> Muat Lebih Banyak Doa
            </button>
        @endif
    </section>


    <!-- ========================================================================= -->
    <!-- 10. TANDA KASIH / AMPLOP DIGITAL (Kado Pernikahan Digital & Fisik) -->
    <!-- ========================================================================= -->
    @if(count($gifts) > 0)
    <section id="giftSection" style="padding: 3.5rem 1.25rem; background: var(--c-mahogany); position: relative; text-align: center;">
        
        <div style="margin-bottom: 2rem;">
            <span style="font-size: 0.8rem; letter-spacing: 3px; text-transform: uppercase; color: var(--c-gold-light); font-family: var(--font-display);">
                Tanda Asih
            </span>
            <h2 class="font-serif gold-gradient-text" style="font-size: 2rem; margin-top: 0.25rem;">
                Amplop Digital &amp; Kado
            </h2>
            <p style="font-size: 0.85rem; color: var(--c-beige); max-width: 380px; margin: 0.5rem auto 0;">
                Donga pangestu panjenengan minangka kado ingkang paling aji. Nanging bilih panjenengan kersa maringi tandha katresnan, keparenga ngaturaken lumantar rekening ing ngandhap menika:
            </p>
        </div>

        @foreach($gifts as $gift)
            <div class="glass-card" style="padding: 1.75rem 1.5rem; max-width: 420px; margin: 0 auto 1.5rem; border-color: rgba(198, 161, 91, 0.4); text-align: center;">
                
                <h4 style="font-size: 1.1rem; color: var(--c-gold-light); font-weight: 700; margin-bottom: 0.25rem;">
                    {{ $gift->bank_name }}
                </h4>

                @if($gift->qr_code_image)
                    <div style="width: 160px; height: 160px; margin: 1rem auto; padding: 8px; background: #ffffff; border-radius: 12px; border: 2px solid var(--c-gold);">
                        <img src="{{ asset('assets/images/ornaments/qris-bca.svg') }}" alt="QRIS {{ $gift->bank_name }}" style="width: 100%; height: 100%; object-fit: contain;">
                    </div>
                @endif

                <p style="font-size: 0.85rem; color: var(--c-beige); margin-bottom: 0.25rem;">
                    Nomor Rekening:
                </p>
                <div style="background: rgba(0,0,0,0.4); border: 1px solid rgba(198,161,91,0.3); border-radius: 10px; padding: 10px; margin-bottom: 0.75rem;">
                    <span id="accNum_{{ $gift->id }}" class="font-serif" style="font-size: 1.3rem; letter-spacing: 2px; color: #FFF1D0; font-weight: 700;">
                        {{ $gift->account_number }}
                    </span>
                </div>
                <p style="font-size: 0.85rem; color: var(--c-ivory); margin-bottom: 1.25rem;">
                    a.n. <strong>{{ $gift->account_holder }}</strong>
                </p>

                <button onclick="copyToClipboard('{{ $gift->account_number }}', 'Nomor rekening {{ $gift->bank_name }} berhasil disalin!')" class="btn-gold" style="font-size: 0.85rem; padding: 0.7rem 1.5rem; width: 100%;">
                    <i class="fa-solid fa-copy"></i> Salin Nomor Rekening
                </button>
            </div>
        @endforeach

        <!-- Kirim Kado Fisik Address -->
        @if(!empty($gifts[0]->gift_address))
            <div class="glass-card" style="padding: 1.5rem; max-width: 420px; margin: 1.5rem auto 0; border-color: rgba(198, 161, 91, 0.35); text-align: center;">
                <i class="fa-solid fa-box-open" style="font-size: 1.6rem; color: var(--c-gold-light); margin-bottom: 0.5rem; display: block;"></i>
                <h4 style="font-size: 1.05rem; color: #FFF1D0; font-weight: 600; margin-bottom: 0.4rem;">
                    Kirim Kado Fisik
                </h4>
                <p style="font-size: 0.85rem; color: var(--c-beige); line-height: 1.6; margin-bottom: 1rem;">
                    {{ $gifts[0]->gift_address }}<br>
                    Penerima: <strong>{{ $gifts[0]->recipient_name ?? 'Arya & Sekar' }}</strong> ({{ $gifts[0]->recipient_phone ?? '081234567890' }})
                </p>
                <button onclick="copyToClipboard('{{ addslashes($gifts[0]->gift_address) }}', 'Alamat pengiriman kado berhasil disalin!')" class="btn-outline-gold" style="font-size: 0.8rem; padding: 0.65rem 1.4rem;">
                    <i class="fa-solid fa-copy"></i> Salin Alamat Kado
                </button>
            </div>
        @endif
    </section>
    @endif


    <!-- ========================================================================= -->
    <!-- 11. UNGGAH-UNGGUH & PROTOKOL ADAT JAWA -->
    <!-- ========================================================================= -->
    <section style="padding: 3rem 1.25rem; background: var(--c-brown); text-align: center; border-top: 1px solid rgba(198,161,91,0.2);">
        <div style="max-width: 420px; margin: 0 auto;">
            <h4 class="font-serif gold-gradient-text" style="font-size: 1.25rem; margin-bottom: 1rem;">
                Tata Krama &amp; Tata Busana
            </h4>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 1.5rem;">
                <div style="background: rgba(0,0,0,0.25); border: 1px solid rgba(198,161,91,0.25); border-radius: 12px; padding: 12px;">
                    <i class="fa-solid fa-shirt" style="color: var(--c-gold-light); font-size: 1.4rem; margin-bottom: 6px; display: block;"></i>
                    <h5 style="font-size: 0.85rem; color: #FFF1D0; font-weight: 600; margin-bottom: 4px;">Busana</h5>
                    <p style="font-size: 0.75rem; color: var(--c-beige);">Batik Elegan / Busana Nasional Beradab</p>
                </div>
                <div style="background: rgba(0,0,0,0.25); border: 1px solid rgba(198,161,91,0.25); border-radius: 12px; padding: 12px;">
                    <i class="fa-solid fa-clock" style="color: var(--c-gold-light); font-size: 1.4rem; margin-bottom: 6px; display: block;"></i>
                    <h5 style="font-size: 0.85rem; color: #FFF1D0; font-weight: 600; margin-bottom: 4px;">Wanci Rawuh</h5>
                    <p style="font-size: 0.75rem; color: var(--c-beige);">Rawuh Pas Wektu / Tepat Waktu</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================================================= -->
    <!-- 12. PENUTUP & TANCEP KAYON (Closing Section) -->
    <!-- ========================================================================= -->
    <section style="padding: 4rem 1.25rem 6rem; background: var(--c-mahogany); position: relative; text-align: center; background-image: radial-gradient(circle at 50% 50%, rgba(198, 161, 91, 0.15) 0%, transparent 70%);">
        
        <!-- Closing Gunungan Kayon -->
        <div style="width: 120px; height: auto; margin: 0 auto 1.5rem;">
            <img src="{{ asset('assets/images/ornaments/gunungan.svg') }}" alt="Gunungan Wayang" style="width: 100%; height: auto; filter: drop-shadow(0 6px 16px rgba(198, 161, 91, 0.35));">
        </div>

        <p class="font-serif gold-gradient-text" style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.75rem;">
            Maturnuwun Sanget
        </p>

        <p style="font-size: 0.85rem; line-height: 1.7; color: var(--c-beige); max-width: 400px; margin: 0 auto 2rem;">
            {{ $wedding->closing_text ?? 'Maturnuwun sanget awit saking sih kawigatosan, rawuh, saha donga pangestu panjenengan sedaya. Mugi Gusti Ingkang Maha Asih tansah paring berkah lan karaharjan dumateng kito sedaya.' }}
        </p>

        <h3 class="font-serif" style="font-size: 1.8rem; color: #FFF1D0; font-weight: 700; margin-bottom: 0.5rem;">
            {{ $wedding->couple_short_names ?? 'Arya & Sekar' }}
        </h3>
        <p style="font-size: 0.85rem; color: var(--c-gold-light);">
            Beserta Seluruh Keluarga Besar
        </p>

        <div style="margin-top: 3.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(198,161,91,0.2); font-size: 0.75rem; color: rgba(248, 241, 229, 0.5);">
            <p>Digital Wedding Invitation Adat Jawa &bull; Keraton Ngayogyakarta</p>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    // -------------------------------------------------------------
    // Countdown Timer Engine
    // -------------------------------------------------------------
    const targetDateStr = "{{ $wedding->wedding_date ? $wedding->wedding_date->format('Y-m-d H:i:s') : '2026-11-28 08:00:00' }}";
    const targetDate = new Date(targetDateStr.replace(/-/g, "/")).getTime();

    function updateCountdown() {
        const now = new Date().getTime();
        const difference = targetDate - now;

        if (difference > 0) {
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((difference % (1000 * 60)) / 1000);

            document.getElementById('countdownDays').innerText = String(days).padStart(2, '0');
            document.getElementById('countdownHours').innerText = String(hours).padStart(2, '0');
            document.getElementById('countdownMinutes').innerText = String(minutes).padStart(2, '0');
            document.getElementById('countdownSeconds').innerText = String(seconds).padStart(2, '0');
        } else {
            document.getElementById('countdownDays').innerText = "00";
            document.getElementById('countdownHours').innerText = "00";
            document.getElementById('countdownMinutes').innerText = "00";
            document.getElementById('countdownSeconds').innerText = "00";
        }
    }
    setInterval(updateCountdown, 1000);
    updateCountdown();

    // -------------------------------------------------------------
    // RSVP AJAX Submission
    // -------------------------------------------------------------
    function submitRsvp(e) {
        e.preventDefault();
        const form = document.getElementById('rsvpForm');
        const submitBtn = document.getElementById('rsvpSubmitBtn');
        const formData = new FormData(form);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Ngirim Konfirmasi...';

        fetch("{{ route('invitation.rsvp') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> KIRIM KONFIRMASI';

            if (data.success) {
                showToast(data.message, 5000);
                form.reset();
            } else {
                showToast(data.message || 'Gagal mengirim konfirmasi. Silakan coba lagi.');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> KIRIM KONFIRMASI';
            showToast('Terjadi kendala jaringan. Silakan periksa koneksi Anda.');
        });
    }

    // -------------------------------------------------------------
    // Wishes AJAX Submission
    // -------------------------------------------------------------
    function submitWish(e) {
        e.preventDefault();
        const form = document.getElementById('wishForm');
        const submitBtn = document.getElementById('wishSubmitBtn');
        const formData = new FormData(form);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Ngaturaken Doa...';

        fetch("{{ route('invitation.wish') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-feather-pointed"></i> KIRIM DOA RESTU';

            if (data.success) {
                showToast(data.message, 4500);
                form.reset();

                // If approved immediately, prepend to wishes list
                if (data.is_approved && data.wish) {
                    const list = document.getElementById('wishesList');
                    const card = document.createElement('div');
                    card.className = 'glass-card';
                    card.style.cssText = 'padding: 1.15rem 1.25rem; border-color: rgba(198, 161, 91, 0.4); animation: fadeIn 0.5s ease;';
                    card.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.4rem;">
                            <h4 style="font-size: 0.95rem; font-weight: 700; color: #FFF1D0;">${data.wish.name}</h4>
                            <span style="font-size: 0.7rem; color: rgba(248, 241, 229, 0.6);">${data.wish.time_ago}</span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--c-ivory); line-height: 1.5; white-space: pre-line;">${data.wish.message}</p>
                    `;
                    list.prepend(card);
                }
            } else {
                showToast(data.message || 'Gagal mengirim doa.');
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fa-solid fa-feather-pointed"></i> KIRIM DOA RESTU';
            showToast('Terjadi kendala jaringan.');
        });
    }

    // -------------------------------------------------------------
    // Wishes Load More AJAX
    // -------------------------------------------------------------
    let wishesOffset = 12;
    function loadMoreWishes() {
        const btn = document.getElementById('loadMoreWishesBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memuat...';

        fetch(`{{ route('invitation.wishes') }}?offset=${wishesOffset}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-rotate-right"></i> Muat Lebih Banyak Doa';

            if (data.success && data.wishes.length > 0) {
                const list = document.getElementById('wishesList');
                data.wishes.forEach(w => {
                    const card = document.createElement('div');
                    card.className = 'glass-card';
                    card.style.cssText = 'padding: 1.15rem 1.25rem; border-color: rgba(198, 161, 91, 0.25);';
                    card.innerHTML = `
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.4rem;">
                            <h4 style="font-size: 0.95rem; font-weight: 700; color: #FFF1D0;">${w.name}</h4>
                            <span style="font-size: 0.7rem; color: rgba(248, 241, 229, 0.6);">${w.time_ago}</span>
                        </div>
                        <p style="font-size: 0.85rem; color: var(--c-ivory); line-height: 1.5; white-space: pre-line;">${w.message}</p>
                    `;
                    list.appendChild(card);
                });
                wishesOffset += data.wishes.length;

                if (!data.has_more) {
                    btn.style.display = 'none';
                }
            } else {
                btn.style.display = 'none';
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-rotate-right"></i> Muat Lebih Banyak Doa';
        });
    }
</script>
@endpush
