<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi #{{ $transaction->id }} - Tho Cookies</title>

    {{-- Import Fonts: Poppins (UI), Fredoka (Heading), Inconsolata (Struk Text), Libre Barcode 39 (Barcode) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=Inconsolata:wght@400;500;700&family=Libre+Barcode+39&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/thecookies.png') }}">

    <style>
        /* ==========================================================================
           1. CSS VARIABEL & RESET
           ========================================================================== */
        :root {
            --primary: #F26522;
            /* Honey Orange */
            --brown-dark: #3E2723;
            /* Cokelat Tua */
            --brown-text: #4A332D;
            /* Teks Struk */
            --cream-bg: #FFFDF9;
            /* Latar Web */
            --paper-color: #FAFAFA;
            /* Warna Kertas Struk */
            --success: #10B981;
            /* Emerald Green */
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--cream-bg);
            /* Pola titik halus estetik untuk layar Web */
            background-image: radial-gradient(var(--brown-dark) 0.5px, transparent 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            padding: 40px 20px 80px;
            /* Ruang bawah ekstra untuk tombol */
        }

        /* ==========================================================================
           2. MODE WEB: SIMULASI 3D STRUK & ELEMEN UI (TIDAK DICETAK)
           ========================================================================== */

        /* Lencana Pembayaran Berhasil */
        .status-badge {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 2px solid var(--success);
            padding: 10px 25px;
            border-radius: 50px;
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.2);
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Container Tombol Aksi */
        .action-buttons {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 15px;
            z-index: 100;
            background: rgba(255, 253, 249, 0.85);
            backdrop-filter: blur(10px);
            padding: 15px 25px;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(62, 39, 35, 0.1);
            border: 1px solid rgba(242, 101, 34, 0.15);
        }

        .btn-action {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 1.05rem;
            padding: 12px 30px;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-decoration: none;
        }

        .btn-print {
            background: linear-gradient(135deg, var(--primary), #FFB300);
            color: white;
            border: none;
            box-shadow: 0 8px 20px rgba(242, 101, 34, 0.3);
        }

        .btn-print:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(242, 101, 34, 0.4);
        }

        .btn-back {
            background: transparent;
            color: var(--brown-dark);
            border: 2px solid var(--brown-dark);
        }

        .btn-back:hover {
            background: var(--brown-dark);
            color: white;
            transform: translateY(-4px);
        }

        /* ==========================================================================
           3. DESAIN KERTAS STRUK THERMAL
           ========================================================================== */

        /* Wadah Kertas */
        .thermal-receipt {
            background: var(--paper-color);
            width: 380px;
            max-width: 100%;
            position: relative;
            padding: 40px 25px;
            color: var(--brown-text);
            /* Font khusus mesin kasir */
            font-family: 'Inconsolata', monospace;
            /* Efek Melayang 3D Layar Web */
            filter: drop-shadow(0 20px 40px rgba(62, 39, 35, 0.15));
            /* Ujung Bergerigi (Zigzag Cut) menggunakan clip-path mask */
            clip-path: polygon(0% 10px, 2.5% 0px, 5% 10px, 7.5% 0px, 10% 10px, 12.5% 0px, 15% 10px, 17.5% 0px, 20% 10px, 22.5% 0px,
                    25% 10px, 27.5% 0px, 30% 10px, 32.5% 0px, 35% 10px, 37.5% 0px, 40% 10px, 42.5% 0px, 45% 10px, 47.5% 0px,
                    50% 10px, 52.5% 0px, 55% 10px, 57.5% 0px, 60% 10px, 62.5% 0px, 65% 10px, 67.5% 0px, 70% 10px, 72.5% 0px,
                    75% 10px, 77.5% 0px, 80% 10px, 82.5% 0px, 85% 10px, 87.5% 0px, 90% 10px, 92.5% 0px, 95% 10px, 97.5% 0px, 100% 10px,

                    100% calc(100% - 10px), 97.5% 100%, 95% calc(100% - 10px), 92.5% 100%, 90% calc(100% - 10px), 87.5% 100%, 85% calc(100% - 10px), 82.5% 100%, 80% calc(100% - 10px), 77.5% 100%,
                    75% calc(100% - 10px), 72.5% 100%, 70% calc(100% - 10px), 67.5% 100%, 65% calc(100% - 10px), 62.5% 100%, 60% calc(100% - 10px), 57.5% 100%, 55% calc(100% - 10px), 52.5% 100%,
                    50% calc(100% - 10px), 47.5% 100%, 45% calc(100% - 10px), 42.5% 100%, 40% calc(100% - 10px), 37.5% 100%, 35% calc(100% - 10px), 32.5% 100%, 30% calc(100% - 10px), 27.5% 100%,
                    25% calc(100% - 10px), 22.5% 100%, 20% calc(100% - 10px), 17.5% 100%, 15% calc(100% - 10px), 12.5% 100%, 10% calc(100% - 10px), 7.5% 100%, 5% calc(100% - 10px), 2.5% 100%, 0% calc(100% - 10px));
        }

        /* ─── KONTEN STRUK ─── */
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .receipt-logo {
            width: 65px;
            height: 65px;
            object-fit: contain;
            margin-bottom: 10px;
            filter: grayscale(100%) contrast(1.2);
        }

        .store-name {
            font-family: 'Fredoka', sans-serif;
            font-size: 26px;
            font-weight: 700;
            margin: 0 0 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .store-address {
            font-size: 13px;
            font-weight: 500;
            margin: 2px 0;
            color: #555;
        }

        .dashed-divider {
            border-top: 2px dashed #999;
            margin: 15px 0;
            width: 100%;
        }

        .receipt-meta {
            font-size: 13px;
            margin-bottom: 15px;
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .meta-label {
            font-weight: 700;
            color: #555;
        }

        .meta-value {
            text-align: right;
            font-weight: 600;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px;
        }

        .items-table th {
            text-align: left;
            font-weight: 700;
            border-bottom: 1px solid #999;
            padding-bottom: 8px;
            text-transform: uppercase;
        }

        .items-table th.right {
            text-align: right;
        }

        .items-table th.center {
            text-align: center;
        }

        .items-table td {
            padding: 8px 0;
            vertical-align: top;
            font-weight: 600;
        }

        .item-name {
            margin-bottom: 3px;
        }

        .item-price {
            font-size: 11px;
            color: #666;
            font-weight: 500;
        }

        .receipt-summary {
            margin-top: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 6px;
            font-weight: 600;
        }

        .summary-row.grand-total {
            font-size: 18px;
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            margin: 15px 0;
            padding: 10px 0;
            border-top: 2px dashed #999;
            border-bottom: 2px dashed #999;
        }

        /* Pewarnaan khusus Web, akan di-override di mode cetak */
        .screen-orange {
            color: var(--primary);
        }

        .receipt-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            font-weight: 500;
            line-height: 1.6;
        }

        .barcode {
            font-family: 'Libre Barcode 39', cursive;
            font-size: 40px;
            margin-top: 15px;
            color: var(--brown-text);
            line-height: 0.8;
            font-weight: normal;
        }

        /* ==========================================================================
           4. MODE CETAK FISIK (THERMAL PRINTER)
           ========================================================================== */
        @media print {

            /* Pengaturan Kertas Margin 0 untuk Printer Kasir */
            @page {
                margin: 0;
                padding: 0;
                size: auto;
            }

            /* Membersihkan Latar dan Elemen Layar */
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
                align-items: flex-start;
            }

            .no-print,
            .status-badge,
            .action-buttons {
                display: none !important;
            }

            /* Membersihkan Efek Web pada Struk */
            .thermal-receipt {
                width: 100% !important;
                /* Gunakan lebar mutlak kertas printer */
                max-width: 100% !important;
                margin: 0 !important;
                padding: 10px !important;
                /* Padding diminimalkan */
                box-shadow: none !important;
                filter: none !important;
                clip-path: none !important;
                /* Matikan efek zigzag agar bersih */
                background: white !important;
                color: #000 !important;
                /* Tinta hitam murni */
            }

            /* Memaksa semua teks menjadi hitam tanpa gradasi */
            .store-name,
            .screen-orange,
            .grand-total,
            .meta-label,
            .item-price {
                color: #000 !important;
            }

            .dashed-divider,
            .grand-total {
                border-color: #000 !important;
            }

            /* Optimalisasi Font Tinta Printer */
            .receipt-logo {
                filter: grayscale(100%) contrast(200%) !important;
            }

            .items-table,
            .receipt-meta,
            .receipt-summary,
            .receipt-footer {
                font-size: 12px !important;
                color: #000 !important;
                font-weight: 600 !important;
            }

            .store-name {
                font-size: 20px !important;
            }

            .summary-row.grand-total {
                font-size: 16px !important;
            }
        }
    </style>
</head>

<body>

    <!-- Lencana Status (Hanya Layar) -->
    <div class="status-badge no-print">
        <i class="fas fa-check-circle"></i> PEMBAYARAN BERHASIL
    </div>

    <!-- Container Struk Thermal -->
    <div class="thermal-receipt">

        {{-- Header Toko --}}
        <div class="receipt-header">
            <img src="{{ asset('img/thecookies.png') }}" alt="Tho Cookies Logo" class="receipt-logo"
                onerror="this.src='https://cdn-icons-png.flaticon.com/512/3014/3014401.png'">
            <h1 class="store-name screen-orange">Tho Cookies</h1>
            <div class="store-address">Jl. Manis Legit No. 99, Kuliner</div>
            <div class="store-address">Telp: 0812-3456-7890</div>
        </div>

        <div class="dashed-divider"></div>

        {{-- Meta Informasi Transaksi --}}
        <div class="receipt-meta">
            <div class="meta-row">
                <span class="meta-label">No. Order</span>
                <span class="meta-value">#{{ $transaction->id }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Tanggal</span>
                <span class="meta-value">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Kasir</span>
                <span class="meta-value">{{ $transaction->user->name ?? 'Admin' }}</span>
            </div>
            <div class="meta-row">
                <span class="meta-label">Pelanggan</span>
                <span class="meta-value">{{ Str::limit($transaction->customer_name, 18) }}</span>
            </div>

            {{-- Keterangan / Kelas --}}
            @if ($transaction->customer_class)
                <div class="meta-row">
                    <span class="meta-label">Kelas/Ket</span>
                    <span class="meta-value">{{ $transaction->customer_class }}</span>
                </div>
            @endif

            {{-- Tipe Pesanan --}}
            <div class="meta-row">
                <span class="meta-label">Tipe Order</span>
                <span class="meta-value">
                    {{ $transaction->order_type }}
                    @if ($transaction->order_type == 'Dine-in')
                        (Meja {{ $transaction->table_number }})
                    @endif
                </span>
            </div>
        </div>

        <div class="dashed-divider"></div>

        {{-- Tabel Daftar Menu --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">MENU</th>
                    <th class="center" style="width: 15%;">QTY</th>
                    <th class="right" style="width: 35%;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->details as $detail)
                    <tr>
                        <td>
                            <div class="item-name">{{ $detail->product->name }}</div>
                            <div class="item-price">Rp{{ number_format($detail->product->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="center">{{ $detail->quantity }}</td>
                        <td class="right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="dashed-divider"></div>

        {{-- Ringkasan Pembayaran --}}
        <div class="receipt-summary">
            <!-- (Contoh Data Subtotal & Diskon jika ada, Anda bisa sesuaikan dengan model DB Anda. Diambil dari total_amount sebagai fallback) -->
            <div class="summary-row">
                <span>Total Item</span>
                <span>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row grand-total">
                <span>TOTAL AKHIR</span>
                <span class="screen-orange">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>

            {{-- PERBAIKAN LOGIKA PEMBAYARAN & KEMBALIAN (DUAL MODE COMPATIBILITY) --}}
            @php
                $subtotal = $transaction->total_amount;
                $diskon = $transaction->discount_amount ?? 0;
                $grandTotal = $subtotal - $diskon;

                // 1. Evaluasi Uang Diterima:
                $bayar = (isset($transaction->payment_amount) && $transaction->payment_amount > 0)
                    ? $transaction->payment_amount
                    : $grandTotal;

                // 2. Evaluasi Uang Kembalian:
                $kembali = (isset($transaction->change_amount) && $transaction->change_amount >= 0 && $transaction->payment_amount > 0)
                    ? $transaction->change_amount
                    : (($bayar > $grandTotal) ? ($bayar - $grandTotal) : 0);
            @endphp

            <div class="summary-row">
                <span class="meta-label">BAYAR ({{ $transaction->payment_method }})</span>
                <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span class="meta-label">KEMBALI</span>
                <span>Rp {{ number_format($kembali, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="dashed-divider"></div>

        {{-- Footer & Barcode --}}
        <div class="receipt-footer">
            <div>Terima kasih atas kunjungan Anda.</div>
            <div>Semoga harimu selalu manis bersama Tho Cookies!</div>

            {{-- Barcode Dekoratif berdasarkan ID Transaksi --}}
            <div class="barcode">
                *{{ str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}*
            </div>
            <div style="font-size: 10px; margin-top: 2px;">
                {{ strtoupper(uniqid('TC-')) }}
            </div>
        </div>

    </div>

    <!-- Tombol Aksi Melayang Cerdas (Hanya Layar) -->
    <div class="action-buttons no-print">
        <button class="btn-action btn-back" onclick="handleBack()" title="Kembali ke halaman sebelumnya">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <button class="btn-action btn-print" onclick="window.print()" title="Cetak struk kasir">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
    </div>

    <!-- SKRIP DETEKSI NAVIGASI PINTAR UNTUK TOMBOL KEMBALI -->
    <script>
        function handleBack() {
            // Ambil URL cadangan (fallback) dinamis dari Laravel Blade berdasarkan peran pengguna saat ini
            @auth
            const fallbackUrl =
                "{{ Auth::user()->role->name === 'admin' ? route('admin.dashboard') : route('kasir.dashboard') }}";
        @else
            const fallbackUrl = "/";
        @endauth

        // 1. Jika dibuka di tab baru (target="_blank") dan memiliki pembuka (opener)
        if (window.opener) {
            window.close(); // Tutup tab ini secara otomatis untuk kenyamanan kasir
        }
        // 2. Jika ada riwayat navigasi di tab yang sama, kembali ke halaman sebelumnya
        else if (window.history.length > 1) {
            window.history.back();
        }
        // 3. Jika tidak ada riwayat sama sekali, arahkan ke dasbor yang sesuai
        else {
            window.location.href = fallbackUrl;
        }
        }
    </script>

</body>

</html>