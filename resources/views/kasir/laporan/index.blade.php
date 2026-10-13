@extends('kasir.layouts.app')

@section('title', 'Laporan Penjualan & Riwayat Struk')

@section('content')
    {{-- Import Font Premium --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #F26522;
            --primary-glow: rgba(242, 101, 34, 0.15);
            --primary-dark: #d64f12;
            --brown: #5D4037;
            --brown-light: #8D6E63;
            --cream: #FFF8E1;
            --cream-dark: #F5EBE6;
            --white: #FFFFFF;
            --success: #10b981;
            --success-glow: rgba(16, 185, 129, 0.15);
            --info: #0284c7;
            --info-glow: rgba(2, 132, 199, 0.15);
            --bg-gray: #FAF8F5;
            --border-color: #F1EAE2;
        }

        /* --- 1. SINGLE FRAME LAYOUT (100VH) --- */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-gray);
            color: var(--brown);
            margin: 0;
            overflow-x: hidden;
        }

        .report-wrapper {
            height: calc(100vh - 85px);
            /* Menyesuaikan Navbar Kasir Anda */
            min-height: 650px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 20px;
            gap: 20px;
            background-color: var(--bg-gray);
        }

        h1,
        h2,
        h3,
        h4,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- Custom Scrollbar --- */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background-color: #E2D6CA;
            border-radius: 10px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #C8B29C;
        }

        /* --- Header Premium --- */
        .report-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 16px 28px;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(93, 64, 55, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-left: 6px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        /* Pulse Sync Effect */
        .pulse-dot {
            width: 8px;
            height: 8px;
            background-color: var(--success);
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulseSync 1.8s infinite;
        }

        @keyframes pulseSync {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* --- Layout Dua Kolom Kerja --- */
        .report-body {
            display: flex;
            flex: 1;
            gap: 20px;
            overflow: hidden;
            width: 100%;
        }

        /* --- 2. SISI KIRI (STATISTIK & RIWAYAT) --- */
        .report-left {
            width: 45%;
            display: flex;
            flex-direction: column;
            gap: 20px;
            height: 100%;
            overflow: hidden;
        }

        /* Bento Grid Glassmorphism Stats */
        .glass-stats-container {
            display: flex;
            gap: 16px;
            flex-shrink: 0;
        }

        .glass-stat-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 22px;
            padding: 18px 24px;
            flex: 1;
            display: flex;
            align-items: center;
            gap: 18px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-stat-card.omset-card {
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.04),
                inset 0 0 0 1px rgba(16, 185, 129, 0.1);
        }

        .glass-stat-card.struk-card {
            box-shadow: 0 10px 25px rgba(2, 132, 199, 0.04),
                inset 0 0 0 1px rgba(2, 132, 199, 0.1);
        }

        .glass-stat-card:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.85);
        }

        .glass-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .omset-card .glass-stat-icon {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .struk-card .glass-stat-icon {
            background: rgba(2, 132, 199, 0.1);
            color: var(--info);
        }

        .glass-stat-card:hover .glass-stat-icon {
            transform: scale(1.1);
        }

        /* Daftar Transaksi Selesai */
        .history-list {
            flex: 1;
            overflow-y: auto;
            padding-right: 6px;
        }

        .history-card {
            background: #ffffff;
            border: 1.5px solid rgba(93, 64, 55, 0.05);
            border-radius: 20px;
            padding: 18px 22px;
            margin-bottom: 14px;
            box-shadow: 0 4px 12px rgba(93, 64, 55, 0.02);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .history-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0px;
            background: var(--primary);
            transition: all 0.3s ease;
        }

        .history-card:hover {
            transform: translateY(-3px) scale(1.005);
            box-shadow: 0 12px 24px rgba(93, 64, 55, 0.06);
            border-color: rgba(242, 101, 34, 0.15);
        }

        .history-card.active {
            border-color: var(--primary);
            box-shadow: 0 10px 30px var(--primary-glow), inset 0 0 0 1px var(--primary-glow);
            background-color: #FFFDF9;
        }

        .history-card.active::before {
            width: 5px;
        }

        /* Badge Status Selesai dengan Pulse */
        .status-badge-premium {
            background-color: rgba(16, 185, 129, 0.08);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* --- 3. SISI KANAN (PRATINJAU STRUK TERMAL) --- */
        .report-right {
            width: 55%;
            background: #EBE5DC;
            /* Replika Tekstur Meja Kasir Eksklusif */
            border-radius: 28px;
            box-shadow: inset 0 8px 20px rgba(0, 0, 0, 0.06), 0 10px 30px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            border: 1px solid rgba(255, 255, 255, 0.5);
            height: 100%;
        }

        /* Empty State */
        .empty-receipt-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: var(--brown);
            text-align: center;
            padding: 40px;
            opacity: 0.85;
            animation: fadeIn 0.5s ease-out;
        }

        .empty-receipt-icon {
            font-size: 4.5rem;
            color: #C1B4A5;
            margin-bottom: 20px;
            animation: floatSlow 4s ease-in-out infinite;
        }

        @keyframes floatSlow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* Wrapper Transisi Struk Aktif */
        .receipt-preview-wrapper {
            display: none;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
        }

        .receipt-preview-wrapper.active {
            display: flex;
            animation: slideInUpReceipt 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideInUpReceipt {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* KERTAS TERMAL REALISTIS (3D LUXURY) */
        .thermal-paper-container {
            flex: 1;
            overflow-y: auto;
            padding: 30px 40px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .thermal-paper {
            background: #FCFAF7;
            width: 100%;
            max-width: 410px;
            padding: 35px 28px;
            box-shadow: 0 25px 60px rgba(93, 64, 55, 0.15),
                0 5px 15px rgba(0, 0, 0, 0.05);
            font-family: 'Courier Prime', 'Courier New', Courier, monospace;
            color: #2D2522;
            font-size: 0.88rem;
            line-height: 1.5;
            position: relative;
            border-radius: 4px;
        }

        /* Desain Robekan Kertas Atas & Bawah */
        .thermal-paper::before,
        .thermal-paper::after {
            content: '';
            position: absolute;
            left: 0;
            width: 100%;
            height: 8px;
            background-size: 14px 8px;
        }

        .thermal-paper::before {
            top: -8px;
            background-image: linear-gradient(135deg, #FCFAF7 25%, transparent 25%),
                linear-gradient(225deg, #FCFAF7 25%, transparent 25%);
        }

        .thermal-paper::after {
            bottom: -8px;
            background-image: linear-gradient(45deg, #FCFAF7 25%, transparent 25%),
                linear-gradient(-45deg, #FCFAF7 25%, transparent 25%);
        }

        /* Header Struk */
        .thermal-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px dashed #D3C5B5;
            padding-bottom: 20px;
        }

        .thermal-logo {
            width: 65px;
            height: auto;
            margin-bottom: 12px;
            filter: grayscale(100%) contrast(120%);
        }

        .thermal-store-name {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 4px;
            color: #111;
        }

        /* Detail Info */
        .thermal-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.85rem;
            border-bottom: 1.5px dashed #D3C5B5;
            padding-bottom: 12px;
        }

        /* Tabel Produk */
        .thermal-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .thermal-table th {
            border-bottom: 2px dashed #D3C5B5;
            padding-bottom: 10px;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.82rem;
            color: #111;
        }

        .thermal-table td {
            padding: 8px 0;
            vertical-align: top;
        }

        /* Detail Kalkulasi Total */
        .thermal-totals {
            border-top: 2px dashed #D3C5B5;
            padding-top: 14px;
            margin-bottom: 20px;
        }

        .thermal-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .thermal-row.grand-total {
            font-weight: 800;
            font-size: 1.1rem;
            color: #111;
            margin-top: 10px;
            border-top: 1.5px dashed #D3C5B5;
            padding-top: 10px;
        }

        /* Barcode CSS */
        .receipt-barcode {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 25px 0 15px 0;
        }

        .barcode-bars {
            height: 40px;
            width: 180px;
            background: repeating-linear-gradient(90deg,
                    #2D2522,
                    #2D2522 2px,
                    transparent 2px,
                    transparent 5px,
                    #2D2522 5px,
                    #2D2522 8px,
                    transparent 8px,
                    transparent 10px);
            opacity: 0.85;
        }

        .barcode-text {
            font-size: 0.75rem;
            letter-spacing: 3px;
            margin-top: 6px;
            color: #555;
        }

        /* Footer Struk */
        .thermal-footer {
            text-align: center;
            border-top: 1.5px dashed #D3C5B5;
            padding-top: 18px;
            font-size: 0.8rem;
            font-style: italic;
            line-height: 1.4;
        }

        /* --- 4. TOMBOL CETAK ULANG SHIMMERING (FIXED FOOTER) --- */
        .receipt-action-area {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 20px 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            flex-shrink: 0;
            border-bottom-left-radius: 28px;
            border-bottom-right-radius: 28px;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.03);
        }

        .btn-print-huge {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white !important;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 16px;
            border-radius: 50px;
            /* Rounded Pill */
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            box-shadow: 0 10px 25px var(--primary-glow);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: 'Fredoka', sans-serif;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        /* Shimmering Effect */
        .btn-print-huge::after {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-25deg);
            animation: shimmeringEffect 4s infinite;
            z-index: -1;
        }

        @keyframes shimmeringEffect {
            0% {
                left: -150%;
            }

            20% {
                left: 200%;
            }

            100% {
                left: 200%;
            }
        }

        .btn-print-huge:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(242, 101, 34, 0.35);
        }

        .btn-print-huge:active {
            transform: translateY(2px) scale(0.98);
        }

        /* --- RESPONSIVE UNTUK LAYOUT UTAMA --- */
        @media (max-width: 991px) {
            .report-wrapper {
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }

            .report-body {
                flex-direction: column;
                overflow: visible;
            }

            .report-left {
                width: 100%;
                height: 550px;
            }

            .report-right {
                width: 100%;
                min-height: 650px;
            }

            .glass-stats-container {
                flex-direction: row;
            }
        }

        @media (max-width: 576px) {
            .glass-stats-container {
                flex-direction: column;
            }

            .report-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>

    <div class="container-fluid report-wrapper">

        {{-- Header Halaman Premium --}}
        <div class="report-header">
            <div>
                <h2 class="fw-bold m-0 text-brown font-display">Laporan Kasir</h2>
                <p class="text-muted small m-0 mt-1">Pantau performa harian dan pratinjau detail struk yang Anda proses.</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 px-4 py-2 rounded-pill border border-success border-opacity-20 text-success font-display fw-bold d-flex align-items-center gap-2"
                    style="font-size: 0.95rem;">
                    <span class="pulse-dot"></span> Sinkronisasi Selesai
                </div>
            </div>
        </div>

        {{-- Menghitung statistik penjualan --}}
        @php
            $totalOmset = $transactions->sum('total_amount');
            $totalStruk = $transactions->count();
        @endphp

        {{-- Area Kerja Utama Dua Kolom --}}
        <div class="report-body">

            {{-- KOLOM KIRI: STATISTIK & RIWAYAT TRANSAKSI --}}
            <div class="report-left">

                {{-- Glassmorphism Stats --}}
                <div class="glass-stats-container">
                    <div class="glass-stat-card omset-card">
                        <div class="glass-stat-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <span class="d-block small text-muted fw-bold text-uppercase"
                                style="font-size: 0.75rem; letter-spacing: 0.5px;">Omset Diproses</span>
                            <h4 class="font-display fw-bold m-0 mt-1" style="color: var(--success); font-size: 1.45rem;">
                                Rp {{ number_format($totalOmset, 0, ',', '.') }}
                            </h4>
                        </div>
                    </div>
                    <div class="glass-stat-card struk-card">
                        <div class="glass-stat-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <span class="d-block small text-muted fw-bold text-uppercase"
                                style="font-size: 0.75rem; letter-spacing: 0.5px;">Struk Terbit</span>
                            <h4 class="font-display fw-bold m-0 mt-1 text-dark" style="font-size: 1.45rem;">
                                {{ $totalStruk }} Transaksi
                            </h4>
                        </div>
                    </div>
                </div>

                {{-- Daftar Transaksi --}}
                <div class="history-list custom-scroll">
                    @forelse ($transactions as $transaction)
                        <div class="history-card" id="row-{{ $transaction->id }}"
                            onclick="showReceipt({{ $transaction->id }})">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <span class="badge bg-dark text-white fw-bold me-2 px-2 py-1 rounded"
                                        style="font-family: monospace;">#{{ $transaction->id }}</span>
                                    <span class="status-badge-premium">
                                        <i class="fas fa-circle-check"></i> Selesai
                                    </span>
                                </div>
                                <div class="small text-muted fw-medium">
                                    <i class="far fa-clock me-1"></i>{{ $transaction->created_at->format('H:i') }} WIB
                                </div>
                            </div>

                            <h6 class="fw-bold text-dark mb-1 font-display" style="font-size: 1.05rem;">
                                {{ $transaction->customer_name ?? 'Pelanggan Umum' }}
                            </h6>

                            <div class="d-flex justify-content-between align-items-end mt-2 pt-2 border-top border-light">
                                <div class="small text-muted fw-semibold">
                                    <i class="fas fa-credit-card me-1 text-primary"></i> {{ $transaction->payment_method }}
                                </div>
                                <div class="fw-bold fs-5 text-brown font-display">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted mt-4 bg-white rounded-4 border border-light"
                            style="border-radius: 24px !important;">
                            <i class="fas fa-file-circle-xmark fs-1 mb-3 opacity-25" style="color: var(--primary);"></i>
                            <h4 class="font-display">Belum Ada Transaksi</h4>
                            <p class="small">Riwayat penjualan Anda saat ini masih kosong.</p>
                            <a href="{{ route('kasir.transaction.create') }}"
                                class="btn btn-primary rounded-pill px-4 mt-2">
                                Mulai Kasir
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- KOLOM KANAN: PRATINJAU STRUK TERMAL --}}
            <div class="report-right">

                {{-- State Belum Memilih Transaksi --}}
                <div class="empty-receipt-state" id="emptyState">
                    <i class="fas fa-receipt empty-receipt-icon"></i>
                    <h3 class="font-display mb-2" style="font-weight: 700; color: var(--brown);">Pratinjau Struk</h3>
                    <p class="small text-muted px-4">Klik salah satu kartu transaksi di sebelah kiri<br>untuk menampilkan
                        replika cetakan struk belanja.</p>
                </div>

                {{-- Render Semua Wrapper Struk (Disembunyikan, diaktifkan via JS) --}}
                @foreach ($transactions as $transaction)
                    <div class="receipt-preview-wrapper" id="receipt-{{ $transaction->id }}">

                        {{-- Kertas Struk Termal --}}
                        <div class="thermal-paper-container custom-scroll">
                            <div class="thermal-paper">

                                {{-- Header Struk --}}
                                <div class="thermal-header">
                                    <img src="{{ asset('img/thecookies.png') }}"
                                        onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/3063/3063822.png'"
                                        alt="Tho Cookies Logo" class="thermal-logo">
                                    <div class="thermal-store-name">THO COOKIES</div>
                                    <div style="font-size: 0.78rem; opacity: 0.85;">Signature Artisan Cookies</div>
                                    <div style="font-size: 0.75rem; opacity: 0.8; margin-top: 4px;">Ruko Premium Boulevard
                                        Blok C-10</div>
                                    <div style="font-size: 0.75rem; opacity: 0.8;">Telp: 0812-3456-7890</div>
                                </div>

                                {{-- Info Utama Transaksi --}}
                                <div class="thermal-info">
                                    <div>
                                        WAKTU: {{ $transaction->created_at->format('d/m/Y H:i') }}<br>
                                        KASIR: {{ Auth::user()->name ?? 'Kasir Utama' }}
                                    </div>
                                    <div style="text-align: right;">
                                        STRUK: #{{ $transaction->id }}<br>
                                        PELG : {{ Str::limit($transaction->customer_name ?? 'Umum', 10) }}
                                    </div>
                                </div>

                                {{-- Tabel Daftar Item / Produk --}}
                                <table class="thermal-table">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;">PRODUK</th>
                                            <th style="text-align: right; width: 30%;">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction->details as $detail)
                                            <tr>
                                                <td style="padding-top: 10px;">
                                                    <span
                                                        style="font-weight: 700; color: #111;">{{ Str::limit($detail->product->name, 22) }}</span><br>
                                                    <span>{{ $detail->quantity }} x Rp
                                                        {{ number_format($detail->price ?? $transaction->total_amount / max($transaction->details->sum('quantity'), 1), 0, ',', '.') }}</span>
                                                </td>
                                                <td
                                                    style="text-align: right; vertical-align: bottom; font-weight: 700; padding-top: 10px; color: #111;">
                                                    Rp
                                                    {{ number_format(($detail->price ?? $transaction->total_amount / max($transaction->details->sum('quantity'), 1)) * $detail->quantity, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- Bagian Kalkulasi Total Pembayaran --}}
                                <div class="thermal-totals">
                                    @php
                                        // RENCANA LOGIKA BARU YANG CERDAS & PRESISI:
                                        // 1. Ambil nilai dasar transaksi
                                        $subtotal = $transaction->total_amount;
                                        $diskon = $transaction->discount_amount ?? 0;
                                        $grandTotal = $subtotal - $diskon;

                                        // 2. Evaluasi Uang Bayar:
                                        //    Jika data payment_amount di database bernilai valid (tidak null, tidak nol, dan tidak kosong),
                                        //    maka gunakan data tersebut. Jika tidak (untuk pesanan lama/pesanan mandiri non-tunai),
                                        //    maka sistem secara dinamis akan menganggap bayarnya adalah UANG PAS ($grandTotal) [4].
                                        $bayar =
                                            isset($transaction->payment_amount) && $transaction->payment_amount > 0
                                                ? $transaction->payment_amount
                                                : $grandTotal;

                                        // 3. Evaluasi Kembalian:
                                        //    Jika data change_amount di database bernilai valid, gunakan itu.
                                        //    Jika tidak, hitung selisihnya secara otomatis: ($bayar - $grandTotal).
                                        //    Amankan agar kembalian tidak pernah bernilai minus di struk.
                                        $kembali =
                                            isset($transaction->change_amount) &&
                                            $transaction->change_amount >= 0 &&
                                            $transaction->payment_amount > 0
                                                ? $transaction->change_amount
                                                : ($bayar > $grandTotal
                                                    ? $bayar - $grandTotal
                                                    : 0);
                                    @endphp

                                    <div class="thermal-row">
                                        <span>SUBTOTAL</span>
                                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    @if ($diskon > 0)
                                        <div class="thermal-row" style="color: #ef4444;">
                                            <span>DISKON MEMBER</span>
                                            <span>-Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                                        </div>
                                    @endif

                                    <div class="thermal-row grand-total">
                                        <span>TOTAL</span>
                                        <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                                    </div>

                                    <div style="border-top: 1.5px dashed #D3C5B5; margin: 12px 0 8px 0;"></div>

                                    <div class="thermal-row" style="opacity: 0.9;">
                                        <span>BAYAR ({{ $transaction->payment_method }})</span>
                                        <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="thermal-row" style="opacity: 0.9;">
                                        <span>KEMBALI</span>
                                        <span>Rp {{ number_format($kembali, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                {{-- Barcode Estetis Struk --}}
                                <div class="receipt-barcode">
                                    <div class="barcode-bars"></div>
                                    <div class="barcode-text">TC-{{ $transaction->id }}</div>
                                </div>

                                {{-- Pesan Hangat Penutup --}}
                                <div class="thermal-footer">
                                    "Terima kasih atas kunjungan Anda.<br>
                                    Semoga harimu selalu manis<br>
                                    bersama Tho Cookies!"
                                </div>
                            </div>
                        </div>

                        {{-- Panel Tombol Aksi Bawah --}}
                        <div class="receipt-action-area">
                            <a href="{{ route('transaksi.struk', $transaction->id) }}" target="_blank"
                                class="btn-print-huge">
                                <i class="fas fa-print"></i> CETAK ULANG STRUK
                            </a>
                        </div>

                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Mempertahankan fungsi inti dan melengkapinya dengan animasi transisi yang mulus
        function showReceipt(id) {
            // 1. Reset highlight kartu sebelah kiri
            document.querySelectorAll('.history-card').forEach(card => {
                card.classList.remove('active');
            });

            // 2. Highlight kartu yang diklik
            const selectedCard = document.getElementById('row-' + id);
            if (selectedCard) {
                selectedCard.classList.add('active');
            }

            // 3. Sembunyikan pesan kosong
            const emptyState = document.getElementById('emptyState');
            if (emptyState) {
                emptyState.style.display = 'none';
            }

            // 4. Sembunyikan semua pembungkus pratinjau struk
            document.querySelectorAll('.receipt-preview-wrapper').forEach(wrapper => {
                wrapper.classList.remove('active');
            });

            // 5. Tampilkan struk terpilih dengan transisi masuk
            const targetReceipt = document.getElementById('receipt-' + id);
            if (targetReceipt) {
                targetReceipt.classList.add('active');

                // Atur agar scroll container struk langsung ke posisi paling atas
                const scrollContainer = targetReceipt.querySelector('.thermal-paper-container');
                if (scrollContainer) {
                    scrollContainer.scrollTop = 0;
                }
            }
        }
    </script>
@endpush
