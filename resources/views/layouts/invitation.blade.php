<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $wedding->title ?? 'Pawiwahan Pernikahan Adat Jawa' }}</title>
    <meta name="description" content="Pawiwahan Ageng Pernikahan Adat Jawa {{ $wedding->couple_short_names ?? 'Arya & Sekar' }}. Kanthi hangajab berkah lan pangestu panjenengan sedaya.">
    <meta name="keywords" content="undangan pernikahan, adat jawa, wedding invitation, pawiwahan ageng, yogyakarta, surakarta">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $wedding->title ?? 'Pawiwahan Pernikahan Adat Jawa' }}">
    <meta property="og:description" content="Pawiwahan Ageng {{ $wedding->couple_short_names ?? 'Arya & Sekar' }}. Undangan Digital Pernikahan Tradisional Adat Jawa.">
    <meta property="og:image" content="{{ asset('assets/images/couple/hero.jpg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --c-mahogany: #2F1B14;
            --c-brown: #4A2C20;
            --c-gold: #C6A15B;
            --c-gold-light: #EEDAA2;
            --c-gold-dark: #8C6826;
            --c-ivory: #F8F1E5;
            --c-beige: #E8D8BD;
            --c-sage: #7C8560;
            --c-sage-dark: #555D3D;
            --font-display: 'Cinzel Decorative', serif;
            --font-serif: 'Playfair Display', serif;
            --font-script: 'Great Vibes', cursive;
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --shadow-gold: 0 10px 30px rgba(198, 161, 91, 0.25);
            --shadow-card: 0 15px 35px rgba(47, 27, 20, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--c-mahogany);
            color: var(--c-ivory);
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(198, 161, 91, 0.12) 0%, transparent 60%),
                url("{{ asset('assets/images/ornaments/batik-pattern.svg') }}");
            background-repeat: repeat;
            background-size: 140px 140px;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--c-mahogany);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--c-gold);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--c-gold-light);
        }

        /* Container Limit for High-end Aesthetic Presentation */
        .invitation-container {
            max-width: 500px;
            margin: 0 auto;
            min-height: 100vh;
            background-color: var(--c-mahogany);
            position: relative;
            box-shadow: 0 0 70px rgba(0, 0, 0, 0.7);
            border-left: 1px solid rgba(198, 161, 91, 0.2);
            border-right: 1px solid rgba(198, 161, 91, 0.2);
            overflow: hidden;
        }

        @media (min-width: 992px) {
            .desktop-backdrop {
                display: flex;
                min-height: 100vh;
                background: linear-gradient(135deg, #1b0e0a 0%, #2F1B14 50%, #150a06 100%);
                position: relative;
            }
            .desktop-side-banner {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 4rem 2rem;
                text-align: center;
                color: var(--c-ivory);
                position: relative;
                background-image: url("{{ asset('assets/images/ornaments/batik-pattern.svg') }}");
                background-size: 160px;
                border-right: 1px solid rgba(198, 161, 91, 0.15);
            }
            .desktop-side-banner::before {
                content: '';
                position: absolute;
                inset: 0;
                background: radial-gradient(circle at center, rgba(198, 161, 91, 0.15), transparent 70%);
            }
            .desktop-side-banner > * {
                position: relative;
                z-index: 2;
            }
            .invitation-container {
                width: 480px;
                margin: 0;
                flex-shrink: 0;
                box-shadow: -10px 0 40px rgba(0,0,0,0.5);
            }
        }

        @media (max-width: 991px) {
            .desktop-side-banner {
                display: none !important;
            }
        }

        /* Typography Helper Classes */
        .font-display { font-family: var(--font-display); }
        .font-serif { font-family: var(--font-serif); }
        .font-script { font-family: var(--font-script); }
        
        .gold-gradient-text {
            background: linear-gradient(135deg, #FFF1D0 0%, #C6A15B 50%, #9D7B38 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gold-border {
            border: 1px solid rgba(198, 161, 91, 0.35);
        }
        .gold-border-double {
            border: 3px double rgba(198, 161, 91, 0.6);
        }

        /* Glassmorphism Card */
        .glass-card {
            background: rgba(47, 27, 20, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(198, 161, 91, 0.3);
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        }

        .glass-card-light {
            background: rgba(248, 241, 229, 0.95);
            color: var(--c-mahogany);
            border: 1px solid rgba(198, 161, 91, 0.4);
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
        }

        /* Golden Button */
        .btn-gold {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #E5C378 0%, #C6A15B 50%, #9D7732 100%);
            color: #2F1B14;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.85rem 1.8rem;
            border-radius: 50px;
            border: 1px solid #FFF1D0;
            box-shadow: 0 6px 20px rgba(198, 161, 91, 0.35);
            cursor: pointer;
            transition: all 0.35s ease;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-gold:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 10px 25px rgba(198, 161, 91, 0.5);
            background: linear-gradient(135deg, #FFF1D0 0%, #D4AF37 50%, #AA8232 100%);
            color: #1b0e0a;
        }

        .btn-outline-gold {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: transparent;
            color: var(--c-gold-light);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.65rem 1.4rem;
            border-radius: 50px;
            border: 1px solid rgba(198, 161, 91, 0.6);
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-outline-gold:hover {
            background: rgba(198, 161, 91, 0.2);
            border-color: var(--c-gold-light);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* Section Ornament Divider */
        .ornament-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
            opacity: 0.85;
        }
        .ornament-divider .line {
            height: 1px;
            flex: 1;
            background: linear-gradient(90deg, transparent, rgba(198, 161, 91, 0.7), transparent);
        }
        .ornament-divider img {
            width: 32px;
            height: auto;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));
        }

        /* Falling Jasmine Petals Effect */
        #petal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 99;
            overflow: hidden;
        }
        .petal {
            position: absolute;
            background: radial-gradient(circle, #ffffff 60%, #E8E2D2 100%);
            border-radius: 80% 20% 70% 30% / 70% 30% 70% 30%;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
            opacity: 0.75;
            animation: fall linear infinite;
        }
        @keyframes fall {
            0% {
                transform: translateY(-20px) rotate(0deg) translateX(0);
                opacity: 0;
            }
            15% { opacity: 0.85; }
            90% { opacity: 0.75; }
            100% {
                transform: translateY(105vh) rotate(360deg) translateX(40px);
                opacity: 0;
            }
        }

        /* Floating Audio Control */
        .floating-audio-btn {
            position: fixed;
            bottom: 24px;
            left: 24px;
            z-index: 998;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #C6A15B 0%, #4A2C20 100%);
            border: 2px solid #FFF1D0;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.6), 0 0 12px rgba(198, 161, 91, 0.5);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .floating-audio-btn.spinning {
            animation: rotateDisk 4s linear infinite;
        }
        @keyframes rotateDisk {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .floating-audio-btn:hover {
            transform: scale(1.1);
        }

        /* Floating Bottom Quick Navigation for Invitation */
        .bottom-nav {
            position: fixed;
            bottom: 16px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 997;
            background: rgba(35, 18, 12, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(198, 161, 91, 0.4);
            border-radius: 40px;
            padding: 6px 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            opacity: 0;
            pointer-events: none;
            transition: all 0.4s ease;
        }
        .bottom-nav.active {
            opacity: 1;
            pointer-events: auto;
        }
        .bottom-nav a {
            color: var(--c-ivory);
            font-size: 1rem;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .bottom-nav a:hover, .bottom-nav a.active {
            background: var(--c-gold);
            color: #2F1B14;
            transform: translateY(-2px);
        }

        /* Toast Feedback */
        .toast-popup {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            z-index: 10000;
            background: rgba(47, 27, 20, 0.95);
            border: 1px solid var(--c-gold);
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .toast-popup.show {
            transform: translateX(-50%) translateY(0);
        }

        /* Lightbox modal */
        .lightbox-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.92);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
            padding: 20px;
        }
        .lightbox-modal.active {
            opacity: 1;
            pointer-events: auto;
        }
        .lightbox-modal img {
            max-width: 95%;
            max-height: 85vh;
            border-radius: 12px;
            border: 2px solid var(--c-gold);
            box-shadow: 0 0 30px rgba(198, 161, 91, 0.4);
        }
        .lightbox-close {
            position: absolute;
            top: 24px;
            right: 24px;
            color: #ffffff;
            font-size: 2rem;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .lightbox-close:hover {
            color: var(--c-gold);
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Falling Petals Container -->
    <div id="petal-container"></div>

    <!-- Toast Notification -->
    <div id="toastNotification" class="toast-popup">
        <i class="fa-solid fa-circle-check text-warning" style="color: var(--c-gold-light);"></i>
        <span id="toastMessage">Pemberitahuan</span>
    </div>

    <!-- Lightbox Modal -->
    <div id="lightboxModal" class="lightbox-modal">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <img id="lightboxImg" src="" alt="Gallery Enlarge">
    </div>

    <!-- Floating Audio Control -->
    <button id="audioToggleBtn" class="floating-audio-btn" title="Musik Gamelan Pengantin" onclick="toggleAudio()">
        <i id="audioIcon" class="fa-solid fa-compact-disc"></i>
    </button>
    <!-- Background Audio Element -->
    <audio id="weddingAudio" loop preload="auto">
        <source src="{{ asset('assets/audio/gamelan-modern.mp3') }}" type="audio/mpeg">
    </audio>

    <!-- Floating Bottom Navigation -->
    <nav id="bottomNav" class="bottom-nav">
        <a href="#heroSection" title="Awal"><i class="fa-solid fa-home"></i></a>
        <a href="#coupleSection" title="Mempelai"><i class="fa-solid fa-heart"></i></a>
        <a href="#eventsSection" title="Acara"><i class="fa-solid fa-calendar-alt"></i></a>
        <a href="#storySection" title="Kisah"><i class="fa-solid fa-book-open"></i></a>
        <a href="#gallerySection" title="Galeri"><i class="fa-solid fa-images"></i></a>
        <a href="#rsvpSection" title="RSVP"><i class="fa-solid fa-envelope-open-text"></i></a>
        <a href="#wishesSection" title="Doa"><i class="fa-solid fa-comment-dots"></i></a>
        <a href="#giftSection" title="Kado"><i class="fa-solid fa-gift"></i></a>
    </nav>

    <!-- Main Content Wrapper with Desktop Dual Layout -->
    <div class="desktop-backdrop">
        <!-- Desktop Side Showcase Column -->
        <div class="desktop-side-banner">
            <div style="max-width: 480px;">
                <img src="{{ asset('assets/images/ornaments/gunungan.svg') }}" alt="Gunungan Wayang" style="width: 140px; margin-bottom: 2rem; filter: drop-shadow(0 8px 16px rgba(0,0,0,0.5));">
                <h4 class="font-display gold-gradient-text" style="font-size: 1.1rem; letter-spacing: 3px; margin-bottom: 0.5rem;">PAWIWAHAN AGENG</h4>
                <h1 class="font-serif" style="font-size: 2.5rem; line-height: 1.2; margin-bottom: 1rem; color: #FFF1D0;">
                    {{ $wedding->couple_short_names ?? 'Arya & Sekar' }}
                </h1>
                <p style="font-size: 0.95rem; color: var(--c-beige); margin-bottom: 2rem; font-style: italic;">
                    "{{ $wedding->javanese_quote ?? 'Memayu Hayuning Bawana, Manunggaling Cipta Rasa Karsa Menuju Bebrayan Agung.' }}"
                </p>
                <div style="padding: 1rem 1.5rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(198,161,91,0.3); border-radius: 12px; display: inline-block;">
                    <p style="font-size: 0.85rem; color: var(--c-gold-light); margin-bottom: 0.25rem;">
                        <i class="fa-solid fa-calendar-day" style="margin-right: 6px;"></i> 
                        {{ $wedding->wedding_date ? $wedding->wedding_date->translatedFormat('l, d F Y') : 'Sabtu, 28 November 2026' }}
                    </p>
                    <p style="font-size: 0.85rem; color: var(--c-ivory);">
                        <i class="fa-solid fa-location-dot" style="margin-right: 6px;"></i> Yogyakarta Hadiningrat
                    </p>
                </div>
                <div style="margin-top: 2.5rem; display: flex; justify-content: center; gap: 1rem;">
                    <span style="font-size: 0.8rem; color: rgba(248, 241, 229, 0.6); text-transform: uppercase; letter-spacing: 2px;">
                        Gagrak Ngayogyakarta &bull; Kasunanan Surakarta
                    </span>
                </div>
            </div>
        </div>

        <!-- The Invitation Mobile/App Stage -->
        <main class="invitation-container">
            @yield('content')
        </main>
    </div>

    <!-- Global Scripts -->
    <script>
        // CSRF Token Setup for Fetch/AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toast Helper
        function showToast(message, duration = 3500) {
            const toast = document.getElementById('toastNotification');
            const toastMsg = document.getElementById('toastMessage');
            toastMsg.textContent = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, duration);
        }

        // Falling Jasmine Petals Simulation
        function createPetals() {
            const container = document.getElementById('petal-container');
            const petalCount = 18;
            for (let i = 0; i < petalCount; i++) {
                const petal = document.createElement('div');
                petal.className = 'petal';
                const size = Math.random() * 8 + 8; // 8px - 16px
                petal.style.width = size + 'px';
                petal.style.height = (size * 1.4) + 'px';
                petal.style.left = Math.random() * 100 + 'vw';
                petal.style.animationDuration = (Math.random() * 7 + 6) + 's'; // 6s - 13s
                petal.style.animationDelay = (Math.random() * 5) + 's';
                container.appendChild(petal);
            }
        }
        window.addEventListener('DOMContentLoaded', createPetals);

        // Web Audio API Procedural Gamelan Synthesizer Fallback
        // Ensures traditional melodic bells chime even if local MP3 is blocked by browser autoplay policy
        let audioCtx = null;
        let isGamelanSynthesizing = false;
        let synthInterval = null;

        function playGamelanChime(freq, duration, gainVal = 0.15) {
            if (!audioCtx) {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                audioCtx = new AudioContext();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
            const osc = audioCtx.createOscillator();
            const gain = audioCtx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
            gain.gain.setValueAtTime(gainVal, audioCtx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.0001, audioCtx.currentTime + duration);
            osc.connect(gain);
            gain.connect(audioCtx.destination);
            osc.start();
            osc.stop(audioCtx.currentTime + duration);
        }

        function startJavaneseGamelanMelody() {
            if (synthInterval) clearInterval(synthInterval);
            // Pelog / Slendro scale notes (Hz)
            const notes = [293.66, 329.63, 369.99, 440.00, 493.88, 587.33, 659.25, 739.99];
            let step = 0;
            synthInterval = setInterval(() => {
                if (!isAudioPlaying) return;
                const note = notes[step % notes.length];
                playGamelanChime(note, 2.8, 0.08);
                if (step % 4 === 0) {
                    // Deep gong resonance
                    playGamelanChime(146.83, 4.5, 0.15);
                }
                step++;
            }, 1800);
        }

        // Background Audio Player Logic
        let isAudioPlaying = false;
        const audio = document.getElementById('weddingAudio');
        const audioBtn = document.getElementById('audioToggleBtn');
        const audioIcon = document.getElementById('audioIcon');

        function toggleAudio() {
            if (isAudioPlaying) {
                audio.pause();
                isAudioPlaying = false;
                audioBtn.classList.remove('spinning');
                audioIcon.className = 'fa-solid fa-volume-xmark';
                if (synthInterval) clearInterval(synthInterval);
            } else {
                audio.play().then(() => {
                    isAudioPlaying = true;
                    audioBtn.classList.add('spinning');
                    audioIcon.className = 'fa-solid fa-compact-disc';
                }).catch(() => {
                    // If audio file doesn't play or is blocked, engage procedural gamelan synth!
                    isAudioPlaying = true;
                    audioBtn.classList.add('spinning');
                    audioIcon.className = 'fa-solid fa-music';
                    startJavaneseGamelanMelody();
                });
            }
        }

        function openInvitation() {
            const cover = document.getElementById('openingCover');
            const bottomNav = document.getElementById('bottomNav');
            
            // Smoothly collapse cover curtain
            cover.style.transition = 'transform 0.9s cubic-bezier(0.77, 0, 0.175, 1), opacity 0.9s ease';
            cover.style.transform = 'translateY(-100%)';
            cover.style.opacity = '0';
            setTimeout(() => {
                cover.style.display = 'none';
                bottomNav.classList.add('active');
            }, 900);

            // Trigger music
            if (!isAudioPlaying) {
                toggleAudio();
            }

            // Scroll to hero
            const hero = document.getElementById('heroSection');
            if (hero) {
                hero.scrollIntoView({ behavior: 'smooth' });
            }
        }

        // Lightbox Functions
        function openLightbox(src) {
            const modal = document.getElementById('lightboxModal');
            const img = document.getElementById('lightboxImg');
            img.src = src;
            modal.classList.add('active');
        }
        function closeLightbox() {
            document.getElementById('lightboxModal').classList.remove('active');
        }

        // Copy to clipboard helper
        function copyToClipboard(text, successMsg = 'Nomor rekening berhasil disalin!') {
            navigator.clipboard.writeText(text).then(() => {
                showToast(successMsg);
            }).catch(() => {
                // Fallback for older browsers
                const tempInput = document.createElement('input');
                tempInput.value = text;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                showToast(successMsg);
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
