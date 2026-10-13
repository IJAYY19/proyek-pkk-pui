@extends('admin.layouts.app')

@section('title', 'Edit Menu - Tho Cookies')

@section('content')
    {{-- Import Fonts --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            /* Palette Premium Tho Cookies */
            --primary: #E85D22;
            /* Oranye menyala elegan */
            --primary-glow: rgba(232, 93, 34, 0.25);
            --primary-soft: rgba(232, 93, 34, 0.08);
            --brown-dark: #3A2A22;
            /* Cokelat pekat untuk teks utama */
            --brown-light: #7A6253;
            /* Cokelat pudar untuk teks sekunder */
            --cream-bg: #FDFBF7;
            /* Krem sangat lembut untuk background */
            --white-glass: rgba(255, 255, 255, 0.95);

            /* Status Colors */
            --success: #10B981;
            --success-bg: rgba(16, 185, 129, 0.1);
            --danger: #EF4444;
            --danger-bg: rgba(239, 68, 68, 0.1);
            --warning: #F59E0B;
            --warning-bg: rgba(245, 158, 11, 0.1);
            --neutral: #9CA3AF;
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

        .animate-enter {
            opacity: 0;
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* --- BENTO CARD LAYOUT --- */
        .bento-card {
            background: var(--white-glass);
            border-radius: 28px;
            padding: 35px;
            box-shadow: 0 15px 45px rgba(58, 42, 34, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
            max-width: 1100px;
            margin: 0 auto;
        }

        .bento-card::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, var(--primary-soft) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .bento-content {
            position: relative;
            z-index: 1;
        }

        /* --- TYPOGRAPHY --- */
        .page-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--brown-dark);
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: var(--brown-light);
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .section-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.2rem;
            color: var(--brown-dark);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            color: var(--primary);
            background: var(--primary-soft);
            padding: 8px;
            border-radius: 10px;
            font-size: 1rem;
        }

        /* --- VISUAL AREA (KOLOM KIRI) --- */
        .visual-frame {
            background: #FAFAFA;
            border-radius: 24px;
            padding: 20px;
            border: 1px solid rgba(93, 64, 55, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .current-image-wrapper {
            width: 100%;
            height: 250px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            border: 3px solid white;
            background-color: #eee;
            margin-bottom: 15px;
        }

        .current-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.4s ease-in-out;
        }

        .image-status-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--brown-dark);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .upload-zone-edit {
            border: 2px dashed rgba(93, 64, 55, 0.2);
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            background: white;
        }

        .upload-zone-edit:hover {
            border-color: var(--primary);
            background: var(--primary-soft);
        }

        .upload-zone-edit input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        /* --- FORM INPUT PREMIUM --- */
        .form-group {
            margin-bottom: 22px;
        }

        .form-label {
            font-family: 'Fredoka', sans-serif;
            font-weight: 500;
            color: var(--brown-dark);
            margin-bottom: 8px;
            font-size: 1.05rem;
            display: flex;
            justify-content: space-between;
            /* Untuk tempat badge stok */
            align-items: center;
        }

        .input-premium-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-premium-icon {
            position: absolute;
            left: 18px;
            color: var(--brown-light);
            font-size: 1.1rem;
            transition: color 0.3s;
            pointer-events: none;
            z-index: 2;
        }

        .input-premium {
            width: 100%;
            border: 2px solid rgba(93, 64, 55, 0.15);
            border-radius: 16px;
            padding: 14px 18px 14px 48px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            color: var(--brown-dark);
            background-color: #FAFAFA;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .textarea-premium-wrapper .input-premium-icon {
            top: 16px;
        }

        .input-premium:focus {
            outline: none;
            border-color: var(--primary);
            background-color: white;
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .input-premium:focus~.input-premium-icon,
        .input-premium:not(:placeholder-shown)~.input-premium-icon {
            color: var(--primary);
        }

        .input-premium.is-invalid {
            border-color: var(--danger);
            background-color: rgba(239, 68, 68, 0.02);
        }

        .error-message {
            color: var(--danger);
            font-size: 0.85rem;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Helper Teks */
        .rupiah-helper {
            font-size: 0.85rem;
            color: var(--brown-light);
            margin-top: 8px;
            display: block;
            min-height: 20px;
        }

        /* Dynamic Stock Badge */
        .dynamic-stock-badge {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        .stock-safe {
            background: var(--success-bg);
            color: var(--success);
        }

        .stock-warning {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .stock-danger {
            background: var(--danger-bg);
            color: var(--danger);
        }

        /* --- ACTION BUTTONS --- */
        .btn-wrapper {
            display: flex;
            gap: 15px;
            margin-top: 35px;
            padding-top: 25px;
            border-top: 1px dashed rgba(93, 64, 55, 0.15);
        }

        .btn-premium {
            flex: 1;
            padding: 15px 25px;
            border-radius: 50px;
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 1.1rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-update {
            background: linear-gradient(135deg, #FF7B3D 0%, var(--primary) 100%);
            color: white;
            border: none;
            box-shadow: 0 8px 20px var(--primary-glow);
        }

        .btn-update:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 25px rgba(232, 93, 34, 0.4);
            color: white;
        }

        .btn-cancel {
            background: transparent;
            color: var(--brown-dark);
            border: 2px solid rgba(93, 64, 55, 0.2);
        }

        .btn-cancel:hover {
            background: rgba(93, 64, 55, 0.05);
            border-color: var(--brown-dark);
            color: var(--brown-dark);
        }

        @media (max-width: 991px) {
            .bento-card {
                padding: 25px;
            }

            .visual-frame {
                margin-bottom: 30px;
            }
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-4">

        {{-- Header Halaman --}}
        <div class="text-center mb-5 animate-enter" style="animation-delay: 0.1s;">
            <div class="d-inline-block bg-white p-2 rounded-circle shadow-sm mb-3"
                style="border: 1px solid rgba(0,0,0,0.05);">
                <i class="fas fa-pencil-alt fs-4" style="color: var(--primary);"></i>
            </div>
            <h1 class="page-title font-display">Perbarui Data Menu</h1>
            <p class="page-subtitle">Sesuaikan resep, harga, dan ketersediaan untuk <b>{{ $product->name }}</b>.</p>
        </div>

        {{-- Bento Card Form --}}
        <div class="bento-card animate-enter" style="animation-delay: 0.2s;">
            <div class="bento-content">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row gx-lg-5">
                        {{-- KOLOM KIRI: Visual Area --}}
                        <div class="col-lg-5">
                            <h3 class="section-title"><i class="fas fa-image"></i> Visual Produk</h3>

                            <div class="visual-frame">
                                {{-- Bingkai Pratinjau --}}
                                <div class="current-image-wrapper">
                                    <span class="image-status-badge" id="image-badge">
                                        <i class="fas fa-camera me-1"></i> Foto Saat Ini
                                    </span>

                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            id="main-preview-img">
                                    @else
                                        <div class="d-flex flex-column align-items-center justify-content-center h-100 bg-light text-muted"
                                            id="main-preview-img-placeholder">
                                            <i class="fas fa-cookie-bite" style="font-size: 4rem; opacity: 0.2;"></i>
                                            <span class="mt-2 small">Belum Ada Foto</span>
                                        </div>
                                        {{-- Hidden img tag for new preview --}}
                                        <img src="" alt="Preview Baru" id="main-preview-img" style="display: none;">
                                    @endif
                                </div>

                                {{-- Area Upload Baru --}}
                                <div class="upload-zone-edit @error('image') border-danger @enderror">
                                    <input type="file" id="image" name="image" accept="image/*">
                                    <i class="fas fa-cloud-upload-alt fs-3 mb-2" style="color: var(--brown-light);"></i>
                                    <h6 class="mb-1 fw-bold" style="color: var(--brown-dark);">Ganti Foto Menu</h6>
                                    <p class="small text-muted mb-0">Seret file atau klik area ini.<br>Biarkan kosong jika
                                        tak ingin diganti.</p>
                                </div>

                                @error('image')
                                    <div class="error-message justify-content-center mt-2"><i
                                            class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- KOLOM KANAN: Form Detail --}}
                        <div class="col-lg-7">
                            <h3 class="section-title"><i class="fas fa-list-alt"></i> Detail Data</h3>

                            {{-- Nama Menu --}}
                            <div class="form-group animate-enter" style="animation-delay: 0.3s;">
                                <label for="name" class="form-label">Nama Menu</label>
                                <div class="input-premium-wrapper">
                                    <input type="text" class="input-premium @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    <i class="fas fa-pen input-premium-icon"></i>
                                </div>
                                @error('name')
                                    <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="form-group animate-enter" style="animation-delay: 0.4s;">
                                <label for="description" class="form-label">Deskripsi Singkat</label>
                                <div class="input-premium-wrapper textarea-premium-wrapper">
                                    <textarea class="input-premium @error('description') is-invalid @enderror" id="description" name="description"
                                        rows="3">{{ old('description', $product->description) }}</textarea>
                                    <i class="fas fa-align-left input-premium-icon"></i>
                                </div>
                                @error('description')
                                    <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                {{-- Harga --}}
                                <div class="col-md-6 form-group animate-enter" style="animation-delay: 0.5s;">
                                    <label for="price" class="form-label">Harga Jual (Rp)</label>
                                    <div class="input-premium-wrapper">
                                        <input type="number" class="input-premium @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price', $product->price) }}"
                                            required>
                                        <i class="fas fa-tag input-premium-icon"></i>
                                    </div>
                                    {{-- Rupiah Helper --}}
                                    <div class="rupiah-helper" id="rupiah-helper"></div>
                                    @error('price')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div class="col-md-6 form-group animate-enter" style="animation-delay: 0.6s;">
                                    <label for="stock" class="form-label">
                                        Sisa Stok
                                        <span class="dynamic-stock-badge" id="stock-badge">Memuat...</span>
                                    </label>
                                    <div class="input-premium-wrapper">
                                        <input type="number" class="input-premium @error('stock') is-invalid @enderror"
                                            id="stock" name="stock" value="{{ old('stock', $product->stock) }}"
                                            required>
                                        <i class="fas fa-box input-premium-icon"></i>
                                    </div>
                                    @error('stock')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="btn-wrapper animate-enter" style="animation-delay: 0.7s;">
                                <a href="{{ route('admin.products.index') }}" class="btn-premium btn-cancel">
                                    Batal
                                </a>
                                <button type="submit" class="btn-premium btn-update">
                                    <i class="fas fa-save"></i> Perbarui Menu
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT INTERAKSI FRONTEND --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Logic Pratinjau Gambar & Transisi Memudar Halus
            const imageInput = document.getElementById('image');
            const mainPreviewImg = document.getElementById('main-preview-img');
            const imgPlaceholder = document.getElementById('main-preview-img-placeholder');
            const imageBadge = document.getElementById('image-badge');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            // Efek fade out singkat
                            mainPreviewImg.style.opacity = 0;

                            setTimeout(() => {
                                // Sembunyikan placeholder jika ada
                                if (imgPlaceholder) imgPlaceholder.style.display = 'none';

                                // Ganti source & tampilkan gambar
                                mainPreviewImg.src = e.target.result;
                                mainPreviewImg.style.display = 'block';

                                // Ganti teks badge
                                imageBadge.innerHTML =
                                    '<i class="fas fa-magic me-1"></i> Pratinjau Baru';
                                imageBadge.style.color =
                                    '#10B981'; // Ubah warna badge jadi hijau

                                // Fade in kembali
                                mainPreviewImg.style.opacity = 1;
                            }, 300); // 300ms sejalan dengan transisi CSS
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });

            // 2. Logic Format Rupiah Real-time
            const priceInput = document.getElementById('price');
            const rupiahHelper = document.getElementById('rupiah-helper');

            function renderRupiah() {
                let val = priceInput.value;
                if (val && !isNaN(val)) {
                    let formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(val);

                    rupiahHelper.innerHTML = `<span style="color:var(--primary); font-weight:500;">
                        <i class="fas fa-check-circle me-1"></i> Format: <b>${formatted}</b>
                    </span>`;
                } else {
                    rupiahHelper.innerHTML = 'Masukkan nominal angka saja';
                }
            }

            priceInput.addEventListener('input', renderRupiah);
            renderRupiah(); // Render saat form pertama dimuat

            // 3. Logic Indikator Lencana Stok Cerdas
            const stockInput = document.getElementById('stock');
            const stockBadge = document.getElementById('stock-badge');

            function updateStockBadge() {
                let val = parseInt(stockInput.value);

                // Reset class
                stockBadge.className = 'dynamic-stock-badge';

                if (isNaN(val) || val <= 0) {
                    stockBadge.innerHTML = 'Stok Habis';
                    stockBadge.classList.add('stock-danger');
                } else if (val < 10) {
                    stockBadge.innerHTML = 'Stok Kritis';
                    stockBadge.classList.add('stock-warning');
                } else {
                    stockBadge.innerHTML = 'Stok Aman';
                    stockBadge.classList.add('stock-safe');
                }
            }

            stockInput.addEventListener('input', updateStockBadge);
            updateStockBadge(); // Render status awal saat form dimuat
        });
    </script>
@endsection
