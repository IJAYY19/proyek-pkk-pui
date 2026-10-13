@extends('admin.layouts.app')

@section('title', 'Tambah Menu Baru - Tho Cookies')

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
            --danger: #EF4444;
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

        /* Latar Belakang Kartu (Aksen Abstrak) */
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

        /* --- AREA UPLOAD GAMBAR INTERAKTIF --- */
        .upload-zone {
            border: 2px dashed rgba(93, 64, 55, 0.2);
            border-radius: 24px;
            background: #FAFAFA;
            padding: 40px 20px;
            height: 100%;
            min-height: 380px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .upload-zone:hover {
            border-color: var(--primary);
            background: var(--primary-soft);
        }

        .upload-zone.has-error {
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.05);
        }

        /* Input file disembunyikan menutupi seluruh area */
        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .upload-placeholder {
            text-align: center;
            transition: opacity 0.3s;
        }

        .upload-icon {
            font-size: 3.5rem;
            color: rgba(93, 64, 55, 0.3);
            margin-bottom: 15px;
            transition: transform 0.3s, color 0.3s;
        }

        .upload-zone:hover .upload-icon {
            transform: translateY(-5px);
            color: var(--primary);
        }

        .upload-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.2rem;
            color: var(--brown-dark);
            margin-bottom: 5px;
        }

        .upload-subtitle {
            font-size: 0.85rem;
            color: var(--brown-light);
        }

        /* Live Preview Image */
        .preview-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 22px;
            display: none;
            z-index: 5;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .preview-overlay {
            position: absolute;
            inset: 0;
            background: rgba(58, 42, 34, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            z-index: 6;
            border-radius: 22px;
            transition: opacity 0.3s;
            color: white;
            font-weight: 500;
            pointer-events: none;
        }

        .upload-zone:hover .preview-overlay {
            opacity: 1;
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
            display: block;
        }

        .form-label .required {
            color: var(--danger);
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
            /* Supaya klik tembus ke input */
            z-index: 2;
        }

        .input-premium {
            width: 100%;
            border: 2px solid rgba(93, 64, 55, 0.15);
            border-radius: 16px;
            padding: 14px 18px 14px 48px;
            /* Padding kiri lebih besar untuk ikon */
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            color: var(--brown-dark);
            background-color: #FAFAFA;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Khusus textarea, ikon ditaruh di atas */
        .textarea-premium-wrapper .input-premium-icon {
            top: 16px;
        }

        .input-premium::placeholder {
            color: #BDBDBD;
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
            animation: fadeSlideUp 0.3s ease forwards;
        }

        /* Rupiah Helper text */
        .rupiah-helper {
            font-size: 0.85rem;
            color: var(--brown-light);
            margin-top: 8px;
            display: block;
            min-height: 20px;
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

        .btn-save {
            background: linear-gradient(135deg, #FF7B3D 0%, var(--primary) 100%);
            color: white;
            border: none;
            box-shadow: 0 8px 20px var(--primary-glow);
        }

        .btn-save:hover {
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

        /* Responsive Layout adjustments */
        @media (max-width: 991px) {
            .upload-zone {
                min-height: 250px;
                margin-bottom: 30px;
            }

            .bento-card {
                padding: 25px;
            }
        }

        /* --- KOREKSI LAYOUT KONTEN TERPOTONG (DESKTOP) --- */
        @media (min-width: 992px) {
            .visual-column {
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .upload-zone {
                flex: 1;
                height: auto !important;
            }
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-4">

        {{-- Header Halaman --}}
        <div class="text-center mb-5 animate-enter" style="animation-delay: 0.1s;">
            <h1 class="page-title font-display">Tambah Menu Baru</h1>
            <p class="page-subtitle">Perkaya katalog sajian Tho Cookies dengan menu-menu terbaik.</p>
        </div>

        {{-- Bento Card Form --}}
        <div class="bento-card animate-enter" style="animation-delay: 0.2s;">
            <div class="bento-content">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row gx-lg-5">
                        {{-- KOLOM KIRI: Visual / Upload Area --}}
                        <div class="col-lg-5 mb-4 mb-lg-0 visual-column">
                            <h3 class="section-title"><i class="fas fa-camera-retro"></i> Visual Menu</h3>

                            <div class="upload-zone @error('image') has-error @enderror" id="drop-zone">
                                {{-- Input File (Hidden) --}}
                                <input type="file" id="image" name="image" accept="image/*" class="file-input">

                                {{-- Placeholder saat kosong --}}
                                <div class="upload-placeholder" id="upload-placeholder">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <h4 class="upload-title">Unggah Foto Menu</h4>
                                    <p class="upload-subtitle">Seret & lepas foto ke sini atau <b>Klik untuk
                                            mencari</b>.<br>Format: JPG, PNG, JPEG. (Maks 2MB).</p>
                                </div>

                                {{-- Live Preview Image --}}
                                <img src="" alt="Preview Menu" class="preview-image" id="preview-img">
                                <div class="preview-overlay" id="preview-overlay">
                                    <i class="fas fa-sync-alt me-2"></i> Ganti Foto
                                </div>
                            </div>

                            @error('image')
                                <div class="error-message mt-2 justify-content-center">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- KOLOM KANAN: Detail Form Area --}}
                        <div class="col-lg-7">
                            <h3 class="section-title"><i class="fas fa-cookie-bite"></i> Detail Informasi Menu</h3>

                            {{-- Nama Menu --}}
                            <div class="form-group animate-enter" style="animation-delay: 0.3s;">
                                <label for="name" class="form-label">Nama Menu <span class="required">*</span></label>
                                <div class="input-premium-wrapper">
                                    <input type="text" class="input-premium @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Contoh: Nastar Keju Spesial" required>
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
                                        rows="3" placeholder="Jelaskan rasa, tekstur, dan keunggulannya...">{{ old('description') }}</textarea>
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
                                    <label for="price" class="form-label">Harga Jual (Rp) <span
                                            class="required">*</span></label>
                                    <div class="input-premium-wrapper">
                                        <input type="number" class="input-premium @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price') }}" placeholder="0"
                                            required>
                                        <i class="fas fa-tag input-premium-icon"></i>
                                    </div>
                                    {{-- Rupiah Real-time Helper --}}
                                    <div class="rupiah-helper" id="rupiah-helper">Masukkan nominal angka</div>

                                    @error('price')
                                        <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                {{-- Stok --}}
                                <div class="col-md-6 form-group animate-enter" style="animation-delay: 0.6s;">
                                    <label for="stock" class="form-label">Stok Awal (Porsi) <span
                                            class="required">*</span></label>
                                    <div class="input-premium-wrapper">
                                        <input type="number" class="input-premium @error('stock') is-invalid @enderror"
                                            id="stock" name="stock" value="{{ old('stock') }}" placeholder="0"
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
                                <button type="submit" class="btn-premium btn-save">
                                    <i class="fas fa-check"></i> Simpan Menu
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

            // 1. Logic Live Image Preview & Drag-Drop Effect
            const imageInput = document.getElementById('image');
            const previewImg = document.getElementById('preview-img');
            const uploadPlaceholder = document.getElementById('upload-placeholder');
            const dropZone = document.getElementById('drop-zone');
            const previewOverlay = document.getElementById('preview-overlay');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const file = this.files[0];

                    // Cek jika file adalah gambar
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            previewImg.src = e.target.result;
                            previewImg.style.display = 'block';
                            uploadPlaceholder.style.display = 'none';

                            // Ubah border menjadi solid dan warnanya menyesuaikan primary
                            dropZone.style.borderStyle = 'solid';
                            dropZone.style.borderColor = 'var(--primary)';

                            // Tampilkan overlay "Ganti Foto" untuk indikasi
                            previewOverlay.style.display = 'flex';
                        }
                        reader.readAsDataURL(file);
                    }
                }
            });

            // 2. Logic Format Rupiah Real-time
            const priceInput = document.getElementById('price');
            const rupiahHelper = document.getElementById('rupiah-helper');

            function formatRupiahRealTime() {
                let val = priceInput.value;
                if (val && !isNaN(val)) {
                    // Format menggunakan fitur bawaan JavaScript Intl.NumberFormat
                    let formatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(val);

                    rupiahHelper.innerHTML = `<span style="color:var(--primary); font-weight:500;">
                        <i class="fas fa-check-circle me-1"></i> Format Harga: <b>${formatted}</b>
                    </span>`;
                } else {
                    rupiahHelper.innerHTML = 'Masukkan nominal angka';
                }
            }

            // Panggil saat diketik
            priceInput.addEventListener('input', formatRupiahRealTime);

            // Panggil saat halaman dimuat (untuk me-render old('price') jika form gagal divalidasi)
            if (priceInput.value) {
                formatRupiahRealTime();
            }
        });
    </script>
@endsection
