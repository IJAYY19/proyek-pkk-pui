@extends('admin.layouts.app')

@section('title', 'Kelola Voucher & Diskon - Tho Cookies')

@section('content')
    {{-- Import Fonts & SweetAlert2 --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            /* Palette Premium Tho Cookies */
            --primary: #E85D22;
            --primary-glow: rgba(232, 93, 34, 0.4);
            --primary-soft: rgba(232, 93, 34, 0.1);
            --brown-dark: #3A2A22;
            --brown-light: #7A6253;
            --cream-bg: #FDFBF7;
            --white-glass: rgba(255, 255, 255, 0.85);

            /* Status Colors */
            --success: #10B981;
            --success-bg: rgba(16, 185, 129, 0.15);
            --danger: #EF4444;
            --danger-bg: rgba(239, 68, 68, 0.15);
            --neutral: #6B7280;
            --neutral-bg: rgba(107, 114, 128, 0.15);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream-bg);
            color: var(--brown-dark);
        }

        h1,
        h2,
        h3,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- ANIMASI --- */
        @keyframes fadeSlideUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulsingDot {
            0% {
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                transform: scale(1.1);
                box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
            }

            100% {
                transform: scale(0.9);
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        .animate-enter {
            opacity: 0;
            animation: fadeSlideUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* --- HEADER & PENCARIAN --- */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--brown-dark);
            letter-spacing: -0.5px;
        }

        /* Tombol Tambah Premium */
        .btn-premium-add {
            background: linear-gradient(135deg, #FF7B3D 0%, var(--primary) 100%);
            color: white !important;
            border: none;
            border-radius: 50px;
            padding: 12px 28px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            box-shadow: 0 8px 20px var(--primary-glow);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-premium-add:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 25px rgba(232, 93, 34, 0.5);
        }

        /* Search Box Kapsul */
        .search-capsule {
            position: relative;
            width: 100%;
            max-width: 320px;
        }

        .search-capsule input {
            width: 100%;
            background: white;
            border: 2px solid transparent;
            border-radius: 50px;
            padding: 12px 20px 12px 45px;
            font-size: 0.95rem;
            color: var(--brown-dark);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .search-capsule input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-glow);
        }

        .search-capsule i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--brown-light);
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .search-capsule input:focus+i {
            color: var(--primary);
        }

        /* --- GRID TIKET KUPON --- */
        .ticket-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            align-items: stretch;
        }

        .ticket-card {
            background: var(--white-glass);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 12px 30px rgba(58, 42, 34, 0.05);
            display: flex;
            position: relative;
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        }

        .ticket-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(232, 93, 34, 0.1);
        }

        .ticket-card.expired {
            opacity: 0.75;
            filter: grayscale(80%);
        }

        .ticket-card.expired:hover {
            transform: none;
            box-shadow: 0 12px 30px rgba(58, 42, 34, 0.05);
        }

        /* Bagian Kiri (Tear-off) */
        .ticket-left {
            width: 35%;
            border-right: 2px dashed rgba(93, 64, 55, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 10px;
            position: relative;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0) 100%);
            border-top-left-radius: 24px;
            border-bottom-left-radius: 24px;
        }

        /* Lubang Sobekan Tiket Atas & Bawah */
        .ticket-left::before,
        .ticket-left::after {
            content: '';
            position: absolute;
            right: -11px;
            /* Setengah dari width/height */
            width: 22px;
            height: 22px;
            background-color: var(--cream-bg);
            border-radius: 50%;
            z-index: 5;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .ticket-left::before {
            top: -11px;
        }

        .ticket-left::after {
            bottom: -11px;
            box-shadow: inset 0 -2px 4px rgba(0, 0, 0, 0.03);
        }

        .discount-value {
            font-family: 'Fredoka', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1;
            text-shadow: 2px 2px 0px rgba(232, 93, 34, 0.1);
        }

        .discount-label {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--brown-dark);
            letter-spacing: 1px;
            margin-top: -5px;
        }

        /* Bagian Kanan (Detail) */
        .ticket-right {
            width: 65%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Lencana Kode Voucher */
        .promo-code-badge {
            background: var(--brown-dark);
            color: #FFD166;
            padding: 6px 14px;
            border-radius: 8px;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            letter-spacing: 1.5px;
            border: 1px dashed #FFD166;
            display: inline-block;
            margin-bottom: 10px;
        }

        .promo-desc {
            font-size: 0.85rem;
            color: var(--brown-light);
            margin-bottom: 15px;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .promo-rules {
            font-size: 0.8rem;
            color: var(--brown-dark);
            background: rgba(93, 64, 55, 0.04);
            padding: 8px 12px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .promo-rules i {
            color: var(--primary);
            margin-right: 6px;
        }

        /* Status & Tombol */
        .ticket-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active-pill {
            background: var(--success-bg);
            color: var(--success);
        }

        .dot-active {
            width: 6px;
            height: 6px;
            background-color: var(--success);
            border-radius: 50%;
            animation: pulsingDot 2s infinite;
        }

        .status-expired-pill {
            background: var(--neutral-bg);
            color: var(--neutral);
        }

        /* Tombol Aksi Bulat */
        .action-flex {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 0.85rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-edit {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .btn-edit:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.15) rotate(5deg);
        }

        .btn-delete {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            transform: scale(1.15) rotate(-5deg);
        }

        /* Empty State */
        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            background: var(--white-glass);
            border-radius: 24px;
            border: 2px dashed rgba(93, 64, 55, 0.2);
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.2;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .ticket-card {
                flex-direction: column;
            }

            .ticket-left {
                width: 100%;
                border-right: none;
                border-bottom: 2px dashed rgba(93, 64, 55, 0.2);
                border-radius: 24px 24px 0 0;
                padding: 30px 10px;
            }

            .ticket-left::before {
                top: auto;
                bottom: -11px;
                right: auto;
                left: 20%;
            }

            .ticket-left::after {
                bottom: -11px;
                right: 20%;
            }

            .ticket-right {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-4">

        {{-- Header & Toolbar --}}
        <div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4 animate-enter"
            style="animation-delay: 0.1s;">
            <div>
                <h1 class="page-title mb-1">
                    Kelola <span style="color: var(--primary);">Voucher & Diskon</span>
                </h1>
                <p class="text-muted mb-0" style="color: var(--brown-light) !important;">Atur tiket promosi untuk memanjakan
                    pelanggan Tho Cookies.</p>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-3 align-items-sm-center">
                {{-- Live Search Bar --}}
                <div class="search-capsule">
                    <input type="text" id="searchInput" placeholder="Cari kode voucher...">
                    <i class="fas fa-ticket-alt"></i>
                </div>

                {{-- Add Button Premium --}}
                <a href="{{ route('admin.discounts.create') }}" class="btn-premium-add">
                    <i class="fas fa-plus-circle"></i> Voucher Baru
                </a>
            </div>
        </div>

        {{-- SweetAlert Notifikasi Sukses --}}
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'glass-card'
                        }
                    });
                });
            </script>
        @endif

        {{-- Grid Tiket Kupon --}}
        <div class="ticket-grid" id="couponGrid">
            @forelse ($discounts as $index => $discount)
                @php
                    $isExpired = \Carbon\Carbon::parse($discount->expires_at)->isPast();
                    $isActive = $discount->is_active;
                    $isDimmed = !$isActive || $isExpired ? 'expired' : '';
                @endphp

                <div class="ticket-card {{ $isDimmed }} animate-enter"
                    style="animation-delay: {{ 0.2 + $index * 0.05 }}s;">

                    {{-- Sisi Kiri (Tear-off) --}}
                    <div class="ticket-left">
                        <div class="discount-value">{{ $discount->percentage }}%</div>
                        <div class="discount-label">OFF</div>
                    </div>

                    {{-- Sisi Kanan (Detail Promo) --}}
                    <div class="ticket-right">
                        <div>
                            <div class="promo-code-badge coupon-code-text">{{ $discount->code }}</div>
                            <p class="promo-desc">{{ $discount->description }}</p>

                            <div class="promo-rules">
                                <div><i class="fas fa-shopping-bag"></i> Min:
                                    <b>
                                        @if ($discount->min_purchase > 0)
                                            Rp {{ number_format($discount->min_purchase, 0, ',', '.') }}
                                        @else
                                            Tanpa Syarat
                                        @endif
                                    </b>
                                </div>
                                <div class="mt-1"><i class="far fa-clock"></i> Exp:
                                    <b>{{ \Carbon\Carbon::parse($discount->expires_at)->format('d M Y') }}</b>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Tiket: Status & Aksi --}}
                        <div class="ticket-footer">
                            {{-- Lencana Status --}}
                            @if (!$isActive)
                                <span class="status-pill status-expired-pill">
                                    <i class="fas fa-ban"></i> Nonaktif
                                </span>
                            @elseif ($isExpired)
                                <span class="status-pill status-expired-pill">
                                    <i class="fas fa-hourglass-end"></i> Kedaluwarsa
                                </span>
                            @else
                                <span class="status-pill status-active-pill">
                                    <span class="dot-active"></span> Aktif Berjalan
                                </span>
                            @endif

                            {{-- Tombol Aksi Minimalis --}}
                            <div class="action-flex">
                                <a href="{{ route('admin.discounts.edit', $discount->id) }}" class="btn-icon btn-edit"
                                    title="Edit Voucher">
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.discounts.destroy', $discount->id) }}" method="POST"
                                    class="form-delete d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-icon btn-delete trigger-delete" title="Hapus Voucher"
                                        data-code="{{ $discount->code }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @empty
                <div class="empty-state animate-enter" style="animation-delay: 0.2s;">
                    <div class="empty-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h4 style="font-family: 'Fredoka', sans-serif; color: var(--brown-dark);">Belum Ada Voucher</h4>
                    <p style="color: var(--brown-light);">Katalog diskon Anda masih kosong. Buat kode promo pertama untuk
                        menarik pelanggan!</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- SCRIPT INTERAKSI FRONTEND --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Live Search Filter Instan
            const searchInput = document.getElementById('searchInput');
            const ticketCards = document.querySelectorAll('.ticket-card');

            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase().trim();

                ticketCards.forEach(card => {
                    const codeElement = card.querySelector('.coupon-code-text');
                    if (codeElement) {
                        const couponCode = codeElement.textContent.toLowerCase();
                        if (couponCode.includes(searchText)) {
                            card.style.display = 'flex'; // Kembalikan ke display flex bawaan
                            card.style.opacity = card.classList.contains('expired') ? '0.75' : '1';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });

            // 2. SweetAlert2 Konfirmasi Hapus Dinamis (Meninggalkan bawaan confirm browser)
            const deleteButtons = document.querySelectorAll('.trigger-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.form-delete');
                    const couponCode = this.getAttribute('data-code');

                    Swal.fire({
                        title: 'Hapus Voucher?',
                        html: `Kode promo <b>${couponCode}</b> akan dihapus secara permanen.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#9CA3AF',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn-premium-add',
                            cancelButton: 'btn-premium-add bg-secondary'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'Menghapus...',
                                allowOutsideClick: false,
                                showConfirmButton: false,
                                willOpen: () => {
                                    Swal.showLoading()
                                }
                            });
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
