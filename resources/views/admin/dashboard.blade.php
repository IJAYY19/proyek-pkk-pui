@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    {{-- Import Fonts, Font Awesome, dan Animate.css untuk Transaksi Animasi --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary: #F26522;
            --primary-dark: #D84315;
            --primary-light: rgba(242, 101, 34, 0.1);
            --brown: #5D4037;
            --brown-dark: #3E2723;
            --brown-light: #8D6E63;
            --cream-bg: #FFFDF9;
            --cream-card: #FFF8E1;
            --white: #FFFFFF;
            --success: #10B981;
            --success-glow: rgba(16, 185, 129, 0.3);
            --info: #06B6D4;
            --info-glow: rgba(6, 182, 212, 0.3);
            --purple: #8B5CF6;
            --purple-glow: rgba(139, 92, 246, 0.3);
            --danger: #EF4444;
        }

        body {
            background-color: #FDFBF7;
            font-family: 'Poppins', sans-serif;
            color: var(--brown);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- ANIMASI ENTRY --- */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        .delay-4 {
            animation-delay: 0.4s;
        }

        .delay-5 {
            animation-delay: 0.5s;
        }

        /* --- QUICK CONTROL HUB --- */
        .control-hub-card {
            background: linear-gradient(135deg, #FFFDF9 0%, var(--cream-card) 100%);
            border: 3px solid var(--brown);
            border-radius: 24px;
            box-shadow: 8px 8px 0px rgba(93, 64, 55, 0.1);
            padding: 24px;
        }

        .store-toggle-box {
            background: var(--white);
            border: 2px solid var(--brown);
            border-radius: 18px;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .quick-btn {
            background: var(--white);
            color: var(--brown-dark);
            border: 2px solid var(--brown);
            border-radius: 50px;
            padding: 10px 20px;
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 3px 3px 0px var(--brown);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .quick-btn:hover {
            transform: translateY(-2px);
            box-shadow: 5px 5px 0px var(--brown);
            background-color: var(--cream-card);
            color: var(--primary-dark);
        }

        .quick-btn:active {
            transform: translateY(1px);
            box-shadow: 1px 1px 0px var(--brown);
        }

        /* Toggle Button Custom */
        .switch-custom {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 32px;
        }

        .switch-custom input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider-custom {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #E2E8F0;
            transition: .4s;
            border-radius: 34px;
            border: 2px solid var(--brown);
        }

        .slider-custom:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: var(--brown);
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider-custom {
            background-color: #A7F3D0;
            /* Hijau muda */
        }

        input:checked+.slider-custom:before {
            transform: translateX(28px);
            background-color: var(--success);
        }

        /* --- STATS CARD: BENTO WITH ADAPTIVE GLOW SHADOW --- */
        .bento-stats-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 3px solid var(--brown);
            border-radius: 24px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 165px;
            box-shadow: 6px 6px 0px rgba(93, 64, 55, 0.1);
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* Dynamic Glow Shadows on Hover */
        .bento-stats-card.glow-income:hover {
            box-shadow: 0 15px 30px var(--success-glow), 8px 8px 0px var(--brown);
            transform: translateY(-5px);
        }

        .bento-stats-card.glow-trx:hover {
            box-shadow: 0 15px 30px var(--info-glow), 8px 8px 0px var(--brown);
            transform: translateY(-5px);
        }

        .bento-stats-card.glow-menu:hover {
            box-shadow: 0 15px 30px rgba(242, 101, 34, 0.25), 8px 8px 0px var(--brown);
            transform: translateY(-5px);
        }

        .bento-stats-card.glow-user:hover {
            box-shadow: 0 15px 30px var(--purple-glow), 8px 8px 0px var(--brown);
            transform: translateY(-5px);
        }

        /* Icon Floating */
        .floating-card-icon {
            position: absolute;
            right: 15px;
            top: 15px;
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            border: 2px solid var(--brown);
            box-shadow: 3px 3px 0px var(--brown);
        }

        .bg-glow-success {
            background-color: #E6F4EA;
            color: var(--success);
        }

        .bg-glow-info {
            background-color: #E0F7FA;
            color: var(--info);
        }

        .bg-glow-orange {
            background-color: #FFF3E0;
            color: var(--primary);
        }

        .bg-glow-purple {
            background-color: #F3E5F5;
            color: var(--purple);
        }

        .bento-title {
            font-size: 0.85rem;
            color: var(--brown-light);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1.2px;
            margin-bottom: 5px;
        }

        .bento-value {
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--brown-dark);
            line-height: 1.1;
        }

        /* --- WIDGET CARD GENERAL --- */
        .premium-widget-card {
            background: var(--white);
            border: 3px solid var(--brown);
            border-radius: 24px;
            box-shadow: 8px 8px 0px rgba(93, 64, 55, 0.1);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .premium-widget-header {
            padding: 20px 24px;
            border-bottom: 2.5px solid var(--brown);
            background-color: var(--cream-card);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* --- CHART STYLING --- */
        .chart-tab-btn {
            background: transparent;
            border: 2px solid transparent;
            color: var(--brown-light);
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            padding: 6px 16px;
            border-radius: 30px;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .chart-tab-btn.active {
            background-color: var(--white);
            border-color: var(--brown);
            color: var(--primary-dark);
            box-shadow: 2px 2px 0px var(--brown);
        }

        /* --- COOKIES LEADERBOARD --- */
        .leaderboard-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 0;
        }

        .leaderboard-rank {
            width: 32px;
            height: 32px;
            background-color: var(--cream-card);
            border: 2px solid var(--brown);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-family: 'Fredoka', sans-serif;
            color: var(--brown-dark);
            font-size: 0.9rem;
        }

        .rank-gold {
            background-color: #FFDF00;
            color: #5D4037;
        }

        .rank-silver {
            background-color: #C0C0C0;
            color: #5D4037;
        }

        .rank-bronze {
            background-color: #CD7F32;
            color: #FFFFFF;
        }

        .custom-progress {
            height: 10px;
            background-color: #F1ECE3;
            border-radius: 10px;
            border: 1.5px solid var(--brown);
            overflow: hidden;
        }

        .custom-progress-bar {
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* --- MINI TIMELINE CASIER AUDIT --- */
        .timeline-vertical {
            position: relative;
            padding-left: 30px;
        }

        .timeline-vertical::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 5px;
            bottom: 5px;
            width: 3px;
            background-color: var(--brown);
            opacity: 0.3;
        }

        .timeline-node {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-node:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            position: absolute;
            left: -24px;
            top: 4px;
            width: 11px;
            height: 11px;
            background-color: var(--primary);
            border: 2px solid var(--white);
            border-radius: 50%;
            outline: 2.5px solid var(--brown);
            z-index: 5;
        }

        .timeline-node:nth-child(2) .timeline-dot {
            background-color: var(--info);
        }

        .timeline-node:nth-child(3) .timeline-dot {
            background-color: var(--success);
        }

        /* --- MODERN TABLE STYLING --- */
        .table-premium {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-premium th {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            color: var(--brown-light);
            padding: 16px 20px;
            border-bottom: 2.5px solid var(--brown);
            background: var(--cream-card);
        }

        .table-premium td {
            padding: 16px 20px;
            vertical-align: middle;
            border-bottom: 1.5px solid #F0ECE3;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .table-premium tbody tr:hover td {
            background-color: rgba(242, 101, 34, 0.04);
        }

        /* Glossy Status Badge Pill */
        .badge-glossy-success {
            background-color: rgba(16, 185, 129, 0.12);
            color: var(--success);
            border: 2px solid var(--success);
            font-weight: 700;
        }

        .badge-glossy-warning {
            background-color: rgba(245, 158, 11, 0.12);
            color: #D97706;
            border: 2px solid #D97706;
            font-weight: 700;
        }

        /* Date Pill */
        .date-pill-modern {
            background: var(--white);
            padding: 12px 24px;
            border-radius: 50px;
            border: 2.5px solid var(--brown);
            box-shadow: 4px 4px 0px var(--brown);
            font-weight: 700;
            color: var(--brown-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: 'Fredoka', sans-serif;
        }

        /* Pulse Animation (Stok Menipis) */
        @keyframes pulse-red {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 110, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(239, 68, 110, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 110, 0);
            }
        }

        .pulse-danger-badge {
            background-color: #FEE2E2 !important;
            color: #EF4444 !important;
            border: 2.5px solid #EF4444 !important;
            animation: pulse-red 2s infinite;
        }
    </style>

    @php
        // ==========================================
        // DATA GENERATOR UNTUK GRAFIK TREN RIIL
        // ==========================================

        // 1. DATA HARI INI (Ember Waktu 2 Jam-an)
        $todayTransactions = \App\Models\Transaction::where('status', 'completed')
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->get();

        $hourlySales = [
            '08:00' => 0,
            '10:00' => 0,
            '12:00' => 0,
            '14:00' => 0,
            '16:00' => 0,
            '18:00' => 0,
            '20:00' => 0,
            '22:00' => 0,
        ];

        foreach ($todayTransactions as $trx) {
            $hour = intval($trx->created_at->format('H'));
            if ($hour >= 8 && $hour < 10) {
                $hourlySales['08:00'] += $trx->total_amount;
            } elseif ($hour >= 10 && $hour < 12) {
                $hourlySales['10:00'] += $trx->total_amount;
            } elseif ($hour >= 12 && $hour < 14) {
                $hourlySales['12:00'] += $trx->total_amount;
            } elseif ($hour >= 14 && $hour < 16) {
                $hourlySales['14:00'] += $trx->total_amount;
            } elseif ($hour >= 16 && $hour < 18) {
                $hourlySales['16:00'] += $trx->total_amount;
            } elseif ($hour >= 18 && $hour < 20) {
                $hourlySales['18:00'] += $trx->total_amount;
            } elseif ($hour >= 20 && $hour < 22) {
                $hourlySales['20:00'] += $trx->total_amount;
            } elseif ($hour >= 22) {
                $hourlySales['22:00'] += $trx->total_amount;
            }
        }

        // Konversi ke satuan Ribuan (k) agar grafik rapi
        $todayData = [];
        foreach ($hourlySales as $time => $amount) {
            $todayData[] = round($amount / 1000);
        }

        // 2. DATA MINGGU INI (Tren 7 Hari Terakhir)
        $weeklySales = [];
        $weeklyLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $weeklyLabels[] = $date->translatedFormat('D'); // Senin, Selasa, dll

            $amount = \App\Models\Transaction::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_amount');

            $weeklySales[] = round($amount / 1000);
        }

        // 3. DATA BULAN INI (Tren 4 Minggu Terakhir)
        $monthlySales = [];
        $monthlyLabels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = \Carbon\Carbon::today()->subWeeks($i)->startOfWeek();
            $endOfWeek = \Carbon\Carbon::today()->subWeeks($i)->endOfWeek();

            $amount = \App\Models\Transaction::where('status', 'completed')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->sum('total_amount');

            $monthlySales[] = round($amount / 1000);
        }
    @endphp

    <div class="container-fluid px-0 pb-5">

        {{-- HEADER SECTION --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 pt-3 animate-up gap-3">
            <div>
                <h5 class="text-muted mb-1" style="font-weight: 500;">Selamat Bekerja kembali, <span class="fw-bold"
                        style="color: var(--primary-dark);">Admin!</span> 🧑‍🍳</h5>
                <h2 class="fw-bold mb-0 text-uppercase" style="color: var(--brown-dark); letter-spacing: 1px;">Dashboard
                    Overview</h2>
            </div>
            <div>
                <div class="date-pill-modern">
                    <i class="fa-regular fa-calendar-days" style="color: var(--primary); font-size: 1.2rem;"></i>
                    <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- NEW COMPONENT: QUICK CONTROL HUB --}}
        <div class="row mb-5 animate-up delay-1">
            <div class="col-12">
                <div class="control-hub-card">
                    <div class="row align-items-center g-3">
                        <div class="col-lg-8 col-md-7">
                            <div class="d-flex flex-wrap gap-3 justify-content-md-end justify-content-start">
                                <a href="{{ route('admin.products.create') }}" class="quick-btn">
                                    <i class="fa-solid fa-plus"></i> Tambah Produk
                                </a>
                                <a href="{{ route('admin.discounts.create') }}" class="quick-btn">
                                    <i class="fa-solid fa-ticket"></i> Buat Diskon
                                </a>
                                <a href="{{ route('admin.reports.index') }}" class="quick-btn">
                                    <i class="fa-solid fa-print"></i> Laporan Harian
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 1. STATISTIK CARDS (BENTO STYLE WITH GLOW SHADOWS) --}}
        <div class="row g-4 mb-5">
            <!-- Pendapatan Hari Ini -->
            <div class="col-md-6 col-lg-3 animate-up delay-1">
                <div class="bento-stats-card glow-income">
                    <div class="floating-card-icon bg-glow-success">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <div class="bento-title">Pendapatan Hari Ini</div>
                        <div class="bento-value">
                            <span class="fs-4 fw-normal">Rp</span>{{ number_format($pendapatanHariIni, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="col-md-6 col-lg-3 animate-up delay-2">
                <div class="bento-stats-card glow-trx">
                    <div class="floating-card-icon bg-glow-info">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>
                    <div>
                        <div class="bento-title">Transaksi Sukses</div>
                        <div class="bento-value">
                            {{ $transaksiHariIni }} <span class="fs-5 fw-normal text-muted">Pesanan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Menu -->
            <div class="col-md-6 col-lg-3 animate-up delay-3">
                <div class="bento-stats-card glow-menu">
                    <div class="floating-card-icon bg-glow-orange">
                        <i class="fa-solid fa-cookie-bite"></i>
                    </div>
                    <div>
                        <div class="bento-title">Menu Varian</div>
                        <div class="bento-value">
                            {{ $totalProduk }} <span class="fs-5 fw-normal text-muted">Varian</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total User -->
            <div class="col-md-6 col-lg-3 animate-up delay-4">
                <div class="bento-stats-card glow-user">
                    <div class="floating-card-icon bg-glow-purple">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div>
                        <div class="bento-title">Staf & Kasir</div>
                        <div class="bento-value">
                            {{ $totalUser }} <span class="fs-5 fw-normal text-muted">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. GRAFIK UTAMA & SIDEBAR (ROW 3) --}}
        <div class="row g-4 mb-5">
            {{-- CHart.js Sales Graph --}}
            <div class="col-xl-8 animate-up delay-4">
                <div class="premium-widget-card" style="min-height: 420px;">
                    <div class="premium-widget-header">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-chart-line text-primary fs-5"></i>
                            <h5 class="mb-0 fw-bold text-dark font-display">Grafik Tren Penjualan</h5>
                        </div>
                        <div class="d-flex gap-1 bg-light p-1 rounded-pill border border-2 border-dark"
                            style="background-color: #FDFBF7 !important;">
                            <button onclick="updateChartData('hari_ini')" id="btn-hari_ini"
                                class="chart-tab-btn active">Hari Ini</button>
                            <button onclick="updateChartData('minggu_ini')" id="btn-minggu_ini" class="chart-tab-btn">Minggu
                                Ini</button>
                            <button onclick="updateChartData('bulan_ini')" id="btn-bulan_ini" class="chart-tab-btn">Bulan
                                Ini</button>
                        </div>
                    </div>
                    <div class="p-4 d-flex flex-column flex-grow-1"
                        style="background-color: var(--white); flex: 1; height: 100%;">
                        <div style="position: relative; flex-grow: 1; width: 100%; min-height: 250px;">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leaderboard & Timeline Section --}}
            <div class="col-xl-4 animate-up delay-5">
                <div class="row g-4">
                    @php
                        // Mengambil top 3 produk terlaris berdasarkan total kuantiti penjualan riil di database
                        $topProducts = \App\Models\Product::join(
                            'transaction_details',
                            'products.id',
                            '=',
                            'transaction_details.product_id',
                        )
                            ->select(
                                'products.id',
                                'products.name',
                                'products.image',
                                \Illuminate\Support\Facades\DB::raw('SUM(transaction_details.quantity) as total_qty'),
                            )
                            ->groupBy('products.id', 'products.name', 'products.image')
                            ->orderBy('total_qty', 'desc')
                            ->take(3)
                            ->get();

                        // Menghitung total seluruh kuantiti item yang terjual di toko untuk persentase bar
                        $totalQtySold =
                            \Illuminate\Support\Facades\DB::table('transaction_details')->sum('quantity') ?: 1;
                    @endphp

                    {{-- Leaderboard Menu Dinamis --}}
                    <div class="col-12">
                        <div class="premium-widget-card">
                            <div class="premium-widget-header">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-award text-warning fs-5"></i>
                                    <h5 class="mb-0 fw-bold text-dark font-display">Top Produk Terlaris</h5>
                                </div>
                            </div>
                            <div class="p-4 bg-white">
                                @forelse ($topProducts as $index => $product)
                                    @php
                                        // Menghitung persentase penjualan produk terhadap total seluruh item terjual
                                        $percentage = round(($product->total_qty / $totalQtySold) * 100);

                                        // Menentukan warna rank dan progress bar berdasarkan urutan juara 1, 2, dan 3
                                        if ($index == 0) {
                                            $rankClass = 'rank-gold';
                                            $progressBg =
                                                'background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);';
                                        } elseif ($index == 1) {
                                            $rankClass = 'rank-silver';
                                            $progressBg =
                                                'background: linear-gradient(90deg, #FFB199 0%, #FF0844 100%);';
                                        } else {
                                            $rankClass = 'rank-bronze';
                                            $progressBg =
                                                'background: linear-gradient(90deg, #A1887F 0%, #5D4037 100%);';
                                        }
                                    @endphp
                                    <div class="leaderboard-item">
                                        <div class="leaderboard-rank {{ $rankClass }}">{{ $index + 1 }}</div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between mb-1">
                                                <span class="fw-bold text-dark"
                                                    style="font-size: 0.9rem;">{{ $product->name }}</span>
                                                <span class="small fw-bold text-muted">{{ $product->total_qty }} Terjual
                                                    ({{ $percentage }}%)
                                                </span>
                                            </div>
                                            <div class="custom-progress">
                                                <div class="custom-progress-bar"
                                                    style="width: {{ $percentage }}%; {{ $progressBg }}"></div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4 text-muted">
                                        <i class="fa-solid fa-cookie-bite fa-2x mb-2 text-muted"
                                            style="opacity: 0.3;"></i>
                                        <p class="small mb-0">Belum ada data penjualan tercatat.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    @php
                        // Pencarian model log aktivitas yang aman agar sistem tidak mengalami crash
                        $recentActivities = collect();
                        if (class_exists('\App\Models\ActivityLog')) {
                            $recentActivities = \App\Models\ActivityLog::orderBy('created_at', 'desc')->take(3)->get();
                        } elseif (class_exists('\App\Models\Activity')) {
                            $recentActivities = \App\Models\Activity::orderBy('created_at', 'desc')->take(3)->get();
                        }
                    @endphp

                    {{-- Lini Masa Aktivitas Terkini Dinamis --}}
                    <div class="col-12">
                        <div class="premium-widget-card">
                            <div class="premium-widget-header">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-list-check text-info fs-5"></i>
                                    <h5 class="mb-0 fw-bold text-dark font-display">Aktivitas Terkini</h5>
                                </div>
                            </div>
                            <div class="p-4 bg-white">
                                <div class="timeline-vertical">
                                    @forelse ($recentActivities as $log)
                                        @php
                                            $text = strtolower($log->activity);

                                            // Analisis teks log untuk menentukan judul dan warna indikator secara cerdas
                                            if (
                                                str_contains($text, 'bayar') ||
                                                str_contains($text, 'transaksi') ||
                                                str_contains($text, 'checkout')
                                            ) {
                                                $logTitle = 'Transaksi Selesai';
                                                $dotColor = 'var(--info)'; // Biru
                                            } elseif (
                                                str_contains($text, 'produk') ||
                                                str_contains($text, 'menu') ||
                                                str_contains($text, 'stok')
                                            ) {
                                                $logTitle = 'Manajemen Produk';
                                                $dotColor = 'var(--primary)'; // Oranye
                                            } elseif (
                                                str_contains($text, 'diskon') ||
                                                str_contains($text, 'voucher') ||
                                                str_contains($text, 'kupon')
                                            ) {
                                                $logTitle = 'Diskon & Voucher';
                                                $dotColor = 'var(--success)'; // Hijau
                                            } else {
                                                $logTitle = 'Aktivitas Sistem';
                                                $dotColor = 'var(--brown-light)'; // Cokelat/Abu-abu
                                            }
                                        @endphp
                                        <div class="timeline-node">
                                            <div class="timeline-dot"
                                                style="background-color: {{ $dotColor }} !important;"></div>
                                            <span class="small text-muted d-block" style="font-size: 0.75rem;">
                                                <i class="far fa-clock me-1"></i> {{ $log->created_at->diffForHumans() }}
                                            </span>
                                            <span class="fw-bold d-block text-dark"
                                                style="font-size: 0.85rem;">{{ $logTitle }}</span>
                                            <span class="text-muted small d-block mt-1">{{ $log->activity }}</span>
                                        </div>
                                    @empty
                                        <div class="text-center py-4 text-muted">
                                            <i class="fa-solid fa-clock-rotate-left fa-2x mb-2 text-muted"
                                                style="opacity: 0.3;"></i>
                                            <p class="small mb-0">Belum ada riwayat aktivitas sistem.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. TABEL WIDGETS ROW 4 --}}
        <div class="row g-4">

            {{-- STOK MENIPIS WIDGET --}}
            <div class="col-lg-5 animate-up delay-5">
                <div class="premium-widget-card">
                    <div class="premium-widget-header">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-danger bg-opacity-10 p-2 rounded-circle text-danger d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px; border: 1.5px solid rgba(239, 68, 68, 0.2);">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark font-display">Stok Menipis</h5>
                        </div>
                        @if (!$lowStockProducts->isEmpty())
                            <span class="badge pulse-danger-badge px-3 py-2 rounded-pill shadow-sm">
                                {{ $lowStockProducts->count() }} Peringatan
                            </span>
                        @endif
                    </div>

                    <div class="p-0 bg-white">
                        @if ($lowStockProducts->isEmpty())
                            <div class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" alt="Aman"
                                    style="width: 80px; opacity: 0.3; filter: grayscale(100%);"
                                    class="mb-3 animate__animated animate__pulse animate__infinite">
                                <h5 class="fw-bold text-success mb-1">Stok Aman Terkendali!</h5>
                                <p class="text-muted small mb-0">Semua bahan dan menu tersedia dengan sangat cukup.</p>
                            </div>
                        @else
                            <div class="table-responsive animate__animated animate__fadeIn"
                                style="max-height: 380px; overflow-y: auto;">
                                <table class="table table-premium w-100">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th class="text-center">Sisa Stok</th>
                                            <th class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($lowStockProducts as $product)
                                            <tr>
                                                <td class="fw-bold text-dark">
                                                    <i class="fas fa-cookie text-muted me-2 small"></i>
                                                    {{ $product->name }}
                                                </td>
                                                <td class="text-center">
                                                    <span
                                                        class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2 border border-danger fw-bold"
                                                        style="font-size: 0.85rem;">
                                                        {{ $product->stock }} toples
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="btn btn-sm rounded-pill px-3 fw-bold text-white shadow-sm"
                                                        style="background-color: var(--primary); border: 1.5px solid var(--brown); box-shadow: 2px 2px 0px var(--brown); transition: transform 0.2s;">
                                                        Isi Ulang
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- TRANSAKSI TERAKHIR WIDGET --}}
            <div class="col-lg-7 animate-up delay-5">
                <div class="premium-widget-card">
                    <div class="premium-widget-header">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle text-primary d-flex align-items-center justify-content-center"
                                style="width: 35px; height: 35px; border: 1.5px solid var(--primary-light);">
                                <i class="fas fa-history"></i>
                            </div>
                            <h5 class="mb-0 fw-bold text-dark font-display">Transaksi Terakhir</h5>
                        </div>
                        <a href="{{ route('admin.reports.index') }}"
                            class="btn btn-sm btn-light border-dark border-2 rounded-pill px-3 fw-bold text-muted hover-shadow"
                            style="font-size: 0.8rem; box-shadow: 2px 2px 0px var(--brown);">Lihat Semua</a>
                    </div>

                    <div class="p-0 bg-white">
                        <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                            <table class="table table-premium w-100">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>Detail Customer</th>
                                        <th>Total Nominal</th>
                                        <th class="text-end">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $trx)
                                        <tr>
                                            <td class="text-muted small font-monospace">
                                                <i class="far fa-clock me-1"></i> {{ $trx->created_at->format('H:i') }}
                                                WIB
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $trx->customer_name }}</div>
                                                <div class="small text-muted d-flex align-items-center gap-1 mt-1">
                                                    <i class="fas fa-user-tag text-primary"
                                                        style="font-size: 0.7rem;"></i>
                                                    {{ $trx->customer_class ? $trx->customer_class : 'Umum' }}
                                                </div>
                                            </td>
                                            <td class="fw-bold" style="color: var(--primary-dark); font-size: 0.95rem;">
                                                Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $status = strtolower($trx->status ?? 'selesai');
                                                    if ($status == 'pending' || $status == 'menunggu') {
                                                        $badgeClass = 'badge-glossy-warning';
                                                        $statusText = 'Pending';
                                                    } else {
                                                        $badgeClass = 'badge-glossy-success';
                                                        $statusText = 'Selesai';
                                                    }
                                                @endphp
                                                <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 shadow-sm"
                                                    style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                                    {{ $statusText }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <div class="mb-3">
                                                    <i class="fas fa-receipt" style="font-size: 3rem; color: #ddd;"></i>
                                                </div>
                                                <h6 class="fw-bold text-dark">Belum Ada Transaksi</h6>
                                                <p class="small mb-0">Transaksi hari ini akan muncul di sini saat penjualan
                                                    berlangsung.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Script CDN Chart.js & Logika Dashboard --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ==========================================
        // DYNAMIC CHART DATA ENGINE (CHART.JS)
        // ==========================================
        // Pengumpan data dinamis terenkripsi JSON dari database SQLite
        const chartDataSets = {
            hari_ini: {
                labels: {!! json_encode(array_keys($hourlySales)) !!},
                data: {!! json_encode($todayData) !!}
            },
            minggu_ini: {
                labels: {!! json_encode($weeklyLabels) !!},
                data: {!! json_encode($weeklySales) !!}
            },
            bulan_ini: {
                labels: {!! json_encode($monthlyLabels) !!},
                data: {!! json_encode($monthlySales) !!}
            }
        };

        let currentChart;

        function initializeChart() {
            const ctx = document.getElementById('salesTrendChart').getContext('2d');
            currentChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartDataSets.hari_ini.labels,
                    datasets: [{
                        label: 'Pendapatan (Ribu Rp)',
                        data: chartDataSets.hari_ini.data,
                        borderColor: '#F26522',
                        borderWidth: 4,
                        backgroundColor: 'rgba(242, 101, 34, 0.08)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#3E2723',
                        pointBorderColor: '#FFFFFF',
                        pointHoverBackgroundColor: '#F26522',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: '#F1ECE3'
                            },
                            ticks: {
                                color: '#5D4037',
                                font: {
                                    family: 'Poppins',
                                    weight: 600
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#5D4037',
                                font: {
                                    family: 'Poppins',
                                    weight: 600
                                }
                            }
                        }
                    }
                }
            });
        }

        function updateChartData(tabType) {
            // Update Active Class di Button Tab
            document.querySelectorAll('.chart-tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById('btn-' + tabType).classList.add('active');

            // Ganti Data Grafik secara Smooth
            currentChart.data.labels = chartDataSets[tabType].labels;
            currentChart.data.datasets[0].data = chartDataSets[tabType].data;
            currentChart.update();
        }

        // Load awal saat halaman siap
        window.addEventListener('load', function() {
            initializeChart();
        });
    </script>
@endsection
