<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kasir Panel — Tho Cookies')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/thecookies.png') }}">

    {{-- CSS Libraries --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Script untuk mencegah flicker Sidebar saat load --}}
    <script>
        // Membaca state dari LocalStorage sebelum CSS di-render penuh
        if (localStorage.getItem('sidebar_state') === 'collapsed') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>

    <style>
        :root {
            /* Palette Gourmet Bakery (Tho Cookies Premium) */
            --primary: #F26522;
            /* Honey Orange */
            --primary-hover: #D84315;
            --brown-dark: #3E2723;
            /* Cokelat Tua Mewah */
            --brown-light: #5D4037;
            --cream-warm: #FAF0E6;
            /* Krem Hangat */
            --cream-light: #FFFDF9;
            --amber-gold: #FFB300;
            --white: #FFFFFF;

            /* Sidebar Dimensions */
            --sidebar-expanded: 260px;
            --sidebar-collapsed: 80px;
            --transition-speed: 0.4s;
        }

        /* ─── GLOBAL RESET & TYPOGRAPHY ─── */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream-light);
            color: var(--brown-dark);
            margin: 0;
            overflow: hidden;
            /* Dikontrol oleh Flexbox Shell */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* Scrollbar Mewah */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(93, 64, 55, 0.2);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* ─── FLEXBOX SHELL LAYOUT ─── */
        #app-layout {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
            background-image: radial-gradient(circle at top right, rgba(242, 101, 34, 0.03), transparent 40%),
                radial-gradient(circle at bottom left, rgba(255, 179, 0, 0.03), transparent 40%);
        }

        /* ─── SIDEBAR (KOLOM KIRI) ─── */
        #sidebar {
            width: var(--sidebar-expanded);
            height: 100%;
            background: linear-gradient(180deg, var(--brown-dark) 0%, #2A1A17 100%);
            display: flex;
            flex-direction: column;
            transition: width var(--transition-speed) cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 100;
            box-shadow: 4px 0 25px rgba(62, 39, 35, 0.15);
            flex-shrink: 0;
        }

        /* State: Collapsed */
        html.sidebar-collapsed #sidebar {
            width: var(--sidebar-collapsed);
        }

        /* Floating Toggle Button */
        .floating-toggle {
            position: absolute;
            top: 35px;
            right: -16px;
            /* Melayang di luar tepi */
            width: 32px;
            height: 32px;
            background: var(--primary);
            color: var(--white);
            border: 4px solid var(--cream-light);
            /* Menyesuaikan background main content */
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 101;
            box-shadow: 0 4px 10px rgba(242, 101, 34, 0.3);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .floating-toggle:hover {
            transform: scale(1.15);
            background: var(--amber-gold);
        }

        .floating-toggle i {
            font-size: 0.8rem;
            transition: transform var(--transition-speed);
        }

        /* Header Sidebar (Logo) */
        .sidebar-header {
            padding: 25px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            white-space: nowrap;
            overflow: hidden;
            height: 90px;
            transition: padding var(--transition-speed);
        }

        html.sidebar-collapsed .sidebar-header {
            padding: 25px 15px;
            justify-content: center;
        }

        .logo-img {
            width: 45px;
            height: 45px;
            flex-shrink: 0;
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
            transition: transform 0.3s;
        }

        .sidebar-header:hover .logo-img {
            transform: rotate(-10deg) scale(1.1);
        }

        .brand-text {
            color: var(--white);
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .brand-text span {
            color: var(--primary);
        }

        /* Menu Navigasi */
        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .menu-label {
            padding: 0 25px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: rgba(255, 255, 255, 0.4);
            margin: 15px 0 10px;
            font-weight: 600;
            white-space: nowrap;
            transition: opacity 0.3s, visibility 0.3s;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.6);
            padding: 15px 25px;
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            white-space: nowrap;
            border-left: 4px solid transparent;
        }

        .sidebar-link i {
            width: 25px;
            font-size: 1.2rem;
            text-align: center;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .menu-text {
            margin-left: 15px;
            transition: opacity 0.3s, visibility 0.3s;
        }

        /* Hover & Active States */
        .sidebar-link:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.03);
        }

        .sidebar-link:hover i {
            transform: translateX(4px);
            color: var(--amber-gold);
        }

        .sidebar-link.active {
            color: var(--white);
            background: linear-gradient(90deg, rgba(242, 101, 34, 0.15) 0%, transparent 100%);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .sidebar-link.active i {
            color: var(--primary);
            text-shadow: 0 0 15px rgba(242, 101, 34, 0.6);
        }

        /* Transisi Hilang Teks saat Collapsed */
        html.sidebar-collapsed .brand-text,
        html.sidebar-collapsed .menu-label,
        html.sidebar-collapsed .menu-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
            /* Ensures it doesn't take space */
            margin-left: 0;
        }

        html.sidebar-collapsed .sidebar-link {
            padding: 15px 0;
            justify-content: center;
        }

        html.sidebar-collapsed .sidebar-link i {
            margin: 0;
        }

        /* Sidebar Footer (Logout) */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(0, 0, 0, 0.15);
            white-space: nowrap;
            overflow: hidden;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #ff6b6b;
            border: 2px solid #ff6b6b;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-logout i {
            font-size: 1.1rem;
            transition: transform 0.3s;
        }

        .btn-logout .menu-text {
            margin-left: 10px;
        }

        .btn-logout:hover {
            background: #ff6b6b;
            color: white;
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
            transform: translateY(-2px);
        }

        html.sidebar-collapsed .sidebar-footer {
            padding: 20px 10px;
        }

        html.sidebar-collapsed .btn-logout {
            padding: 12px 0;
            border-color: transparent;
        }

        /* ─── MAIN CONTENT (KOLOM KANAN) ─── */
        #main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            /* Konten di dalam content-area yang scroll */
            position: relative;
        }

        /* Topbar / Header Melayang (Glassmorphism) */
        .topbar {
            background: rgba(255, 253, 249, 0.7);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(93, 64, 55, 0.06);
            padding: 15px 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 50;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            flex-shrink: 0;
        }

        .topbar-left {
            display: flex;
            flex-direction: column;
        }

        .page-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brown-dark);
            margin: 0;
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 0.85rem;
            color: var(--brown-light);
            opacity: 0.8;
            font-weight: 500;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Widget Jam Real-Time */
        .clock-widget {
            background: var(--white);
            border: 1px solid rgba(93, 64, 55, 0.08);
            border-radius: 50px;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(61, 39, 35, 0.04);
        }

        .clock-widget i {
            color: var(--primary);
            font-size: 1.2rem;
            animation: pulseIcon 2s infinite;
        }

        @keyframes pulseIcon {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
                color: var(--amber-gold);
            }
        }

        .clock-time {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--brown-dark);
            letter-spacing: 0.5px;
        }

        /* Profil Kasir */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            padding: 6px 20px 6px 6px;
            border-radius: 50px;
            border: 1px solid rgba(93, 64, 55, 0.08);
            box-shadow: 0 4px 15px rgba(61, 39, 35, 0.04);
            transition: all 0.3s;
            cursor: pointer;
        }

        .user-profile:hover {
            border-color: var(--primary);
            box-shadow: 0 6px 20px rgba(242, 101, 34, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--amber-gold));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            font-weight: 700;
            font-family: 'Fredoka', sans-serif;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }

        .user-name {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--brown-dark);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--primary);
            font-weight: 600;
        }

        /* Area Render Konten Dinamis */
        .content-area {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
            position: relative;
        }

        /* Animasi Transisi Halaman (SPA Feel) */
        .page-transition {
            animation: fadeInScale 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.98) translateY(15px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Responsif Tablet & Mobile */
        @media (max-width: 991px) {

            /* Sidebar otomatis sembunyi jika layar sempit */
            #sidebar {
                position: absolute;
                height: 100%;
                left: calc(var(--sidebar-expanded) * -1);
            }

            html.sidebar-collapsed #sidebar {
                left: calc(var(--sidebar-collapsed) * -1);
            }

            /* Jika ada tombol toggle eksternal untuk mobile (Opsional, bawaan flexbox) */
            .page-title {
                font-size: 1.2rem;
            }

            .content-area {
                padding: 20px 15px;
            }

            .clock-widget {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- ─── FLEXBOX LAYOUT SHELL ─── -->
    <div id="app-layout">

        <!-- ═══ SIDEBAR KIRI ═══ -->
        <aside id="sidebar">

            <!-- Tombol Toggle Melayang -->
            <div id="sidebar-toggle" class="floating-toggle" title="Kecilkan/Lebarkan Menu">
                <i class="fas fa-chevron-left" id="toggle-icon"></i>
            </div>

            <!-- Header & Logo -->
            <div class="sidebar-header">
                <img src="{{ asset('img/thecookies.png') }}" alt="Logo Tho Cookies" class="logo-img"
                    onerror="this.src='https://cdn-icons-png.flaticon.com/512/3014/3014401.png'">
                <div class="brand-text font-display">Tho <span>Cookies</span></div>
            </div>

            <!-- Navigasi Menu -->
            <nav class="sidebar-nav">
                <div class="menu-label">Pusat Kendali</div>

                <a href="{{ route('kasir.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}" title="Dashboard">
                    <i class="fas fa-home"></i>
                    <span class="menu-text">Dashboard</span>
                </a>

                <div class="menu-label">Meja Kasir</div>

                <a href="{{ route('kasir.transaction.create') }}"
                    class="sidebar-link {{ request()->routeIs('kasir.transaction.create') ? 'active' : '' }}"
                    title="Buat Transaksi">
                    <i class="fas fa-cash-register"></i>
                    <span class="menu-text">Buat Transaksi</span>
                </a>

                <a href="{{ route('kasir.pesanan.index') }}"
                    class="sidebar-link {{ request()->routeIs('kasir.pesanan.index') ? 'active' : '' }}"
                    title="Pesanan Masuk">
                    <i class="fas fa-concierge-bell"></i>
                    <span class="menu-text">Pesanan Masuk</span>
                </a>

                <a href="{{ route('kasir.laporan.index') }}"
                    class="sidebar-link {{ request()->routeIs('kasir.laporan.index') ? 'active' : '' }}"
                    title="Riwayat Laporan">
                    <i class="fas fa-receipt"></i>
                    <span class="menu-text">Riwayat Transaksi</span>
                </a>
            </nav>

            <!-- Footer & Logout -->
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout" title="Keluar Sistem">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="menu-text">Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ═══ AREA KONTEN UTAMA (KOLOM KANAN) ═══ -->
        <main id="main-content">

            <!-- Header Melayang (Glassmorphism Topbar) -->
            <header class="topbar">
                <div class="topbar-left">
                    <h1 class="page-title">@yield('title', 'Kasir Panel')</h1>
                    <span class="page-subtitle">Pusat Pelayanan Kasir Tho Cookies</span>
                </div>

                <div class="topbar-right">
                    <!-- Widget Jam Digital Real-Time -->
                    <div class="clock-widget" title="Waktu Aktif Sistem">
                        <i class="far fa-clock"></i>
                        <span class="clock-time" id="live-clock-kasir">00:00:00 WIB</span>
                    </div>

                    <!-- Mini Profil Pengguna -->
                    <div class="user-profile">
                        <div class="user-avatar shadow-sm">
                            {{ substr(Auth::user()->name ?? 'K', 0, 1) }}
                        </div>
                        <div class="user-info d-none d-sm-flex">
                            <span class="user-name">Halo, {{ Str::limit(Auth::user()->name ?? 'Kasir', 12) }}</span>
                            <span class="user-role"><i class="fas fa-circle text-success"
                                    style="font-size:8px; margin-right:4px;"></i> Kasir Aktif</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Konten Halaman Render Blade -->
            <section class="content-area page-transition">
                @yield('content')
            </section>

        </main>

    </div>
    <!-- /#app-layout -->

    {{-- Javascript Libraries --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    {{-- Global Scripts untuk Animasi & State Kasir --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ── LOGIKA COLLAPSIBLE SIDEBAR DENGAN MEMORI (LOCALSTORAGE) ──
            const htmlElement = document.documentElement;
            const toggleBtn = document.getElementById('sidebar-toggle');
            const toggleIcon = document.getElementById('toggle-icon');

            // Set icon awal berdasarkan state yang terbaca
            if (htmlElement.classList.contains('sidebar-collapsed')) {
                toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    htmlElement.classList.toggle('sidebar-collapsed');

                    // Simpan state & Putar Ikon Panah
                    if (htmlElement.classList.contains('sidebar-collapsed')) {
                        localStorage.setItem('sidebar_state', 'collapsed');
                        toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
                    } else {
                        localStorage.setItem('sidebar_state', 'expanded');
                        toggleIcon.classList.replace('fa-chevron-right', 'fa-chevron-left');
                    }
                });
            }

            // ── LOGIKA WIDGET JAM DIGITAL REAL-TIME ──
            function updateClock() {
                const now = new Date();
                const opts = {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };
                const timeStr = now.toLocaleTimeString('id-ID', opts).replace(/\./g, ':');
                const el = document.getElementById('live-clock-kasir');
                if (el) {
                    el.textContent = timeStr + ' WIB';
                }
            }
            setInterval(updateClock, 1000);
            updateClock(); // Inisialisasi awal
        });
    </script>

</body>

</html>
