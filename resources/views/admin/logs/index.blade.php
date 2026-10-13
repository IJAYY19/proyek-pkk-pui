@extends('admin.layouts.app')

@section('title', 'Activity Log')

@section('content')
    {{-- Import Font & Animate.css --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --primary: #F26522;
            --brown: #5D4037;
            --cream: #FFF8E1;
            --white: #FFFFFF;

            /* Warna Pendar Node & Badge */
            --node-success: #10B981;
            /* Emerald Green */
            --node-warning: #F26522;
            /* Tho Cookies Orange */
            --node-info: #2563EB;
            /* Premium Blue */
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
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* --- ANIMASI & MIKRO INTERAKSI --- */
        .animate-up {
            opacity: 0;
            animation: slideInUpSoft 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes slideInUpSoft {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Denyut (Pulse) Pendar Ikon Timeline */
        @keyframes pulse-success {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.6);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        @keyframes pulse-warning {
            0% {
                box-shadow: 0 0 0 0 rgba(242, 101, 34, 0.6);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(242, 101, 34, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(242, 101, 34, 0);
            }
        }

        @keyframes pulse-info {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.6);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(37, 99, 235, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
        }

        /* --- SEARCH BAR KAPSUL --- */
        .search-capsule {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(93, 64, 55, 0.1);
            border-radius: 50px;
            padding: 8px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 15px rgba(93, 64, 55, 0.03);
            transition: all 0.3s ease;
        }

        .search-capsule:focus-within {
            border-color: var(--primary);
            box-shadow: 0 4px 20px rgba(242, 101, 34, 0.15);
            background: #fff;
        }

        .search-capsule i {
            color: #888;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .search-capsule:focus-within i {
            color: var(--primary);
        }

        .search-capsule input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            color: var(--brown);
        }

        /* --- VERTICAL TIMELINE UI --- */
        .timeline-container {
            position: relative;
            padding-left: 2.5rem;
            /* Ruang untuk garis dan ikon */
            margin-top: 2rem;
        }

        /* Garis Vertikal Putus-putus */
        .timeline-container::before {
            content: '';
            position: absolute;
            left: 0.75rem;
            top: 0;
            bottom: 0;
            width: 0;
            border-left: 2px dashed #cbd5e1;
            z-index: 0;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            z-index: 1;
        }

        /* Simpul (Node) Melingkar */
        .timeline-node {
            position: absolute;
            left: -2.35rem;
            /* Memposisikan pas di tengah garis */
            top: 1.5rem;
            width: 1.2rem;
            height: 1.2rem;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 2;
        }

        .node-success {
            background-color: var(--node-success);
        }

        .node-warning {
            background-color: var(--node-warning);
        }

        .node-info {
            background-color: var(--node-info);
        }

        /* --- KARTU GLASSMORPHISM --- */
        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 20px 25px;
            box-shadow: 0 4px 20px rgba(93, 64, 55, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Hover Interaktif pada Timeline Item */
        .timeline-item:hover .glass-card {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 15px 35px rgba(93, 64, 55, 0.08);
            border-color: rgba(242, 101, 34, 0.2);
        }

        .timeline-item:hover .node-success {
            animation: pulse-success 1.5s infinite;
            transform: scale(1.2);
        }

        .timeline-item:hover .node-warning {
            animation: pulse-warning 1.5s infinite;
            transform: scale(1.2);
        }

        .timeline-item:hover .node-info {
            animation: pulse-info 1.5s infinite;
            transform: scale(1.2);
        }

        /* --- LENCANA PERAN (Translucent Glass Pills) --- */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid transparent;
        }

        .badge-admin {
            background: rgba(37, 99, 235, 0.1);
            color: var(--node-info);
            border-color: rgba(37, 99, 235, 0.15);
        }

        .badge-kasir {
            background: rgba(242, 101, 34, 0.1);
            color: var(--node-warning);
            border-color: rgba(242, 101, 34, 0.15);
        }

        .badge-guest {
            background: rgba(16, 185, 129, 0.1);
            color: var(--node-success);
            border-color: rgba(16, 185, 129, 0.15);
        }

        /* Detail Teks Log */
        .log-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px dashed rgba(93, 64, 55, 0.15);
            padding-bottom: 12px;
            margin-bottom: 5px;
        }

        .log-time {
            font-family: 'Fredoka', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            color: #888;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .log-user-name {
            font-weight: 600;
            color: var(--brown);
            margin-left: 5px;
        }

        .log-action {
            font-size: 1.05rem;
            line-height: 1.6;
            color: var(--brown);
        }

        /* --- PAGINATION (Tho Cookies Theme - Premium High-Contrast Upgrade) --- */
        .pagination {
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 3rem;
            justify-content: center;
        }

        .page-link {
            border-radius: 50px !important;
            border: 2px solid var(--brown) !important;
            /* Garis tepi cokelat tegas */
            color: var(--brown) !important;
            /* Angka warna cokelat pekat */
            font-weight: 600 !important;
            padding: 10px 20px !important;
            background: var(--white) !important;
            /* Latar belakang putih solid (tidak transparan) */
            box-shadow: 3px 3px 0px var(--brown) !important;
            /* Efek bayangan pop-art */
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
            text-decoration: none !important;
        }

        .page-link:hover {
            background: var(--cream) !important;
            color: var(--primary) !important;
            transform: translateY(-2px) !important;
            box-shadow: 5px 5px 0px var(--brown) !important;
        }

        /* Tombol Halaman Aktif (Active Page) */
        .page-item.active .page-link,
        .active>.page-link {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
            color: var(--color-black) !important;
            /* Angka putih murni kontras tinggi */
            border-color: var(--brown) !important;
            box-shadow: 4px 4px 0px var(--brown) !important;
            /* Bayangan cokelat tetap konsisten */
            font-weight: 700 !important;
            transform: translateY(-2px) !important;
        }

        /* Tombol Halaman Nonaktif (Disabled) */
        .page-item.disabled .page-link {
            background: #F3F4F6 !important;
            color: #9CA3AF !important;
            border-color: #D1D5DB !important;
            box-shadow: none !important;
            cursor: not-allowed !important;
            transform: none !important;
        }
    </style>

    <div class="container-fluid px-0 pb-5">

        {{-- Header & Search --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4 mb-2 pt-3 animate-up">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-circle p-3 shadow-sm border border-light">
                    <i class="fas fa-stream text-primary fs-4"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0 font-display" style="color: var(--brown);">Jejak Aktivitas</h2>
                    <p class="text-muted small mb-0 d-flex align-items-center gap-2">
                        <span
                            style="width: 8px; height: 8px; background: var(--node-success); border-radius: 50%; display: inline-block; animation: pulse-success 2s infinite;"></span>
                        Sistem mencatat secara real-time
                    </p>
                </div>
            </div>

            {{-- Kolom Pencarian Cepat --}}
            <div class="search-capsule">
                <i class="fas fa-search"></i>
                <input type="text" id="instantSearch" placeholder="Cari nama, aktivitas, atau peran...">
            </div>
        </div>

        {{-- VERTICAL TIMELINE UI --}}
        <div class="timeline-container" id="timelineContainer">
            @forelse($logs as $index => $log)
                @php
                    // Logika Klasifikasi Pendar Node (Node Glow)
                    $nodeClass = 'node-info'; // Default: Biru
                    $textActivity = strtolower($log->activity);

                    if (Str::contains($textActivity, ['menambahkan', 'create', 'membuat', 'tambah', 'baru'])) {
                        $nodeClass = 'node-success'; // Hijau Emerald
                    } elseif (Str::contains($textActivity, ['memperbarui', 'update', 'edit', 'ubah'])) {
                        $nodeClass = 'node-warning'; // Oranye
                    } elseif (Str::contains($textActivity, ['transaksi', 'pesanan', 'pembayaran', 'selesai'])) {
                        $nodeClass = 'node-info'; // Biru Premium
                    } elseif (Str::contains($textActivity, ['menghapus', 'delete', 'hapus'])) {
                        // Menghapus tetap pakai oranye kemerahan agar sejalan dengan aksen sistem
                        $nodeClass = 'node-warning';
                    }
                @endphp

                <div class="timeline-item animate-up searchable-item" style="animation-delay: {{ $loop->index * 0.08 }}s;">
                    {{-- Simpul Lini Masa --}}
                    <div class="timeline-node {{ $nodeClass }}"></div>

                    {{-- Kartu Glassmorphism --}}
                    <div class="glass-card">
                        <div class="log-meta">
                            {{-- Lencana Peran (Translucent Glass Pill) & Nama --}}
                            <div>
                                @if ($log->user)
                                    @if ($log->user->role->name == 'admin')
                                        <span class="role-badge badge-admin"><i class="fas fa-user-shield"></i> Admin</span>
                                    @else
                                        <span class="role-badge badge-kasir"><i class="fas fa-cash-register"></i>
                                            Kasir</span>
                                    @endif
                                    <span class="log-user-name">{{ $log->user->name }}</span>
                                @else
                                    <span class="role-badge badge-guest"><i class="fas fa-user-secret"></i> Guest</span>
                                    <span class="log-user-name text-muted fst-italic">Sistem / Pelanggan</span>
                                @endif
                            </div>

                            {{-- Waktu --}}
                            <div class="log-time">
                                <i class="far fa-clock"></i>
                                <span>{{ $log->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        {{-- Isi Aktivitas --}}
                        <div class="log-action">
                            {{ $log->activity }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 animate-up" style="margin-left: -2.5rem;">
                    <div style="font-size: 4rem; opacity: 0.15; color: var(--brown); margin-bottom: 15px;">
                        <i class="fas fa-history"></i>
                    </div>
                    <h5 class="fw-bold text-muted font-display">Garis Waktu Kosong</h5>
                    <p class="text-muted small">Belum ada jejak aktivitas yang terekam di sistem.</p>
                </div>
            @endforelse
        </div>

        {{-- Navigasi Halaman (Pagination) --}}
        <div class="d-flex justify-content-center animate-up" style="animation-delay: 0.8s;">
            {{ $logs->links() }}
        </div>

    </div>

    {{-- SCRIPT PENCARIAN INSTAN (Real-time Client Side) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('instantSearch');
            const timelineItems = document.querySelectorAll('.searchable-item');

            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase().trim();

                timelineItems.forEach(function(item) {
                    // Mengambil seluruh teks di dalam kartu (nama, peran, waktu, aktivitas)
                    const textContent = item.textContent || item.innerText;

                    if (textContent.toLowerCase().includes(filter)) {
                        // Tampilkan dengan gaya aslinya jika cocok
                        item.style.display = "";
                        // Tambahkan sedikit animasi saat muncul kembali
                        item.style.animation = "none";
                        item.offsetHeight; /* trigger reflow */
                        item.style.animation = null;
                    } else {
                        // Sembunyikan jika tidak cocok
                        item.style.display = "none";
                    }
                });
            });
        });
    </script>
@endsection
