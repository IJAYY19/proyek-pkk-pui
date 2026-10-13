@extends('admin.layouts.app')

@section('title', 'Laporan & Analitik Transaksi')

@section('content')
    {{-- Import Font & CDN --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #F26522;
            --primary-dark: #D84315;
            --brown: #5D4037;
            --cream: #FFF8E1;
            --white: #FFFFFF;
            --yellow: #FFC107;
            --emerald: #10B981;
            --emerald-bg: #D1FAE5;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream);
            color: var(--brown);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- MIKRO INTERAKSI & ANIMASI --- */
        .animate-up {
            opacity: 0;
            animation: slideInUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* --- 1. PANEL FILTER & TOMBOL EKSPOR ELEGAN --- */
        .filter-panel {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 15px 25px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 32px rgba(93, 64, 55, 0.05);
            margin-bottom: 25px;
        }

        .date-input-group {
            background: #fff;
            border-radius: 50px;
            padding: 5px 20px;
            display: flex;
            align-items: center;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(93, 64, 55, 0.1);
            transition: all 0.3s;
        }

        .date-input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(242, 101, 34, 0.15);
        }

        .date-input-group:focus-within i {
            color: var(--primary) !important;
        }

        .date-input {
            border: none;
            outline: none;
            background: transparent;
            padding: 8px 10px;
            font-size: 0.9rem;
            color: var(--brown);
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
        }

        .btn-capsule {
            border-radius: 50px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-glow-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            box-shadow: 0 4px 15px rgba(242, 101, 34, 0.3);
        }

        .btn-glow-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(242, 101, 34, 0.4);
            color: white;
        }

        .btn-glow-pdf {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-glow-pdf:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
            color: white;
        }

        .btn-glow-excel {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.3);
        }

        .btn-glow-excel:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(46, 204, 113, 0.4);
            color: white;
        }

        /* --- 2. BENTO GRID (GLASSMORPHISM) --- */
        .bento-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 24px;
            padding: 25px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(93, 64, 55, 0.04);
            transition: all 0.4s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .bento-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 15px 40px rgba(242, 101, 34, 0.08);
            border-color: rgba(242, 101, 34, 0.2);
        }

        .bento-icon {
            position: absolute;
            right: -10px;
            bottom: -15px;
            font-size: 6rem;
            opacity: 0.04;
            color: var(--brown);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            transform: rotate(-10deg);
        }

        .bento-card:hover .bento-icon {
            opacity: 0.1;
            color: var(--primary);
            transform: rotate(0deg) scale(1.1);
        }

        .bento-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: #888;
            margin-bottom: 5px;
        }

        .bento-value {
            font-family: 'Fredoka', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--brown);
            line-height: 1.2;
        }

        .bento-value.text-primary {
            color: var(--primary) !important;
        }

        /* --- 3. CHART CARD --- */
        .chart-card {
            background: #fff;
            border-radius: 24px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 40px rgba(93, 64, 55, 0.06);
            margin-bottom: 30px;
        }

        /* --- 4. REDESAIN TABEL LAPORAN TRANSAKSI --- */
        .table-card {
            background: #fff;
            border-radius: 24px;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(93, 64, 55, 0.06);
            border: none;
        }

        .table-modern {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead th {
            background-color: #fafafa;
            color: #9e9e9e;
            font-family: 'Fredoka', sans-serif;
            font-size: 0.85rem;
            padding: 20px 25px;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid #eee;
            font-weight: 500;
        }

        .table-modern tbody td {
            padding: 20px 25px;
            vertical-align: middle;
            border-bottom: 1px dashed rgba(93, 64, 55, 0.15);
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .table-modern tbody tr:last-child td {
            border-bottom: none;
        }

        /* Row Hover Highlight Tipis */
        .table-modern tbody tr {
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .table-modern tbody tr:hover td {
            background-color: rgba(255, 248, 225, 0.6);
            /* Warna krem tipis */
        }

        .table-modern tbody tr:hover {
            transform: scale(1.002);
        }

        /* Lencana Status Emerald Green */
        .badge-status {
            background-color: var(--emerald-bg);
            color: var(--emerald);
            padding: 6px 14px;
            border-radius: 50px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid rgba(16, 185, 129, 0.2);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-id {
            background-color: #f5f5f5;
            color: var(--brown);
            padding: 5px 12px;
            border-radius: 8px;
            font-family: 'Fredoka', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid #e0e0e0;
        }

        .product-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .product-list li {
            padding: 3px 0;
            font-size: 0.85rem;
            color: #555;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .qty-badge {
            background: rgba(242, 101, 34, 0.1);
            color: var(--primary);
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        /* Print Button Outline */
        .btn-print-modern {
            background: transparent;
            color: var(--brown);
            border: 1px solid rgba(93, 64, 55, 0.3);
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-print-modern:hover {
            background: var(--brown);
            color: var(--white);
            border-color: var(--brown);
            box-shadow: 0 4px 12px rgba(93, 64, 55, 0.2);
        }

        /* --- SEMBUNYIKAN SCROLLBAR DI DESKTOP NAMUN TETAP BERFUNGSI DI MOBILE --- */
        .table-responsive {
            -ms-overflow-style: none;
            /* Untuk Internet Explorer & Edge */
            scrollbar-width: none;
            /* Untuk Firefox */
        }

        .table-responsive::-webkit-scrollbar {
            display: none;
            /* Untuk Chrome, Safari, dan Opera */
        }
    </style>

    <div class="container-fluid px-0 pb-5">

        {{-- Header Title --}}
        <div class="d-flex align-items-center mb-4 pt-3 animate-up">
            <div class="bg-white rounded-circle p-3 shadow-sm me-3">
                <i class="fas fa-chart-line text-primary fs-3"></i>
            </div>
            <div>
                <h2 class="fw-bold mb-0" style="color: var(--brown);">Analitik & Laporan</h2>
                <p class="text-muted mb-0">Pantau performa penjualan dan wawasan data transaksi Anda.</p>
            </div>
        </div>

        {{-- 1. PANEL FILTER & TOMBOL EKSPOR --}}
        <div class="filter-panel animate-up delay-1">
            <form action="{{ route('admin.reports.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5 d-flex gap-3">
                    <div class="date-input-group flex-grow-1">
                        <i class="far fa-calendar-alt text-muted me-2 transition-all"></i>
                        <input type="date" name="start_date" class="date-input w-100" placeholder="Dari Tanggal"
                            value="{{ request('start_date') }}">
                    </div>
                    <div class="date-input-group flex-grow-1">
                        <i class="far fa-calendar-alt text-muted me-2 transition-all"></i>
                        <input type="date" name="end_date" class="date-input w-100" placeholder="Sampai Tanggal"
                            value="{{ request('end_date') }}">
                    </div>
                </div>

                <div class="col-md-7 d-flex justify-content-md-end gap-2">
                    <button type="submit" class="btn-capsule btn-glow-primary">
                        <i class="fas fa-search"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- 2. BENTO GRID STATS --}}
        @php
            // Kalkulasi dinamis langsung dari variabel $transactions (Fallback UI jika controller belum mengirim variabel khusus)
            $totalPendapatan = $transactions->sum('total_amount');
            $totalTransaksi = $transactions->count();
            $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

            // Menghitung total item terjual (mengambil dari relasi details)
            $totalItemTerjual = 0;
            foreach ($transactions as $trx) {
                if (isset($trx->details)) {
                    $totalItemTerjual += $trx->details->sum('quantity');
                }
            }
        @endphp
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3 animate-up delay-1">
                <div class="bento-card">
                    <i class="fas fa-wallet bento-icon"></i>
                    <div class="bento-title">Total Pendapatan</div>
                    <div class="bento-value text-primary">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 animate-up delay-2">
                <div class="bento-card">
                    <i class="fas fa-receipt bento-icon"></i>
                    <div class="bento-title">Total Transaksi</div>
                    <div class="bento-value">{{ $totalTransaksi }} <span class="fs-6 fw-normal text-muted">Struk</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 animate-up delay-3">
                <div class="bento-card">
                    <i class="fas fa-chart-pie bento-icon"></i>
                    <div class="bento-title">Rata-Rata Penjualan</div>
                    <div class="bento-value">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 animate-up delay-4">
                <div class="bento-card">
                    <i class="fas fa-cookie-bite bento-icon"></i>
                    <div class="bento-title">Item Terjual</div>
                    <div class="bento-value">{{ $totalItemTerjual }} <span class="fs-6 fw-normal text-muted">Pcs</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. GRAFIK INTERAKTIF CHART.JS --}}
        <div class="row mb-4 animate-up delay-4">
            <div class="col-12">
                <div class="chart-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold font-display text-dark mb-0">Tren Penjualan Terakhir</h5>
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">Data Dinamis</span>
                    </div>
                    <div style="height: 300px; width: 100%;">
                        <canvas id="salesAnalyticChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. TABEL LAPORAN TRANSAKSI --}}
        <div class="table-card animate-up delay-4 mb-4">
            <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-white">
                <h5 class="fw-bold font-display text-dark mb-0">Rincian Transaksi</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th class="ps-4">ID Transaksi</th>
                            <th>Tanggal & Waktu</th>
                            <th>Detail Pelanggan</th>
                            <th>Rincian Pesanan</th>
                            <th>Status Bayar</th>
                            <th class="text-end">Total Nominal</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge-id">#{{ $transaction->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $transaction->created_at->format('d M Y') }}</div>
                                    <div class="small text-muted"><i
                                            class="far fa-clock me-1"></i>{{ $transaction->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ Str::limit($transaction->customer_name ?? '-', 20) }}
                                    </div>
                                    <div class="small text-muted mt-1 d-flex align-items-center gap-1">
                                        <i class="far fa-user-circle"></i> {{ $transaction->customer_class ?? 'Umum' }}
                                    </div>
                                </td>
                                <td style="min-width: 250px;">
                                    <ul class="product-list">
                                        @if (isset($transaction->details))
                                            @foreach ($transaction->details as $detail)
                                                <li>
                                                    <span class="text-truncate"
                                                        style="max-width: 180px;">{{ $detail->product->name ?? 'Produk' }}</span>
                                                    <span class="qty-badge">{{ $detail->quantity }}x</span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="text-muted fst-italic">Detail tidak tersedia</li>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    {{-- Lencana Status Premium --}}
                                    <span class="badge-status">
                                        <i class="fas fa-check-circle"></i> Lunas
                                    </span>
                                </td>
                                <td class="text-end fw-bold" style="color: var(--primary); font-size: 1.05rem;">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="text-center pe-4">
                                    <a href="{{ route('transaksi.struk', $transaction->id) }}" target="_blank"
                                        class="btn-print-modern" title="Cetak Struk">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div
                                        style="font-size: 3.5rem; opacity: 0.1; color: var(--brown); margin-bottom: 15px;">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <h5 class="text-muted fw-bold">Belum Ada Data Transaksi</h5>
                                    <p class="text-muted small">Terapkan filter tanggal yang berbeda atau tunggu transaksi
                                        masuk.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Script Konfigurasi Chart.js Premium --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('salesAnalyticChart').getContext('2d');

            // 1. Setup Gradasi Mewah untuk Fill Area
            let gradientFill = ctx.createLinearGradient(0, 0, 0, 300);
            gradientFill.addColorStop(0, 'rgba(242, 101, 34, 0.4)'); // Oranye semi-transparan
            gradientFill.addColorStop(1, 'rgba(242, 101, 34, 0.0)'); // Memudar ke bawah

            // Mengumpulkan data dari PHP untuk Chart (Data sederhana berdasarkan 7 transaksi terakhir)
            // Note: Idealnya data chart didapat dari query terpisah di Controller. Ini adalah ekstraksi visual.
            @php
                $chartLabels = [];
                $chartData = [];
                // Mengambil 7 transaksi terakhir untuk ilustrasi grafik
                foreach ($transactions->take(7)->reverse() as $trx) {
                    $chartLabels[] = $trx->created_at->format('d M');
                    $chartData[] = $trx->total_amount;
                }
            @endphp

            const chartData = {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Nominal Penjualan (Rp)',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#F26522', // Oranye murni
                    backgroundColor: gradientFill,
                    borderWidth: 3,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: '#F26522',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    pointHoverBackgroundColor: '#F26522',
                    pointHoverBorderColor: '#FFFFFF',
                    pointHoverBorderWidth: 2,
                    fill: true,
                    tension: 0.4 // Membuat garis melengkung dinamis (smooth tension)
                }]
            };

            const chartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(93, 64, 55, 0.9)', // Tooltip cokelat elegan
                        titleFont: {
                            family: 'Poppins',
                            size: 13
                        },
                        bodyFont: {
                            family: 'Poppins',
                            size: 14,
                            weight: 'bold'
                        },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        minimumFractionDigits: 0
                                    }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: {
                                family: 'Poppins',
                                size: 11
                            },
                            color: '#888'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.04)',
                            drawBorder: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            font: {
                                family: 'Poppins',
                                size: 11
                            },
                            color: '#888',
                            callback: function(value, index, values) {
                                if (value >= 1000000) return (value / 1000000) + ' Jt';
                                if (value >= 1000) return (value / 1000) + ' Rb';
                                return value;
                            }
                        },
                        beginAtZero: true
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            };

            new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: chartOptions
            });
        });
    </script>
@endsection
