@extends('kasir.layouts.app')

@section('title', 'Kasir - Buat Transaksi')

@section('content')
    {{-- Import Font --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #F26522;
            --primary-dark: #D84315;
            --primary-light: #FFEDE4;
            --brown: #5D4037;
            --cream: #FFF8E1;
            --cream-dark: #FFECB3;
            --white: #FFFFFF;
            --yellow: #FFC107;
            --green: #10B981;
            --red: #EF4444;
        }

        /* ─── POS SINGLE FRAME ARCHITECTURE ─── */
        body,
        html {
            overflow: hidden !important;
            height: 100%;
        }

        .main-content {
            padding: 0 !important;
            overflow: hidden !important;
            height: 100vh;
            display: flex;
            flex-direction: column;
            background-image:
                radial-gradient(circle at top right, rgba(242, 101, 34, 0.05), transparent 40%),
                radial-gradient(circle at bottom left, rgba(255, 193, 7, 0.05), transparent 40%);
            background-color: var(--cream);
        }

        .pos-wrapper {
            flex: 1;
            display: flex;
            flex-direction: row;
            overflow: hidden;
            padding: 15px 20px 20px;
            gap: 20px;
            max-width: 1600px;
            margin: 0 auto;
            width: 100%;
        }

        /* ─── ALERTS (Floating) ─── */
        .pos-alerts {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 350px;
        }

        /* ─── LEFT PANEL: Products (Menu Tersedia) ─── */
        .pos-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px rgba(93, 64, 55, 0.05);
        }

        .pos-left-header {
            flex-shrink: 0;
            padding: 24px 30px 15px;
        }

        .pos-search {
            width: 100%;
            padding: 14px 24px;
            border: 2px solid rgba(93, 64, 55, 0.1);
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: 0.3s;
            background: rgba(255, 255, 255, 0.8);
            color: var(--brown);
            margin-top: 15px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .pos-search:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px var(--primary-light);
        }

        .pos-grid {
            flex: 1;
            overflow-y: auto;
            padding: 10px 30px 30px;
            scrollbar-width: thin;
            scrollbar-color: rgba(242, 101, 34, 0.3) transparent;
        }

        .pos-grid::-webkit-scrollbar {
            width: 6px;
        }

        .pos-grid::-webkit-scrollbar-track {
            background: transparent;
        }

        .pos-grid::-webkit-scrollbar-thumb {
            background: rgba(242, 101, 34, 0.3);
            border-radius: 10px;
        }

        /* Product Card Kasir */
        .product-card {
            background: #fff;
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 5px 15px rgba(93, 64, 55, 0.05);
            height: 100%;
            position: relative;
            padding: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .product-card:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 15px 30px rgba(242, 101, 34, 0.15);
            border-color: var(--primary-light);
        }

        .product-card:active {
            transform: scale(0.97);
        }

        .product-card.out-of-stock {
            opacity: 0.6;
            cursor: not-allowed;
            filter: grayscale(0.8);
        }

        /* Gambar Bulat Manis */
        .product-img-wrapper {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            background-color: var(--cream);
            margin-bottom: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            flex-shrink: 0;
            border: 3px solid white;
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
        }

        .product-card:hover .product-img-wrapper img {
            transform: scale(1.1);
        }

        .product-title {
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 4px;
            line-height: 1.2;
            color: var(--brown);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            color: var(--primary);
            font-weight: 800;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            margin-top: auto;
        }

        /* Badge Stok & Habis */
        .badge-habis {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--red);
            color: white;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 50px;
            text-transform: uppercase;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }

        .badge-sisa {
            font-size: 0.7rem;
            background: var(--cream-dark);
            color: var(--brown);
            padding: 2px 8px;
            border-radius: 50px;
            font-weight: 700;
            margin-top: 6px;
            display: inline-block;
        }

        /* ─── RIGHT PANEL: Cart (Struk Belanja Premium) ─── */
        .pos-right {
            width: 420px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .struk-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            background: #FFFFFF;
            border-radius: 28px;
            border: 2px dashed rgba(93, 64, 55, 0.15);
            /* Penutup bergelombang/dashed */
            box-shadow: 0 15px 40px rgba(93, 64, 55, 0.08);
            overflow: hidden;
        }

        /* 1. Header Struk */
        .cart-header {
            background: rgba(255, 255, 255, 0.9);
            color: var(--brown);
            padding: 24px 24px 16px;
            text-align: center;
            flex-shrink: 0;
            border-bottom: 2px dashed rgba(93, 64, 55, 0.1);
        }

        .cart-header h3 {
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            margin: 0;
            font-size: 1.4rem;
        }

        /* 2. Daftar Belanja (Table) */
        .cart-body {
            flex: 1;
            overflow-y: auto;
            padding: 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(242, 101, 34, 0.2) transparent;
        }

        .cart-body::-webkit-scrollbar {
            width: 5px;
        }

        .cart-body::-webkit-scrollbar-thumb {
            background: rgba(242, 101, 34, 0.2);
            border-radius: 10px;
        }

        .table-cart {
            width: 100%;
            border-collapse: collapse;
        }

        .table-cart th {
            position: sticky;
            top: 0;
            background: #fafafa;
            z-index: 1;
            font-size: 0.75rem;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(93, 64, 55, 0.05);
            text-transform: uppercase;
            color: var(--gray-400);
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .table-cart td {
            padding: 16px;
            border-bottom: 1px dashed rgba(93, 64, 55, 0.08);
            vertical-align: middle;
        }

        .qty-input {
            width: 45px;
            text-align: center;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            padding: 4px;
            font-weight: 700;
            color: var(--brown);
            transition: 0.3s;
        }

        .qty-input:focus {
            border-color: var(--primary);
            outline: none;
            background: var(--primary-light);
        }

        .btn-remove-small {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            background: #FFF0F0;
            color: var(--red);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            font-size: 0.85rem;
        }

        .btn-remove-small:hover {
            background: var(--red);
            color: white;
            transform: scale(1.1) rotate(5deg);
        }

        /* 3. Form Detail & Pembayaran (Footer) */
        .cart-footer {
            flex-shrink: 0;
            background: #FAFAFA;
            border-top: 2px dashed rgba(93, 64, 55, 0.15);
            padding: 24px;
        }

        .total-display {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            background: var(--primary-light);
            padding: 16px 20px;
            border-radius: 16px;
            border: 1px solid rgba(242, 101, 34, 0.2);
        }

        .total-label {
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--brown);
        }

        .total-value {
            font-family: 'Fredoka', sans-serif;
            font-size: 2rem;
            color: var(--primary);
            font-weight: 800;
            line-height: 1;
            text-shadow: 0 4px 10px rgba(242, 101, 34, 0.2);
        }

        .form-control-custom,
        .form-select-custom {
            border: 2px solid rgba(93, 64, 55, 0.1);
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 12px;
            width: 100%;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            color: var(--brown);
            transition: 0.3s;
            background: white;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-light);
            outline: none;
        }

        /* Uang Diterima & Kembalian (Dinamis) */
        .calc-box {
            background: white;
            border: 2px dashed rgba(16, 185, 129, 0.3);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 12px;
            display: none;
            /* Hidden by default */
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .calc-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .calc-row:last-child {
            margin-bottom: 0;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px dashed #eee;
        }

        .input-diterima {
            text-align: right;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--brown);
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            padding: 6px 12px;
            width: 150px;
            outline: none;
            transition: 0.3s;
        }

        .input-diterima:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .btn-checkout {
            background: linear-gradient(135deg, var(--primary), #E74C3C);
            color: white;
            border: none;
            border-radius: 50px;
            width: 100%;
            padding: 16px;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(242, 101, 34, 0.3);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-checkout:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 30px rgba(242, 101, 34, 0.4);
        }

        .btn-checkout:active {
            transform: translateY(1px);
        }

        /* ─── MOBILE RESPONSIVE (< 992px) ─── */
        @media (max-width: 991.98px) {

            body,
            html {
                overflow: auto !important;
                height: auto;
            }

            .main-content {
                height: auto;
                overflow: visible !important;
            }

            .pos-wrapper {
                flex-direction: column;
                height: auto;
                padding: 15px;
            }

            .pos-left {
                height: 65vh;
                border-radius: 20px;
                flex: none;
            }

            .pos-right {
                width: 100%;
            }

            .struk-card {
                height: auto;
            }

            .cart-body {
                max-height: 350px;
            }

            .pos-alerts {
                position: relative;
                top: 0;
                left: 0;
                transform: none;
                width: 100%;
                margin-bottom: 15px;
            }
        }
    </style>

    {{-- Floating alerts --}}
    @if (session('success'))
        <div class="pos-alerts">
            <div class="alert alert-success border-0 fw-bold rounded-pill shadow-lg py-3 px-4 mb-0 d-flex align-items-center"
                style="background: #D1FAE5; color: #065F46;">
                <i class="fas fa-check-circle fs-4 me-3"></i> {{ session('success') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="pos-alerts">
            <div class="alert alert-danger border-0 fw-bold rounded-pill shadow-lg py-3 px-4 mb-0 d-flex align-items-center"
                style="background: #FEE2E2; color: #991B1B;">
                <i class="fas fa-exclamation-triangle fs-4 me-3"></i> {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════
         POS MAIN WRAPPER (SINGLE FRAME)
         ══════════════════════════════════════════ --}}
    <div class="pos-wrapper">

        {{-- ───────────── LEFT: PRODUCTS ───────────── --}}
        <div class="pos-left">

            {{-- Fixed Header --}}
            <div class="pos-left-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold m-0 font-display" style="color:var(--brown);font-size:1.8rem;">
                            <i class="fas fa-cookie-bite me-2" style="color:var(--primary);"></i> Menu Tersedia
                        </h2>
                    </div>
                    <span class="badge border fw-bold"
                        style="background:var(--primary-light); color:var(--primary); border-color:var(--primary)!important; padding: 6px 12px; font-size: 0.9rem; border-radius: 50px;">
                        {{ $products->count() }} Item
                    </span>
                </div>
                <input type="text" class="pos-search shadow-sm" id="pos-search"
                    placeholder="&#128269; Cari nama cookies atau minuman..." oninput="filterProducts(this.value)">
            </div>

            {{-- Scrollable Product Grid --}}
            <div class="pos-grid" id="pos-grid">
                <div class="row g-4" id="product-grid-row">
                    @forelse($products as $product)
                        <div class="col-6 col-sm-4 col-xl-3 product-col" data-name="{{ strtolower($product->name) }}">
                            <div class="product-card {{ $product->stock <= 0 ? 'out-of-stock' : '' }}"
                                data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">

                                <div class="product-img-wrapper">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            loading="lazy">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100 text-muted"
                                            style="background: var(--cream-dark);">
                                            <i class="fas fa-cookie fa-2x opacity-50" style="color: var(--brown);"></i>
                                        </div>
                                    @endif
                                </div>

                                @if ($product->stock <= 0)
                                    <span class="badge-habis">Habis</span>
                                @endif

                                <div class="product-title">{{ $product->name }}</div>

                                @if ($product->stock > 0 && $product->stock <= 10)
                                    <div class="badge-sisa">Sisa {{ $product->stock }}</div>
                                @endif

                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <div style="font-size: 4.5rem; color: rgba(93,64,55,0.2);"><i class="fas fa-box-open"></i></div>
                            <p class="fw-bold mt-3" style="color: var(--brown); font-size: 1.2rem;">Belum ada menu yang siap
                                dijual.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ───────────── RIGHT: CART (STRUK BELANJA) ───────────── --}}
        <div class="pos-right">
            <div class="struk-card">

                {{-- 1. Header Struk --}}
                <div class="cart-header">
                    <i class="fas fa-store mb-2" style="font-size: 2rem; color: var(--primary);"></i>
                    <h3>Struk Pembayaran</h3>
                    <div style="font-size: 0.8rem; color: var(--gray-400); font-weight: 600; margin-top: 4px;">THO COOKIES
                        POS SYSTEM</div>
                </div>

                <form action="{{ route('kasir.transaction.store') }}" method="POST" class="d-flex flex-column"
                    style="flex:1;overflow:hidden;" id="transactionForm" onsubmit="return prepareSubmit()">
                    @csrf

                    {{-- 2. Daftar Belanja (Scrollable) --}}
                    <div class="cart-body">
                        <table class="table-cart">
                            <thead>
                                <tr>
                                    <th width="45%">Item Menu</th>
                                    <th width="15%" class="text-center">Qty</th>
                                    <th width="30%" class="text-end">Subtotal</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <tr id="empty-cart-msg">
                                    <td colspan="4" class="text-center py-5">
                                        <i class="fas fa-shopping-basket mb-3"
                                            style="font-size:3rem;color:rgba(242,101,34,0.2);display:block;"></i>
                                        <span class="fw-bold" style="color: var(--gray-400);">Keranjang masih kosong.</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- 3. Form Detail & Pembayaran (Fixed Footer) --}}
                    <div class="cart-footer">
                        <div class="total-display shadow-sm">
                            <span class="total-label">Total Bayar</span>
                            <span class="total-value">Rp <span id="total-price">0</span></span>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <input type="text" name="customer_name" class="form-control-custom shadow-sm"
                                    placeholder="Nama Pelanggan" required>
                            </div>
                            <div class="col-6">
                                <input type="text" name="customer_class" class="form-control-custom shadow-sm"
                                    placeholder="Kelas/Catatan (Opsional)">
                            </div>
                        </div>

                        <select id="payment-main" class="form-select-custom shadow-sm" required>
                            <option value="Tunai" selected>💵 Tunai (Cash)</option>
                            <option value="Non Tunai">💳 Non Tunai (Qris/Transfer/Kartu)</option>
                        </select>

                        {{-- Fitur Baru: Kalkulator Uang Kembalian Tunai --}}
                        <div id="change-calculator-container" class="calc-box shadow-sm">
                            <div class="calc-row">
                                <span class="fw-bold" style="color: var(--brown); font-size: 0.9rem;">Uang Diterima</span>
                                <div class="d-flex align-items-center">
                                    <span class="fw-bold me-2" style="color: var(--brown);">Rp</span>
                                    <input type="text" id="uang-diterima" class="input-diterima" placeholder="0">
                                </div>
                            </div>
                            <div class="calc-row">
                                <span class="fw-bold" style="color: var(--gray-600); font-size: 0.95rem;">Kembalian</span>
                                <span id="uang-kembalian" class="fw-bold font-display"
                                    style="font-size: 1.4rem; color: var(--gray-400);">Rp 0</span>
                            </div>
                        </div>

                        {{-- Input Non Tunai --}}
                        <div id="payment-type-container" style="display:none;">
                            <select id="payment-type" class="form-select-custom shadow-sm">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="GoPay">GoPay / QRIS</option>
                                <option value="OVO">OVO</option>
                                <option value="DANA">DANA</option>
                                <option value="ShopeePay">ShopeePay</option>
                                <option value="Kartu Debit">Kartu Debit</option>
                                <option value="Kartu Kredit">Kartu Kredit</option>
                            </select>
                        </div>

                        <div id="payment-bank-container" style="display:none;">
                            <select id="payment-bank" class="form-select-custom shadow-sm"></select>
                        </div>

                        <input type="hidden" name="payment_method" id="final-payment-method">
                        <input type="hidden" name="cart_data" id="cart-data">
                        <input type="hidden" name="payment_amount" id="hidden-payment-amount">
                        <input type="hidden" name="change_amount" id="hidden-change-amount">

                        <button type="submit" class="btn-checkout" id="btn-submit">
                            <i class="fas fa-check-circle"></i> BAYAR SEKARANG
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>{{-- end .pos-wrapper --}}
@endsection

@push('scripts')
    <script>
        // ── Product Search / Filter ──
        function filterProducts(query) {
            const q = query.toLowerCase().trim();
            document.querySelectorAll('.product-col').forEach(col => {
                const name = col.dataset.name || '';
                col.style.display = (!q || name.includes(q)) ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. CART LOGIC (Dipertahankan Utuh) ---
            let cart = [];
            let currentTotalValue = 0; // Menyimpan nilai total real untuk kalkulator

            const cartItemsBody = document.getElementById('cart-items');
            const totalPriceSpan = document.getElementById('total-price');
            const hiddenCartInput = document.getElementById('cart-data');
            const emptyCartMsg = document.getElementById('empty-cart-msg');

            const formatRupiah = (n) => new Intl.NumberFormat('id-ID').format(n);

            function addToCart(product) {
                const existing = cart.find(item => item.id === product.id);
                if (existing) {
                    existing.quantity++;
                } else {
                    cart.push({
                        ...product,
                        quantity: 1
                    });
                }
                renderCart();

                // Quick visual feedback: flash card membal
                const card = document.querySelector(`.product-card[data-id="${product.id}"]`);
                if (card) {
                    card.style.transform = 'scale(1.05)';
                    card.style.borderColor = 'var(--green)';
                    setTimeout(() => {
                        card.style.transform = '';
                        card.style.borderColor = '';
                    }, 200);
                }
            }

            function renderCart() {
                cartItemsBody.innerHTML = '';
                let total = 0;

                if (cart.length === 0) {
                    if (emptyCartMsg) cartItemsBody.appendChild(emptyCartMsg);
                    totalPriceSpan.textContent = '0';
                    hiddenCartInput.value = '';
                    currentTotalValue = 0;
                    calculateChange(); // Update kembalian jika cart kosong
                    return;
                }

                cart.forEach(item => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>
                            <div class="fw-bold" style="font-size:0.9rem;color:var(--brown);">${item.name}</div>
                            <div class="small" style="color:var(--primary); font-weight:600;">Rp ${formatRupiah(item.price)}</div>
                        </td>
                        <td class="text-center">
                            <input type="number" value="${item.quantity}" min="1"
                                   class="qty-input quantity-input shadow-sm" data-id="${item.id}">
                        </td>
                        <td class="text-end fw-bold font-display" style="color:var(--primary);font-size:1rem;">${formatRupiah(subtotal)}</td>
                        <td class="text-center">
                            <button type="button" class="btn-remove-small btn-remove shadow-sm" data-id="${item.id}" title="Hapus">
                                <i class="fas fa-trash-alt" style="pointer-events:none;"></i>
                            </button>
                        </td>
                    `;
                    cartItemsBody.appendChild(tr);
                });

                currentTotalValue = total;
                totalPriceSpan.textContent = formatRupiah(total);
                hiddenCartInput.value = JSON.stringify(cart);
                calculateChange(); // Auto update kembalian tiap keranjang berubah
            }

            // Click product to add
            document.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', function() {
                    if (this.classList.contains('out-of-stock')) return;
                    addToCart({
                        id: parseInt(this.dataset.id),
                        name: this.dataset.name,
                        price: parseFloat(this.dataset.price)
                    });
                });
            });

            cartItemsBody.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove')) {
                    cart = cart.filter(item => item.id !== parseInt(e.target.dataset.id));
                    renderCart();
                }
            });

            cartItemsBody.addEventListener('change', function(e) {
                if (e.target.classList.contains('quantity-input')) {
                    const productId = parseInt(e.target.dataset.id);
                    const qty = parseInt(e.target.value);
                    const found = cart.find(item => item.id === productId);
                    if (found && qty > 0) {
                        found.quantity = qty;
                    } else {
                        cart = cart.filter(item => item.id !== productId);
                    }
                    renderCart();
                }
            });

            // --- 2. FITUR BARU: KALKULATOR KEMBALIAN TUNAI ---
            const uangDiterimaInput = document.getElementById('uang-diterima');
            const kembalianDisplay = document.getElementById('uang-kembalian');

            function calculateChange() {
                if (mainSelect.value !== 'Tunai') return;

                // Hapus titik untuk mendapatkan angka murni
                let nominalDiterimaStr = uangDiterimaInput.value.replace(/\./g, '');
                let diterima = parseInt(nominalDiterimaStr) || 0;

                if (diterima === 0) {
                    kembalianDisplay.textContent = "Rp 0";
                    kembalianDisplay.style.color = "var(--gray-400)";
                    return;
                }

                let kembalian = diterima - currentTotalValue;

                if (kembalian < 0) {
                    kembalianDisplay.textContent = "Uang Kurang!";
                    kembalianDisplay.style.color = "var(--red)";
                } else {
                    kembalianDisplay.textContent = "Rp " + formatRupiah(kembalian);
                    kembalianDisplay.style.color = "var(--green)"; // Hijau kontras
                }
            }

            // Format input uang diterima secara live
            uangDiterimaInput.addEventListener('input', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value) {
                    this.value = formatRupiah(value);
                } else {
                    this.value = '';
                }
                calculateChange();
            });


            // --- 3. PAYMENT DROPDOWN LOGIC ---
            const banks = {
                debit: ['BCA', 'BRI', 'BNI', 'Mandiri', 'BTN', 'CIMB Niaga', 'Danamon', 'Permata', 'Bank Mega',
                    'BSI'
                ],
                kredit: ['BCA', 'BRI', 'BNI', 'Mandiri', 'CIMB Niaga', 'Danamon', 'HSBC', 'Citibank',
                    'Bank Mega', 'BSI'
                ]
            };
            const mainSelect = document.getElementById('payment-main');
            const typeSelect = document.getElementById('payment-type');
            const bankSelect = document.getElementById('payment-bank');
            const typeContainer = document.getElementById('payment-type-container');
            const bankContainer = document.getElementById('payment-bank-container');
            const finalInput = document.getElementById('final-payment-method');
            const calcContainer = document.getElementById('change-calculator-container');

            function updateFinalPayment() {
                if (mainSelect.value === 'Tunai') {
                    finalInput.value = 'Tunai';
                    return;
                }
                let res = typeSelect.value;
                if ((res === 'Kartu Debit' || res === 'Kartu Kredit') && bankSelect.value) {
                    res += ` - ${bankSelect.value}`;
                }
                finalInput.value = res;
            }

            mainSelect.addEventListener('change', function() {
                const isNonTunai = this.value === 'Non Tunai';
                typeContainer.style.display = isNonTunai ? 'block' : 'none';
                calcContainer.style.display = isNonTunai ? 'none' :
                    'block'; // Tampilkan kalkulator jika Tunai

                if (!isNonTunai) {
                    bankContainer.style.display = 'none';
                    typeSelect.value = '';
                    bankSelect.innerHTML = '';
                    calculateChange();
                } else {
                    uangDiterimaInput.value = ''; // Reset uang jika pindah ke non-tunai
                }

                updateFinalPayment();
            });

            // Tampilkan kalkulator secara default karena 'Tunai' adalah default selected
            calcContainer.style.display = 'block';

            typeSelect.addEventListener('change', function() {
                bankSelect.innerHTML = '';
                const opts = this.value === 'Kartu Debit' ? banks.debit : this.value === 'Kartu Kredit' ?
                    banks.kredit : [];
                if (opts.length) {
                    bankContainer.style.display = 'block';
                    opts.forEach(b => {
                        const o = document.createElement('option');
                        o.value = o.textContent = b;
                        bankSelect.appendChild(o);
                    });
                } else {
                    bankContainer.style.display = 'none';
                }
                updateFinalPayment();
            });

            bankSelect.addEventListener('change', updateFinalPayment);
            updateFinalPayment();

            // --- PAYMENT AMOUNT SUBMISSION FIX ---
            // Populate hidden inputs with raw numeric values before form submit
            window.prepareSubmit = function() {
                const hiddenPayment = document.getElementById('hidden-payment-amount');
                const hiddenChange = document.getElementById('hidden-change-amount');

                if (mainSelect.value === 'Tunai') {
                    // Strip dots from formatted "100.000" → 100000
                    let rawDiterima = uangDiterimaInput.value.replace(/[^0-9]/g, '');
                    let diterima = parseInt(rawDiterima) || 0;
                    let kembalian = diterima - currentTotalValue;

                    // Validate: cash must cover the total
                    if (diterima > 0 && kembalian < 0) {
                        alert('Uang diterima tidak cukup untuk membayar!');
                        return false;
                    }

                    hiddenPayment.value = diterima > 0 ? diterima : currentTotalValue;
                    hiddenChange.value = kembalian > 0 ? kembalian : 0;
                } else {
                    // Non-tunai: bayar = exact total, no change
                    hiddenPayment.value = currentTotalValue;
                    hiddenChange.value = 0;
                }

                return true; // allow form to submit
            };

            // --- 4. AUTO-PRINT STRUK ---
            @if (session('print_struk'))
                const url = "{{ route('transaksi.struk', ':id') }}".replace(':id',
                    "{{ session('print_struk') }}");
                // Buka pop-up struk kasir profesional
                window.open(url, '_blank', 'width=450,height=700,left=200,top=100');
            @endif
        });
    </script>
@endpush
