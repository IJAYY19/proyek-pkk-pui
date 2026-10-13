@extends('admin.layouts.app')

@section('title', 'Manajemen Produk - Tho Cookies')

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
            /* Oranye menyala elegan */
            --primary-glow: rgba(232, 93, 34, 0.4);
            --brown-dark: #3A2A22;
            /* Cokelat pekat untuk teks utama */
            --brown-light: #7A6253;
            /* Cokelat pudar untuk teks sekunder */
            --cream-bg: #FDFBF7;
            /* Krem sangat lembut untuk background */
            --white-glass: rgba(255, 255, 255, 0.85);

            /* Status Colors */
            --success: #10B981;
            --success-bg: rgba(16, 185, 129, 0.1);
            --danger: #EF4444;
            --danger-bg: rgba(239, 68, 68, 0.1);
            --warning: #F59E0B;
            --warning-bg: rgba(245, 158, 11, 0.1);
            --neutral: #9CA3AF;
            --neutral-bg: rgba(156, 163, 175, 0.15);
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
                transform: translateY(15px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseCritical {
            0% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4);
            }

            70% {
                box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }

        .animate-enter {
            opacity: 0;
            animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* --- HEADER & TOOLBAR --- */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--brown-dark);
            letter-spacing: -0.5px;
        }

        .page-title span {
            color: var(--primary);
        }

        .badge-total {
            background: var(--primary-glow);
            color: var(--primary);
            font-size: 1rem;
            padding: 4px 12px;
            border-radius: 20px;
            vertical-align: middle;
            margin-left: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
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
            max-width: 350px;
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

        .search-capsule input::placeholder {
            color: #A89F9A;
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

        /* --- CARD & TABLE KELAS DUNIA --- */
        .glass-card {
            background: var(--white-glass);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 28px;
            padding: 10px;
            box-shadow: 0 15px 35px rgba(58, 42, 34, 0.04);
            overflow: hidden;
        }

        .table-premium {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .table-premium th {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            color: var(--brown-light);
            font-weight: 500;
            padding: 20px 24px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.04);
            text-transform: capitalize;
        }

        .table-premium td {
            padding: 18px 24px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.02);
            transition: background 0.3s ease;
        }

        .table-premium tbody tr {
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .table-premium tbody tr:hover td {
            background: rgba(255, 255, 255, 0.9);
        }

        .table-premium tbody tr:last-child td {
            border-bottom: none;
        }

        /* Gambar Produk */
        .img-squircle {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background-color: #f8f9fa;
        }

        .table-premium tbody tr:hover .img-squircle {
            transform: scale(1.15) rotate(4deg);
        }

        .img-placeholder {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            background: #f1f1f1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ccc;
            font-size: 1.5rem;
            border: 3px solid white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        /* Tipografi Tabel */
        .product-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.15rem;
            font-weight: 500;
            color: var(--brown-dark);
            margin-bottom: 2px;
            display: block;
        }

        .product-desc {
            font-size: 0.85rem;
            color: var(--brown-light);
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price-badge {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--brown-dark);
        }

        /* Status Stok */
        .stock-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .stock-safe {
            background: var(--success-bg);
            color: var(--success);
        }

        .stock-critical {
            background: var(--danger-bg);
            color: var(--danger);
            animation: pulseCritical 2s infinite;
        }

        .stock-empty {
            background: var(--neutral-bg);
            color: var(--neutral);
        }

        /* Tombol Aksi Minimalis */
        .action-flex {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }

        .btn-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-edit {
            background: var(--warning-bg);
            color: var(--warning);
        }

        .btn-edit:hover {
            background: var(--warning);
            color: white;
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-delete {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .btn-delete:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.2;
            margin-bottom: 15px;
        }

        /* Custom Pagination (Opsional menyesuaikan style Tailwind/Bootstrap bawaan) */
        .pagination {
            margin-bottom: 0;
        }

        .page-link {
            color: var(--brown-dark);
            border-radius: 8px;
            margin: 0 3px;
            border: none;
            background: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.02);
        }

        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 4px 10px var(--primary-glow);
        }
    </style>

    <div class="container-fluid px-2 px-md-4 py-4">

        {{-- Header & Toolbar --}}
        <div class="page-header d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-4 animate-enter"
            style="animation-delay: 0.1s;">
            <div>
                <h1 class="page-title mb-1">
                    Kelola <span>Menu Tho Cookies</span>
                    {{-- Asumsi $products menggunakan paginate(), kita ambil total() --}}
                    @if (method_exists($products, 'total'))
                        <span class="badge-total">{{ $products->total() }}</span>
                    @else
                        <span class="badge-total">{{ count($products) }}</span>
                    @endif
                </h1>
                <p class="text-muted mb-0" style="color: var(--brown-light) !important;">Katalog sajian premium, kelola harga
                    dan ketersediaan stok.</p>
            </div>

            <div class="d-flex flex-column flex-sm-row gap-3 align-items-sm-center">
                {{-- Live Search Bar --}}
                <div class="search-capsule">
                    <input type="text" id="searchInput" placeholder="Ketik nama menu...">
                    <i class="fas fa-search"></i>
                </div>

                {{-- Add Button --}}
                <a href="{{ route('admin.products.create') }}" class="btn-premium-add">
                    <i class="fas fa-plus"></i> Tambah Menu
                </a>
            </div>
        </div>

        {{-- Notifikasi Sukses via SweetAlert (Lebih elegan dari alert biasa) --}}
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

        {{-- Tabel Data --}}
        <div class="glass-card animate-enter" style="animation-delay: 0.2s;">
            <div class="table-responsive">
                <table class="table-premium" id="productTable">
                    <thead>
                        <tr>
                            <th style="width: 80px; text-align: center;">Katalog</th>
                            <th>Detail Menu</th>
                            <th>Harga</th>
                            <th>Status Stok</th>
                            <th style="width: 120px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $index => $product)
                            <tr class="animate-enter" style="animation-delay: {{ 0.3 + $index * 0.05 }}s;">
                                {{-- Kolom Gambar --}}
                                <td style="text-align: center;">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                            class="img-squircle">
                                    @else
                                        <div class="img-placeholder">
                                            <i class="fas fa-cookie-bite"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Kolom Nama & Deskripsi --}}
                                <td class="product-info-cell">
                                    <span class="product-title">{{ $product->name }}</span>
                                    @if ($product->description)
                                        <div class="product-desc" title="{{ $product->description }}">
                                            {{ $product->description }}
                                        </div>
                                    @else
                                        <div class="product-desc fst-italic opacity-50">Tanpa deskripsi</div>
                                    @endif
                                </td>

                                {{-- Kolom Harga --}}
                                <td>
                                    <span class="price-badge">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>

                                {{-- Kolom Stok (Smart Badge) --}}
                                <td>
                                    @if ($product->stock <= 0)
                                        <span class="stock-pill stock-empty">
                                            <i class="fas fa-times-circle"></i> Habis
                                        </span>
                                    @elseif ($product->stock < 10)
                                        <span class="stock-pill stock-critical">
                                            <i class="fas fa-exclamation-triangle"></i> Sisa {{ $product->stock }}
                                        </span>
                                    @else
                                        <span class="stock-pill stock-safe">
                                            <i class="fas fa-check-circle"></i> {{ $product->stock }} Porsi
                                        </span>
                                    @endif
                                </td>

                                {{-- Kolom Aksi --}}
                                <td>
                                    <div class="action-flex">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn-icon btn-edit" title="Edit Menu">
                                            <i class="fas fa-pen"></i>
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                            class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-icon btn-delete trigger-delete"
                                                title="Hapus Menu" data-name="{{ $product->name }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="animate-enter" style="animation-delay: 0.3s;">
                                <td colspan="5">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <h4 style="font-family: 'Fredoka', sans-serif; color: var(--brown-dark);">Belum Ada
                                            Menu</h4>
                                        <p style="color: var(--brown-light);">Katalog produk Anda masih kosong. Mulai
                                            tambahkan sajian terbaik Tho Cookies!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if (method_exists($products, 'links'))
            <div class="mt-4 d-flex justify-content-center animate-enter" style="animation-delay: 0.8s;">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    {{-- SCRIPT INTERAKSI --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Live Search Filter Super Cepat
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#productTable tbody tr');

            searchInput.addEventListener('input', function() {
                const searchText = this.value.toLowerCase().trim();

                tableRows.forEach(row => {
                    // Hindari filter baris "Empty State" jika ada
                    if (row.querySelector('.empty-state')) return;

                    const titleElement = row.querySelector('.product-title');
                    if (titleElement) {
                        const productName = titleElement.textContent.toLowerCase();
                        if (productName.includes(searchText)) {
                            row.style.display = '';
                            row.style.opacity = '1';
                        } else {
                            row.style.display = 'none';
                            row.style.opacity = '0';
                        }
                    }
                });
            });

            // 2. SweetAlert2 Konfirmasi Hapus Dinamis
            const deleteButtons = document.querySelectorAll('.trigger-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // Hentikan form disubmit langsung

                    const form = this.closest('.form-delete');
                    const productName = this.getAttribute('data-name');

                    Swal.fire({
                        title: 'Hapus Menu?',
                        html: `Anda yakin ingin menghapus <b>${productName}</b> dari katalog? Data tidak dapat dikembalikan.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#EF4444',
                        cancelButtonColor: '#9CA3AF',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        customClass: {
                            confirmButton: 'btn-premium-add',
                            cancelButton: 'btn-premium-add bg-secondary',
                            popup: 'glass-card'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Tampilkan loading sebelum form tersubmit
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
