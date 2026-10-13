<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Staff — Tho Cookies</title>
    <meta name="description" content="Portal login eksklusif untuk staf dan admin Tho Cookies.">

    <link rel="icon" type="image/png" href="{{ asset('img/thecookies.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* === COLOURED VARIABLES & ESTETIKA THO COOKIES === */
        :root {
            --primary: #F26522;
            /* Honey Orange */
            --primary-glow: rgba(242, 101, 34, 0.25);
            --primary-dark: #D84315;
            --brown-deep: #3E2723;
            /* Cokelat Tua */
            --brown-soft: #5D4037;
            --cream-light: #FFFDF9;
            /* Krem Hangat */
            --cream-warm: #FAF0E6;
            --white-glass: rgba(255, 255, 255, 0.75);
            --danger-bg: rgba(254, 242, 242, 0.95);
            --danger-text: #B91C1C;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--cream-warm);
            padding: 24px;
            overflow: hidden;
            position: relative;
        }

        /* ─── 1. SPLASH SCREEN / ENTRANCE OVERLAY ─── */
        #splash-overlay {
            position: fixed;
            inset: 0;
            background-color: #FFF8E1;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        #splash-overlay.fade-out {
            opacity: 0;
            visibility: hidden;
        }

        .splash-icon {
            font-size: 3rem;
            color: var(--primary);
            animation: pulse-splash 1s infinite alternate;
        }

        @keyframes pulse-splash {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }

            100% {
                transform: scale(1.1);
                opacity: 1;
                filter: drop-shadow(0 0 15px var(--primary-glow));
            }
        }

        /* ─── 2. LATAR BELAKANG FLUID & FLOATING ORBS ─── */
        .fluid-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            overflow: hidden;
            background: linear-gradient(135deg, var(--cream-light) 0%, var(--cream-warm) 100%);
            background-image: radial-gradient(var(--brown-soft) 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            opacity: 0.85;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.5;
            animation: orbMovement 25s infinite alternate cubic-bezier(0.45, 0.05, 0.55, 0.95);
        }

        .orb-1 {
            width: 45vw;
            height: 45vw;
            background: rgba(242, 101, 34, 0.15);
            top: -10%;
            left: -10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 40vw;
            height: 40vw;
            background: rgba(255, 179, 0, 0.12);
            bottom: -15%;
            right: -5%;
            animation-delay: -6s;
        }

        .orb-3 {
            width: 35vw;
            height: 35vw;
            background: rgba(93, 64, 55, 0.08);
            top: 35%;
            left: 45%;
            animation-delay: -12s;
        }

        @keyframes orbMovement {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }

            50% {
                transform: translate(6vw, 8vh) scale(1.15) rotate(120deg);
            }

            100% {
                transform: translate(-4vw, -6vh) scale(0.9) rotate(240deg);
            }
        }

        /* ─── 3. WADAH UTAMA & ENTRANCE ANIMATION ─── */
        .login-wrapper {
            display: flex;
            width: 1050px;
            max-width: 100%;
            min-height: 650px;
            border-radius: 28px;
            box-shadow: 0 20px 50px rgba(93, 64, 55, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            z-index: 10;
            overflow: hidden;
            background: transparent;
            /* Status Awal (Hidden) */
            opacity: 0;
            transform: translateY(40px) scale(0.95);
            transition: opacity 1s cubic-bezier(0.34, 1.56, 0.64, 1), transform 1s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.8s ease, background 0.8s ease;
        }

        /* Status Aktif (Shown) setelah loader selesai */
        .login-wrapper.entrance-active {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* ─── 4. EFEK "OPENING GATE" (OUTRO ANIMATION) ─── */
        .visual-side,
        .form-side {
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Wrapper Transparan saat membelah */
        .login-wrapper.is-opening {
            box-shadow: none;
            border-color: transparent;
        }

        /* Belah ke Kiri */
        .login-wrapper.is-opening .visual-side {
            transform: translateX(-150px) scale(0.9);
            opacity: 0;
            filter: blur(10px);
        }

        /* Belah ke Kanan */
        .login-wrapper.is-opening .form-side {
            transform: translateX(150px) scale(0.9);
            opacity: 0;
            filter: blur(10px);
        }

        /* ─── KOLOM KIRI (BRAND EXPERIENCE) ─── */
        .visual-side {
            width: 45%;
            background: linear-gradient(135deg, #FFEBD8 0%, #FFD2B3 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 50px 40px;
            position: relative;
            overflow: hidden;
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }

        .visual-side::before {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.7) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
            animation: radialPulse 4s ease-in-out infinite alternate;
        }

        @keyframes radialPulse {
            0% {
                transform: scale(0.95);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.1);
                opacity: 0.9;
            }
        }

        .logo-container-3d {
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: floatLogo 5s ease-in-out infinite;
        }

        .floating-logo {
            width: 250px;
            max-width: 100%;
            filter: drop-shadow(0 25px 35px rgba(62, 39, 35, 0.15));
            transition: transform 0.5s ease;
        }

        .logo-container-3d:hover .floating-logo {
            transform: scale(1.05) rotate(-5deg);
        }

        .dynamic-shadow {
            width: 140px;
            height: 14px;
            background: rgba(62, 39, 35, 0.1);
            border-radius: 50%;
            margin-top: 20px;
            filter: blur(5px);
            z-index: 1;
            animation: shadowPulse 5s ease-in-out infinite;
        }

        @keyframes floatLogo {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes shadowPulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.8;
            }

            50% {
                transform: scale(0.7);
                opacity: 0.3;
            }
        }

        .welcome-text {
            z-index: 2;
            text-align: center;
            color: var(--brown-deep);
            margin-top: 25px;
        }

        .welcome-text h3 {
            font-family: 'Fredoka', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(255, 255, 255, 0.4);
        }

        .welcome-text p {
            font-size: 1rem;
            font-weight: 500;
            color: var(--brown-soft);
            opacity: 0.9;
            line-height: 1.5;
        }

        /* ─── KOLOM KANAN (INTERACTIVE LOGIN FORM) ─── */
        .form-side {
            width: 55%;
            background: var(--white-glass);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            padding: 60px 65px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .btn-back {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brown-soft);
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-size: 1.1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(93, 64, 55, 0.05);
        }

        .btn-back:hover {
            background: var(--primary);
            color: white;
            transform: rotate(90deg) scale(1.1);
            box-shadow: 0 10px 20px var(--primary-glow);
        }

        .logo-small {
            width: 65px;
            margin-bottom: 20px;
            filter: drop-shadow(0 6px 12px rgba(0, 0, 0, 0.06));
        }

        .form-title {
            font-family: 'Fredoka', sans-serif;
            font-size: 2.3rem;
            color: var(--brown-deep);
            font-weight: 700;
            margin-bottom: 6px;
        }

        .form-subtitle {
            color: var(--brown-soft);
            font-size: 0.95rem;
            margin-bottom: 35px;
            font-weight: 500;
            opacity: 0.8;
        }

        .alert-error {
            background: var(--danger-bg);
            border: 1px solid rgba(239, 68, 68, 0.15);
            border-left: 5px solid #EF4444;
            color: var(--danger-text);
            border-radius: 16px;
            padding: 16px 20px;
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.08);
            animation: errorShake 0.4s ease;
        }

        @keyframes errorShake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-6px);
            }

            75% {
                transform: translateX(6px);
            }
        }

        /* ─── ELEMEN FORM ─── */
        .field-group {
            position: relative;
            margin-bottom: 25px;
        }

        /* Pembungkus Khusus Input & Ikon (Solusi Keselarasan Presisi) */
        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .field-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #8E8E8E;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 8px;
            padding-left: 4px;
            transition: color 0.3s ease;
        }

        /* Diubah top: 50% relatif terhadap .input-wrapper */
        .field-icon-left {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #A8A8A8;
            font-size: 1.1rem;
            transition: all 0.4s ease;
            pointer-events: none;
            z-index: 2;
        }

        .input-field {
            width: 100%;
            padding: 16px 50px 16px 54px;
            border: 2px solid transparent;
            border-radius: 16px;
            outline: none;
            font-size: 1rem;
            font-weight: 600;
            color: var(--brown-deep);
            background: rgba(255, 255, 255, 0.85);
            box-shadow: 0 4px 12px rgba(93, 64, 55, 0.02), inset 0 0 0 1px rgba(93, 64, 55, 0.06);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .input-field::placeholder {
            color: #C4C4C4;
            font-weight: 500;
        }

        .field-group:focus-within .field-label {
            color: var(--primary);
        }

        .input-field:focus {
            background: white;
            border-color: rgba(242, 101, 34, 0.4);
            box-shadow: 0 0 0 5px var(--primary-glow), 0 12px 25px rgba(242, 101, 34, 0.1);
            transform: translateY(-2px);
        }

        /* Diubah selektornya agar menargetkan di dalam pembungkus */
        .input-field:focus~.field-icon-left {
            color: var(--primary);
            transform: translateY(-50%) scale(1.15);
        }

        /* Diubah top: 50% relatif terhadap .input-wrapper */
        .btn-eye {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #A8A8A8;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            z-index: 2;
            font-size: 1.1rem;
            border-radius: 50%;
        }

        .btn-eye:hover {
            color: var(--primary);
            background: var(--primary-glow);
            transform: translateY(-50%) scale(1.1);
        }

        /* ─── TOMBOL SUBMIT SHIMMERING ─── */
        .btn-submit {
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--primary) 0%, #FF8C00 50%, var(--primary-dark) 100%);
            color: white;
            font-weight: 800;
            font-size: 1.05rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            box-shadow: 0 12px 30px var(--primary-glow);
            margin-top: 20px;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .btn-submit::after {
            content: '';
            position: absolute;
            top: 0;
            left: -150%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.5), transparent);
            transform: skewX(-25deg);
            animation: shimmeringSweep 4.5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            z-index: -1;
        }

        @keyframes shimmeringSweep {
            0% {
                left: -150%;
            }

            20% {
                left: 200%;
            }

            100% {
                left: 200%;
            }
        }

        .btn-submit:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 35px rgba(242, 101, 34, 0.4);
        }

        .btn-submit:active {
            transform: translateY(2px) scale(0.98);
        }

        .btn-submit.loading .btn-text {
            display: none;
        }

        .btn-submit.loading .btn-loader {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-footer {
            text-align: center;
            margin-top: 35px;
            font-size: 0.85rem;
            color: #9E9E9E;
            font-weight: 600;
            line-height: 1.5;
        }

        /* ─── RESPONSIVE DESIGN ─── */
        @media (max-width: 991.98px) {
            body {
                padding: 16px;
                overflow: auto;
            }

            .login-wrapper {
                flex-direction: column;
                width: 100%;
                max-width: 500px;
                min-height: auto;
            }

            .visual-side {
                width: 100%;
                border-radius: 28px 28px 0 0;
                border-right: none;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
                padding: 40px 30px;
            }

            .form-side {
                width: 100%;
                border-radius: 0 0 28px 28px;
                padding: 40px 30px;
            }

            .btn-back {
                top: 20px;
                right: 20px;
            }

            .floating-logo {
                width: 200px;
            }

            /* Penyesuaian Slide Out untuk Mobile (Atas & Bawah) */
            .login-wrapper.is-opening .visual-side {
                transform: translateY(-100px) scale(0.9);
            }

            .login-wrapper.is-opening .form-side {
                transform: translateY(100px) scale(0.9);
            }
        }
    </style>
</head>

<body>

    <!-- 1. Overlay Splash / Loading Masuk -->
    <div id="splash-overlay">
        <i class="fas fa-cookie-bite splash-icon"></i>
    </div>

    <!-- Latar Belakang Morfologi Cair -->
    <div class="fluid-bg">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <!-- Wadah Login Utama -->
    <div class="login-wrapper" id="login-wrapper">

        <!-- SISI KIRI: BRAND EXPERIENCE -->
        <div class="visual-side">
            <div class="logo-container-3d">
                <img src="{{ asset('img/thecookies.png') }}" alt="Tho Cookies Mascot" class="floating-logo"
                    onerror="this.src='https://cdn-icons-png.flaticon.com/512/3014/3014401.png'">
                <div class="dynamic-shadow"></div>
            </div>
            <div class="welcome-text">
                <h3>Selamat Datang! 👋</h3>
                <p>Siap melayani dengan kehangatan manis hari ini?</p>
            </div>
        </div>

        <!-- SISI KANAN: FORM LOGIN STAFF -->
        <div class="form-side">
            <a href="{{ route('landing') }}" class="btn-back" title="Kembali ke Beranda">
                <i class="fas fa-times"></i>
            </a>

            <img src="{{ asset('img/thecookies.png') }}" alt="Logo Tho Cookies" class="logo-small"
                onerror="this.style.display='none'">

            <h1 class="form-title">Login Staff</h1>
            <p class="form-subtitle">Masukkan kredensial Anda untuk mengakses panel manajemen.</p>

            <!-- Pesan Error Laravel Bawaan -->
            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-triangle fa-lg"></i>
                    <div>Username atau Password yang Anda masukkan salah. Silakan coba lagi.</div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" autocomplete="off" id="loginForm">
                @csrf

                <!-- Input Username -->
                <div class="field-group">
                    <label class="field-label" for="username">Username ID</label>
                    <div class="input-wrapper">
                        <input type="text" class="input-field" name="username" id="username"
                            placeholder="Masukkan username Anda" value="{{ old('username') }}" required
                            autocomplete="off">
                        <i class="fas fa-user field-icon-left"></i>
                    </div>
                </div>

                <!-- Input Password dengan Eye Toggle -->
                <div class="field-group">
                    <label class="field-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" class="input-field" name="password" id="password"
                            placeholder="Masukkan password Anda" required>
                        <i class="fas fa-lock field-icon-left"></i>

                        <!-- Tombol Toggle Mata -->
                        <button type="button" class="btn-eye" id="togglePassword"
                            title="Tampilkan/Sembunyikan Password">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Tombol Submit Dinamis -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-text"><i class="fas fa-sign-in-alt me-2"></i> Masuk Sekarang</span>
                    <span class="btn-loader" style="display:none;"><i class="fas fa-circle-notch fa-spin"></i> Membuka
                        Panel...</span>
                </button>
            </form>

            <div class="form-footer">
                &copy; {{ date('Y') }} Tho Cookies System.<br>
                <span style="color: #C2C2C2; font-weight: 500;">Authorized Personnel Only.</span>
            </div>
        </div>

    </div>

    <!-- SCRIPT INTERAKSI UI (ENTRANCE, OUTRO & PASSWORD TOGGLE) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. ENTRANCE ANIMATION (Page Intro) ---
            const overlay = document.getElementById('splash-overlay');
            const wrapper = document.getElementById('login-wrapper');

            // Tunggu sebentar (150ms) agar DOM siap, lalu fade out overlay & naikkan kartu login
            setTimeout(() => {
                overlay.classList.add('fade-out');
                wrapper.classList.add('entrance-active');
            }, 150);

            // --- 2. EXIT ANIMATION "OPENING GATE" (Submit Interceptor) ---
            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');

            if (loginForm && submitBtn) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Cegah submit bawaan

                    // Ubah tombol ke state Loading
                    submitBtn.classList.add('loading');
                    submitBtn.style.pointerEvents = 'none'; // Cegah double-click

                    // Trigger animasi "Opening Gate"
                    wrapper.classList.add('is-opening');

                    // Tunggu 1000ms untuk membiarkan CSS transisi bermain secara utuh
                    setTimeout(() => {
                        // Setelah 1 detik, lanjutkan request POST ke backend Laravel
                        HTMLFormElement.prototype.submit.call(loginForm);
                    }, 1000);
                });
            }

            // --- 3. PASSWORD EYE TOGGLE (Utuh / Tidak Diubah Logikanya) ---
            const toggleBtn = document.getElementById('togglePassword');
            const passInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (toggleBtn && passInput) {
                toggleBtn.addEventListener('click', function() {
                    const isPassword = passInput.type === 'password';
                    passInput.type = isPassword ? 'text' : 'password';
                    eyeIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
                    toggleBtn.style.color = isPassword ? 'var(--primary)' : '#a8a8a8';
                });
            }
        });
    </script>

</body>

</html>
