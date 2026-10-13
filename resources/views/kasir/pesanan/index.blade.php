@extends('kasir.layouts.app')

@section('title', 'Daftar Pesanan Masuk')

@section('content')
    {{-- Import Font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #F26522;
            --primary-glow: rgba(242, 101, 34, 0.3);
            --brown: #5D4037;
            --cream: #FFF8E1;
            --white: #FFFFFF;
            --yellow: #FFC107;
            --bg-gray: #f4f6f8;
            --border-color: #e2e8f0;
        }

        /* --- 1. SINGLE FRAME LAYOUT (100VH) --- */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-gray);
            color: var(--brown);
            margin: 0;
        }

        .pos-wrapper {
            height: calc(100vh - 80px);
            min-height: 600px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            padding: 15px;
            gap: 15px;
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- Header --- */
        .pos-header {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(93, 64, 55, 0.05);
            border-left: 5px solid var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        /* --- Layout Dua Kolom Utama --- */
        .pos-body {
            display: flex;
            flex: 1;
            gap: 20px;
            overflow: hidden;
        }

        /* --- 2. SISI KIRI: ANTREAN (QUEUE) --- */
        .pos-queue-panel {
            width: 38%;
            display: flex;
            flex-direction: column;
            background: transparent;
        }

        .queue-list {
            flex: 1;
            overflow-y: auto;
            padding-right: 10px;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        .queue-list::-webkit-scrollbar {
            width: 6px;
        }

        .queue-list::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }

        /* Kartu Antrean */
        .queue-card {
            background: #fff;
            border: 2px solid transparent;
            border-radius: 20px;
            padding: 15px 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .queue-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            border-color: #e2e8f0;
        }

        /* Active State (Glow) */
        .queue-card.active {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-glow), 0 6px 15px rgba(242, 101, 34, 0.2);
            background-color: #fffaf7;
        }

        /* Pulsing Dot untuk pesanan */
        .pulse-dot {
            width: 12px;
            height: 12px;
            background-color: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: 15px;
            right: 15px;
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        /* --- 3. SISI KANAN: DETAIL & CHECKOUT (RECEIPT STYLE) --- */
        .pos-detail-panel {
            width: 62%;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        /* Empty State */
        .empty-detail-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #94a3b8;
            text-align: center;
            padding: 40px;
        }

        /* Pembungkus detail aktif */
        .transaction-detail-container {
            display: none;
            flex-direction: column;
            height: 100%;
        }

        .transaction-detail-container.active {
            display: flex;
        }

        /* Bagian 1: Header Struk */
        .receipt-header {
            padding: 20px 25px;
            background-color: #fff;
            border-bottom: 2px dashed #cbd5e1;
            flex-shrink: 0;
        }

        /* Bagian 2: Daftar Item (Scrollable) */
        .receipt-items {
            flex: 1;
            overflow-y: auto;
            padding: 20px 25px;
            background-color: #fafafa;
        }

        /* Bagian 3: Checkout / Pembayaran */
        .receipt-checkout {
            padding: 20px 25px;
            background-color: #fff;
            border-top: 2px dashed #cbd5e1;
            flex-shrink: 0;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 -4px 15px rgba(0, 0, 0, 0.03);
        }

        /* --- Elemen Form & Tombol --- */
        .form-select-custom,
        .form-control-custom {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 15px;
            width: 100%;
            font-size: 0.95rem;
            margin-bottom: 12px;
            outline: none;
            transition: all 0.2s;
            background-color: #f8fafc;
        }

        .form-select-custom:focus,
        .form-control-custom:focus {
            border-color: var(--primary);
            background-color: #fff;
            box-shadow: 0 0 0 4px var(--primary-glow);
        }

        .total-box {
            background: linear-gradient(135deg, #FFF8E1 0%, #FFE0B2 100%);
            border: 2px solid var(--primary);
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            margin-bottom: 15px;
        }

        .btn-process {
            background: linear-gradient(135deg, var(--primary) 0%, #e65100 100%);
            color: white;
            border: none;
            font-weight: 700;
            font-size: 1.1rem;
            padding: 15px;
            border-radius: 15px;
            width: 100%;
            box-shadow: 0 4px 15px var(--primary-glow);
            transition: all 0.3s ease;
            font-family: 'Fredoka', sans-serif;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .btn-process:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(242, 101, 34, 0.4);
        }

        .btn-process:active {
            transform: translateY(1px);
        }

        /* Responsif untuk layar kecil (Tablet/Mobile) */
        @media (max-width: 991px) {
            .pos-wrapper {
                height: auto;
                min-height: 100vh;
                overflow: visible;
            }

            .pos-body {
                flex-direction: column;
                overflow: visible;
            }

            .pos-queue-panel {
                width: 100%;
                height: 400px;
            }

            .pos-detail-panel {
                width: 100%;
                min-height: 600px;
            }
        }

        /* --- FIX STACKING CONFLICT & Z-INDEX UNTUK MODAL QR CODE --- */
        .modal-backdrop {
            z-index: 1040 !important;
        }

        #qrPaymentModal {
            z-index: 1060 !important;
        }

        #qrPaymentModal .modal-dialog {
            z-index: 1061 !important;
            position: relative;
            pointer-events: auto !important;
        }

        #qrPaymentModal .modal-content {
            position: relative;
            z-index: 1062 !important;
            pointer-events: auto !important;
        }

        #qrPaymentModal input,
        #qrPaymentModal button {
            pointer-events: auto !important;
        }
    </style>

    <div class="container-fluid pos-wrapper">

        {{-- Header Halaman --}}
        <div class="pos-header">
            <div>
                <h2 class="fw-bold m-0 text-brown font-display">Pesanan Masuk</h2>
                <p class="text-muted small m-0">Pilih pesanan di antrean untuk memproses pembayaran.</p>
            </div>
            <div class="d-flex align-items-center gap-3">
                @if (session('success'))
                    <span class="badge bg-success px-3 py-2 fs-6 rounded-pill shadow-sm"><i class="fas fa-check me-1"></i>
                        {{ session('success') }}</span>
                @endif
                @if (session('error'))
                    <span class="badge bg-danger px-3 py-2 fs-6 rounded-pill shadow-sm"><i
                            class="fas fa-exclamation me-1"></i> {{ session('error') }}</span>
                @endif
                <div
                    class="bg-warning bg-opacity-25 px-4 py-2 rounded-pill border border-warning text-warning font-display fs-4 fw-bold">
                    <i class="fas fa-bell me-2"></i> {{ $pendingTransactions->count() }} Antrean
                </div>
            </div>
        </div>

        {{-- Layout 2 Kolom Utama --}}
        <div class="pos-body">

            {{-- KOLOM KIRI: DAFTAR ANTREAN --}}
            <div class="pos-queue-panel">
                <div class="queue-list" id="queueList">
                    @forelse($pendingTransactions as $transaction)
                        <div class="queue-card" id="card-{{ $transaction->id }}"
                            onclick="selectOrder({{ $transaction->id }})">
                            <div class="pulse-dot"></div>
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="font-display fw-bold mb-1 text-dark">#{{ $transaction->id }} -
                                        {{ $transaction->customer_name }}</h5>
                                    <div class="d-flex gap-2 align-items-center">
                                        @if ($transaction->customer_class)
                                            <span class="badge bg-secondary bg-opacity-10 text-dark border border-secondary"
                                                style="font-size: 0.7rem;">
                                                {{ $transaction->customer_class }}
                                            </span>
                                        @endif
                                        @if ($transaction->order_type == 'Dine-in')
                                            <span class="badge bg-primary"><i class="fas fa-chair me-1"></i> Meja
                                                {{ $transaction->table_number }}</span>
                                        @else
                                            <span class="badge bg-warning text-dark"><i
                                                    class="fas fa-shopping-bag me-1"></i> Bungkus</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="small text-muted fw-medium"><i
                                            class="far fa-clock me-1"></i>{{ $transaction->created_at->format('H:i') }}
                                    </div>
                                    <div class="small text-muted" style="font-size: 0.7rem;">
                                        {{ $transaction->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <div
                                class="pt-2 mt-2 border-top border-light d-flex justify-content-between align-items-center">
                                <span class="small text-muted fw-medium">{{ $transaction->details->sum('quantity') }}
                                    Item</span>
                                <span class="fw-bold fs-5" style="color: var(--primary);">Rp
                                    {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted mt-5">
                            <i class="fas fa-mug-hot fs-1 mb-3 opacity-25"></i>
                            <h4 class="font-display">Antrean Kosong</h4>
                            <p class="small">Belum ada pesanan masuk saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- KOLOM KANAN: DETAIL & CHECKOUT --}}
            <div class="pos-detail-panel">

                {{-- State Kosong (Ditampilkan saat belum ada yang diklik) --}}
                <div class="empty-detail-state" id="emptyState">
                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" alt="Select Order" width="120"
                        class="mb-4 opacity-50" style="filter: grayscale(100%);">
                    <h3 class="font-display">Pilih Pesanan</h3>
                    <p>Klik salah satu kartu antrean di sebelah kiri<br>untuk melihat detail dan memproses pembayaran.</p>
                </div>

                {{-- Loop Semua Container Detail Pesanan (Disembunyikan via CSS, dimunculkan via JS) --}}
                @foreach ($pendingTransactions as $transaction)
                    <div class="transaction-detail-container" id="detail-{{ $transaction->id }}">

                        {{-- 1. Header Struk --}}
                        <div class="receipt-header">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h4 class="font-display fw-bold text-dark m-0">Pesanan #{{ $transaction->id }}</h4>
                                <span
                                    class="badge bg-dark bg-opacity-10 text-dark px-3 py-2 rounded-pill border border-secondary">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                            <div class="fs-6 text-muted fw-medium">
                                <i class="fas fa-user-circle me-1"></i> {{ $transaction->customer_name }}
                                @if ($transaction->customer_class)
                                    | Kelas: {{ $transaction->customer_class }}
                                @endif
                            </div>
                        </div>

                        {{-- 2. Daftar Menu (Scrollable) --}}
                        <div class="receipt-items">
                            <h6 class="fw-bold text-uppercase text-muted small mb-3" style="letter-spacing: 1px;">Rincian
                                Pembelian</h6>
                            <div class="d-flex flex-column gap-3">
                                @foreach ($transaction->details as $detail)
                                    <div
                                        class="d-flex justify-content-between align-items-center p-3 bg-white border border-light rounded-4 shadow-sm">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-primary fw-bold"
                                                style="width: 40px; height: 40px; font-size: 1.1rem;">
                                                {{ $detail->quantity }}x
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark" style="font-size: 1.05rem;">
                                                    {{ $detail->product->name }}</div>
                                                <div class="small text-muted">Rp
                                                    {{ number_format($detail->price ?? $transaction->total_amount / $transaction->details->sum('quantity'), 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fw-bold text-dark">
                                            Rp
                                            {{ number_format(($detail->price ?? $transaction->total_amount / $transaction->details->sum('quantity')) * $detail->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($transaction->discount_amount > 0)
                                <div
                                    class="d-flex justify-content-between align-items-center mt-4 p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-4">
                                    <div class="text-success fw-bold"><i class="fas fa-tags me-2"></i>Diskon
                                        ({{ $transaction->discount_code }})</div>
                                    <div class="text-success fw-bold fs-5">- Rp
                                        {{ number_format($transaction->discount_amount, 0, ',', '.') }}</div>
                                </div>
                            @endif
                        </div>

                        {{-- 3. Checkout / Pembayaran Form --}}
                        <div class="receipt-checkout">
                            <form action="{{ route('kasir.pesanan.selesaikan', $transaction->id) }}" method="POST"
                                class="payment-form" id="form-{{ $transaction->id }}">
                                @csrf

                                <div class="row align-items-end">
                                    {{-- Area Input Pembayaran --}}
                                    <div class="col-md-7 border-end pe-4">
                                        <h6 class="fw-bold text-uppercase text-muted small mb-3"
                                            style="letter-spacing: 1px;">Metode Pembayaran</h6>

                                        <div class="row">
                                            <div class="col-6">
                                                <label class="small fw-bold text-brown mb-1">Metode</label>
                                                <select class="form-select-custom main-select" required>
                                                    <option value="Tunai" selected>Tunai (Cash)</option>
                                                    <option value="Non Tunai">Non Tunai / Digital</option>
                                                </select>
                                            </div>

                                            <!-- Pilihan Non-Tunai (Hidden by default) -->
                                            <div class="col-6 non-tunai-wrapper" style="display: none;">
                                                <label class="small fw-bold text-brown mb-1">Tipe Digital</label>
                                                <select class="form-select-custom type-select">
                                                    <option value="">-- Pilih Tipe --</option>
                                                    <option value="GoPay">GoPay</option>
                                                    <option value="OVO">OVO</option>
                                                    <option value="DANA">DANA</option>
                                                    <option value="ShopeePay">ShopeePay</option>
                                                    <option value="QRIS">QRIS</option>
                                                    <option value="Kartu Debit">Kartu Debit</option>
                                                    <option value="Kartu Kredit">Kartu Kredit</option>
                                                </select>
                                            </div>

                                            <!-- Pilihan Bank (Hidden by default) -->
                                            <div class="col-12 bank-wrapper mt-1" style="display: none;">
                                                <label class="small fw-bold text-brown mb-1">Pilih Bank</label>
                                                <select class="form-select-custom bank-select">
                                                    <!-- Diisi via JS -->
                                                </select>
                                            </div>

                                            <!-- Kalkulator Tunai (Hanya muncul jika Tunai) -->
                                            <div class="col-12 cash-calculator-wrapper mt-1">
                                                <label class="small fw-bold text-brown mb-1">Uang Diterima (Rp)</label>
                                                {{-- PERBAIKAN 1: Menambahkan name="payment_amount" agar terkirim ke Controller --}}
                                                <input type="number" name="payment_amount"
                                                    class="form-control-custom cash-input"
                                                    placeholder="Masukkan nominal uang..."
                                                    data-total="{{ $transaction->total_amount }}">
                                                <div class="d-flex justify-content-between mt-2 px-2">
                                                    <span class="small fw-bold text-muted">Kembalian:</span>
                                                    <span class="fw-bold text-success fs-5 change-output">Rp 0</span>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="payment_method" class="final-payment-input"
                                            value="Tunai">
                                        {{-- PERBAIKAN 2: Input tersembunyi untuk menyimpan dan mengirimkan change_amount --}}
                                        <input type="hidden" name="change_amount" class="change-amount-input"
                                            value="0">
                                    </div>

                                    {{-- Area Total & Tombol --}}
                                    <div class="col-md-5 ps-4">
                                        <div class="total-box shadow-sm">
                                            <span class="d-block small fw-bold text-muted text-uppercase mb-1">Total
                                                Tagihan</span>
                                            <h2 class="font-display fw-bold text-dark m-0"
                                                style="color: var(--primary) !important;">
                                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                            </h2>
                                        </div>

                                        <button type="submit" class="btn-process w-100">
                                            <i class="fas fa-print me-2"></i> CETAK & SELESAI
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
    <!-- Modal QR Code Pembayaran Non-Tunai (Tho Cookies Theme) -->
    <div class="modal fade" id="qrPaymentModal" tabindex="-1" aria-labelledby="qrPaymentModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg" style="background: var(--cream, #FFF8E1); color: var(--brown, #5D4037);">
                <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="background: rgba(242, 101, 34, 0.15); width: 44px; height: 44px; color: var(--primary, #F26522);">
                            <i class="fas fa-qrcode fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title font-display fw-bold mb-0" id="qrModalTitle" style="color: var(--brown, #5D4037);">Pembayaran Non Tunai</h5>
                            <small class="text-muted fw-medium" id="qrModalSubtitle">Pesanan #---</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4 text-center">
                    <!-- Loading State Feedback -->
                    <div id="qrLoadingState" class="py-5">
                        <i class="fas fa-cookie-bite fa-spin fa-3x mb-3" style="color: var(--primary, #F26522) !important;"></i>
                        <h5 class="font-display fw-bold" style="color: var(--brown, #5D4037);">Menyiapkan Kode QR...</h5>
                        <p class="small text-muted mb-0">Mohon tunggu sebentar, transaksi sedang diproses.</p>
                    </div>

                    <!-- Main QR Content State -->
                    <div id="qrContentState" class="d-none">
                        <!-- Box QR Code Estetik -->
                        <div class="qr-code-wrapper mx-auto mb-3 p-3 bg-white rounded-4 shadow-sm position-relative" style="width: 220px; height: 220px; border: 3px dashed var(--primary, #F26522);">
                            <img id="qrCodeImg" src="" alt="QR Code Pembayaran" class="w-100 h-100 object-fit-contain rounded-3">
                        </div>

                        <div class="badge bg-warning bg-opacity-25 text-dark border border-warning px-3 py-1 rounded-pill small fw-bold mb-3 font-display">
                            <i class="fas fa-scan me-1" style="color: var(--primary, #F26522);"></i> Scan QR untuk Menyelesaikan Pembayaran
                        </div>

                        <!-- Ringkasan Tagihan -->
                        <div class="p-3 bg-white rounded-4 shadow-sm mb-3 border text-start">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="small text-muted font-display text-uppercase">Total Tagihan</span>
                                <span class="fw-bold fs-4 font-display" style="color: var(--primary, #F26522);" id="qrTotalAmount">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center small text-muted">
                                <span>Metode Digital</span>
                                <span class="fw-bold text-dark" id="qrPaymentMethodLabel">-</span>
                            </div>
                        </div>

                        <!-- Input Kasir -->
                        <div class="text-start">
                            <div class="mb-2">
                                <label class="small fw-bold text-brown mb-1">Nominal Diterima (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-2 border-end-0 rounded-start-3 fw-bold text-muted">Rp</span>
                                    <input type="number" id="qrNominalInput" class="form-control form-control-custom border-2 rounded-end-3 m-0" placeholder="0">
                                </div>
                            </div>
                            <div>
                                <label class="small fw-bold text-brown mb-1">No. Referensi / 4 Digit HP <span class="text-muted fw-normal">(Opsional)</span></label>
                                <input type="text" id="qrRefInput" class="form-control form-control-custom border-2 m-0" placeholder="Contoh: REF123456 / 8123">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4 flex-column gap-2" id="qrModalFooter">
                    <button type="button" id="btnConfirmQrPayment" class="btn-process w-100 m-0 py-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                        <i class="fas fa-check-circle"></i> KONFIRMASI PEMBAYARAN BERHASIL
                    </button>
                    <button type="button" class="btn btn-light rounded-pill w-100 fw-bold text-muted border py-2" data-bs-dismiss="modal">
                        Batal / Ganti Metode
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // --- Fungsi Master-Detail (Kiri ke Kanan) ---
        function selectOrder(id) {
            document.querySelectorAll('.queue-card').forEach(card => {
                card.classList.remove('active');
            });

            const selectedCard = document.getElementById('card-' + id);
            if (selectedCard) {
                selectedCard.classList.add('active');
                const dot = selectedCard.querySelector('.pulse-dot');
                if (dot) dot.style.display = 'none';
            }

            document.getElementById('emptyState').style.display = 'none';

            document.querySelectorAll('.transaction-detail-container').forEach(panel => {
                panel.classList.remove('active');
            });

            const targetPanel = document.getElementById('detail-' + id);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        }

        // --- Logika Form Pembayaran, Kalkulator & Bank ---
        document.addEventListener('DOMContentLoaded', function() {

            const firstCard = document.querySelector('.queue-card');
            if (firstCard) {
                const firstId = firstCard.id.split('-')[1];
                selectOrder(firstId);
            }

            const banks = {
                'Kartu Debit': ['BCA', 'BRI', 'BNI', 'Mandiri', 'BTN', 'CIMB Niaga', 'Danamon', 'Permata',
                    'Bank Mega', 'BSI'
                ],
                'Kartu Kredit': ['BCA', 'BRI', 'BNI', 'Mandiri', 'CIMB Niaga', 'Danamon', 'HSBC', 'Citibank',
                    'Bank Mega', 'BSI (Syariah)'
                ]
            };

            document.querySelectorAll('.payment-form').forEach(form => {
                const mainSelect = form.querySelector('.main-select');
                const typeSelect = form.querySelector('.type-select');
                const bankSelect = form.querySelector('.bank-select');
                const nonTunaiWrapper = form.querySelector('.non-tunai-wrapper');
                const bankWrapper = form.querySelector('.bank-wrapper');
                const finalInput = form.querySelector('.final-payment-input');
                const changeInputHidden = form.querySelector(
                    '.change-amount-input'); // PERBAIKAN 3: Elemen input kembalian

                // Kalkulator variables
                const cashWrapper = form.querySelector('.cash-calculator-wrapper');
                const cashInput = form.querySelector('.cash-input');
                const changeOutput = form.querySelector('.change-output');

                const formatRupiah = (angka) => {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(angka);
                };

                function updateFinalValue() {
                    const mainVal = mainSelect.value;
                    const typeVal = typeSelect.value;
                    const bankVal = bankSelect.value;

                    if (mainVal === 'Tunai') {
                        finalInput.value = 'Tunai';
                    } else {
                        if ((typeVal === 'Kartu Debit' || typeVal === 'Kartu Kredit') && bankVal) {
                            finalInput.value = `${typeVal} - ${bankVal}`;
                        } else {
                            finalInput.value = typeVal;
                        }
                    }
                }

                // Kalkulator Kembalian Event
                if (cashInput) {
                    cashInput.addEventListener('input', function() {
                        const total = parseFloat(this.getAttribute('data-total'));
                        const bayar = parseFloat(this.value) || 0;
                        const kembalian = bayar - total;

                        if (kembalian >= 0) {
                            changeOutput.textContent = formatRupiah(kembalian);
                            changeOutput.classList.remove('text-danger');
                            changeOutput.classList.add('text-success');

                            // PERBAIKAN 4: Update input kembalian yang dikirim ke controller
                            if (changeInputHidden) {
                                changeInputHidden.value = kembalian;
                            }
                        } else {
                            changeOutput.textContent = "Uang Kurang!";
                            changeOutput.classList.remove('text-success');
                            changeOutput.classList.add('text-danger');

                            if (changeInputHidden) {
                                changeInputHidden.value = 0;
                            }
                        }
                    });
                }

                // Event Listener: Main Select (Tunai/Non Tunai)
                mainSelect.addEventListener('change', function() {
                    if (this.value === 'Non Tunai') {
                        nonTunaiWrapper.style.display = 'block';
                        cashWrapper.style.display = 'none';
                        typeSelect.setAttribute('required', 'required');

                        if (cashInput) {
                            cashInput.value = '';
                            changeOutput.textContent = 'Rp 0';
                        }
                        if (changeInputHidden) {
                            changeInputHidden.value = 0;
                        }
                    } else {
                        nonTunaiWrapper.style.display = 'none';
                        bankWrapper.style.display = 'none';
                        cashWrapper.style.display = 'block';
                        typeSelect.value = '';
                        typeSelect.removeAttribute('required');
                        bankSelect.removeAttribute('required');
                    }
                    updateFinalValue();
                });

                // Event Listener: Type Select
                typeSelect.addEventListener('change', function() {
                    const selectedType = this.value;
                    bankSelect.innerHTML = '<option value="">-- Pilih Bank --</option>';

                    if (selectedType === 'Kartu Debit' || selectedType === 'Kartu Kredit') {
                        bankWrapper.style.display = 'block';
                        bankSelect.setAttribute('required', 'required');

                        banks[selectedType].forEach(bankName => {
                            const option = document.createElement('option');
                            option.value = bankName;
                            option.textContent = bankName;
                            bankSelect.appendChild(option);
                        });
                    } else {
                        bankWrapper.style.display = 'none';
                        bankSelect.removeAttribute('required');
                    }
                    updateFinalValue();
                });

                bankSelect.addEventListener('change', updateFinalValue);

                // PERBAIKAN 5: Proteksi Submit & Handle Simulasi QR Modal Pembayaran Non-Tunai
                form.addEventListener('submit', function(e) {
                    const mainVal = mainSelect.value;
                    if (mainVal === 'Tunai') {
                        const total = parseFloat(cashInput.getAttribute('data-total'));
                        const bayar = parseFloat(cashInput.value) || 0;
                        if (bayar < total) {
                            e.preventDefault();
                            alert('Proses dibatalkan! Uang diterima kurang dari total tagihan.');
                            return false;
                        }
                    } else if (mainVal === 'Non Tunai') {
                        if (!form._qrConfirmed) {
                            e.preventDefault();
                            updateFinalValue();

                            const transactionId = form.id.replace('form-', '');
                            const total = parseFloat(cashInput.getAttribute('data-total'));
                            const methodLabel = finalInput.value || 'Non Tunai';

                            openQrModal(form, transactionId, total, methodLabel);
                            return false;
                        }
                    }
                });
            });

            // Global handling for QR Code Payment Modal
            let activeFormForQr = null;
            let qrBsModal = null;

            const qrModalEl = document.getElementById('qrPaymentModal');
            if (qrModalEl) {
                // Pindahkan elemen modal langsung di bawah body agar tidak terperangkap di stacking context parent
                if (qrModalEl.parentNode !== document.body) {
                    document.body.appendChild(qrModalEl);
                }
                qrBsModal = bootstrap.Modal.getInstance(qrModalEl) || new bootstrap.Modal(qrModalEl);

                // Bersihkan backdrop secara tuntas ketika modal ditutup
                qrModalEl.addEventListener('hidden.bs.modal', function () {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('overflow');
                    document.body.style.removeProperty('padding-right');
                });
            }

            function openQrModal(form, transactionId, total, methodLabel) {
                activeFormForQr = form;
                form._qrConfirmed = false;

                if (!qrModalEl) return;

                if (!qrBsModal) {
                    qrBsModal = bootstrap.Modal.getInstance(qrModalEl) || new bootstrap.Modal(qrModalEl);
                }

                const formatRupiah = (angka) => {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(angka);
                };

                // Formatter / populasi data ke Modal
                document.getElementById('qrModalTitle').textContent = `Pembayaran Non Tunai — ${methodLabel}`;
                document.getElementById('qrModalSubtitle').textContent = `Pesanan #${transactionId}`;
                document.getElementById('qrPaymentMethodLabel').textContent = methodLabel;
                document.getElementById('qrTotalAmount').textContent = formatRupiah(total);
                
                const nominalInput = document.getElementById('qrNominalInput');
                nominalInput.value = total;
                nominalInput.setAttribute('data-total', total);
                document.getElementById('qrRefInput').value = '';

                // QR Code Generator URL
                const qrImgUrl = `https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=THOCOOKIES-ORDER-${transactionId}`;
                document.getElementById('qrCodeImg').src = qrImgUrl;

                const loadingState = document.getElementById('qrLoadingState');
                const contentState = document.getElementById('qrContentState');
                const modalFooter = document.getElementById('qrModalFooter');

                // Tampilkan loading sekejap (600ms)
                loadingState.classList.remove('d-none');
                contentState.classList.add('d-none');
                modalFooter.classList.add('d-none');

                qrBsModal.show();

                setTimeout(() => {
                    loadingState.classList.add('d-none');
                    contentState.classList.remove('d-none');
                    modalFooter.classList.remove('d-none');
                    nominalInput.focus();
                }, 600);
            }

            // Tombol Konfirmasi Pembayaran Berhasil di Modal QR
            const confirmQrBtn = document.getElementById('btnConfirmQrPayment');
            if (confirmQrBtn) {
                confirmQrBtn.addEventListener('click', function() {
                    if (!activeFormForQr) return;

                    const nominalInput = document.getElementById('qrNominalInput');
                    const total = parseFloat(nominalInput.getAttribute('data-total')) || 0;
                    const bayar = parseFloat(nominalInput.value) || 0;

                    if (bayar < total) {
                        alert('Proses dibatalkan! Uang diterima kurang dari total tagihan.');
                        return;
                    }

                    const refInput = document.getElementById('qrRefInput');
                    const refVal = refInput ? refInput.value.trim() : '';

                    const finalInput = activeFormForQr.querySelector('.final-payment-input');
                    if (refVal && finalInput) {
                        finalInput.value = `${finalInput.value} (Ref: ${refVal})`;
                    }

                    const cashInput = activeFormForQr.querySelector('.cash-input');
                    const changeInputHidden = activeFormForQr.querySelector('.change-amount-input');

                    if (cashInput) cashInput.value = bayar;
                    if (changeInputHidden) changeInputHidden.value = Math.max(0, bayar - total);

                    activeFormForQr._qrConfirmed = true;

                    if (qrBsModal) {
                        qrBsModal.hide();
                    }

                    activeFormForQr.submit();
                });
            }
            @if (session('print_struk'))
                const transactionId = "{{ session('print_struk') }}";
                const url = "{{ route('transaksi.struk', ':id') }}".replace(':id', transactionId);
                window.open(url, '_blank', 'width=400,height=600');
            @endif
        });
    </script>
@endpush
