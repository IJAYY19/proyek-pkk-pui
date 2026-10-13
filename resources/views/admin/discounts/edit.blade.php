@extends('admin.layouts.app')

@section('title', 'Edit Voucher')

@section('content')
    {{-- Import Google Fonts & Font Awesome --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #F26522;
            --primary-dark: #D84315;
            --primary-glow: rgba(242, 101, 34, 0.4);
            --brown: #5D4037;
            --brown-dark: #3E2723;
            --brown-light: #8D6E63;
            --cream-bg: #FDFBF7;
            --cream-card: #FFF8E1;
            --white: #FFFFFF;
            --gray-sub: #7A7A7A;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream-bg);
            color: var(--brown);
        }

        h1,
        h2,
        h3,
        h4,
        .font-display,
        .form-label,
        .ticket-title {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- BENTO CONTAINER LAYOUT --- */
        .bento-card {
            background: var(--white);
            border: 3px solid var(--brown);
            border-radius: 28px;
            box-shadow: 12px 12px 0px rgba(93, 64, 55, 0.12);
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        /* --- LEFT SIDE: GLASSMORPHISM TICKET PREVIEW --- */
        .preview-pane {
            /* Background pattern halus untuk menonjolkan efek glass */
            background-color: #F8F3EB;
            background-image: radial-gradient(#E8DCCD 1px, transparent 1px);
            background-size: 20px 20px;
            border-right: 3px dashed var(--brown);
            padding: 50px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            border-top-left-radius: 25px;
            border-bottom-left-radius: 25px;
        }

        /* Setengah lingkaran sobekan pembatas estetik */
        .preview-pane::before,
        .preview-pane::after {
            content: '';
            position: absolute;
            right: -14.5px;
            width: 26px;
            height: 26px;
            background-color: var(--white);
            border: 3px solid var(--brown);
            border-radius: 50%;
            z-index: 10;
        }

        .preview-pane::before {
            top: -13px;
        }

        .preview-pane::after {
            bottom: -13px;
        }

        /* GLASSMORPHISM TICKET BASE - NO OVERFLOW HIDDEN! */
        .cookie-ticket {
            width: 100%;
            max-width: 340px;
            position: relative;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 2px solid rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(93, 64, 55, 0.1),
                inset 0 0 0 1px rgba(255, 255, 255, 0.5);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            /* PENTING: Dilarang memakai overflow:hidden di sini agar badge aman */
        }

        .cookie-ticket:hover {
            transform: translateY(-8px) rotate(1.5deg);
        }

        /* Dekorasi Gerigi Tiket Samping */
        .ticket-cutout-left,
        .ticket-cutout-right {
            position: absolute;
            top: 55%;
            width: 20px;
            height: 20px;
            background-color: #F8F3EB;
            border: 2px solid rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            z-index: 5;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.04);
        }

        .ticket-cutout-left {
            left: -10px;
        }

        .ticket-cutout-right {
            right: -10px;
        }

        /* Menerapkan border-radius hanya di header agar menyatu dengan kartu */
        .ticket-header {
            background: linear-gradient(135deg, rgba(255, 248, 225, 0.85) 0%, rgba(255, 243, 205, 0.85) 100%);
            border-bottom: 3px dashed var(--brown-light);
            padding: 25px 20px 20px;
            text-align: center;
            position: relative;
            border-top-left-radius: 17px;
            border-top-right-radius: 17px;
        }

        /* BADGE MELAYANG - Tidak akan terpotong */
        .ticket-badge {
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
            color: var(--white);
            font-family: 'Fredoka', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 6px 18px;
            border-radius: 50px;
            position: absolute;
            top: -16px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 4px 10px var(--primary-glow), 2px 2px 0px var(--brown);
            border: 2px solid var(--white);
            letter-spacing: 0.5px;
            z-index: 20;
        }

        .ticket-body {
            padding: 25px 20px;
            text-align: center;
            border-bottom-left-radius: 17px;
            border-bottom-right-radius: 17px;
        }

        .ticket-promo-code {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-dark);
            letter-spacing: 2px;
            background: rgba(255, 255, 255, 0.8);
            border: 2px dashed var(--brown-light);
            padding: 8px 15px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 12px;
            max-width: 100%;
            word-wrap: break-word;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        /* --- RIGHT SIDE: PREMIUM FORM DETAILS --- */
        .form-pane {
            padding: 40px;
            background-color: var(--white);
            border-top-right-radius: 25px;
            border-bottom-right-radius: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--brown-dark);
            margin-bottom: 8px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Input Group Master styling */
        .premium-input-group {
            position: relative;
            display: flex;
            align-items: stretch;
            width: 100%;
            border: 2.5px solid var(--brown);
            border-radius: 14px;
            background-color: #FAFAFA;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .premium-input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-glow);
            transform: translateY(-2px);
            background-color: var(--white);
        }

        .premium-input-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            background-color: #F0EDE6;
            color: var(--brown-light);
            border-right: 2.5px solid var(--brown);
            font-size: 1.1rem;
            transition: all 0.25s ease;
        }

        .premium-input-group:focus-within .premium-input-icon {
            color: var(--primary);
            background-color: #FFF5F0;
            border-right-color: var(--primary);
        }

        .premium-form-control {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            padding: 12px 16px;
            font-family: 'Poppins', sans-serif;
            color: var(--brown-dark);
            font-weight: 600;
            width: 100%;
            background: transparent;
        }

        textarea.premium-form-control {
            min-height: 100px;
            resize: vertical;
        }

        .premium-form-control::placeholder {
            color: #A1887F;
            font-weight: 400;
        }

        /* Custom Status Switch */
        .status-switch-container {
            background-color: #FDFBF7;
            border: 2.5px solid var(--brown);
            border-radius: 14px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }

        .status-switch-container:hover {
            background-color: #FFF9EE;
        }

        .form-check-input {
            width: 3em !important;
            height: 1.5em !important;
            border: 2px solid var(--brown) !important;
            cursor: pointer;
            box-shadow: none !important;
        }

        .form-check-input:checked {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* Bantuan Rupiah Live Output */
        .live-rupiah-helper {
            font-size: 0.85rem;
            color: var(--primary-dark);
            font-weight: 600;
            margin-top: 6px;
            display: block;
            padding-left: 4px;
            min-height: 20px;
        }

        /* Action Buttons */
        .btn-update-premium {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: none;
            border-radius: 50px;
            padding: 14px 30px;
            font-weight: 700;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            width: 100%;
            box-shadow: 0 8px 20px var(--primary-glow), 0 4px 0px var(--brown-dark);
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-update-premium:hover {
            transform: scale(1.03) translateY(-4px);
            box-shadow: 0 12px 25px var(--primary-glow), 0 6px 0px var(--brown-dark);
            color: var(--white);
        }

        .btn-update-premium:active {
            transform: scale(0.98) translateY(2px);
            box-shadow: 0 2px 10px var(--primary-glow), 0 0px 0px var(--brown-dark);
        }

        .btn-cancel-premium {
            background: transparent;
            color: var(--brown);
            border: 2.5px solid var(--brown-light);
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cancel-premium:hover {
            background-color: rgba(141, 110, 99, 0.08);
            color: var(--brown-dark);
            border-color: var(--brown-dark);
        }

        /* Validasi Error Premium */
        .text-danger-premium {
            font-size: 0.8rem;
            font-weight: 600;
            color: #D32F2F;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
            animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-4px);
            }

            75% {
                transform: translateX(4px);
            }
        }

        /* Responsive tweaks */
        @media (max-width: 991.98px) {
            .bento-card {
                border-radius: 20px;
            }

            .preview-pane {
                border-right: none;
                border-bottom: 3px dashed var(--brown);
                padding: 40px 20px;
                border-top-right-radius: 17px;
                border-bottom-left-radius: 0;
            }

            .preview-pane::before,
            .preview-pane::after {
                bottom: -14.5px;
                left: 50%;
                transform: translateX(-50%);
            }

            .preview-pane::before {
                top: -14.5px;
                left: 50%;
            }

            .form-pane {
                padding: 30px 20px;
                border-top-right-radius: 0;
                border-bottom-left-radius: 17px;
            }
        }
    </style>

    <div class="container py-4">
        {{-- Header Halaman --}}
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-warning rounded-circle p-3 border border-3 border-dark shadow-sm mb-3"
                style="width: 70px; height: 70px;">
                <i class="fas fa-pencil-alt text-dark fs-3"></i>
            </div>
            <h1 class="fw-bold mb-1" style="color: var(--brown-dark);">Edit Voucher</h1>
            <p class="text-muted mb-0">Perbarui informasi dan syarat ketentuan kupon eksklusif ini.</p>
        </div>

        <div class="bento-card">
            <form action="{{ route('admin.discounts.update', $discount->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-0">

                    {{-- KOLOM KIRI: LIVE PREVIEW TICKET (BENTO LEFT) --}}
                    <div class="col-lg-5 preview-pane">
                        <h4 class="text-center fw-bold mb-5"
                            style="color: var(--brown-light); font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1.5px;">
                            <i class="fa-solid fa-wand-magic-sparkles me-2"></i>Live Update Preview
                        </h4>

                        <div class="cookie-ticket">
                            {{-- Telinga Gerigi Kiri & Kanan --}}
                            <div class="ticket-cutout-left"></div>
                            <div class="ticket-cutout-right"></div>

                            {{-- Bagian Atas Tiket --}}
                            <div class="ticket-header">
                                <span class="ticket-badge" id="preview-badge">MEMUAT...</span>
                                <div class="d-flex align-items-center justify-content-center gap-2 mt-2">
                                    <i class="fa-solid fa-cookie-bite"
                                        style="color: var(--primary); font-size: 1.4rem;"></i>
                                    <span class="font-display fw-bold text-dark mb-0"
                                        style="font-size: 1.2rem; letter-spacing: 0.5px;">THO COOKIES</span>
                                </div>
                            </div>

                            {{-- Bagian Tengah / Informasi Diskon Utama --}}
                            <div class="ticket-body">
                                <span class="text-muted d-block small mb-1">Gunakan Kode Kupon:</span>
                                <div class="ticket-promo-code" id="preview-code">KODE</div>

                                <div class="my-2">
                                    <h2 class="font-display fw-bold text-dark mb-0" style="font-size: 2.6rem;"
                                        id="preview-percentage">
                                        0% <span
                                            style="font-size: 1.2rem; color: var(--primary); font-family: 'Poppins', sans-serif;">OFF</span>
                                    </h2>
                                </div>

                                <p class="small text-muted fw-bold px-2 mb-3" id="preview-description"
                                    style="line-height: 1.4; min-height: 40px;">
                                    Deskripsi Promo
                                </p>

                                <div class="pt-3 border-top border-1"
                                    style="border-color: rgba(93, 64, 55, 0.1) !important;">
                                    <div class="row text-start g-2">
                                        <div class="col-6">
                                            <span style="font-size: 0.7rem; color: var(--gray-sub);"
                                                class="d-block text-uppercase">Min. Belanja</span>
                                            <strong style="font-size: 0.8rem; color: var(--brown-dark);"
                                                id="preview-min-purchase">Rp 0</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <span style="font-size: 0.7rem; color: var(--gray-sub);"
                                                class="d-block text-uppercase">Berlaku s/d</span>
                                            <strong style="font-size: 0.8rem; color: var(--brown-dark);"
                                                id="preview-expiry">-</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-center px-4 d-none d-lg-block">
                            <p class="small text-muted mb-0" style="font-style: italic;">
                                "Data telah di-pre-populate. Setiap perubahan Anda akan langsung direfleksikan pada tiket di
                                atas."
                            </p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: FORM DETAIL DATA (BENTO RIGHT) --}}
                    <div class="col-lg-7 form-pane">

                        <div class="row">
                            {{-- Kode Promo --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fa-solid fa-ticket"></i> Kode Voucher
                                </label>
                                <div class="premium-input-group">
                                    <span class="premium-input-icon"><i class="fa-solid fa-keyboard"></i></span>
                                    <input type="text" id="input-code" class="premium-form-control text-uppercase"
                                        name="code" value="{{ old('code', $discount->code) }}" required>
                                </div>
                                @error('code')
                                    <small class="text-danger-premium">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            {{-- Persentase --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fa-solid fa-percent"></i> Besar Diskon (%)
                                </label>
                                <div class="premium-input-group">
                                    <span class="premium-input-icon"><i class="fa-solid fa-percent"></i></span>
                                    <input type="number" id="input-percentage" class="premium-form-control"
                                        name="percentage" min="1" max="100"
                                        value="{{ old('percentage', $discount->percentage) }}" required>
                                </div>
                                @error('percentage')
                                    <small class="text-danger-premium">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fa-solid fa-align-left"></i> Nama Promo / Deskripsi
                            </label>
                            <div class="premium-input-group" style="align-items: flex-start;">
                                <span class="premium-input-icon" style="height: 100%;"><i
                                        class="fa-solid fa-pen-fancy"></i></span>
                                <textarea id="input-description" class="premium-form-control" name="description" required>{{ old('description', $discount->description) }}</textarea>
                            </div>
                            @error('description')
                                <small class="text-danger-premium">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row">
                            {{-- Minimal Belanja --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fa-solid fa-wallet"></i> Min. Belanja (Rp)
                                </label>
                                <div class="premium-input-group">
                                    <span class="premium-input-icon"
                                        style="font-weight: bold; font-size: 0.9rem;">Rp</span>
                                    <input type="number" id="input-min-purchase" class="premium-form-control"
                                        name="min_purchase" value="{{ old('min_purchase', $discount->min_purchase) }}"
                                        required>
                                </div>
                                <span class="live-rupiah-helper" id="rupiah-formatted">
                                    -> Minimum Belanja: Rp 0
                                </span>
                            </div>

                            {{-- Tanggal Kadaluarsa --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fa-regular fa-calendar-days"></i> Berlaku Sampai
                                </label>
                                <div class="premium-input-group">
                                    <span class="premium-input-icon"><i class="fa-regular fa-calendar"></i></span>
                                    <input type="date" id="input-expires-at" class="premium-form-control"
                                        name="expires_at"
                                        value="{{ old('expires_at', $discount->expires_at ? \Carbon\Carbon::parse($discount->expires_at)->format('Y-m-d') : '') }}"
                                        required>
                                </div>
                                @error('expires_at')
                                    <small class="text-danger-premium">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Status Aktif Premium Toggle --}}
                        <div class="mb-5">
                            <label class="form-label">
                                <i class="fa-solid fa-toggle-on"></i> Status Visibilitas
                            </label>

                            {{-- Hidden input for fallback if checkbox is unchecked --}}
                            <input type="hidden" name="is_active" value="0">

                            <div class="status-switch-container">
                                <div>
                                    <strong id="status-label-title" class="d-block"
                                        style="color: var(--brown-dark); font-size: 0.95rem;">Voucher Aktif</strong>
                                    <small class="text-muted" style="font-size: 0.8rem;">Status saat ini: Kupon dapat
                                        digunakan oleh pelanggan.</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="input-is-active"
                                        name="is_active" value="1"
                                        {{ old('is_active', $discount->is_active) ? 'checked' : '' }}>
                                </div>
                            </div>
                        </div>

                        <hr class="border-2 border-secondary opacity-10 my-4">

                        {{-- Tombol Navigasi / Aksi --}}
                        <div class="row g-3">
                            <div class="col-md-5 order-2 order-md-1">
                                <a href="{{ route('admin.discounts.index') }}" class="btn-cancel-premium">
                                    Batal & Kembali
                                </a>
                            </div>
                            <div class="col-md-7 order-1 order-md-2">
                                <button type="submit" class="btn-update-premium">
                                    <i class="fa-solid fa-cloud-arrow-up"></i> Perbarui Voucher
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- INTERACTIVE JAVASCRIPT ENGINE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Element Inputs
            const inputCode = document.getElementById('input-code');
            const inputPercentage = document.getElementById('input-percentage');
            const inputDescription = document.getElementById('input-description');
            const inputMinPurchase = document.getElementById('input-min-purchase');
            const inputExpiresAt = document.getElementById('input-expires-at');
            const inputIsActive = document.getElementById('input-is-active');

            // Element Previews
            const previewCode = document.getElementById('preview-code');
            const previewPercentage = document.getElementById('preview-percentage');
            const previewDescription = document.getElementById('preview-description');
            const previewMinPurchase = document.getElementById('preview-min-purchase');
            const previewExpiry = document.getElementById('preview-expiry');
            const previewBadge = document.getElementById('preview-badge');

            // Helper Texts
            const rupiahFormatted = document.getElementById('rupiah-formatted');
            const statusLabelTitle = document.getElementById('status-label-title');

            // Helper format mata uang Rupiah
            function formatRupiah(angka) {
                let numberString = angka.toString().replace(/[^,\d]/g, '');
                let split = numberString.split(',');
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return 'Rp ' + (rupiah ? rupiah : '0');
            }

            // Helper format Tanggal Manusiawi
            function formatDateFriendly(dateString) {
                if (!dateString) return '-';
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', options);
            }

            // Sync: Kode Voucher (Auto-uppercase & Real-time Sync)
            inputCode.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
                let codeVal = this.value.trim();
                previewCode.textContent = codeVal !== '' ? codeVal : 'KODE';
            });

            // Sync: Besar Diskon
            inputPercentage.addEventListener('input', function() {
                let percentVal = parseInt(this.value);
                if (isNaN(percentVal) || percentVal < 1) {
                    previewPercentage.innerHTML =
                        '0% <span style="font-size: 1.2rem; color: var(--primary); font-family: \'Poppins\', sans-serif;">OFF</span>';
                } else {
                    if (percentVal > 100) {
                        this.value = 100;
                        percentVal = 100;
                    }
                    previewPercentage.innerHTML = percentVal +
                        '% <span style="font-size: 1.2rem; color: var(--primary); font-family: \'Poppins\', sans-serif;">OFF</span>';
                }
            });

            // Sync: Deskripsi Promo (Dari Textarea)
            inputDescription.addEventListener('input', function() {
                let descVal = this.value.trim();
                previewDescription.textContent = descVal !== '' ? descVal : 'Deskripsi Promo';
            });

            // Sync & Auto-Format: Minimum Belanja
            inputMinPurchase.addEventListener('input', function() {
                let rawVal = this.value;
                if (rawVal === '' || isNaN(rawVal) || rawVal < 0) {
                    rawVal = 0;
                }

                const formatted = formatRupiah(rawVal);

                // Update helper text di bawah kolom input
                rupiahFormatted.textContent = '-> Minimum Belanja: ' + formatted;

                // Update di visualisasi kupon kiri
                previewMinPurchase.textContent = formatted;
            });

            // Sync: Tanggal Kadaluarsa
            inputExpiresAt.addEventListener('change', function() {
                previewExpiry.textContent = formatDateFriendly(this.value);
            });

            // Sync: Status Aktif Badge & Label
            inputIsActive.addEventListener('change', function() {
                if (this.checked) {
                    previewBadge.textContent = 'VOUCHER AKTIF';
                    previewBadge.style.background =
                        'linear-gradient(90deg, var(--primary), var(--primary-dark))';
                    previewBadge.style.color = '#FFFFFF';
                    statusLabelTitle.textContent = 'Voucher Aktif';
                    statusLabelTitle.style.color = 'var(--brown-dark)';
                } else {
                    previewBadge.textContent = 'NON-AKTIF';
                    previewBadge.style.background = '#7A7A7A';
                    previewBadge.style.color = '#FFFFFF';
                    statusLabelTitle.textContent = 'Voucher Disembunyikan';
                    statusLabelTitle.style.color = '#7A7A7A';
                }
            });

            // ==========================================
            // INIT: PRE-POPULATE DATA SAAT HALAMAN DIMUAT
            // ==========================================
            const triggerEvent = (el, type) => {
                if (el) el.dispatchEvent(new Event(type));
            };

            triggerEvent(inputCode, 'input');
            triggerEvent(inputPercentage, 'input');
            triggerEvent(inputDescription, 'input');
            triggerEvent(inputMinPurchase, 'input');
            triggerEvent(inputExpiresAt, 'change');
            triggerEvent(inputIsActive, 'change');
        });
    </script>
@endsection
