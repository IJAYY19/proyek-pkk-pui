<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Tho Cookies')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/thecookies.png') }}">

    {{-- CSS Libraries & Fonts --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- AOS & Chart.js (Sesuai Permintaan) --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- Script Anti-Flicker: Membaca state dari LocalStorage sebelum CSS di-render --}}
    <script>
        if (localStorage.getItem('admin_sidebar_state') === 'collapsed') {
            document.documentElement.classList.add('sidebar-collapsed');
        }
    </script>

    <style>
        :root {
            /* Palette Gourmet Bakery (Premium Admin Tho Cookies) */
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
            /* Dikontrol penuh oleh Flexbox Shell */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* Scrollbar Premium */
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
            /* Latar belakang subtle pattern/gradient */
            background-image: radial-gradient(circle at top right, rgba(242, 101, 34, 0.03), transparent 40%),
                radial-gradient(circle at bottom left, rgba(255, 179, 0, 0.03), transparent 40%);
        }

        /* ─── SIDEBAR (KOLOM KIRI) ─── */
        #sidebar {
            width: var(--sidebar-expanded);
            height: 100%;
            background: linear-gradient(180deg, var(--brown-dark) 0%, #251614 100%);
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
            top: 40px;
            right: -16px;
            /* Melayang di tepi sidebar */
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

        /* Header Sidebar (Logo & Brand) */
        .sidebar-header {
            padding: 25px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            white-space: nowrap;
            overflow: hidden;
            height: 100px;
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

        .brand-text-container {
            display: flex;
            flex-direction: column;
            transition: opacity 0.3s, visibility 0.3s, width 0.3s;
        }

        .brand-text {
            color: var(--white);
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }

        .brand-text span {
            color: var(--amber-gold);
        }

        .brand-subtitle {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Menu Navigasi */
        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            scrollbar-width: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
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
            padding: 14px 25px;
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
            transition: opacity 0.3s, visibility 0.3s, width 0.3s;
        }

        /* Hover & Active States */
        .sidebar-link:hover {
            color: var(--white);
            background: rgba(255, 255, 255, 0.03);
        }

        .sidebar-link:hover i {
            transform: translateX(5px);
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
            filter: drop-shadow(0 0 8px rgba(242, 101, 34, 0.6));
        }

        /* Transisi Hilang Teks saat Collapsed */
        html.sidebar-collapsed .brand-text-container,
        html.sidebar-collapsed .menu-label,
        html.sidebar-collapsed .menu-text {
            opacity: 0;
            visibility: hidden;
            width: 0;
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
            background: rgba(0, 0, 0, 0.2);
            white-space: nowrap;
            overflow: hidden;
        }

        .btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px;
            background: rgba(239, 68, 68, 0.1);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.2);
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
            background: #ef4444;
            color: white;
            border-color: #ef4444;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
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
            position: relative;
        }

        /* Topbar / Header Melayang (Glassmorphism) */
        .topbar {
            background: rgba(255, 253, 249, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(93, 64, 55, 0.06);
            padding: 15px 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 50;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.02);
            flex-shrink: 0;
        }

        .topbar-left {
            display: flex;
            flex-direction: column;
        }

        .page-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.6rem;
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

        /* Widget Jam & Tanggal */
        .datetime-widget {
            background: var(--white);
            border: 1px solid rgba(93, 64, 55, 0.08);
            border-radius: 50px;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(61, 39, 35, 0.03);
        }

        .datetime-widget i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        .datetime-text {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--brown-dark);
            letter-spacing: 0.5px;
        }

        /* Profil Admin */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--white);
            padding: 6px 20px 6px 6px;
            border-radius: 50px;
            border: 1px solid rgba(93, 64, 55, 0.08);
            box-shadow: 0 4px 15px rgba(61, 39, 35, 0.03);
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
            background: linear-gradient(135deg, var(--brown-dark), var(--brown-light));
            color: var(--amber-gold);
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
            padding: 35px;
            position: relative;
        }

        /* Animasi Transisi Halaman */
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
            #sidebar {
                position: absolute;
                height: 100%;
                left: calc(var(--sidebar-expanded) * -1);
            }

            html.sidebar-collapsed #sidebar {
                left: calc(var(--sidebar-collapsed) * -1);
            }

            .page-title {
                font-size: 1.3rem;
            }

            .content-area {
                padding: 20px 15px;
            }

            .datetime-widget {
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
                <div class="brand-text-container">
                    <div class="brand-text font-display">Tho <span>Cookies</span></div>
                    <div class="brand-subtitle">Admin Panel</div>
                </div>
            </div>

            <!-- Navigasi Menu -->
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    title="Dashboard Overview">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="menu-text">Dashboard</span>
                </a>

                <div class="menu-label">Manajemen Toko</div>

                <a href="{{ route('admin.products.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}"
                    title="Daftar Menu">
                    <i class="fas fa-utensils"></i>
                    <span class="menu-text">Daftar Menu</span>
                </a>

                <a href="{{ route('admin.reports.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}" title="Laporan">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span class="menu-text">Laporan</span>
                </a>

                <a href="{{ route('admin.discounts.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.discounts*') ? 'active' : '' }}"
                    title="Kelola Diskon">
                    <i class="fas fa-tags"></i>
                    <span class="menu-text">Kelola Diskon</span>
                </a>

                <div class="menu-label">Sistem</div>

                <a href="{{ route('admin.logs.index') }}"
                    class="sidebar-link {{ request()->routeIs('admin.logs*') ? 'active' : '' }}" title="Activity Log">
                    <i class="fas fa-history"></i>
                    <span class="menu-text">Activity Log</span>
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
                    <h1 class="page-title">@yield('title', 'Admin Dashboard')</h1>
                    <span class="page-subtitle">Pusat Kendali Manajerial Tho Cookies</span>
                </div>

                <div class="topbar-right">
                    <!-- Widget Tanggal & Jam -->
                    <div class="datetime-widget" title="Waktu Sistem Saat Ini">
                        <i class="far fa-calendar-alt"></i>
                        <span class="datetime-text" id="live-datetime-admin">Memuat...</span>
                    </div>

                    <!-- Mini Profil Admin -->
                    <div class="user-profile">
                        <div class="user-avatar shadow-sm">
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="user-info d-none d-sm-flex">
                            <span class="user-name">Halo, {{ Str::limit(Auth::user()->name ?? 'Admin', 12) }}</span>
                            <span class="user-role"><i class="fas fa-shield-alt text-warning"
                                    style="font-size:10px; margin-right:4px;"></i> Administrator</span>
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
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    @stack('scripts')

    {{-- Global Scripts untuk Animasi & State Admin --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ── LOGIKA COLLAPSIBLE SIDEBAR DENGAN MEMORI MANDIRI (LOCALSTORAGE) ──
            const htmlElement = document.documentElement;
            const toggleBtn = document.getElementById('sidebar-toggle');
            const toggleIcon = document.getElementById('toggle-icon');

            // Sesuaikan arah ikon panah saat halaman dimuat (berdasarkan CSS class dari head)
            if (htmlElement.classList.contains('sidebar-collapsed')) {
                toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    // Toggle class CSS
                    htmlElement.classList.toggle('sidebar-collapsed');

                    // Simpan status spesifik untuk admin & Putar Ikon Panah
                    if (htmlElement.classList.contains('sidebar-collapsed')) {
                        localStorage.setItem('admin_sidebar_state', 'collapsed');
                        toggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
                    } else {
                        localStorage.setItem('admin_sidebar_state', 'expanded');
                        toggleIcon.classList.replace('fa-chevron-right', 'fa-chevron-left');
                    }
                });
            }

            // ── LOGIKA WIDGET TANGGAL & JAM REAL-TIME ──
            function updateDateTime() {
                const now = new Date();
                const options = {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                };
                // Memformat waktu sesuai locale Indonesia (misal: "8 Jun 2026, 12:53:00")
                const timeString = now.toLocaleDateString('id-ID', options).replace(/\./g, ':');

                const dtElement = document.getElementById('live-datetime-admin');
                if (dtElement) {
                    dtElement.textContent = timeString + ' WIB';
                }
            }
            setInterval(updateDateTime, 1000);
            updateDateTime(); // Jalankan sekali saat load agar tidak tertulis 'Memuat...'

            // Inisialisasi AOS jika digunakan di konten admin
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true
                });
            }
        });
    </script>

</body>

</html>
