@extends('admin.layouts.app')

@section('title', 'Buat Diskon Baru')

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
            --primary-light: rgba(242, 101, 34, 0.08);
            --brown: #5D4037;
            --brown-dark: #3E2723;
            --brown-light: #8D6E63;
            --cream-bg: #FFFDF9;
            --cream-card: #FFF8E1;
            --white: #FFFFFF;
            --gray-sub: #7A7A7A;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FDFBF7;
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
            overflow: hidden;
            transition: all 0.3s ease;
        }

        /* --- LEFT SIDE: PREMIUM LIVE PREVIEW TICKET --- */
        .preview-pane {
            background-color: #FFF9EE;
            border-right: 3px dashed var(--brown);
            padding: 40px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        /* Setengah lingkaran sobekan tiket estetik di atas & bawah garis batas */
        .preview-pane::before,
        .preview-pane::after {
            content: '';
            position: absolute;
            right: -13px;
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

        /* Desain Struktur Tiket */
        .cookie-ticket {
            width: 100%;
            max-width: 340px;
            background: var(--white);
            border: 3px solid var(--brown);
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(93, 64, 55, 0.08);
            position: relative;
            transition: transform 0.3s ease;
        }

        .cookie-ticket:hover {
            transform: translateY(-5px) rotate(1deg);
        }

        /* Dekorasi Gerigi Tiket Samping */
        .ticket-cutout-left,
        .ticket-cutout-right {
            position: absolute;
            top: 60%;
            width: 16px;
            height: 16px;
            background-color: #FFF9EE;
            border: 3px solid var(--brown);
            border-radius: 50%;
            z-index: 5;
        }

        .ticket-cutout-left {
            left: -10px;
        }

        .ticket-cutout-right {
            right: -10px;
        }

        .ticket-header {
            background: linear-gradient(135deg, var(--cream-card) 0%, #FFF3CD 100%);
            border-bottom: 3px dashed var(--brown);
            padding: 20px;
            text-align: center;
            position: relative;
            border-top-left-radius: 17px;
            border-top-right-radius: 17px;
        }

        .ticket-badge {
            background: var(--primary);
            color: var(--white);
            font-family: 'Fredoka', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            border: 2px solid var(--brown);
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 2px 2px 0px var(--brown);
        }

        .ticket-body {
            padding: 25px 20px;
            text-align: center;
        }

        .ticket-promo-code {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-dark);
            letter-spacing: 2px;
            background: var(--cream-card);
            border: 2px dashed var(--brown);
            padding: 8px 15px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 12px;
            max-width: 100%;
            word-wrap: break-word;
        }

        /* --- RIGHT SIDE: PREMIUM FORM DETAILS --- */
        .form-pane {
            padding: 40px;
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
            background-color: var(--white);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .premium-input-group:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 5px rgba(242, 101, 34, 0.15);
            transform: translateY(-1px);
        }

        .premium-input-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 16px;
            background-color: #FFFDF9;
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
            font-weight: 500;
            width: 100%;
            background: transparent;
        }

        .premium-form-control::placeholder {
            color: #A1887F;
            font-weight: 400;
        }

        /* Special Switch Styling */
        .switch-container {
            background-color: #FDFBF7;
            border: 2px solid var(--brown);
            border-radius: 14px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--brown);
        }

        .form-check-input {
            border-color: var(--brown);
            cursor: pointer;
            width: 2.5em;
            height: 1.25em;
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
            transition: opacity 0.2s;
        }

        /* Action Buttons */
        .btn-save-premium {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: var(--white);
            border: 2.5px solid var(--brown-dark);
            border-radius: 50px;
            padding: 14px 30px;
            font-weight: 700;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            width: 100%;
            box-shadow: 4px 4px 0px var(--brown-dark);
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-save-premium:hover {
            transform: translateY(-3px);
            box-shadow: 6px 6px 0px var(--brown-dark);
            color: var(--white);
        }

        .btn-save-premium:active {
            transform: translateY(1px);
            box-shadow: 2px 2px 0px var(--brown-dark);
        }

        .btn-cancel-premium {
            background: transparent;
            color: var(--brown-light);
            border: 2.5px solid var(--brown-light);
            border-radius: 50px;
            padding: 14px 30px;
            font-weight: 700;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s ease;
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

        /* Responsive custom tweaks */
        @media (max-width: 991.98px) {
            .preview-pane {
                border-right: none;
                border-bottom: 3px dashed var(--brown);
                padding: 30px 20px;
            }

            .preview-pane::before,
            .preview-pane::after {
                bottom: -13px;
                left: 50%;
                transform: translateX(-50%);
            }

            .preview-pane::before {
                top: -13px;
                left: 50%;
            }

            .form-pane {
                padding: 30px 20px;
            }
        }
    </style>

    <div class="container py-4">
        {{-- Header Halaman --}}
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-warning rounded-circle p-3 border border-3 border-dark shadow-sm mb-3"
                style="width: 70px; height: 70px;">
                <i class="fas fa-tags text-dark fs-3"></i>
            </div>
            <h1 class="fw-bold mb-1" style="color: var(--brown-dark);">Buat Voucher Baru</h1>
            <p class="text-muted mb-0">Rancang penawaran terbaik untuk pembeli setia kue premium Anda.</p>
        </div>

        <div class="bento-card">
            <form action="{{ route('admin.discounts.store') }}" method="POST">
                @csrf

                <div class="row g-0">

                    {{-- KOLOM KIRI: LIVE PREVIEW VOUCHER (BENTO LEFT) --}}
                    <div class="col-lg-5 preview-pane">
                        <h4 class="text-center fw-bold mb-4"
                            style="color: var(--brown-light); font-size: 1.1rem; text-transform: uppercase; letter-spacing: 1.5px;">
                            <i class="fa-solid fa-eye me-2"></i>Live Ticket Preview
                        </h4>

                        <div class="cookie-ticket">
                            {{-- Telinga Gerigi Kiri & Kanan --}}
                            <div class="ticket-cutout-left"></div>
                            <div class="ticket-cutout-right"></div>

                            {{-- Bagian Atas Tiket --}}
                            <div class="ticket-header">
                                <span class="ticket-badge" id="preview-badge">VOUCHER AKTIF</span>
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
                                <div class="ticket-promo-code" id="preview-code">MIE10</div>

                                <div class="my-2">
                                    <h2 class="font-display fw-bold text-dark mb-0" style="font-size: 2.5rem;"
                                        id="preview-percentage">
                                        10% <span
                                            style="font-size: 1.3rem; color: var(--primary); font-family: 'Poppins', sans-serif;">OFF</span>
                                    </h2>
                                </div>

                                <p class="small text-muted fw-bold px-2 mb-3" id="preview-description"
                                    style="line-height: 1.4; min-height: 40px;">
                                    Promo Gajian Hemat
                                </p>

                                <div class="pt-3 border-top border-1" style="border-color: #EFEFEF !important;">
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
                                                id="preview-expiry">Selamanya</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center px-4 d-none d-lg-block">
                            <p class="small text-muted mb-0" style="font-style: italic;">
                                "Tampilan di atas merepresentasikan bentuk visualisasi voucher asli saat pelanggan melakukan
                                checkout."
                            </p>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: FORM DETAIL DATA (BENTO RIGHT) --}}
                    <div class="col-lg-7 form-pane">

                        <div class="row">
                            {{-- Kode Promo --}}
                            <div class="col-md-6 mb-4">
                                <label class="form-label">
                                    <i class="fa-solid fa-ticket"></i> Kode Voucher (Unik)
                                </label>
                                <div class="premium-input-group">
                                    <span class="premium-input-icon"><i class="fa-solid fa-keyboard"></i></span>
                                    <input type="text" id="input-code"
                                        class="premium-form-control text-uppercase fw-bold" name="code"
                                        placeholder="MIE10" value="{{ old('code') }}" required>
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
                                        name="percentage" placeholder="10" min="1" max="100"
                                        value="{{ old('percentage') }}" required>
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
                                <i class="fa-solid fa-align-left"></i> Nama Promo / Deskripsi Singkat
                            </label>
                            <div class="premium-input-group">
                                <span class="premium-input-icon"><i class="fa-solid fa-pen-fancy"></i></span>
                                <input type="text" id="input-description" class="premium-form-control"
                                    name="description" placeholder="Contoh: Promo Gajian Hemat"
                                    value="{{ old('description') }}" required>
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
                                        name="min_purchase" placeholder="0" value="{{ old('min_purchase', 0) }}">
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
                                        name="expires_at" value="{{ old('expires_at') }}" required>
                                </div>
                                @error('expires_at')
                                    <small class="text-danger-premium">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>

                        {{-- Status Aktif & Switch Custom --}}
                        <div class="mb-4">
                            <label class="form-label">
                                <i class="fa-solid fa-toggle-on"></i> Status Voucher Awal
                            </label>
                            <div class="switch-container">
                                <div>
                                    <strong id="status-label-title" class="d-block"
                                        style="color: var(--brown-dark); font-size: 0.9rem;">Voucher Langsung
                                        Aktif</strong>
                                    <small class="text-muted" style="font-size: 0.8rem;">Pelanggan dapat langsung
                                        menggunakannya setelah disimpan.</small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="input-is-active"
                                        name="is_active" value="1" checked style="transform: scale(1.3);">
                                </div>
                            </div>
                        </div>

                        <hr class="border-2 border-secondary opacity-15 my-4">

                        {{-- Tombol Navigasi / Aksi --}}
                        <div class="row g-3">
                            <div class="col-md-6 order-2 order-md-1">
                                <a href="{{ route('admin.discounts.index') }}" class="btn-cancel-premium">
                                    <i class="fa-solid fa-arrow-left me-2"></i> Batal & Kembali
                                </a>
                            </div>
                            <div class="col-md-6 order-1 order-md-2">
                                <button type="submit" class="btn-save-premium">
                                    <i class="fas fa-save"></i> Simpan Voucher
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
                if (!dateString) return 'Selamanya';
                const options = {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', options);
            }

            // Sync: Kode Voucher (Auto-uppercase & Real-time Sync)
            inputCode.addEventListener('input', function(e) {
                this.value = this.value.toUpperCase();
                let codeVal = this.value.trim();
                previewCode.textContent = codeVal !== '' ? codeVal : 'MIE10';
            });

            // Sync: Besar Diskon
            inputPercentage.addEventListener('input', function() {
                let percentVal = parseInt(this.value);
                if (isNaN(percentVal) || percentVal < 1) {
                    previewPercentage.innerHTML =
                        '0% <span style="font-size: 1.3rem; color: var(--primary); font-family: \'Poppins\', sans-serif;">OFF</span>';
                } else {
                    if (percentVal > 100) {
                        this.value = 100;
                        percentVal = 100;
                    }
                    previewPercentage.innerHTML = percentVal +
                        '% <span style="font-size: 1.3rem; color: var(--primary); font-family: \'Poppins\', sans-serif;">OFF</span>';
                }
            });

            // Sync: Deskripsi Promo
            inputDescription.addEventListener('input', function() {
                let descVal = this.value.trim();
                previewDescription.textContent = descVal !== '' ? descVal : 'Promo Gajian Hemat';
            });

            // Sync & Auto-Format: Minimum Belanja
            inputMinPurchase.addEventListener('input', function() {
                let rawVal = this.value;
                if (rawVal === '' || isNaN(rawVal) || rawVal < 0) {
                    rawVal = 0;
                }

                const formatted = formatRupiah(rawVal);

                // Update helper di bawah kolom input
                rupiahFormatted.textContent = '-> Minimum Belanja: ' + formatted;

                // Update di visualisasi kupon kiri
                previewMinPurchase.textContent = formatted;
            });

            // Sync: Tanggal Kadaluarsa
            inputExpiresAt.addEventListener('change', function() {
                previewExpiry.textContent = formatDateFriendly(this.value);
            });

            // Sync: Status Aktif Badge
            inputIsActive.addEventListener('change', function() {
                if (this.checked) {
                    previewBadge.textContent = 'VOUCHER AKTIF';
                    previewBadge.style.backgroundColor = 'var(--primary)';
                    previewBadge.style.color = '#FFFFFF';
                } else {
                    previewBadge.textContent = 'NON-AKTIF';
                    previewBadge.style.backgroundColor = '#7A7A7A';
                    previewBadge.style.color = '#FFFFFF';
                }
            });

            // Trigger inisialisasi awal (jika terdapat value lama dari 'old()')
            if (inputCode.value) inputCode.dispatchEvent(new Event('input'));
            if (inputPercentage.value) inputPercentage.dispatchEvent(new Event('input'));
            if (inputDescription.value) inputDescription.dispatchEvent(new Event('input'));
            if (inputMinPurchase.value) inputMinPurchase.dispatchEvent(new Event('input'));
            if (inputExpiresAt.value) inputExpiresAt.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
