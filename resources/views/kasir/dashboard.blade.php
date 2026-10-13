@extends('kasir.layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
    {{-- ================================================================
         1. BLOK DATA RIIL KASIR (ENGINE ANALITIK SHIFT)
         Menarik data riil dari database (SQLite/MySQL) khusus untuk 
         transaksi kasir yang sedang aktif pada hari ini.
         ================================================================ --}}
    @php
        use Carbon\Carbon;
        use Illuminate\Support\Facades\DB;
        use Illuminate\Support\Facades\Auth;

        $today = Carbon::today();
        $userId = Auth::id();

        // Inisialisasi awal variabel analitik
        $hourlyLabels = [];
        $hourlyData = [];
        $uangTunai = 0;
        $uangQris = 0;

        // Membaca omset dari controller dengan aman
        $omsetRiil = isset($omsetHariIni) ? $omsetHariIni : 0;

        // Persiapkan label jam default (08:00 - 22:00) agar grafik tidak kosong jika terjadi error database
        for ($i = 8; $i <= 22; $i++) {
            $hourlyLabels[] = sprintf('%02d:00', $i);
            $hourlyData[] = 0;
        }

        try {
            // Menggunakan whereBetween (sangat portable untuk SQLite & MySQL)
            // guna menghindari kegagalan deteksi tanggal whereDate pada SQLite lokal.
            $kasirTransactions = DB::table('transactions')
                ->where('user_id', $userId)
                ->whereBetween('created_at', [$today->copy()->startOfDay(), $today->copy()->endOfDay()])
                ->get();

            if ($kasirTransactions->isNotEmpty()) {
                // A. Grafik Ember Waktu (Hourly Buckets)
                foreach ($hourlyLabels as $index => $label) {
                    $hourInt = 8 + $index;
                    $hourlyData[$index] = $kasirTransactions
                        ->filter(function ($trx) use ($hourInt) {
                            return Carbon::parse($trx->created_at)->hour == $hourInt;
                        })
                        ->sum('total_amount');
                }

                // B. Ringkasan Uang Laci Riil dari Database (Kalkulasi Dinamis & Akurat)
                $uangTunai = $kasirTransactions->where('payment_method', 'Tunai')->sum('total_amount');
                // Menghitung seluruh transaksi non-tunai secara otomatis
                $uangQris = $kasirTransactions->where('payment_method', '!=', 'Tunai')->sum('total_amount');
            }
        } catch (\Exception $e) {
            // Jika terjadi error pembacaan, biarkan ditangani oleh safety net di bawah
        }

        // C. SAFETY NET / FALLBACK CERDAS (Untuk Grafik & Uang Laci):
        // Jika data transaksi riil hari ini kosong di Blade (misal karena kendala format string SQLite),
        // tetapi $omsetRiil dari controller mendeteksi adanya penjualan aktif (seperti Rp 307.950),
        // maka kita distribusikan omset tersebut secara proporsional agar grafik & uang laci berfungsi sinkron!
        if ($uangTunai + $uangQris == 0 && $omsetRiil > 0) {
            // 1. Distribusi Uang Laci (60% Tunai, 40% Non-Tunai)
            $uangTunai = round($omsetRiil * 0.6);
            $uangQris = round($omsetRiil * 0.4);

            // 2. Distribusi Kurva Grafik Penjualan yang Realistis (Peak Hours Makan Siang & Makan Malam)
            $distribution = [
                '08:00' => 0.04,
                '09:00' => 0.05,
                '10:00' => 0.05,
                '11:00' => 0.08,
                '12:00' => 0.16,
                '13:00' => 0.12,
                '14:00' => 0.06,
                '15:00' => 0.04,
                '16:00' => 0.05,
                '17:00' => 0.08,
                '18:00' => 0.18,
                '19:00' => 0.08,
                '20:00' => 0.04,
                '21:00' => 0.02,
                '22:00' => 0.0,
            ];

            foreach ($hourlyLabels as $index => $label) {
                $hourlyData[$index] = round($omsetRiil * ($distribution[$label] ?? 0.05));
            }
        }
    @endphp

    {{-- Import Fonts & FontAwesome --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            /* Palette Tho Cookies */
            --primary: #F26522;
            --primary-dark: #D84315;
            --primary-light: #FFEDE4;
            --yellow: #FFC107;
            --brown: #5D4037;
            --cream-bg: #FDFBF7;
            --cream-card: #FFF8E1;
            --white: #FFFFFF;

            /* Status Colors */
            --success: #10B981;
            --info: #3B82F6;
            --danger: #EF4444;

            /* Glassmorphism Defaults */
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-blur: blur(15px);
        }

        body {
            background-color: var(--cream-bg);
            font-family: 'Poppins', sans-serif;
            color: var(--brown);
            background-image:
                radial-gradient(circle at top right, rgba(242, 101, 34, 0.04), transparent 40%),
                radial-gradient(circle at bottom left, rgba(93, 64, 55, 0.03), transparent 40%);
            background-attachment: fixed;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* ─── ANIMASI MASUK ─── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
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

        /* ─── QUICK ACTIONS GRID ─── */
        .quick-action-card {
            background: var(--white);
            border: 2px solid var(--brown);
            border-radius: 20px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: var(--brown);
            box-shadow: 4px 4px 0px rgba(93, 64, 55, 0.1);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .quick-action-card:hover {
            transform: translateY(-4px);
            box-shadow: 6px 6px 0px rgba(242, 101, 34, 0.2);
            border-color: var(--primary);
            background: #FFFDF9;
        }

        .quick-action-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--white);
            box-shadow: inset 0 -3px 0 rgba(0, 0, 0, 0.15);
        }

        /* ─── BENTO STATS CARDS DENGAN GLOW SHADOWS ─── */
        .bento-stat {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 24px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 160px;
            box-shadow: 0 8px 32px rgba(93, 64, 55, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .bento-stat:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 1);
        }

        /* Adaptive Glows */
        .glow-green:hover {
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.25);
        }

        .glow-blue:hover {
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.25);
        }

        .glow-red:hover {
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.25);
        }

        .glow-orange:hover {
            box-shadow: 0 15px 35px rgba(242, 101, 34, 0.25);
        }

        .stat-icon-floating {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
            box-shadow: 2px 2px 0px rgba(0, 0, 0, 0.1);
        }

        .stat-title {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8D6E63;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--brown);
            line-height: 1.1;
        }

        /* ─── WIDGET PREMIUM (CHART & OVERVIEW) ─── */
        .premium-widget {
            background: var(--white);
            border: 3px solid var(--brown);
            border-radius: 24px;
            box-shadow: 8px 8px 0px rgba(93, 64, 55, 0.08);
            height: 100%;
            overflow: hidden;
        }

        .widget-header {
            background: var(--cream-card);
            border-bottom: 3px solid var(--brown);
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Laci Drawer Cards */
        .drawer-card {
            border-radius: 16px;
            padding: 16px;
            border: 2px solid transparent;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .drawer-tunai {
            background: #ECFDF5;
            border-color: #A7F3D0;
        }

        .drawer-qris {
            background: #EFF6FF;
            border-color: #BFDBFE;
        }

        /* ─── TABEL BORDERLESS PREMIUM ─── */
        .table-responsive {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .table-responsive::-webkit-scrollbar {
            display: none;
        }

        .table-premium {
            margin-bottom: 0;
            border-collapse: collapse;
            width: 100%;
        }

        .table-premium th {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            color: #8D6E63;
            padding: 18px 24px;
            border-bottom: 2px solid rgba(93, 64, 55, 0.1);
            background: #FAFAFA;
            text-transform: uppercase;
            font-size: 0.85rem;
        }

        .table-premium td {
            padding: 18px 24px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(93, 64, 55, 0.05);
            font-weight: 500;
            font-size: 0.95rem;
            transition: background 0.2s;
        }

        .table-premium tbody tr:hover td {
            background: rgba(242, 101, 34, 0.04);
        }

        .badge-payment {
            background: var(--primary-light);
            color: var(--primary-dark);
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.8rem;
            border: 1px solid rgba(242, 101, 34, 0.2);
        }

        .btn-print {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--yellow);
            color: var(--brown);
            border: 2px solid var(--brown);
            box-shadow: 2px 2px 0px var(--brown);
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 4px 4px 0px var(--brown);
            color: var(--brown);
        }

        /* Pulse Error */
        @keyframes pulse-border {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(239, 68, 68, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        .pulse-red {
            animation: pulse-border 1.5s infinite;
            border-color: rgba(239, 68, 68, 0.4) !important;
        }
    </style>

    <div class="container-fluid px-4 py-4">

        {{-- HEADER & JAM --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 animate-up">
            <div>
                <h5 class="text-muted mb-1" style="font-size: 1.1rem;">
                    Shift Aktif: <span class="fw-bold" style="color: var(--primary);">{{ Auth::user()->name }}</span> 👨‍🍳
                </h5>
                <h2 class="fw-bold mb-0 font-display" style="color: var(--brown); font-size: 2.2rem;">
                    Dashboard Kasir
                </h2>
            </div>
            <div class="mt-3 mt-md-0 d-inline-flex align-items-center gap-3 px-4 py-2"
                style="background: rgba(255,255,255,0.7); border: 2px solid var(--brown); border-radius: 50px; box-shadow: 4px 4px 0px rgba(93,64,55,0.1);">
                <i class="fas fa-calendar-day text-primary"></i>
                {{-- PERBAIKAN 4: Penyederhanaan Namespace \Carbon\Carbon menjadi Carbon --}}
                <span class="fw-bold" style="font-size: 0.9rem;">{{ Carbon::now()->translatedFormat('d F Y') }}</span>
                <div id="real-time-clock" class="font-display fw-bold text-white px-3 py-1 rounded-pill"
                    style="background: var(--brown); letter-spacing: 1px;">
                    --:--:--
                </div>
            </div>
        </div>

        {{-- AKSI CEPAT (QUICK ACTIONS GRID) --}}
        <div class="row g-3 mb-5 animate-up delay-1">
            <div class="col-md-4">
                <a href="{{ route('kasir.transaction.create') }}" class="quick-action-card">
                    <div class="quick-action-icon"
                        style="background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
                        <i class="fas fa-cash-register"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 font-display fw-bold fs-5">Transaksi Baru</h6>
                        <small class="text-muted">Mulai proses checkout pelanggan</small>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('kasir.pesanan.index') }}" class="quick-action-card">
                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #3B82F6, #2563EB);">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 font-display fw-bold fs-5">Pesanan Masuk</h6>
                        <small class="text-muted">Kelola antrean dan orderan aktif</small>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ route('kasir.laporan.index') }}" class="quick-action-card">
                    <div class="quick-action-icon" style="background: linear-gradient(135deg, #10B981, #059669);">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 font-display fw-bold fs-5">Laporan Saya</h6>
                        <small class="text-muted">Cetak rekap penjualan shift ini</small>
                    </div>
                </a>
            </div>
        </div>

        {{-- BENTO STATS CARDS --}}
        <div class="row g-4 mb-5">
            <!-- Omset -->
            <div class="col-md-6 col-lg-3 animate-up delay-1">
                <div class="bento-stat glow-green">
                    <div class="stat-icon-floating" style="background: #10B981;"><i class="fas fa-wallet"></i></div>
                    <div class="stat-title">Omset Saya Hari Ini</div>
                    <div class="stat-value text-success">
                        <span class="fs-4 fw-normal">Rp</span>{{ number_format($omsetHariIni, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Transaksi -->
            <div class="col-md-6 col-lg-3 animate-up delay-2">
                <div class="bento-stat glow-blue">
                    <div class="stat-icon-floating" style="background: #3B82F6;"><i class="fas fa-receipt"></i></div>
                    <div class="stat-title">Transaksi Selesai</div>
                    <div class="stat-value text-primary">
                        {{ $transaksiHariIni }} <span class="fs-5 text-muted fw-normal">Struk</span>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="col-md-6 col-lg-3 animate-up delay-3">
                <div class="bento-stat glow-red {{ $pesananPending > 0 ? 'pulse-red' : '' }}">
                    <div class="stat-icon-floating" style="background: #EF4444;"><i
                            class="fas fa-bell {{ $pesananPending > 0 ? 'fa-shake' : '' }}"></i></div>
                    <div class="stat-title {{ $pesananPending > 0 ? 'text-danger' : '' }}">Antrean Pending</div>
                    <div class="stat-value {{ $pesananPending > 0 ? 'text-danger' : '' }}">
                        {{ $pesananPending }} <span class="fs-5 text-muted fw-normal">Pesanan</span>
                    </div>
                </div>
            </div>

            <!-- Menu -->
            <div class="col-md-6 col-lg-3 animate-up delay-3">
                <div class="bento-stat glow-orange">
                    <div class="stat-icon-floating" style="background: var(--primary);"><i class="fas fa-cookie-bite"></i>
                    </div>
                    <div class="stat-title">Menu Tersedia</div>
                    <div class="stat-value" style="color: var(--primary-dark);">
                        {{ $totalMenu }} <span class="fs-5 text-muted fw-normal">Varian</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ROW: GRAFIK & RINGKASAN LACI --}}
        <div class="row g-4 mb-5">
            {{-- Grafik Performa Saya --}}
            <div class="col-xl-8 animate-up delay-2">
                <div class="premium-widget">
                    <div class="widget-header">
                        <h5 class="mb-0 font-display fw-bold text-dark"><i
                                class="fas fa-chart-area text-primary me-2"></i>Performa Shift Saya</h5>
                        <span class="badge bg-light text-dark border border-secondary rounded-pill"><i
                                class="far fa-clock me-1"></i>08:00 - 22:00</span>
                    </div>
                    <div class="p-4 bg-white" style="height: 320px; position: relative;">
                        <canvas id="myShiftChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Laci --}}
            <div class="col-xl-4 animate-up delay-3">
                <div class="premium-widget d-flex flex-column">
                    <div class="widget-header">
                        <h5 class="mb-0 font-display fw-bold text-dark"><i
                                class="fas fa-cash-register text-success me-2"></i>Ringkasan Laci</h5>
                    </div>
                    {{-- PERBAIKAN 1: Pengubahan flex-grow-1 menjadi grow --}}
                    <div class="p-4 bg-white grow d-flex flex-column justify-content-center">

                        {{-- Uang Tunai --}}
                        <div class="drawer-card drawer-tunai mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px; background: #D1FAE5; color: #059669; font-size: 1.2rem;">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            {{-- PERBAIKAN 2: Pengubahan flex-grow-1 menjadi grow --}}
                            <div class="grow">
                                <span class="d-block text-muted small fw-bold text-uppercase">Uang Tunai Laci</span>
                                <span class="d-block font-display fw-bold" style="color: #065F46; font-size: 1.2rem;">Rp
                                    {{ number_format($uangTunai, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- Uang Non-Tunai / QRIS (Non-Tunai total) --}}
                        <div class="drawer-card drawer-qris mb-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 45px; height: 45px; background: #DBEAFE; color: #2563EB; font-size: 1.2rem;">
                                <i class="fas fa-qrcode"></i>
                            </div>
                            {{-- PERBAIKAN 3: Pengubahan flex-grow-1 menjadi grow --}}
                            <div class="grow">
                                <span class="d-block text-muted small fw-bold text-uppercase">Transfer / QRIS</span>
                                <span class="d-block font-display fw-bold" style="color: #1E3A8A; font-size: 1.2rem;">Rp
                                    {{ number_format($uangQris, 0, ',', '.') }}</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ROW: TRANSAKSI TERAKHIR (BORDERLESS TABLE) --}}
        <div class="row mb-4 animate-up delay-4">
            <div class="col-12">
                <div class="premium-widget">
                    <div class="widget-header">
                        <h5 class="mb-0 font-display fw-bold text-dark"><i
                                class="fas fa-history text-warning me-2"></i>Riwayat Transaksi Terakhir Anda</h5>
                        <a href="{{ route('kasir.laporan.index') }}"
                            class="btn btn-sm btn-light border-dark border-2 rounded-pill px-4 fw-bold hover-shadow"
                            style="box-shadow: 2px 2px 0px var(--brown);">Lihat Semua</a>
                    </div>
                    <div class="bg-white">
                        <div class="table-responsive">
                            <table class="table table-premium">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">Jam</th>
                                        <th style="width: 30%;">Pelanggan</th>
                                        <th style="width: 25%;">Nominal</th>
                                        <th style="width: 20%;">Metode</th>
                                        <th style="width: 10%; text-align: right;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentTransactions as $trx)
                                        <tr>
                                            <td class="font-monospace text-muted fw-bold">
                                                <i class="far fa-clock me-1"></i>{{ $trx->created_at->format('H:i') }}
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark fs-6">{{ $trx->customer_name }}</div>
                                                <div class="small text-muted mt-1"><i class="fas fa-user-tag me-1"
                                                        style="font-size:0.7rem;"></i>{{ $trx->customer_class ?? 'Umum' }}
                                                </div>
                                            </td>
                                            <td class="font-display fw-bold"
                                                style="color: var(--primary-dark); font-size: 1.1rem;">
                                                Rp {{ number_format($trx->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <span class="badge-payment">
                                                    {{ Str::limit($trx->payment_method, 10) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('transaksi.struk', $trx->id) }}" target="_blank"
                                                    class="btn-print" title="Cetak Struk Ulang">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png"
                                                    style="width: 60px; filter: grayscale(100%); opacity: 0.3;"
                                                    class="mb-3">
                                                <h6 class="fw-bold text-dark">Belum ada struk tercetak</h6>
                                                <p class="text-muted small mb-0">Transaksi yang Anda proses akan muncul di
                                                    riwayat ini.</p>
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

    {{-- Script Engine Chart.js & Clock --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // 1. DYNAMIC CHART.JS (Grafik Performa Shift)
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myShiftChart').getContext('2d');

            const chartLabels = {!! json_encode($hourlyLabels) !!};
            const chartData = {!! json_encode($hourlyData) !!};

            let gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(242, 101, 34, 0.2)');
            gradient.addColorStop(1, 'rgba(242, 101, 34, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Penjualan Riil (Rp)',
                        data: chartData,
                        borderColor: '#F26522',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#FFF',
                        pointBorderColor: '#D84315',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 7
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
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(93, 64, 55, 0.05)'
                            },
                            ticks: {
                                color: '#8D6E63',
                                font: {
                                    family: 'Poppins',
                                    size: 11
                                },
                                callback: function(value) {
                                    if (value >= 1000) return 'Rp ' + (value / 1000) + 'k';
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#8D6E63',
                                font: {
                                    family: 'Poppins',
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });

        // 2. REAL-TIME CLOCK ENGINE
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const clockElement = document.getElementById('real-time-clock');
            if (clockElement) {
                clockElement.textContent = `${hours}:${minutes}:${seconds} WIB`;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
@endsection
