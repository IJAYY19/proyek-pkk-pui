<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja — Tho Cookies</title>
    <meta name="description" content="Periksa dan selesaikan pesanan Anda di Tho Cookies.">

    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            /* Palette Tho Cookies Premium */
            --primary: #F26522;
            --primary-dark: #D84315;
            --primary-light: #FFEDE4;
            --amber: #FFB300;
            --brown: #5D4037;
            --cream: #FFF8E1;
            --cream-dark: #FFECB3;

            /* Glassmorphism & Shadows */
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 20px 40px rgba(93, 64, 55, 0.06);
            --receipt-shadow: 0 10px 30px rgba(242, 101, 34, 0.08);

            /* Grays */
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
        }

        * {
            box-sizing: border-box;
            scrollbar-width: none;
        }

        *::-webkit-scrollbar {
            display: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream);
            color: var(--brown);
            margin: 0;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(242, 101, 34, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(255, 179, 0, 0.05) 0%, transparent 40%);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .font-display {
            font-family: 'Fredoka', sans-serif;
        }

        /* ─── SINGLE FRAME APP LAYOUT (DESKTOP >= 992px) ─── */
        @media (min-width: 992px) {
            body {
                height: 100vh;
                overflow: hidden;
                display: flex;
                flex-direction: column;
            }

            .app-container {
                flex: 1;
                display: flex;
                flex-direction: column;
                max-width: 1400px;
                margin: 0 auto;
                width: 100%;
                padding: 1.25rem 2rem 1.5rem;
                overflow: hidden;
            }

            .app-header-area {
                flex-shrink: 0;
            }

            .app-content-row {
                flex: 1;
                display: flex;
                margin-top: 12px;
                gap: 28px;
                overflow: hidden;
            }

            .left-column,
            .right-column {
                height: 100%;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }

            .left-column {
                flex: 7;
                min-width: 0;
            }

            .right-column {
                flex: 5;
                min-width: 0;
            }
        }

        /* ─── MOBILE SCROLL LAYOUT (< 992px) ─── */
        @media (max-width: 991.98px) {
            body {
                height: auto;
                overflow-x: hidden;
            }

            .app-container {
                padding: 1.25rem 1rem 120px;
            }

            .app-content-row {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .left-column,
            .right-column {
                height: auto;
                overflow: visible;
            }

            .receipt-footer.pinned-bottom {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                border-radius: 24px 24px 0 0;
                box-shadow: 0 -10px 40px rgba(93, 64, 55, 0.15);
                z-index: 100;
                background: rgba(255, 255, 255, 0.97);
                backdrop-filter: blur(15px);
                border-top: none;
            }
        }

        /* ─── HEADER & STEPS ─── */
        .steps-wrapper {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 6px 14px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(93, 64, 55, 0.04);
            border: 1px solid var(--glass-border);
            margin-bottom: 0.75rem;
            gap: 10px;
        }

        .step-pill {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-400);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .step-pill.active {
            color: var(--primary);
            background: var(--primary-light);
            padding: 5px 12px;
            border-radius: 50px;
        }

        .step-arrow {
            font-size: 0.55rem;
            color: var(--gray-300);
        }

        /* ─── KOLOM KIRI (KERANJANG & TABS) ─── */
        .left-panel {
            background: transparent;
            display: flex;
            flex-direction: column;
            flex: 1;
            overflow: hidden;
        }

        .tab-floating-wrapper {
            display: flex;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            padding: 5px;
            border-radius: 100px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--glass-shadow);
            width: fit-content;
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .tab-btn {
            background: transparent;
            border: none;
            padding: 10px 20px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-500);
            cursor: pointer;
            transition: 0.4s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn:hover {
            color: var(--brown);
        }

        .tab-btn.active {
            background: white;
            color: var(--primary);
            box-shadow: 0 8px 25px rgba(242, 101, 34, 0.15);
        }

        .tab-badge {
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 50px;
        }

        .tab-badge.secondary {
            background: var(--gray-200);
            color: var(--gray-600);
        }

        /* Scrollable Area for Items */
        .items-scroll-area {
            flex: 1;
            overflow-y: auto;
            padding-right: 8px;
            padding-bottom: 16px;
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        /* ─── Cart Item Card ─── */
        .cart-item-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 14px rgba(93, 64, 55, 0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .cart-item-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(242, 101, 34, 0.09);
            background: white;
        }

        .item-img-box {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            overflow: hidden;
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: inset 0 0 8px rgba(0, 0, 0, 0.04);
        }

        .item-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.4s ease;
        }

        .cart-item-card:hover .item-img-box img {
            transform: scale(1.06);
        }

        .item-img-box i {
            font-size: 2rem;
            color: var(--amber);
        }

        .item-details {
            flex: 1;
            min-width: 0;
        }

        .item-title {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            font-size: 1.05rem;
            color: var(--brown);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .item-price-unit {
            font-size: 0.82rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .item-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .qty-control {
            width: 56px;
            background: var(--gray-100);
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 8px;
            text-align: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--brown);
            transition: 0.3s;
        }

        .qty-control:focus {
            background: white;
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .item-subtotal {
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
            min-width: 90px;
            text-align: right;
        }

        .btn-delete {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: #FFF0F0;
            color: #EF4444;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s ease;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .btn-delete:hover {
            background: #EF4444;
            color: white;
            transform: scale(1.1);
            box-shadow: 0 6px 14px rgba(239, 68, 68, 0.25);
        }

        /* ─── KOLOM KANAN (STRUK CHECKOUT) ─── */
        .receipt-container {
            background: var(--glass-bg);
            backdrop-filter: blur(25px);
            border-radius: 28px;
            border: 1px solid var(--glass-border);
            box-shadow: var(--receipt-shadow), inset 0 0 0 1px rgba(255, 255, 255, 0.8);
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow: hidden;
            position: relative;
        }

        /* Receipt Header Accent */
        .receipt-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--amber), var(--primary));
            z-index: 10;
        }

        /* Form area (Scrollable) */
        .receipt-body {
            flex: 1;
            overflow-y: auto;
            padding: 28px 22px 16px;
        }

        .receipt-section-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.1rem;
            color: var(--brown);
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .receipt-section-title i {
            color: var(--primary);
            background: var(--primary-light);
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 0.95rem;
        }

        /* Input Premium */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-500);
            margin-bottom: 6px;
            display: block;
        }

        .premium-input-box {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid var(--gray-200);
            border-radius: 14px;
            transition: 0.3s ease;
            overflow: hidden;
        }

        .premium-input-box:focus-within {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .premium-input-box i {
            padding: 0 14px;
            color: var(--gray-400);
            font-size: 1rem;
        }

        .premium-input-box:focus-within i {
            color: var(--primary);
        }

        .premium-input-box input {
            flex: 1;
            padding: 12px 14px 12px 0;
            border: none;
            background: transparent;
            font-weight: 500;
            color: var(--brown);
            outline: none;
            font-size: 0.9rem;
        }

        .premium-input-box input::placeholder {
            color: var(--gray-400);
        }

        /* Order Type Radio */
        .radio-pills {
            display: flex;
            gap: 10px;
        }

        .radio-label {
            flex: 1;
            text-align: center;
            padding: 12px 8px;
            border: 2px solid var(--gray-200);
            border-radius: 14px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.88rem;
            color: var(--gray-500);
            transition: 0.3s;
            background: rgba(255, 255, 255, 0.8);
        }

        input[type="radio"]:checked+.radio-label {
            background: white;
            border-color: var(--primary);
            color: var(--primary);
            box-shadow: 0 6px 18px rgba(242, 101, 34, 0.12);
        }

        /* Voucher Box */
        .voucher-box {
            background: white;
            border: 2px dashed var(--gray-300);
            border-radius: 16px;
            padding: 14px;
            margin-bottom: 0;
            transition: 0.3s;
        }

        .voucher-box:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(242, 101, 34, 0.05);
        }

        .btn-voucher-trigger {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: transparent;
            border: none;
            color: var(--brown);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            padding: 0;
            margin-bottom: 10px;
        }

        .input-voucher-wrapper {
            display: flex;
            gap: 8px;
        }

        .input-voucher {
            flex: 1;
            padding: 10px 14px;
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            outline: none;
            font-weight: 500;
            transition: 0.3s;
            font-size: 0.88rem;
        }

        .input-voucher:focus {
            border-color: var(--primary);
        }

        .btn-claim {
            padding: 0 20px;
            background: var(--brown);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-size: 0.88rem;
        }

        .btn-claim:hover {
            background: var(--primary);
        }

        .discount-success {
            background: #ECFDF5;
            border: 1px solid #6EE7B7;
            border-radius: 12px;
            padding: 10px 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .discount-success .code {
            font-weight: 700;
            color: #047857;
        }

        .discount-success .badge-pct {
            background: #10B981;
            color: white;
            padding: 3px 7px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            margin-left: 6px;
        }

        .btn-remove-disc {
            background: white;
            border: none;
            color: #EF4444;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            font-size: 0.75rem;
        }

        /* Separator / Dashed Line */
        .receipt-divider {
            border: none;
            border-top: 2px dashed var(--gray-300);
            margin: 18px 0;
            position: relative;
        }

        .receipt-divider::before,
        .receipt-divider::after {
            content: '';
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background: var(--cream);
            border-radius: 50%;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.05);
        }

        .receipt-divider::before {
            left: -32px;
        }

        .receipt-divider::after {
            right: -32px;
        }

        /* Pinned Bottom Area */
        .receipt-footer {
            flex-shrink: 0;
            background: white;
            padding: 16px 22px 20px;
            border-top: 2px dashed var(--gray-300);
            box-shadow: 0 -8px 16px rgba(0, 0, 0, 0.02);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.88rem;
            color: var(--gray-500);
            margin-bottom: 6px;
            font-weight: 500;
        }

        .summary-row .val {
            color: var(--brown);
            font-weight: 600;
        }

        .summary-row.disc {
            color: #059669;
        }

        .summary-row.disc .val {
            color: #059669;
        }

        .total-box {
            background: var(--primary-light);
            border: 2px dashed rgba(242, 101, 34, 0.3);
            border-radius: 16px;
            padding: 12px 16px;
            text-align: center;
            margin: 12px 0;
        }

        .total-box .lbl {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--primary-dark);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .total-box .amt {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }

        .btn-checkout-massive {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--amber), var(--primary));
            color: white;
            border: none;
            border-radius: 50px;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.05rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 8px 22px rgba(242, 101, 34, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-checkout-massive:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(242, 101, 34, 0.4);
        }

        /* ─── MODAL, LOADING & EMPTY STATE ─── */
        .empty-cart-state {
            text-align: center;
            padding: 50px 20px;
        }

        .empty-cart-state img {
            width: 130px;
            margin-bottom: 16px;
            animation: float 4s ease-in-out infinite;
            filter: drop-shadow(0 12px 20px rgba(93, 64, 55, 0.1));
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        .modal-content {
            border-radius: 24px;
            border: none;
            box-shadow: 0 30px 60px rgba(93, 64, 55, 0.15);
        }

        .modal-header {
            border-bottom: 1px solid var(--gray-200);
            padding: 20px 24px;
        }

        #loading-overlay {
            position: fixed;
            inset: 0;
            background: rgba(255, 248, 225, 0.85);
            backdrop-filter: blur(12px);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        /* ─── MOBILE RESPONSIVE ─── */
        @media (max-width: 576px) {
            .steps-wrapper {
                padding: 5px 10px;
                gap: 6px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .step-pill {
                font-size: 0.72rem;
            }

            .cart-item-card {
                padding: 12px;
                gap: 10px;
                position: relative;
            }

            .item-img-box {
                width: 60px;
                height: 60px;
                border-radius: 14px;
            }

            .item-title {
                font-size: 0.92rem;
            }

            .item-price-unit {
                font-size: 0.78rem;
            }

            .item-actions {
                gap: 8px;
            }

            .item-subtotal {
                font-size: 0.95rem;
                min-width: 70px;
            }

            .qty-control {
                width: 48px;
                padding: 6px;
                font-size: 0.85rem;
            }

            .btn-delete {
                width: 36px;
                height: 36px;
                border-radius: 10px;
            }

            .tab-floating-wrapper {
                width: 100%;
                overflow-x: auto;
            }

            .tab-btn {
                flex: 1;
                justify-content: center;
                white-space: nowrap;
                padding: 10px 14px;
                font-size: 0.82rem;
            }

            .receipt-body {
                padding: 22px 16px 12px;
            }

            .receipt-footer {
                padding: 14px 16px 18px;
            }

            .total-box .amt {
                font-size: 1.5rem;
            }

            .btn-checkout-massive {
                padding: 13px;
                font-size: 0.95rem;
            }
        }

        /* Very small item row at 400-576px: keep horizontal but compact */
        @media (min-width: 401px) and (max-width: 576px) {
            .cart-item-card {
                flex-direction: row;
                align-items: center;
            }
        }

        /* Very small screens: stack card vertically */
        @media (max-width: 400px) {
            .cart-item-card {
                flex-direction: column;
                align-items: stretch;
            }

            .item-img-box {
                width: 100%;
                height: 120px;
                border-radius: 14px;
            }

            .item-actions {
                justify-content: space-between;
                border-top: 1px dashed var(--gray-200);
                padding-top: 10px;
            }

            .btn-delete {
                position: absolute;
                top: 16px;
                right: 16px;
                background: white;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>

<body>

    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <i class="fas fa-cookie-bite"
            style="font-size:5rem;color:var(--primary);animation:spin 1.5s linear infinite; filter: drop-shadow(0 10px 20px rgba(242,101,34,0.3));"></i>
        <h3 class="mt-4 font-display" style="color:var(--brown);">Memproses...</h3>
    </div>

    <div class="app-container">

        <!-- Header Area -->
        <div class="app-header-area animate__animated animate__fadeInDown">
            <!-- Steps Indicator -->
            <div class="steps-wrapper">
                <div class="step-pill active"><i class="fas fa-shopping-basket"></i> 1. Keranjang</div>
                <i class="fas fa-chevron-right step-arrow"></i>
                <div class="step-pill"><i class="fas fa-file-invoice"></i> 2. Verifikasi Kasir</div>
                <i class="fas fa-chevron-right step-arrow"></i>
                <div class="step-pill"><i class="fas fa-check-circle"></i> 3. Selesai</div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-1">
                <h2 class="m-0 font-display fw-bold" style="font-size:2rem; color:var(--brown);">
                    Pesanan <span style="color:var(--primary);">Kamu</span>
                </h2>
                <a href="{{ route('landing') }}"
                    class="btn btn-dark rounded-pill px-4 py-2 fw-bold d-none d-sm-inline-flex align-items-center gap-2"
                    style="background:var(--brown); border:none; box-shadow:0 8px 20px rgba(93,64,55,0.15);">
                    <i class="fas fa-plus"></i> Tambah Menu
                </a>
                <a href="{{ route('landing') }}" class="btn btn-dark rounded-circle d-sm-none"
                    style="width:42px;height:42px;display:flex;align-items:center;justify-content:center;background:var(--brown); border:none;">
                    <i class="fas fa-plus"></i>
                </a>
            </div>

            <!-- Notifications -->
            @if (session('success'))
                <div class="alert border-0 shadow-sm rounded-4 fw-bold mt-2 mb-0 d-flex align-items-center gap-2 animate__animated animate__fadeIn"
                    style="background:#ECFDF5;color:#065F46; border:1px solid #A7F3D0 !important; padding:10px 16px; font-size:0.9rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert border-0 shadow-sm rounded-4 fw-bold mt-2 mb-0 d-flex align-items-center gap-2 animate__animated animate__shakeX"
                    style="background:#FEF2F2;color:#991B1B; border:1px solid #FECACA !important; padding:10px 16px; font-size:0.9rem;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="app-content-row">

            <!-- ════ KOLOM KIRI: DAFTAR PRODUK & TABS ════ -->
            <div class="left-column">
                <div class="left-panel animate__animated animate__fadeInUp">

                    <!-- Floating Tabs -->
                    <div class="tab-floating-wrapper">
                        <button class="tab-btn active" id="tab-btn-order" onclick="switchTab('order')">
                            <i class="fas fa-shopping-bag"></i> Keranjang
                            <span class="tab-badge" id="order-count-badge">{{ count($cart) }}</span>
                        </button>
                        <button class="tab-btn" id="tab-btn-favorites" onclick="switchTab('favorites')">
                            <i class="fas fa-heart text-danger"></i> Favorit
                            <span class="tab-badge secondary" id="fav-count-badge">0</span>
                        </button>
                    </div>

                    <!-- Scrollable Items Area -->
                    <div class="items-scroll-area">
                        <!-- TAB 1: Pesanan Saya -->
                        <div class="tab-panel active" id="tab-order">
                            <div id="cart-items-container">
                                @if (empty($cart))
                                    <!-- EMPTY STATE -->
                                    <div class="empty-cart-state animate__animated animate__zoomIn">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3081/3081986.png"
                                            alt="Empty Cart">
                                        <h3 class="font-display" style="color:var(--brown);">Keranjang Masih Kosong!
                                        </h3>
                                        <p class="text-muted mb-4 fw-medium">Yuk, pilih cookies atau dessert favoritmu
                                            untuk maniskan harimu.</p>
                                        <a href="{{ route('landing') }}"
                                            class="btn btn-lg rounded-pill px-5 fw-bold text-white shadow-lg"
                                            style="background:linear-gradient(135deg,var(--amber),var(--primary));">
                                            <i class="fas fa-cookie-bite me-2"></i> Eksplor Menu
                                        </a>
                                    </div>
                                @else
                                    @php $i = 0; @endphp
                                    @foreach ($cart as $id => $details)
                                        @php $i++; @endphp
                                        <div class="cart-item-card"
                                            style="animation: fadeIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; animation-delay: {{ $i * 50 }}ms; opacity: 0;">
                                            <!-- Image -->
                                            <div class="item-img-box">
                                                @if ($details['image'])
                                                    <img src="{{ asset('storage/' . $details['image']) }}"
                                                        alt="{{ $details['name'] }}">
                                                @else
                                                    <i class="fas fa-cookie"></i>
                                                @endif
                                            </div>

                                            <!-- Info -->
                                            <div class="item-details">
                                                <div class="item-title" title="{{ $details['name'] }}">
                                                    {{ $details['name'] }}</div>
                                                <div class="item-price-unit">Rp
                                                    {{ number_format($details['price'], 0, ',', '.') }} / pcs</div>
                                            </div>

                                            <!-- Actions (Qty, Subtotal, Delete) -->
                                            <div class="item-actions">
                                                <form action="{{ route('cart.update') }}" method="POST"
                                                    class="m-0">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $id }}">
                                                    <input type="number" name="quantity"
                                                        value="{{ $details['quantity'] }}" min="1"
                                                        class="qty-control shadow-sm"
                                                        onchange="showLoading(); this.closest('form').submit()">
                                                </form>

                                                <div class="item-subtotal">
                                                    Rp
                                                    {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                                </div>

                                                <form action="{{ route('cart.remove', $id) }}" method="POST"
                                                    class="m-0">
                                                    @csrf
                                                    <button type="submit" class="btn-delete shadow-sm"
                                                        title="Hapus Menu">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <!-- TAB 2: Produk Disukai -->
                        <div class="tab-panel" id="tab-favorites">
                            <div id="favorite-items-container" class="hidden">
                                <!-- Rendered by JS -->
                            </div>
                            <div class="empty-cart-state" id="fav-empty" style="display:none;">
                                <img src="https://cdn-icons-png.flaticon.com/512/3081/3081986.png"
                                    alt="Empty Favorites">
                                <h3 class="font-display" style="color:var(--brown);">Belum Ada Favorit</h3>
                                <p class="text-muted fw-medium">Jelajahi menu dan klik tombol hati untuk menyimpan
                                    cookies idamanmu di sini.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ════ KOLOM KANAN: STRUK CHECKOUT ════ -->
            @if (!empty($cart))
                <div class="right-column">
                    <div class="receipt-container animate__animated animate__fadeInRight">

                        <!-- Area Form Scrollable -->
                        <div class="receipt-body">

                            <!-- Form Data Pemesan -->
                            <form action="{{ route('cart.checkout') }}" method="POST" id="checkoutForm"
                                onsubmit="showLoading(); return true;">
                                @csrf

                                {{-- Section 1: Data Kasir --}}
                                <div class="receipt-section-title"><i class="fas fa-user-edit"></i> Data Pemesan</div>

                                <div class="form-group">
                                    <label>Nama Pelanggan <span class="text-danger">*</span></label>
                                    <div class="premium-input-box">
                                        <i class="fas fa-user"></i>
                                        <input type="text" name="customer_name" required
                                            placeholder="Masukkan nama panggilan">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Keterangan / Kelas</label>
                                    <div class="premium-input-box">
                                        <i class="fas fa-id-badge"></i>
                                        <input type="text" name="customer_class" required
                                            placeholder="Misal: XII RPL 1 / Guru">
                                    </div>
                                </div>

                                <hr class="receipt-divider">

                                {{-- Section 2: Metode Pesanan --}}
                                <div class="receipt-section-title"><i class="fas fa-concierge-bell"></i> Metode Pesanan</div>

                                <div class="form-group">
                                    <div class="radio-pills">
                                        <input type="radio" class="d-none" name="order_type" id="dineIn"
                                            value="Dine-in" onchange="toggleTableInput()">
                                        <label class="radio-label" for="dineIn"><i
                                                class="fas fa-store fs-5 mb-1 d-block"></i> Makan Sini</label>

                                        <input type="radio" class="d-none" name="order_type" id="takeAway"
                                            value="Takeaway" onchange="toggleTableInput()" checked>
                                        <label class="radio-label" for="takeAway"><i
                                                class="fas fa-shopping-bag fs-5 mb-1 d-block"></i> Bawa Pulang</label>
                                    </div>
                                </div>

                                <div class="form-group animate__animated animate__fadeIn" id="table-input-container"
                                    style="display:none;">
                                    <label>Nomor Meja <span class="text-danger">*</span></label>
                                    <div class="premium-input-box">
                                        <i class="fas fa-chair"></i>
                                        <input type="number" name="table_number" id="table_number"
                                            placeholder="Meja nomor berapa?">
                                    </div>
                                </div>

                                <input type="hidden" name="payment_method" value="Cash">
                            </form>

                            <hr class="receipt-divider">

                            {{-- Section 3: Voucher --}}
                            <div class="receipt-section-title"><i class="fas fa-ticket-alt"></i> Kode Voucher</div>

                            <div class="voucher-box">
                                <button type="button" class="btn-voucher-trigger" data-bs-toggle="modal"
                                    data-bs-target="#voucherModal">
                                    <span><i class="fas fa-tags text-warning me-1"></i> Pilih atau masukkan kode</span>
                                    <i class="fas fa-chevron-right text-muted" style="font-size:0.8rem;"></i>
                                </button>
                                <form action="{{ route('cart.apply_discount') }}" method="POST">
                                    @csrf
                                    <div class="input-voucher-wrapper">
                                        <input type="text" name="code" class="input-voucher"
                                            placeholder="Ketik kode voucher...">
                                        <button class="btn-claim" type="submit">Klaim</button>
                                    </div>
                                </form>
                                @if (session('discount'))
                                    <div class="discount-success animate__animated animate__bounceIn">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-check-circle me-2" style="color:#059669;"></i>
                                            <span class="code">{{ session('discount')['code'] }}</span>
                                            <span class="badge-pct">{{ session('discount')['percentage'] }}%
                                                OFF</span>
                                        </div>
                                        <form action="{{ route('cart.remove_discount') }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-remove-disc" title="Hapus promo">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                        </div>

                        <!-- Area Bawah Pinned (Ringkasan & Tombol) -->
                        <div class="receipt-footer pinned-bottom">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            @if (session('discount'))
                                <div class="summary-row disc">
                                    <span>Diskon ({{ session('discount')['percentage'] }}%)</span>
                                    <span class="val">− Rp {{ number_format($discountAmount, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <div class="total-box">
                                <div class="lbl">Total Tagihan</div>
                                <div class="amt">Rp {{ number_format($finalTotal, 0, ',', '.') }}</div>
                            </div>

                            <button type="submit" form="checkoutForm" class="btn-checkout-massive">
                                <i class="fas fa-lock"></i> BUAT PESANAN SEKARANG
                            </button>
                            <p class="text-center mt-2 mb-0 text-muted" style="font-size:0.75rem; font-weight:500;">
                                <i class="fas fa-info-circle me-1" style="color:var(--primary);"></i> Transaksi
                                dibayar langsung di kasir
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- MODAL VOUCHER -->
    <div class="modal fade" id="voucherModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-display fw-bold" style="color:var(--brown); font-size:1.4rem;">
                        <i class="fas fa-tags text-warning me-2"></i> Pilih Voucher
                    </h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    @forelse($availableCoupons as $coupon)
                        @php $isEligible = $subtotal >= $coupon->min_purchase; @endphp
                        <div class="card mb-3 border-0 shadow-sm rounded-4 {{ $isEligible ? '' : 'opacity-50' }}"
                            style="background: rgba(255,255,255,0.8); border: 2px solid var(--gray-200) !important;">
                            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-4 p-2 text-center text-white fw-bold shadow-sm"
                                        style="width:60px;height:60px;background:linear-gradient(135deg,var(--primary),var(--amber));display:flex;flex-direction:column;justify-content:center; flex-shrink:0;">
                                        <span class="fs-4 lh-1">{{ $coupon->percentage }}%</span>
                                        <small style="font-size:0.6rem; letter-spacing:1px;">DISC</small>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-1" style="color:var(--brown); font-size:1rem;">
                                            {{ $coupon->description ?? 'Diskon Spesial' }}</h6>
                                        <div class="small text-muted mb-1">
                                            Kode: <span
                                                class="badge bg-white text-dark border shadow-sm px-2 py-1">{{ $coupon->code }}</span>
                                        </div>
                                        @if ($coupon->min_purchase > 0)
                                            <small class="fw-bold {{ $isEligible ? 'text-success' : 'text-danger' }}">
                                                Min. Beli: Rp {{ number_format($coupon->min_purchase, 0, ',', '.') }}
                                            </small>
                                        @else
                                            <small class="fw-bold text-success">Tanpa Minimum Belanja</small>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    @if ($isEligible)
                                        <form action="{{ route('cart.apply_discount') }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            <input type="hidden" name="code" value="{{ $coupon->code }}">
                                            <button class="btn rounded-pill fw-bold px-4 shadow-sm"
                                                style="background:var(--primary);color:white;border:none;">Pakai</button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary rounded-pill px-4 border-0"
                                            style="background:var(--gray-200); color:var(--gray-600);"
                                            disabled>Syarat</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/3081/3081986.png"
                                style="width:100px;opacity:0.4; filter:grayscale(100%);" class="mb-3">
                            <p class="text-muted fw-bold" style="font-size:1.1rem;">Yah, belum ada voucher tersedia.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT BAWAAN (TIDAK DIUBAH LOGIKANYA, HANYA UPDATE TEMPLATE HTML FAVORITE) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showLoading() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }

        function toggleTableInput() {
            const dineIn = document.getElementById('dineIn');
            const container = document.getElementById('table-input-container');
            const input = document.getElementById('table_number');

            if (!container || !input) return;

            if (dineIn && dineIn.checked) {
                container.style.display = 'block';
                input.required = true;
            } else {
                container.style.display = 'none';
                input.required = false;
                input.value = '';
            }
        }

        const FAV_KEY = 'jagoanmie_favorites';

        function getFavorites() {
            try {
                return JSON.parse(localStorage.getItem(FAV_KEY) || '[]');
            } catch (e) {
                return [];
            }
        }

        function saveFavorites(arr) {
            localStorage.setItem(FAV_KEY, JSON.stringify(arr));
        }

        function removeFavorite(id) {
            saveFavorites(getFavorites().filter(f => String(f.id) !== String(id)));
            renderFavoritesTab();
            updateFavoriteBadge();
        }

        function updateFavoriteBadge() {
            const badge = document.getElementById('fav-count-badge');
            if (!badge) return;
            const count = getFavorites().length;
            badge.textContent = count;
            badge.className = count > 0 ? 'tab-badge' : 'tab-badge secondary';
        }

        function renderFavoritesTab() {
            const favs = getFavorites();
            const list = document.getElementById('favorite-items-container');
            const empty = document.getElementById('fav-empty');

            if (!list || !empty) return;

            if (favs.length === 0) {
                list.innerHTML = '';
                list.classList.add('hidden');
                empty.style.display = 'block';
                return;
            }

            empty.style.display = 'none';
            list.classList.remove('hidden');

            // Template disesuaikan dengan desain cart-item-card yang baru
            list.innerHTML = favs.map(f => `
                <div class="cart-item-card" id="fav-item-${f.id}">
                    <div class="item-img-box">
                        <img src="${escHtml(f.image || f.imgSrc)}" alt="${escHtml(f.name)}" onerror="this.src='https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&w=150&q=80'">
                    </div>
                    <div class="item-details">
                        <div class="item-title">${escHtml(f.name)}</div>
                        <div class="item-price-unit" style="color:var(--primary); font-weight:700;">Rp ${Number(f.price).toLocaleString('id-ID')}</div>
                        <div style="font-size:0.75rem;color:var(--gray-400);margin-top:2px;font-weight:500;">${escHtml((f.desc || '').substring(0, 50))}…</div>
                    </div>
                    <div class="item-actions flex-column flex-sm-row">
                        <button class="btn-delete shadow-sm" onclick="removeFavorite('${f.id}')" title="Hapus dari Favorit">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" style="background:var(--primary-light); color:var(--primary); border:none;" onclick="addFavToCart('${f.id}')">
                            <i class="fas fa-plus"></i> Pesan
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function escHtml(str) {
            return String(str ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g,
                '&quot;');
        }

        function addFavToCart(productId) {
            sessionStorage.setItem('cart_active_tab', 'favorites');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('cart.add') }}';
            form.style.display = 'none';

            const token = document.createElement('input');
            token.type = 'hidden';
            token.name = '_token';
            token.value = '{{ csrf_token() }}';

            const pid = document.createElement('input');
            pid.type = 'hidden';
            pid.name = 'product_id';
            pid.value = productId;

            form.appendChild(token);
            form.appendChild(pid);
            document.body.appendChild(form);
            showLoading();
            form.submit();
        }

        function switchTab(tab) {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            const btn = document.getElementById('tab-btn-' + tab);
            if (btn) btn.classList.add('active');

            const cartPanel = document.getElementById('tab-order');
            const favPanel = document.getElementById('tab-favorites');

            if (tab === 'favorites') {
                if (cartPanel) cartPanel.classList.remove('active');
                if (favPanel) favPanel.classList.add('active');
                renderFavoritesTab();
            } else {
                if (favPanel) favPanel.classList.remove('active');
                if (cartPanel) cartPanel.classList.add('active');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleTableInput();
            updateFavoriteBadge();

            const savedTab = sessionStorage.getItem('cart_active_tab');
            const urlParams = new URLSearchParams(window.location.search);

            if (savedTab === 'favorites' || urlParams.get('tab') === 'favorites' || window.location.search.includes(
                    'tab=favorites')) {
                if (savedTab) sessionStorage.removeItem('cart_active_tab');
                switchTab('favorites');
            } else if (savedTab === 'order') {
                sessionStorage.removeItem('cart_active_tab');
                switchTab('order');
            }
        });
    </script>
</body>

</html>
