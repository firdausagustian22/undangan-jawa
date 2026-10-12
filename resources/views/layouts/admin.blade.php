<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - Pawiwahan Ageng Adat Jawa</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700&family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- HTML5 QR Code Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        :root {
            --c-dark-bg: #1A0E0A;
            --c-sidebar: #24140D;
            --c-card: #2F1B14;
            --c-card-light: #3A231A;
            --c-gold: #C6A15B;
            --c-gold-light: #EEDAA2;
            --c-gold-hover: #D4AF37;
            --c-ivory: #F8F1E5;
            --c-beige: #E8D8BD;
            --c-border: rgba(198, 161, 91, 0.25);
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --font-serif: 'Playfair Display', serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--c-dark-bg);
            color: var(--c-ivory);
            min-height: 100vh;
            display: flex;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 270px;
            background: var(--c-sidebar);
            border-right: 1px solid var(--c-border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--c-border);
            background: rgba(0,0,0,0.15);
        }
        .sidebar-brand img {
            width: 36px;
            height: auto;
        }
        .sidebar-brand h2 {
            font-family: var(--font-serif);
            font-size: 1.1rem;
            color: var(--c-gold-light);
            line-height: 1.2;
        }
        .sidebar-brand span {
            font-size: 0.75rem;
            color: var(--c-beige);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 1.25rem 0.75rem;
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu-header {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(232, 216, 189, 0.5);
            padding: 0.75rem 0.75rem 0.25rem;
            font-weight: 700;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.75rem 1rem;
            border-radius: 10px;
            color: var(--c-beige);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .sidebar-menu a i {
            font-size: 1.05rem;
            width: 22px;
            text-align: center;
            color: var(--c-gold);
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(198, 161, 91, 0.15);
            color: #ffffff;
            border: 1px solid rgba(198, 161, 91, 0.3);
        }
        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(198, 161, 91, 0.25) 0%, rgba(198, 161, 91, 0.1) 100%);
            border-left: 3px solid var(--c-gold);
            color: #FFF1D0;
            font-weight: 600;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--c-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(0,0,0,0.2);
        }

        /* Main Content Layout */
        .admin-main {
            margin-left: 270px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--c-dark-bg);
            background-image: radial-gradient(circle at 90% 10%, rgba(198, 161, 91, 0.08) 0%, transparent 60%);
        }

        .admin-header {
            height: 70px;
            background: var(--c-sidebar);
            border-bottom: 1px solid var(--c-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .admin-content {
            padding: 2rem;
            flex: 1;
        }

        /* Reusable UI Components */
        .stat-card {
            background: var(--c-card);
            border: 1px solid var(--c-border);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            position: relative;
            overflow: hidden;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            border-color: rgba(198, 161, 91, 0.5);
        }
        .stat-card .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            background: rgba(198, 161, 91, 0.15);
            color: var(--c-gold-light);
            border: 1px solid rgba(198, 161, 91, 0.3);
        }

        .panel-card {
            background: var(--c-card);
            border: 1px solid var(--c-border);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            margin-bottom: 1.5rem;
        }

        /* Buttons */
        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #E5C378 0%, #C6A15B 100%);
            color: #2F1B14;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            border: 1px solid #FFF1D0;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, #FFF1D0 0%, #D4AF37 100%);
            transform: translateY(-1px);
            color: #1b0e0a;
        }

        .btn-outline-gold {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--c-gold-light);
            font-weight: 500;
            font-size: 0.85rem;
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            border: 1px solid var(--c-border);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-outline-gold:hover {
            background: rgba(198, 161, 91, 0.15);
            border-color: var(--c-gold-light);
            color: #ffffff;
        }

        .btn-danger-outline {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: transparent;
            color: #FC8181;
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid rgba(252, 129, 129, 0.4);
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-danger-outline:hover {
            background: rgba(252, 129, 129, 0.15);
        }

        /* Form Inputs */
        .form-input, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(20, 10, 6, 0.7);
            border: 1px solid var(--c-border);
            border-radius: 8px;
            color: #ffffff;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s ease;
        }
        .form-input:focus, .form-select:focus {
            border-color: var(--c-gold-light);
            box-shadow: 0 0 0 2px rgba(198, 161, 91, 0.2);
        }

        /* Data Tables */
        .data-table-container {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--c-border);
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.875rem;
        }
        .data-table th {
            background: rgba(0,0,0,0.3);
            color: var(--c-gold-light);
            padding: 1rem 1.25rem;
            font-weight: 600;
            border-bottom: 1px solid var(--c-border);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .data-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(198, 161, 91, 0.12);
            color: var(--c-ivory);
        }
        .data-table tr:hover td {
            background: rgba(198, 161, 91, 0.05);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success { background: rgba(72, 187, 120, 0.2); color: #9AE6B4; border: 1px solid rgba(72, 187, 120, 0.4); }
        .badge-danger { background: rgba(245, 101, 101, 0.2); color: #FEB2B2; border: 1px solid rgba(245, 101, 101, 0.4); }
        .badge-warning { background: rgba(236, 201, 75, 0.2); color: #FAF089; border: 1px solid rgba(236, 201, 75, 0.4); }
        .badge-info { background: rgba(99, 179, 237, 0.2); color: #BEE3F8; border: 1px solid rgba(99, 179, 237, 0.4); }

        /* Modal Structure */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 1000;
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }
        .modal-box {
            background: var(--c-card);
            border: 1px solid var(--c-gold);
            border-radius: 16px;
            max-width: 520px;
            width: 100%;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6);
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
            }
            .mobile-menu-btn {
                display: block !important;
            }
        }
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--c-gold-light);
            font-size: 1.4rem;
            cursor: pointer;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Admin Sidebar -->
    <aside id="adminSidebar" class="admin-sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('assets/images/ornaments/gunungan.svg') }}" alt="Gunungan">
            <div>
                <h2>PAWIWAHAN</h2>
                <span>Kanjeng Panel Admin</span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Menu Utama</li>
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Ringkasan Statistik
                </a>
            </li>
            <li>
                <a href="{{ route('admin.checkin.index') }}" class="{{ request()->routeIs('admin.checkin.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-qrcode"></i> Check-in Tamu (Hari-H)
                </a>
            </li>

            <li class="menu-header">Manajemen Undangan</li>
            <li>
                <a href="{{ route('admin.guests.index') }}" class="{{ request()->routeIs('admin.guests.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-address-book"></i> Daftar Tamu Undangan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.rsvps.index') }}" class="{{ request()->routeIs('admin.rsvps.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope-circle-check"></i> Konfirmasi RSVP
                </a>
            </li>
            <li>
                <a href="{{ route('admin.wishes.index') }}" class="{{ request()->routeIs('admin.wishes.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-comments"></i> Moderasi Doa Restu
                </a>
            </li>

            <li class="menu-header">Konfigurasi</li>
            <li>
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-sliders"></i> Pengaturan Konten
                </a>
            </li>
            <li>
                <a href="{{ route('admin.audit.index') }}" class="{{ request()->routeIs('admin.audit.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-shield-halved"></i> Log Aktivitas Keamanan
                </a>
            </li>

            <li class="menu-header">Tautan Cepat</li>
            <li>
                <a href="{{ url('/') }}" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Undangan Web
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--c-gold); color: #2F1B14; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div style="font-size: 0.8rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 130px;">
                    <div style="font-weight: 600; color: #FFF1D0;">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div style="font-size: 0.7rem; color: var(--c-beige);">Panitiya Pawiwahan</div>
                </div>
            </div>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" title="Keluar Sistem" style="background: none; border: none; color: #FC8181; cursor: pointer; font-size: 1rem; padding: 4px;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <!-- Top Header Bar -->
        <header class="admin-header">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="mobile-menu-btn" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h3 style="font-size: 1.15rem; font-weight: 600; color: #FFF1D0;">
                    @yield('page_title', 'Dashboard')
                </h3>
            </div>

            <div style="display: flex; align-items: center; gap: 1rem;">
                <a href="{{ url('/') }}" target="_blank" class="btn-outline-gold" style="font-size: 0.8rem; padding: 6px 14px;">
                    <i class="fa-solid fa-eye"></i> Pratinjau Undangan
                </a>
            </div>
        </header>

        <!-- Main Workspace -->
        <main class="admin-content">
            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div style="background: rgba(72, 187, 120, 0.2); border: 1px solid rgba(72, 187, 120, 0.5); color: #9AE6B4; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div style="background: rgba(99, 179, 237, 0.2); border: 1px solid rgba(99, 179, 237, 0.5); color: #BEE3F8; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-info" style="font-size: 1.2rem;"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div style="background: rgba(245, 101, 101, 0.2); border: 1px solid rgba(245, 101, 101, 0.5); color: #FEB2B2; padding: 1rem 1.25rem; border-radius: 10px; margin-bottom: 1.5rem;">
                    <div style="font-weight: 600; margin-bottom: 4px;">Terjadi kesalahan pengisian form:</div>
                    <ul style="margin-left: 20px; font-size: 0.85rem;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('adminSidebar').classList.toggle('open');
        }

        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }
    </script>

    @stack('scripts')
</body>
</html>
