<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tho Cookies</title>

    <link rel="icon" type="image/png" href="{{ asset('img/thecookies.png') }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* === COLOR VARIABLES (Gourmet Bakery Theme) === */
        :root {
            --cream-light: #FFFDF9;
            --cream-warm: #FAF0E6;
            --brown-deep: #3D2314;
            --brown-soft: #634330;
            --honey-orange: #F26522;
            --honey-glow: rgba(242, 101, 34, 0.4);
            --amber-gold: #FFB300;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.8);
        }

        html,
        body {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        html::-webkit-scrollbar,
        body::-webkit-scrollbar {
            display: none;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--cream-light);
            color: var(--brown-deep);
            overflow-x: hidden;
            /* Premium subtle mesh gradient background */
            background-image:
                radial-gradient(circle at 15% 10%, rgba(242, 101, 34, 0.03) 0%, transparent 40%),
                radial-gradient(circle at 85% 30%, rgba(255, 179, 0, 0.04) 0%, transparent 40%),
                radial-gradient(circle at 50% 80%, rgba(61, 35, 20, 0.03) 0%, transparent 50%);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-display,
        .nav-link,
        .price-tag,
        .btn-bold {
            font-family: 'Fredoka', sans-serif;
        }

        /* === UTILITIES & GLASSMORPHISM === */
        .glass-premium {
            background: var(--glass-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--glass-border);
            box-shadow: 0 30px 60px rgba(61, 35, 20, 0.05), inset 0 0 0 1px rgba(255, 255, 255, 0.6);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--honey-orange), var(--amber-gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hover-bouncy {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .hover-bouncy:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px var(--honey-glow);
        }

        /* === PRELOADER === */
        #preloader {
            position: fixed;
            inset: 0;
            background: var(--cream-warm);
            z-index: 99999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: opacity 0.5s ease;
        }

        .loader-bowl {
            font-size: 4.5rem;
            color: var(--honey-orange);
            animation: bowlBounce 0.6s infinite alternate;
            filter: drop-shadow(0 10px 10px rgba(242, 101, 34, 0.3));
        }

        .loader-shadow {
            width: 60px;
            height: 12px;
            background: rgba(61, 35, 20, 0.15);
            border-radius: 50%;
            margin-top: 15px;
            animation: shadowScale 0.6s infinite alternate;
        }

        @keyframes bowlBounce {
            from {
                transform: translateY(0);
            }

            to {
                transform: translateY(-25px);
            }
        }

        @keyframes shadowScale {
            from {
                transform: scale(1);
                opacity: 1;
            }

            to {
                transform: scale(0.5);
                opacity: 0.3;
            }
        }

        /* === PROGRESS BAR === */
        .progress-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: transparent;
            z-index: 100000;
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--honey-orange), var(--amber-gold));
            width: 0%;
            border-radius: 0 5px 5px 0;
            box-shadow: 0 0 15px var(--honey-orange);
        }

        /* === NAVBAR === */
        .navbar {
            padding: 25px 0;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 999;
        }

        .nav-glass {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border-radius: 100px;
            padding: 10px 30px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px rgba(61, 35, 20, 0.06), inset 0 0 0 1px rgba(255, 255, 255, 0.7);
            transition: all 0.4s ease;
        }

        .navbar.scrolled {
            padding: 12px 0;
        }

        .navbar.scrolled .nav-glass {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 25px 50px rgba(61, 35, 20, 0.1);
        }

        .logo-wrapper {
            background: white;
            border-radius: 50%;
            padding: 6px;
            box-shadow: 0 8px 20px rgba(61, 35, 20, 0.08);
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .navbar-brand:hover .logo-wrapper {
            transform: rotate(-15deg) scale(1.15);
            box-shadow: 0 15px 30px rgba(242, 101, 34, 0.25);
        }

        .logo-img {
            height: 45px;
        }

        .navbar-nav .nav-link {
            font-weight: 600;
            color: var(--brown-soft) !important;
            font-size: 1.05rem;
            margin: 0 6px;
            padding: 10px 24px !important;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active-link {
            color: white !important;
            background: var(--brown-deep);
            box-shadow: 0 8px 20px rgba(61, 35, 20, 0.2);
            transform: translateY(-2px);
        }

        .btn-wishlist-nav {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            box-shadow: 0 8px 20px rgba(61, 35, 20, 0.08);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            color: var(--honey-orange);
            border: 1px solid rgba(242, 101, 34, 0.15);
            text-decoration: none;
        }

        .btn-wishlist-nav:hover {
            transform: translateY(-4px) scale(1.1);
            box-shadow: 0 15px 30px var(--honey-glow);
            background: var(--honey-orange);
            color: white;
        }

        .wishlist-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 800;
            border: 2px solid white;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.4);
        }

        .btn-user {
            background: linear-gradient(135deg, var(--honey-orange), var(--amber-gold));
            color: white !important;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-family: 'Fredoka', sans-serif;
            border: none;
            box-shadow: 0 10px 25px rgba(242, 101, 34, 0.3);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .btn-user:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 20px 40px rgba(242, 101, 34, 0.45);
        }

        .btn-profile {
            background: white;
            color: var(--brown-deep) !important;
            border: 2px solid var(--brown-deep);
            box-shadow: 0 8px 20px rgba(61, 35, 20, 0.1);
        }

        .btn-profile:hover {
            background: var(--brown-deep);
            color: var(--amber-gold) !important;
        }

        /* === HERO SECTION === */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 150px;
            padding-bottom: 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 10px 25px;
            border-radius: 50px;
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            color: var(--honey-orange);
            letter-spacing: 1px;
            box-shadow: 0 15px 30px rgba(242, 101, 34, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.9);
            margin-bottom: 25px;
        }

        .hero-title {
            font-size: clamp(3.5rem, 6vw, 6rem);
            font-weight: 800;
            line-height: 1.05;
            color: var(--brown-deep);
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .hero-title-stroke {
            -webkit-text-stroke: 2px var(--brown-deep);
            color: transparent;
            display: block;
            margin-top: 5px;
            text-shadow: 15px 15px 0px rgba(242, 101, 34, 0.08);
        }

        .hero-desc {
            font-size: 1.15rem;
            color: var(--brown-soft);
            max-width: 550px;
            line-height: 1.8;
            margin-bottom: 40px;
            font-weight: 400;
        }

        .hero-visuals {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 5;
        }

        .hero-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--amber-gold) 0%, var(--honey-orange) 40%, transparent 70%);
            filter: blur(60px);
            opacity: 0.25;
            border-radius: 50%;
            animation: pulseGlow 6s infinite alternate;
            z-index: -1;
        }

        @keyframes pulseGlow {
            0% {
                transform: scale(0.9);
                opacity: 0.2;
            }

            100% {
                transform: scale(1.1);
                opacity: 0.4;
            }
        }

        /* --- BINGKAI FOTO PREMIUM THO COOKIES --- */
        .hero-image-frame {
            position: relative;
            padding: 16px;
            background: var(--white);
            border: 3.5px solid var(--brown-deep);
            border-radius: 45px;
            box-shadow: 15px 15px 0px rgba(99, 67, 48, 0.12);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            width: 100%;
            max-width: 500px;
            z-index: 5;
            animation: float3D 6s ease-in-out infinite;
            /* Seluruh bingkai mengapung secara selaras */
        }

        .hero-image-frame:hover {
            transform: translateY(-8px) rotate(1deg) scale(1.02);
            box-shadow: 20px 20px 0px var(--honey-orange);
            border-color: var(--honey-orange);
        }

        /* Pita Isolasi Kertas Estetik khas Toko Roti */
        .bakery-tape {
            position: absolute;
            top: -15px;
            left: 15%;
            background: var(--honey-orange);
            color: white;
            padding: 6px 25px;
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            transform: rotate(-4deg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            z-index: 10;
            border-radius: 4px;
            border: 2px solid var(--brown-deep);
        }

        .hero-main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 30px;
            /* Melengkung mengikuti sudut bingkai putih luar */
            display: block;
        }

        @keyframes float3D {

            0%,
            100% {
                transform: translateY(0) rotate(-2deg);
            }

            50% {
                transform: translateY(-30px) rotate(2deg);
                filter: drop-shadow(0 60px 70px rgba(61, 35, 20, 0.15));
            }
        }

        .floating-price-tag {
            position: absolute;
            bottom: 5%;
            right: -5%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            padding: 18px 30px;
            border-radius: 40px;
            border: 2px solid white;
            box-shadow: 0 25px 50px rgba(61, 35, 20, 0.15);
            display: flex;
            align-items: center;
            gap: 15px;
            animation: floatOpposite 5s ease-in-out infinite;
            z-index: 10;
        }

        @keyframes floatOpposite {

            0%,
            100% {
                transform: translateY(15px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* === BAKER'S DAILY SPECIAL (NEW INTERACTIVE SECTION) === */
        .daily-special-section {
            margin-top: -30px;
            padding-bottom: 80px;
            position: relative;
            z-index: 10;
        }

        .special-card {
            background: linear-gradient(135deg, var(--brown-deep) 0%, #29150B 100%);
            border-radius: 40px;
            padding: 40px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 40px 80px rgba(61, 35, 20, 0.3);
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(255, 179, 0, 0.2);
        }

        .special-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(242, 101, 34, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        .special-content {
            color: white;
            position: relative;
            z-index: 2;
            max-width: 60%;
        }

        .timer-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 15px 25px;
            border-radius: 20px;
            display: inline-flex;
            gap: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 20px;
        }

        .time-block {
            text-align: center;
        }

        .time-block span.num {
            font-family: 'Fredoka', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--amber-gold);
            line-height: 1;
            display: block;
        }

        .time-block span.lbl {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
        }

        .time-colon {
            font-size: 1.8rem;
            font-weight: bold;
            color: rgba(255, 255, 255, 0.3);
            align-self: center;
            margin-top: -10px;
        }

        /* === MARQUEE === */
        .marquee-section {
            background: var(--amber-gold);
            padding: 20px 0;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            border-top: 3px dashed var(--brown-deep);
            border-bottom: 3px dashed var(--brown-deep);
            transform: rotate(-1deg) scale(1.02);
            z-index: 2;
        }

        .marquee-content {
            display: inline-block;
            animation: marqueeScroll 25s linear infinite;
        }

        .marquee-item {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--brown-deep);
            margin: 0 40px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            text-transform: uppercase;
        }

        @keyframes marqueeScroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* === BENTO BOX FEATURES (ASYMMETRIC GRID) === */
        .features-section {
            padding: 120px 0;
            background: var(--cream-warm);
            position: relative;
        }

        .section-badge {
            display: inline-block;
            padding: 10px 25px;
            background: rgba(242, 101, 34, 0.1);
            color: var(--honey-orange);
            border-radius: 50px;
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 1px solid rgba(242, 101, 34, 0.2);
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--brown-deep);
            line-height: 1.2;
        }

        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            grid-auto-rows: minmax(280px, auto);
            gap: 25px;
        }

        .bento-item {
            background: white;
            border-radius: 40px;
            padding: 40px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 50px rgba(61, 35, 20, 0.04);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .bento-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 35px 60px rgba(242, 101, 34, 0.15);
            border-color: var(--amber-gold);
        }

        .bento-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(242, 101, 34, 0.05) 0%, transparent 60%);
            pointer-events: none;
        }

        .bento-col-8 {
            grid-column: span 8;
        }

        .bento-col-4 {
            grid-column: span 4;
        }

        .bento-col-12 {
            grid-column: span 12;
        }

        .bento-row-2 {
            grid-row: span 2;
        }

        .bento-icon {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 25px;
            transition: transform 0.4s;
        }

        .bento-item:hover .bento-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .icon-honey {
            background: rgba(242, 101, 34, 0.1);
            color: var(--honey-orange);
        }

        .icon-gold {
            background: rgba(255, 179, 0, 0.15);
            color: var(--amber-gold);
        }

        .icon-cocoa {
            background: rgba(61, 35, 20, 0.08);
            color: var(--brown-deep);
        }

        .bento-item h3 {
            font-size: 1.8rem;
            color: var(--brown-deep);
            font-weight: 700;
            margin-bottom: 15px;
        }

        .bento-item p {
            color: var(--brown-soft);
            font-size: 1.05rem;
            line-height: 1.7;
            flex-grow: 1;
            margin: 0;
        }

        /* === ABOUT (MAGAZINE LAYOUT WITH BOUNCY STACKED IMAGES) === */
        .about-section {
            padding: 120px 0;
            background: var(--cream-light);
            position: relative;
            overflow: hidden;
        }

        .mag-stacked-wrapper {
            position: relative;
            height: 600px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 1000px;
        }

        .mag-img {
            position: absolute;
            border-radius: 40px;
            box-shadow: 0 30px 60px rgba(61, 35, 20, 0.15);
            object-fit: cover;
            transition: all 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 8px solid white;
        }

        .img-back {
            width: 70%;
            height: 60%;
            top: 5%;
            right: 5%;
            transform: rotate(8deg);
            opacity: 0.8;
            z-index: 1;
            filter: grayscale(20%);
        }

        .img-front {
            width: 85%;
            height: 75%;
            bottom: 5%;
            left: 0;
            transform: rotate(-4deg);
            z-index: 2;
        }

        /* The Bouncy Hover Effect on Stacked Images */
        .mag-stacked-wrapper:hover .img-back {
            transform: translate(30px, -30px) rotate(15deg) scale(1.05);
            opacity: 1;
            filter: grayscale(0%);
            box-shadow: 0 40px 80px rgba(242, 101, 34, 0.2);
        }

        .mag-stacked-wrapper:hover .img-front {
            transform: translate(-20px, 20px) rotate(-8deg) scale(1.05);
            box-shadow: 0 40px 80px rgba(61, 35, 20, 0.3);
        }

        .mag-content {
            padding-left: 40px;
        }

        .mag-title {
            font-size: 4.5rem;
            color: var(--brown-deep);
            line-height: 1;
            font-weight: 800;
            margin-bottom: 30px;
            letter-spacing: -1px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            border-top: 2px dashed rgba(61, 35, 20, 0.15);
            padding-top: 30px;
            margin-top: 40px;
        }

        .stat-box h4 {
            font-size: 3rem;
            color: var(--honey-orange);
            font-weight: 800;
            margin: 0;
            line-height: 1;
        }

        .stat-box p {
            font-family: 'Fredoka', sans-serif;
            font-size: 0.9rem;
            color: var(--brown-deep);
            font-weight: 700;
            text-transform: uppercase;
            margin-top: 10px;
        }

        /* === GOURMET MATCHMAKER (NEW INTERACTIVE SECTION) === */
        .matchmaker-section {
            padding: 100px 0 60px;
            background: var(--cream-warm);
        }

        .match-glass-panel {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border-radius: 40px;
            padding: 50px;
            border: 1px solid white;
            box-shadow: 0 30px 60px rgba(61, 35, 20, 0.05);
        }

        .match-tabs {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .match-tab-btn {
            background: white;
            border: 2px solid transparent;
            padding: 18px 25px;
            border-radius: 25px;
            text-align: left;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--brown-soft);
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.03);
        }

        .match-tab-btn:hover {
            transform: translateX(10px);
            color: var(--honey-orange);
        }

        .match-tab-btn.active {
            background: var(--honey-orange);
            color: white;
            border-color: var(--honey-orange);
            box-shadow: 0 15px 30px rgba(242, 101, 34, 0.3);
            transform: translateX(15px);
        }

        .match-display {
            background: white;
            border-radius: 30px;
            padding: 30px;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 30px;
            position: relative;
            border: 2px dashed rgba(242, 101, 34, 0.2);
            transition: all 0.5s ease;
            opacity: 1;
        }

        .match-img-wrap {
            width: 45%;
            height: 250px;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            background: var(--cream-light);
        }

        .match-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .match-bars {
            width: 55%;
        }

        .m-bar-group {
            margin-bottom: 15px;
        }

        .m-bar-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--brown-deep);
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .m-bar-track {
            height: 10px;
            background: var(--cream-warm);
            border-radius: 10px;
            overflow: hidden;
        }

        .m-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--amber-gold), var(--honey-orange));
            border-radius: 10px;
            width: 0%;
            transition: width 1s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        /* === PREMIUM MENU CARDS === */
        .menu-section {
            padding: 80px 0 120px;
            background: var(--cream-warm);
            position: relative;
        }

        .product-card {
            background: white;
            border-radius: 32px;
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px rgba(61, 35, 20, 0.04);
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
            z-index: 1;
        }

        .product-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 40px 60px rgba(61, 35, 20, 0.12);
            z-index: 5;
        }

        .pc-img-wrap {
            height: 300px;
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            background: var(--cream-light);
            margin-bottom: 20px;
            cursor: pointer;
        }

        .pc-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .product-card:hover .pc-img-wrap img {
            transform: scale(1.12) rotate(3deg);
        }

        .badge-stock {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            color: var(--brown-deep);
            font-family: 'Fredoka', sans-serif;
            font-weight: 700;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.85rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            z-index: 10;
            border: 1px solid white;
        }

        .badge-stock.low {
            background: var(--amber-gold);
            color: var(--brown-deep);
            animation: pulseAlert 2s infinite;
            border: none;
        }

        @keyframes pulseAlert {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 179, 0, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(255, 179, 0, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(255, 179, 0, 0);
            }
        }

        .btn-heart-card {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d1d5db;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            z-index: 15;
        }

        .btn-heart-card:hover {
            transform: scale(1.2);
            color: #ef4444;
        }

        .btn-heart-card.favorited {
            color: #ef4444;
            background: #fee2e2;
            border: 1px solid #fca5a5;
        }

        .pc-content {
            padding: 0 5px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .pc-title {
            font-size: 1.7rem;
            color: var(--brown-deep);
            font-weight: 800;
            margin-bottom: 5px;
        }

        .pc-rating {
            color: var(--amber-gold);
            font-size: 0.95rem;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pc-desc {
            color: var(--brown-soft);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 25px;
            flex-grow: 1;
        }

        .pc-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 15px;
            border-top: 2px dashed rgba(61, 35, 20, 0.1);
        }

        .pc-price {
            font-family: 'Fredoka', sans-serif;
            font-size: 1.8rem;
            color: var(--honey-orange);
            font-weight: 800;
        }

        .btn-add-cart {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: var(--brown-deep);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 10px 25px rgba(61, 35, 20, 0.2);
            cursor: pointer;
        }

        /* The requested 90deg rotation hover */
        .btn-add-cart:hover {
            background: var(--honey-orange);
            transform: scale(1.15) rotate(90deg);
            box-shadow: 0 15px 35px rgba(242, 101, 34, 0.4);
        }

        .sold-out-overlay {
            position: absolute;
            inset: 0;
            background: rgba(253, 251, 247, 0.7);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 24px;
        }

        .sold-out-badge {
            background: #ef4444;
            color: white;
            padding: 12px 30px;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            border-radius: 50px;
            transform: rotate(-10deg);
            box-shadow: 0 15px 30px rgba(239, 68, 68, 0.3);
            border: 4px solid white;
        }

        /* === PREMIUM MODAL === */
        #product-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 100000;
            background: rgba(61, 35, 20, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeIn 0.4s ease;
        }

        #product-modal-overlay.show {
            display: flex;
        }

        .pm-card {
            background: var(--cream-light);
            border-radius: 40px;
            max-width: 950px;
            width: 100%;
            overflow: hidden;
            box-shadow: 0 50px 100px rgba(0, 0, 0, 0.4);
            animation: popUp 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: row;
            max-height: 85vh;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        @keyframes popUp {
            0% {
                transform: scale(0.8) translateY(60px);
                opacity: 0;
            }

            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .pm-img-wrap {
            width: 45%;
            position: relative;
            background: white;
            padding: 20px;
        }

        .pm-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .pm-close {
            position: absolute;
            top: 25px;
            left: 25px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brown-deep);
            font-size: 1.3rem;
            cursor: pointer;
            transition: all 0.4s;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            z-index: 10;
        }

        .pm-close:hover {
            background: #ef4444;
            color: white;
            transform: rotate(90deg) scale(1.15);
        }

        .pm-body {
            width: 55%;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            background: var(--cream-light);
        }

        .pm-title {
            font-size: 3rem;
            color: var(--brown-deep);
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.1;
            letter-spacing: -1px;
        }

        .pm-price {
            font-family: 'Fredoka', sans-serif;
            font-size: 2.5rem;
            color: var(--honey-orange);
            font-weight: 800;
            margin-bottom: 25px;
            display: block;
        }

        .pm-desc {
            color: var(--brown-soft);
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 40px;
            flex-grow: 1;
        }

        .pm-actions {
            display: flex;
            gap: 20px;
        }

        .pm-btn-cart {
            flex: 1;
            padding: 20px 30px;
            background: linear-gradient(135deg, var(--honey-orange), var(--amber-gold));
            color: white;
            border: none;
            border-radius: 50px;
            font-family: 'Fredoka', sans-serif;
            font-size: 1.3rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 20px 40px rgba(242, 101, 34, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .pm-btn-cart:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(242, 101, 34, 0.5);
        }

        .pm-btn-fav {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: white;
            border: 2px solid #e5e7eb;
            color: #d1d5db;
            font-size: 1.6rem;
            cursor: pointer;
            transition: all 0.4s;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
        }

        .pm-btn-fav:hover {
            border-color: #ef4444;
            color: #ef4444;
            transform: scale(1.15);
        }

        .pm-btn-fav.favorited {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #ef4444;
        }

        /* === FOOTER === */
        footer {
            background: #2A170D;
            color: var(--cream-light);
            position: relative;
            padding-top: 100px;
            padding-bottom: 30px;
            overflow: hidden;
        }

        .footer-wave {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .footer-wave svg {
            display: block;
            width: calc(100% + 1.3px);
            height: 60px;
        }

        .footer-wave .shape-fill {
            fill: var(--cream-warm);
        }

        .footer-brand h3 {
            font-size: 2.8rem;
            color: var(--amber-gold);
            margin-bottom: 20px;
            font-weight: 800;
            font-family: 'Fredoka', sans-serif;
        }

        .footer-text {
            font-size: 1.1rem;
            opacity: 0.8;
            line-height: 1.8;
            margin-bottom: 30px;
            color: #E8DCC4;
        }

        .footer-heading {
            font-size: 1.5rem;
            color: white;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
            font-family: 'Fredoka', sans-serif;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 40px;
            height: 4px;
            background: var(--honey-orange);
            border-radius: 10px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: #D1BFAe;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .footer-links a:hover {
            color: var(--amber-gold);
            transform: translateX(10px);
        }

        .social-circle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            color: var(--amber-gold);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            transition: all 0.4s;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-right: 15px;
            text-decoration: none;
        }

        .social-circle:hover {
            background: var(--honey-orange);
            color: white;
            transform: translateY(-8px) scale(1.1);
            border-color: var(--honey-orange);
            box-shadow: 0 15px 30px rgba(242, 101, 34, 0.4);
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 60px;
            padding-top: 30px;
            text-align: center;
            color: #8C7A6B;
            font-size: 1rem;
        }

        @media (max-width: 991px) {
            .navbar-collapse {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border-radius: 20px;
                padding: 20px;
                margin-top: 15px;
                border: 1px solid rgba(61, 35, 20, 0.1);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }

            .hero-section {
                text-align: center;
                padding-top: 180px;
            }

            .hero-badge {
                margin: 0 auto 30px;
            }

            .hero-desc {
                margin: 0 auto 40px;
            }

            .floating-price-tag {
                bottom: 0;
                right: 10%;
            }

            .special-card {
                flex-direction: column;
                text-align: center;
            }

            .special-content {
                max-width: 100%;
                margin-bottom: 30px;
            }

            .bento-col-8,
            .bento-col-4 {
                grid-column: span 12;
            }

            .mag-stacked-wrapper {
                height: 400px;
                margin-bottom: 50px;
            }

            .mag-content {
                padding-left: 0;
                text-align: center;
            }

            .match-display {
                flex-direction: column;
            }

            .match-img-wrap,
            .match-bars {
                width: 100%;
            }

            .pm-card {
                flex-direction: column;
                max-height: 90vh;
                overflow-y: auto;
            }

            .pm-img-wrap,
            .pm-body {
                width: 100%;
            }

            .pm-img-wrap {
                height: 300px;
                flex-shrink: 0;
                padding: 0;
            }

            .pm-img-wrap img {
                border-radius: 0;
            }

            .pm-close {
                left: auto;
                right: 20px;
                background: rgba(255, 255, 255, 0.8);
            }
        }

        /* --- REDESAIN TOMBOL LIHAT MENU PREMIUM --- */
.btn-outline-bakery {
    border: 2px solid var(--brown-soft);
    color: var(--brown-soft) !important;
    background: transparent;
    border-radius: 50px;
    font-family: 'Fredoka', sans-serif;
    font-weight: 700;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

/* Efek Hover Membal dan Mengisi Warna */
.btn-outline-bakery:hover {
    background: var(--brown-deep);
    color: var(--amber-gold) !important;
    border-color: var(--brown-deep);
    transform: translateY(-4px);
    box-shadow: 0 10px 25px rgba(61, 35, 20, 0.15);
}

/* Animasi Anak Panah Meluncur ke Kanan */
.transition-arrow {
    transition: transform 0.3s ease, color 0.3s ease;
    color: var(--honey-orange);
}

.btn-outline-bakery:hover .transition-arrow {
    transform: translateX(6px);
    color: var(--amber-gold);
}

    </style>
</head>

<body>

    <!-- Preloader -->
    <div id="preloader">
        <i class="fas fa-cookie-bite loader-bowl"></i>
        <div class="loader-shadow"></div>
        <h3 class="mt-4 font-display" style="color: var(--brown-deep); letter-spacing: 2px;">Memanggang...</h3>
    </div>

    <!-- Scroll Progress Bar -->
    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container nav-glass">
            <a class="navbar-brand d-flex align-items-center gap-3" href="#">
                <div class="logo-wrapper">
                    <img src="{{ asset('img/thecookies.png') }}" alt="Logo" class="logo-img">
                </div>
                <span class="d-none d-sm-block font-display"
                    style="font-weight: 800; font-size: 1.5rem; color: var(--brown-deep); letter-spacing: 0.5px;">Tho<span
                        style="color: var(--honey-orange);">Cookies</span></span>
            </a>
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <i class="fas fa-bars fs-2 text-brown"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link active-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Keunggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#profile">Kisah Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#menu">Menu Spesial</a></li>
                </ul>
                <div class="nav-actions mt-3 mt-lg-0 d-flex justify-content-center align-items-center gap-3">
                    {{-- Wishlist Icon (Dipertahankan logic ID-nya) --}}
                    <a href="{{ route('cart.index') }}?tab=favorites" class="btn-wishlist-nav" id="wishlist-nav-btn"
                        title="Produk Disukai">
                        <i class="fas fa-heart"></i>
                        <span id="wishlist-badge" class="wishlist-badge" style="display:none;">0</span>
                    </a>

                    @guest
                        <a href="{{ route('login') }}" class="btn btn-user hover-bouncy">
                            <i class="fas fa-user-circle me-2"></i> Masuk
                        </a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-user btn-profile dropdown-toggle hover-bouncy" type="button"
                                data-bs-toggle="dropdown">
                                Hi, {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-3 glass-premium">
                                @if (Auth::user()->role->name == 'admin')
                                    <li><a class="dropdown-item rounded-3 py-2 fw-medium"
                                            href="{{ route('admin.dashboard') }}"><i
                                                class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard</a></li>
                                @elseif(Auth::user()->role->name == 'kasir')
                                    <li><a class="dropdown-item rounded-3 py-2 fw-medium"
                                            href="{{ route('kasir.dashboard') }}"><i
                                                class="fas fa-cash-register me-2 text-success"></i> Kasir</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item rounded-3 text-danger fw-bold py-2"><i
                                                class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <!-- Kiri: Teks -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200">
                    <div class="hero-badge">
                        <i class="fas fa-fire text-orange" style="color:var(--honey-orange)"></i> Freshly Baked Everyday
                    </div>

                    <h1 class="hero-title">
                        Karya Seni di Setiap <br>
                        <span class="text-gradient">Gigitan Manis!</span>
                        <span class="hero-title-stroke">Tho Cookies</span>
                    </h1>

                    <p class="hero-desc">
                        Nikmati sensasi premium soft cookies kami yang renyah di pinggir, lumer di tengah. Harmoni rasa
                        sempurna untuk disandingkan dengan segelas susu segar pilihan.
                    </p>

                    <div class="d-flex gap-4 flex-wrap justify-content-md-start justify-content-center align-items-center">
    <a href="#menu" class="btn btn-user hover-bouncy px-5 py-3 fs-5">
        <i class="fas fa-shopping-bag me-2"></i> Pesan Sekarang
    </a>
    <a href="#menu" class="btn btn-outline-bakery px-5 py-3 fs-5">
        Lihat Menu <i class="fas fa-arrow-right ms-2 transition-arrow"></i>
    </a>
</div>
                </div>

                <!-- Kanan: Visual 3D Premium Frame -->
                <div class="col-lg-6 mt-5 mt-lg-0" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="200">
                    <div class="hero-visuals">
                        <div class="hero-glow"></div>

                        <!-- BINGKAI FOTO PREMIUM -->
                        <div class="hero-image-frame">
                            <!-- Pita Perekat Khas Toko Roti -->
                            <div class="bakery-tape">
                                <i class="fas fa-certificate me-1"></i> Original
                            </div>

                            <img src="{{ asset('img/cookies_hero.png') }}" alt="Tho Cookies Premium"
                                class="hero-main-img"
                                onerror="this.src='https://images.unsplash.com/photo-1499636136210-6f4ee915583e?auto=format&fit=crop&w=600&q=80'">
                        </div>

                        <!-- Floating Price Tag (Overlapping Bingkai Baru) -->
                        <div class="floating-price-tag">
                            <div class="tag-icon"
                                style="width:55px;height:55px;background:var(--amber-gold);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.6rem;color:var(--brown-deep)">
                                <i class="fas fa-cookie"></i>
                            </div>
                            <div style="display:flex;flex-direction:column;font-family:'Fredoka',sans-serif">
                                <span
                                    style="font-size:0.9rem;color:var(--brown-soft);font-weight:700;text-transform:uppercase;">Best
                                    Seller</span>
                                <span
                                    style="font-size:1.8rem;color:var(--honey-orange);font-weight:800;line-height:1;">Premium</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BAKER'S DAILY SPECIAL (FITUR BARU) -->
    <section class="daily-special-section container" data-aos="fade-up" data-aos-offset="-50">
        <div class="special-card">
            <div class="special-content">
                <div class="section-badge"
                    style="background: rgba(255,255,255,0.2); color: white; border:1px solid rgba(255,255,255,0.3); margin-bottom: 20px;">
                    <i class="fas fa-star me-2 text-warning"></i> Baker's Daily Special
                </div>
                <h2
                    style="font-family:'Fredoka',sans-serif; font-size: 3rem; font-weight:800; margin-bottom: 15px; line-height: 1.1;">
                    Ultimate <span style="color:var(--amber-gold)">Triple Choco</span> Melt</h2>
                <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 0;">Produk super eksklusif dipanggang
                    terbatas hari ini. Cokelat lumer 3 lapis yang siap meleleh di mulut Anda. Jangan sampai kehabisan!
                </p>

                <div class="timer-box" id="countdown-timer">
                    <div class="time-block"><span class="num" id="cd-hrs">00</span><span
                            class="lbl">Jam</span></div>
                    <div class="time-colon">:</div>
                    <div class="time-block"><span class="num" id="cd-min">00</span><span
                            class="lbl">Menit</span></div>
                    <div class="time-colon">:</div>
                    <div class="time-block"><span class="num" id="cd-sec">00</span><span
                            class="lbl">Detik</span></div>
                </div>
            </div>
            <div style="position:relative; z-index:2;">
                <a href="#menu" class="btn btn-light rounded-pill px-5 py-3 fw-bold shadow-lg hover-bouncy"
                    style="font-family:'Fredoka',sans-serif; font-size:1.2rem; color:var(--brown-deep);">
                    Amankan Sekarang <i class="fas fa-shopping-cart ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- MARQUEE -->
    <div class="marquee-section">
        <div class="marquee-content">
            <span class="marquee-item"><i class="fas fa-certificate"></i> 100% Cokelat Belgia Asli</span>
            <span class="marquee-item"><i class="fas fa-heart"></i> Dipanggang Penuh Cinta</span>
            <span class="marquee-item"><i class="fas fa-cookie-bite"></i> Renyah Diluar Lumer Didalam</span>
            <span class="marquee-item"><i class="fas fa-glass-water"></i> Susu Murni Grade A</span>
            <span class="marquee-item"><i class="fas fa-certificate"></i> 100% Cokelat Belgia Asli</span>
            <span class="marquee-item"><i class="fas fa-heart"></i> Dipanggang Penuh Cinta</span>
            <span class="marquee-item"><i class="fas fa-cookie-bite"></i> Renyah Diluar Lumer Didalam</span>
            <span class="marquee-item"><i class="fas fa-glass-water"></i> Susu Murni Grade A</span>
        </div>
    </div>

    <!-- BENTO BOX FEATURES (ASYMMETRIC GRID) -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="section-badge"><i class="fas fa-gem me-2"></i> Kualitas Bintang Lima</div>
                <h2 class="section-title">Kenapa Harus <span class="text-gradient">Tho Cookies?</span></h2>
            </div>

            <div class="bento-grid">
                <!-- Large Card 1 -->
                <div class="bento-item bento-col-8 bento-row-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bento-icon icon-honey"><i class="fas fa-medal"></i></div>
                    <h3 style="font-size: 2.5rem;">Bahan Premium Kelas Atas</h3>
                    <p style="font-size: 1.2rem;">Kami tidak pernah kompromi soal rasa. Menggunakan 100% Cokelat Belgia
                        asli, mentega premium terbaik, dan racikan resep rahasia untuk menciptakan keseimbangan rasa
                        manis elegan tanpa membuat eneg di setiap gigitan.</p>
                </div>

                <!-- Small Card 1 -->
                <div class="bento-item bento-col-4"
                    style="background: linear-gradient(135deg, var(--amber-gold) 0%, var(--honey-orange) 100%);"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="bento-icon bg-white text-warning" style="color:var(--honey-orange)!important"><i
                            class="fas fa-fire-burner"></i></div>
                    <h3 class="text-white">Freshly Baked</h3>
                    <p class="text-white" style="opacity: 0.9;">Dipanggang <i>Made to Order</i>. Selalu hangat,
                        renyah, dan harum saat tiba.</p>
                </div>

                <!-- Small Card 2 -->
                <div class="bento-item bento-col-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="bento-icon icon-cocoa"><i class="fas fa-glass-water"></i></div>
                    <h3>Perfect Combo</h3>
                    <p>Paling nikmat disandingkan dengan aneka susu segar murni kami.</p>
                </div>

                <!-- Wide Banner -->
                <div class="bento-item bento-col-12"
                    style="background: var(--brown-deep); border-color:var(--brown-soft); display:flex; flex-direction:row; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:20px; padding:30px 50px;"
                    data-aos="fade-up" data-aos-delay="400">
                    <div>
                        <h3 class="text-white m-0" style="font-size: 2.2rem;">Harga Kaki Lima, Kualitas Hotel Bintang
                            5</h3>
                        <p style="color:#D1BFAe; margin-top:10px;">Kemewahan kuliner yang dapat dinikmati siapa saja.
                        </p>
                    </div>
                    <a href="#menu" class="btn bg-white hover-bouncy px-5 py-3 rounded-pill fw-bold"
                        style="color:var(--brown-deep); font-family:'Fredoka',sans-serif; font-size:1.1rem;">Buktikan
                        Sendiri</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT: MAGAZINE LAYOUT WITH BOUNCY STACKED IMAGES -->
    <section id="profile" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1200">
                    <div class="mag-stacked-wrapper">
                        <!-- Image 1 (Back) -->
                        <img src="https://images.unsplash.com/photo-1558961363-fa8fdf82db35?auto=format&fit=crop&w=600&q=80"
                            alt="Cookie Making" class="mag-img img-back">
                        <!-- Image 2 (Front) -->
                        <img src="{{ asset('img/milk_hero.png') }}" alt="Susu Segar Tho Cookies"
                            class="mag-img img-front"
                            onerror="this.src='https://images.unsplash.com/photo-1757451628318-af04456154e7?w=700&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MzJ8fHBob3RvJTIwY29va2llc3xlbnwwfHwwfHx8MA%3D%3D'">

                        <!-- Floating Badge -->
                        <div
                            style="position:absolute; top: 10%; left: 0%; width:130px; height:130px; background:var(--honey-orange); border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; color:white; border: 6px solid white; box-shadow: 0 15px 30px rgba(242,101,34,0.4); z-index:5; transform:rotate(-15deg);">
                            <span
                                style="font-family:'Fredoka',sans-serif; font-size:2.5rem; font-weight:800; line-height:1;">#1</span>
                            <span
                                style="font-weight:700; font-size:0.85rem; letter-spacing:1px; text-transform:uppercase;">Taste</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1200">
                    <div class="mag-content">
                        <div class="section-badge"
                            style="background: transparent; color: var(--brown-deep); border-color: var(--brown-soft);">
                            <i class="fas fa-book-open me-2"></i> Kisah Kami
                        </div>
                        <h2 class="mag-title">Mahakarya <span class="text-gradient">Rasa & Tradisi.</span></h2>
                        <p style="font-size: 1.15rem; color: var(--brown-soft); line-height: 1.8;">
                            Berawal dari resep rahasia keluarga, <strong>Tho Cookies</strong> menjelma menjadi standar
                            emas pastry lokal. Tujuan kami bukan sekadar menjual kue, melainkan menghadirkan kepingan
                            kebahagiaan yang mampu mengembalikan *mood* terbaik Anda dalam sekejap.
                        </p>

                        <div class="stats-grid">
                            <div class="stat-box">
                                <h4>100<span style="font-size: 1.5rem;">%</span></h4>
                                <p>Bahan Alami</p>
                            </div>
                            <div class="stat-box">
                                <h4>5<span style="font-size: 1.5rem;">k+</span></h4>
                                <p>Happy Tummy</p>
                            </div>
                            <div class="stat-box">
                                <h4>4.9</h4>
                                <p>Rating Publik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GOURMET MATCHMAKER (FITUR BARU INTERAKTIF) -->
    <section class="matchmaker-section container" data-aos="fade-up">
        <div class="text-center mb-5">
            <h2 class="section-title">Gourmet <span class="text-gradient">Matchmaker</span></h2>
            <p style="font-size: 1.1rem; color: var(--brown-soft);">Temukan pasangan minuman paling sempurna untuk
                varian cookies favoritmu.</p>
        </div>

        <div class="match-glass-panel">
            <div class="row align-items-center">

                <!-- Kolom Kiri: Pilihan Kategori (col-lg-4) -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="match-tabs" id="match-tabs">
                        <button class="match-tab-btn active" onclick="updateMatch('choco', this)">
                            <span>🍪 Classic Choco</span>
                            <i class="fas fa-chevron-right fs-6 text-muted"></i>
                        </button>
                        <button class="match-tab-btn" onclick="updateMatch('redvelvet', this)">
                            <span>🧁 Red Velvet Cookies</span>
                            <i class="fas fa-chevron-right fs-6 text-muted"></i>
                        </button>
                        <button class="match-tab-btn" onclick="updateMatch('vanilla', this)">
                            <span>🍦 Vanilla Cream Cookies</span>
                            <i class="fas fa-chevron-right fs-6 text-muted"></i>
                        </button>
                    </div>
                </div>

                <!-- Kolom Kanan: Pratinjau Kategori (col-lg-8) - KODE BARU DENGAN BUNGKUS GRID & CLOSE TAG YANG PRESISE -->
                <div class="col-lg-8">
                    <div class="match-display shadow-sm" id="match-display-area">
                        <div class="match-img-wrap">
                            <img id="match-img" src="{{ asset('img/classicchoco.jpg') }}" alt="Classic Choco">
                        </div>
                        <div class="match-bars">
                            <h4
                                style="font-family:'Fredoka',sans-serif; font-weight:800; color:var(--brown-deep); margin-bottom: 5px;">
                                Varian Menu:</h4>
                            <h3 id="match-title" class="text-gradient"
                                style="font-family:'Fredoka',sans-serif; font-weight:800; font-size:2rem; margin-bottom: 20px;">
                                Classic Choco</h3>

                            <div class="m-bar-group">
                                <div class="m-bar-label"><span>Sweetness Level</span> <span id="val-sweet">85%</span>
                                </div>
                                <div class="m-bar-track">
                                    <div class="m-bar-fill" id="bar-sweet" style="width: 85%;"></div>
                                </div>
                            </div>
                            <div class="m-bar-group">
                                <div class="m-bar-label"><span>Creaminess</span> <span id="val-cream">95%</span></div>
                                <div class="m-bar-track">
                                    <div class="m-bar-fill" id="bar-cream" style="width: 95%;"></div>
                                </div>
                            </div>
                            <div class="m-bar-group">
                                <div class="m-bar-label"><span>Flavor Harmony</span> <span id="val-harm">100%</span>
                                </div>
                                <div class="m-bar-track">
                                    <div class="m-bar-fill" id="bar-harm" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> {{-- Penutup col-lg-8 --}}

            </div> {{-- Penutup row --}}
        </div> {{-- Penutup match-glass-panel --}}
    </section>

    <!-- PREMIUM MENU SECTION -->
    <section id="menu" class="menu-section">
        <div class="container">
            <div class="text-center mb-5" data-aos="zoom-in">
                <div class="section-badge"><i class="fas fa-crown me-2"></i> Signature Collection</div>
                <h2 class="section-title">Pilih Rasa <span class="text-gradient">Favoritmu!</span></h2>
                <p class="mt-3 text-brown-soft mx-auto" style="max-width: 600px; font-size: 1.15rem;">
                    Koleksi mahakarya pastry kami. Setiap gigitan menjanjikan petualangan rasa yang tak terlupakan.
                </p>
            </div>

            <div class="row g-5">
                <!-- Logika Laravel Dipertahankan 100% -->
                @forelse ($products as $index => $product)
                    @php
                        $imgSrc = $product->image
                            ? asset('storage/' . $product->image)
                            : 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&w=500&q=80';
                        $desc =
                            $product->description ??
                            'Perpaduan rasa manis elegan dan tekstur memanjakan yang sempurna untuk menemanimu.';
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up"
                        data-aos-delay="{{ 100 + $index * 50 }}">

                        <!-- Redesain Product Card -->
                        <div class="product-card">

                            <!-- Area Gambar: Mempertahankan onclick Modal original -->
                            <div class="pc-img-wrap"
                                onclick="openProductModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($desc) }}', '{{ $imgSrc }}', {{ $product->stock }})">

                                @if ($product->stock < 20 && $product->stock > 0)
                                    <span class="badge-stock low"><i class="fas fa-fire me-1"></i> Sisa
                                        {{ $product->stock }}</span>
                                @else
                                    <span class="badge-stock">Stok: {{ $product->stock }}</span>
                                @endif

                                <!-- Tombol Favorit: Mempertahankan ID dan fungsi JS original -->
                                <button type="button" class="btn-heart-card" id="heart-card-{{ $product->id }}"
                                    onclick="event.stopPropagation(); toggleFavorite({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($desc) }}', '{{ $imgSrc }}')"
                                    title="Tambah ke Favorit">
                                    <i class="fas fa-heart"></i>
                                </button>

                                @if ($product->stock <= 0)
                                    <div class="sold-out-overlay">
                                        <div class="sold-out-badge">SOLD OUT</div>
                                    </div>
                                @endif

                                <img src="{{ $imgSrc }}" alt="{{ $product->name }}">
                            </div>

                            <div class="pc-content">
                                <h3 class="pc-title">{{ $product->name }}</h3>
                                <div class="pc-rating">
                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i><i class="fas fa-star"></i><i
                                        class="fas fa-star"></i>
                                    <span
                                        style="color: var(--brown-soft); margin-left: 5px; font-weight: 600;">(5.0)</span>
                                </div>
                                <p class="pc-desc">{{ Str::limit($desc, 80) }}</p>

                                <div class="pc-footer">
                                    <span class="pc-price">Rp{{ number_format($product->price, 0, ',', '.') }}</span>

                                    <!-- Form Keranjang: Dipertahankan -->
                                    @if ($product->stock > 0)
                                        <form action="{{ route('cart.add') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="btn-add-cart" title="Tambah ke Keranjang">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn-add-cart"
                                            style="background: #e5e7eb; color: #9ca3af; box-shadow: none; cursor: not-allowed;"
                                            onclick="alert('Maaf, stok {{ $product->name }} sedang habis!')">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="col-12 text-center py-5" data-aos="fade-in">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-lg"
                            style="width: 140px; height: 140px; margin-bottom: 25px; border: 4px solid var(--cream-warm);">
                            <i class="fas fa-cookie-bite fa-4x text-muted" style="opacity: 0.3;"></i>
                        </div>
                        <h3 class="font-display fw-bold" style="color:var(--brown-deep); font-size:2.5rem;">Menu Belum Tersedia.... </table></h3>
                        <p class="text-muted fs-5">Koki kami sedang meracik resep rahasia baru. Silakan kembali lagi
                            nanti!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- LUXURY MODAL (DIRE-STYLING, ID & LOGIC TETAP) -->
    <div id="product-modal-overlay" onclick="closeProductModal(event)">
        <div class="pm-card" id="product-modal-card" onclick="event.stopPropagation()">
            <!-- Tombol Tutup: Mempertahankan closeModal() -->
            <button class="pm-close" onclick="closeModal()" title="Tutup">
                <i class="fas fa-times"></i>
            </button>

            <div class="pm-img-wrap">
                <img id="pm-img" src="" alt="Product Image">
            </div>

            <div class="pm-body">
                <div class="section-badge"
                    style="background: rgba(242, 101, 34, 0.1); color: var(--honey-orange); padding: 6px 18px; font-size: 0.85rem; border: none; align-self: flex-start; margin-bottom: 20px;">
                    <i class="fas fa-crown me-1"></i> Tho Cookies Signature
                </div>

                <h2 class="pm-title" id="pm-name">Nama Produk</h2>

                <div class="pc-rating mb-4" style="font-size: 1.2rem; color:var(--amber-gold);">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                        class="fas fa-star"></i><i class="fas fa-star"></i>
                    <span style="color: var(--brown-soft); margin-left: 10px; font-weight:600; font-size:1rem;">(150+
                        Ulasan Mewah)</span>
                </div>

                <span class="pm-price" id="pm-price">Rp0</span>
                <p class="pm-desc" id="pm-desc">Deskripsi produk.</p>

                <div class="pm-actions">
                    <!-- Form Tambah Keranjang Modal -->
                    <form id="pm-cart-form" action="{{ route('cart.add') }}" method="POST" style="flex:1;">
                        @csrf
                        <input type="hidden" name="product_id" id="pm-product-id" value="">
                        <button type="submit" class="pm-btn-cart" id="pm-btn-cart">
                            <i class="fas fa-shopping-bag"></i> Tambah ke Laci Belanja
                        </button>
                    </form>

                    <!-- Tombol Favorit Modal: Mempertahankan ID & onclick -->
                    <button type="button" class="pm-btn-fav" id="pm-btn-fav" onclick="toggleFavoriteFromModal()"
                        title="Simpan ke Favorit">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- LUXURY FOOTER -->
    <footer id="lokasi">
        <div class="footer-wave">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                preserveAspectRatio="none">
                <path
                    d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"
                    class="shape-fill"></path>
            </svg>
        </div>

        <div class="container">
            <div class="row g-5">
                <!-- Kolom 1 -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-white p-2 rounded-circle" style="box-shadow: 0 0 20px rgba(255,179,0,0.3);">
                            <img src="{{ asset('img/thecookies.png') }}" width="60" alt="Logo Footer">
                        </div>
                        <h3 class="m-0 footer-brand" style="color:var(--amber-gold); font-size:2.2rem;">Tho Cookies
                        </h3>
                    </div>
                    <p class="footer-text">Butik kue kering premium kelas dunia. Menghadirkan simfoni rasa manis elegan
                        dan susu murni segar untuk menyempurnakan setiap momen berhargamu.</p>
                    <div class="d-flex mt-4">
                        <a href="https://www.instagram.com/dzuubyaa._?igsh=MTFqcW4xM3c1aGx5aQ=="
                            class="social-circle"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/6289604441762" class="social-circle"><i
                                class="fab fa-whatsapp"></i></a>
                        <a href="https://www.tiktok.com/@dzuubyaa._" class="social-circle"><i
                                class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- Kolom 2 -->
                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="footer-heading">Navigasi</h5>
                    <ul class="footer-links">
                        <li><a href="#home"><i class="fas fa-angle-right text-orange"
                                    style="color:var(--honey-orange)"></i> Beranda</a></li>
                        <li><a href="#features"><i class="fas fa-angle-right text-orange"
                                    style="color:var(--honey-orange)"></i> Keunggulan</a></li>
                        <li><a href="#profile"><i class="fas fa-angle-right text-orange"
                                    style="color:var(--honey-orange)"></i> Kisah Kami</a></li>
                        <li><a href="#menu"><i class="fas fa-angle-right text-orange"
                                    style="color:var(--honey-orange)"></i> Menu Spesial</a></li>
                    </ul>
                </div>

                <!-- Kolom 3 -->
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <h5 class="footer-heading">Kunjungi Kami</h5>
                    <ul class="footer-links">
                        <li><a href="https://www.tiktok.com/@dzuubyaa._"><i
                                    class="fas fa-map-marker-alt text-orange me-2"
                                    style="color:var(--honey-orange)"></i> Jl. Manis Legit No. 99, Kuliner</a></li>
                        <li><a href="https://wa.me/6289604441762"><i class="fas fa-phone-alt text-orange me-2"
                                    style="color:var(--honey-orange)"></i> +62 896-0444-1762</a></li>
                        <li><a href="mailto:hello@thocookies.com"><i class="fas fa-envelope text-orange me-2"
                                    style="color:var(--honey-orange)"></i> hello@thocookies.com</a></li>
                    </ul>
                    <div class="mt-4 d-inline-block bg-white text-brown px-4 py-2 rounded-pill fw-bold"
                        style="font-family: 'Fredoka', sans-serif; color:var(--brown-deep);">
                        <i class="far fa-clock me-2" style="color:var(--honey-orange)"></i> Buka: 10.00 - 22.00
                    </div>
                </div>

                <!-- Kolom 4 -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <h5 class="footer-heading">VIP Club</h5>
                    <p class="footer-text mb-3" style="font-size: 0.95rem;">Jadilah yang pertama tahu menu rahasia
                        kami.</p>
                    <form action="#">
                        <div class="input-group"
                            style="background: rgba(255,255,255,0.08); padding: 6px; border-radius: 50px; border: 1px solid rgba(255,255,255,0.15);">
                            <input type="email"
                                class="form-control border-0 bg-transparent text-white shadow-none ps-3"
                                placeholder="Email Anda..." required>
                            <button class="btn btn-user py-2 px-4 m-0" type="button"
                                style="transform: none; box-shadow: none; border-radius:40px;"><i
                                    class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="copyright d-flex flex-column flex-md-row justify-content-between align-items-center">
                <div>&copy; {{ date('Y') }} <strong>Tho Cookies Premium</strong></div>
                <div class="mt-3 mt-md-0">
                    <a href="#" class="text-white-50 text-decoration-none me-3 hover-text-white">Privacy
                        Policy</a>
                    <a href="#" class="text-white-50 text-decoration-none hover-text-white">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS Init
        AOS.init({
            duration: 1000,
            once: true,
            offset: 50
        });

        // Preloader
        window.addEventListener("load", function() {
            const preloader = document.getElementById("preloader");
            preloader.style.opacity = "0";
            setTimeout(() => preloader.style.display = "none", 500);
        });

        // Scroll Progress & Navbar Sticky Glass
        window.addEventListener('scroll', function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            document.getElementById("myBar").style.width = scrolled + "%";

            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');

            const sections = document.querySelectorAll("section");
            const navLi = document.querySelectorAll(".navbar-nav .nav-link");
            let current = "";
            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                if (pageYOffset >= sectionTop - 200) current = section.getAttribute("id");
            });
            navLi.forEach((li) => {
                li.classList.remove("active-link");
                if (li.getAttribute("href").includes(current)) li.classList.add("active-link");
            });
        });

        // ═══════════════════════════════════════════
        //   [NEW FITUR] BAKER'S DAILY COUNTDOWN TIMER
        // ═══════════════════════════════════════════
        function initCountdown() {
            // Set 1 Jam 45 Menit 12 Detik ke depan dari saat diload
            let targetTime = new Date().getTime() + (1 * 60 * 60 * 1000) + (45 * 60 * 1000) + (12 * 1000);

            let timerInterval = setInterval(function() {
                let now = new Date().getTime();
                let distance = targetTime - now;

                if (distance < 0) {
                    clearInterval(timerInterval);
                    document.getElementById("cd-hrs").innerText = "00";
                    document.getElementById("cd-min").innerText = "00";
                    document.getElementById("cd-sec").innerText = "00";
                    return;
                }

                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("cd-hrs").innerText = hours.toString().padStart(2, '0');
                document.getElementById("cd-min").innerText = minutes.toString().padStart(2, '0');
                document.getElementById("cd-sec").innerText = seconds.toString().padStart(2, '0');
            }, 1000);
        }
        initCountdown();

        // ═══════════════════════════════════════════
        //   [NEW FITUR] GOURMET MATCHMAKER
        // ═══════════════════════════════════════════
        const matchData = {
            'choco': {
                img: '{{ asset('img/classicchoco.jpg') }}',
                title: 'Classic Choco',
                s: '85%',
                c: '95%',
                h: '100%'
            },
            'redvelvet': {
                img: '{{ asset('img/redvelvetcookies.jpg') }}',
                title: 'Red Velvet Cookies',
                s: '90%',
                c: '85%',
                h: '95%'
            },
            'vanilla': { // Kunci diubah menjadi vanilla
                img: '{{ asset('img/vanillacreamcookies.jpg') }}',
                title: 'Vanilla Cream Cookies',
                s: '75%',
                c: '80%',
                h: '98%'
            }
        };

        function updateMatch(type, btnObj) {
            // Update Active Tab
            document.querySelectorAll('.match-tab-btn').forEach(btn => btn.classList.remove('active'));
            btnObj.classList.add('active');

            // Fade Out Area
            const displayArea = document.getElementById('match-display-area');
            displayArea.style.opacity = '0.4';
            displayArea.style.transform = 'scale(0.98)';

            setTimeout(() => {
                const data = matchData[type];
                document.getElementById('match-img').src = data.img;
                document.getElementById('match-title').innerText = data.title;

                // Update Bars
                document.getElementById('val-sweet').innerText = data.s;
                document.getElementById('bar-sweet').style.width = data.s;
                document.getElementById('val-cream').innerText = data.c;
                document.getElementById('bar-cream').style.width = data.c;
                document.getElementById('val-harm').innerText = data.h;
                document.getElementById('bar-harm').style.width = data.h;

                // Fade In Area
                displayArea.style.opacity = '1';
                displayArea.style.transform = 'scale(1)';
            }, 250);
        }


        // ═══════════════════════════════════════════════════════
        //   FAVORITES — localStorage Logic (ASLI/DIKUNCI)
        // ═══════════════════════════════════════════════════════
        const FAV_KEY = 'jagoanmie_favorites';

        function getFavorites() {
            try {
                return JSON.parse(localStorage.getItem(FAV_KEY) || '[]');
            } catch (e) {
                return [];
            }
        }

        function saveFavorites(favs) {
            localStorage.setItem(FAV_KEY, JSON.stringify(favs));
        }

        function isFavorited(id) {
            return getFavorites().some(f => f.id == id);
        }

        function toggleFavorite(id, name, price, desc, image) {
            let favs = getFavorites();
            const idx = favs.findIndex(f => f.id == id);
            if (idx >= 0) {
                favs.splice(idx, 1);
            } else {
                favs.push({
                    id,
                    name,
                    price,
                    desc,
                    image
                });
            }
            saveFavorites(favs);
            updateHeartUI(id);
            updateWishlistBadge();

            const pmFav = document.getElementById('pm-btn-fav');
            if (pmFav && pmFav.dataset.productId == id) {
                pmFav.classList.toggle('favorited', isFavorited(id));
            }
        }

        function updateHeartUI(id) {
            const btn = document.getElementById('heart-card-' + id);
            if (btn) btn.classList.toggle('favorited', isFavorited(id));
        }

        function updateWishlistBadge() {
            const badge = document.getElementById('wishlist-badge');
            if (!badge) return;
            const count = getFavorites().length;
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        }

        function initFavoriteUI() {
            getFavorites().forEach(f => updateHeartUI(f.id));
            updateWishlistBadge();
        }

        // ═══════════════════════════════════════════════════════
        //   PRODUCT MODAL Logic (ASLI/DIKUNCI)
        // ═══════════════════════════════════════════════════════
        let _currentModalProduct = null;

        function openProductModal(id, name, price, desc, imgSrc, stock) {
            _currentModalProduct = {
                id,
                name,
                price,
                desc,
                imgSrc,
                stock
            };

            document.getElementById('pm-img').src = imgSrc;
            document.getElementById('pm-name').textContent = name;
            document.getElementById('pm-desc').textContent = desc;
            document.getElementById('pm-price').textContent = 'Rp' + price.toLocaleString('id-ID');
            document.getElementById('pm-product-id').value = id;

            const cartBtn = document.getElementById('pm-btn-cart');
            if (stock <= 0) {
                cartBtn.disabled = true;
                cartBtn.style.opacity = '0.5';
                cartBtn.style.cursor = 'not-allowed';
                cartBtn.innerHTML = '<i class="fas fa-times-circle me-2"></i> Stok Habis';
            } else {
                cartBtn.disabled = false;
                cartBtn.style.opacity = '1';
                cartBtn.style.cursor = 'pointer';
                cartBtn.innerHTML = '<i class="fas fa-shopping-bag me-2"></i> Tambah ke Laci Belanja';
            }

            const favBtn = document.getElementById('pm-btn-fav');
            favBtn.dataset.productId = id;
            favBtn.classList.toggle('favorited', isFavorited(id));

            document.getElementById('product-modal-overlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('product-modal-overlay').classList.remove('show');
            document.body.style.overflow = '';
        }

        function closeProductModal(e) {
            if (e.target === document.getElementById('product-modal-overlay')) closeModal();
        }

        function toggleFavoriteFromModal() {
            if (!_currentModalProduct) return;
            const {
                id,
                name,
                price,
                desc,
                imgSrc
            } = _currentModalProduct;
            toggleFavorite(id, name, price, desc, imgSrc);
            const favBtn = document.getElementById('pm-btn-fav');
            favBtn.classList.toggle('favorited', isFavorited(id));
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeModal();
        });
        document.addEventListener('DOMContentLoaded', initFavoriteUI);
    </script>
    <!-- ============================================== -->
    <!-- THOBOT AI WIDGET START                         -->
    <!-- ============================================== -->
    <style>
        .thobot-widget {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            font-family: 'Poppins', sans-serif;
        }

        .thobot-btn {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--honey-orange), var(--amber-gold));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(242, 101, 34, 0.4);
            border: 2px solid white;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            position: relative;
        }

        .thobot-btn::after {
            content: '';
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            border: 2px solid var(--honey-orange);
            opacity: 0;
            animation: pulse-ring 2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.5; }
            100% { transform: scale(1.3); opacity: 0; }
        }

        .thobot-btn:hover {
            transform: scale(1.1) translateY(-5px);
            box-shadow: 0 15px 35px rgba(242, 101, 34, 0.5);
        }

        .thobot-window {
            position: absolute;
            bottom: 85px;
            right: 0;
            width: 350px;
            height: 500px;
            background: rgba(255, 253, 249, 0.9);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(61, 35, 20, 0.15);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px) scale(0.95);
            transform-origin: bottom right;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .thobot-window.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .thobot-header {
            background: linear-gradient(135deg, var(--honey-orange), var(--amber-gold));
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .thobot-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .thobot-avatar {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            position: relative;
        }

        .thobot-status {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 12px;
            height: 12px;
            background: #10B981;
            border: 2px solid white;
            border-radius: 50%;
        }

        .thobot-title {
            line-height: 1.2;
        }

        .thobot-title h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .thobot-title p {
            margin: 0;
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .thobot-close {
            background: rgba(255,255,255,0.2);
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .thobot-close:hover {
            background: rgba(255,255,255,0.4);
            transform: rotate(90deg);
        }

        .thobot-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            scroll-behavior: smooth;
        }

        .thobot-body::-webkit-scrollbar {
            width: 6px;
        }
        .thobot-body::-webkit-scrollbar-thumb {
            background: rgba(61, 35, 20, 0.1);
            border-radius: 10px;
        }

        .msg-bubble {
            max-width: 85%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 0.9rem;
            line-height: 1.5;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .msg-bot {
            background: var(--cream-warm);
            color: var(--brown-deep);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .msg-user {
            background: linear-gradient(135deg, var(--honey-orange), var(--amber-gold));
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 10px rgba(242, 101, 34, 0.2);
        }

        .thobot-footer {
            padding: 15px;
            background: white;
            border-top: 1px solid rgba(0,0,0,0.05);
            display: flex;
            gap: 10px;
        }

        .thobot-input {
            flex: 1;
            border: 1px solid rgba(61, 35, 20, 0.1);
            border-radius: 20px;
            padding: 10px 15px;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            background: #fdfdfd;
            transition: all 0.3s;
        }

        .thobot-input:focus {
            border-color: var(--honey-orange);
            box-shadow: 0 0 0 3px rgba(242, 101, 34, 0.1);
        }

        .thobot-send {
            background: var(--honey-orange);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .thobot-send:hover {
            transform: scale(1.1);
            background: var(--amber-gold);
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 12px 16px;
            background: var(--cream-warm);
            border-radius: 18px;
            border-bottom-left-radius: 4px;
            align-self: flex-start;
            width: fit-content;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            background: var(--honey-orange);
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* Drawer Menu UI */
        .thobot-drawer-btn {
            background: white;
            border-top: 1px solid rgba(0,0,0,0.05);
            padding: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            color: var(--honey-orange);
            font-size: 0.95rem;
            position: relative;
            z-index: 11;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.02);
        }

        .thobot-drawer-btn:hover {
            background: var(--cream-warm);
        }

        .chat-questions-drawer {
            position: absolute;
            bottom: -100%;
            left: 0;
            width: 100%;
            background: rgba(255, 253, 249, 0.95);
            backdrop-filter: blur(20px);
            z-index: 10;
            padding: 20px 20px 75px 20px;
            border-top: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 -10px 30px rgba(61, 35, 20, 0.1);
            transition: bottom 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            max-height: 65%;
            overflow-y: auto;
        }

        .chat-questions-drawer.open {
            bottom: 50px; /* Space for the button itself if we want it to stay, or 0 if it covers */
        }
        
        .chat-questions-drawer.open-full {
            bottom: 0;
            height: auto;
        }

        .chat-questions-drawer::-webkit-scrollbar {
            width: 5px;
        }
        .chat-questions-drawer::-webkit-scrollbar-thumb {
            background: rgba(242, 101, 34, 0.3);
            border-radius: 10px;
        }

        .quick-replies {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
        }

        .qr-btn {
            background: white;
            border: 1px solid rgba(242, 101, 34, 0.2);
            color: var(--brown-deep);
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            text-align: left;
            transition: all 0.2s ease;
            white-space: normal;
            display: flex;
            align-items: center;
            gap: 6px;
            line-height: 1.3;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .qr-btn:hover {
            background: rgba(242, 101, 34, 0.1);
            border-color: var(--honey-orange);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(242, 101, 34, 0.1);
        }

        @media (max-width: 360px) {
            .quick-replies {
                grid-template-columns: 1fr;
            }
        }
        
        /* Drawer Close header */
        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--brown-soft);
        }
        
        .drawer-close-btn {
            background: none;
            border: none;
            color: var(--brown-soft);
            font-size: 1.2rem;
            cursor: pointer;
        }
    </style>

    <div class="thobot-widget">
        <div class="thobot-window" id="thobotWindow">
            <div class="thobot-header">
                <div class="thobot-profile">
                    <div class="thobot-avatar">
                        🐰
                        <div class="thobot-status"></div>
                    </div>
                    <div class="thobot-title">
                        <h4 class="font-display">ThoBot</h4>
                        <p>Your Sweet Assistant</p>
                    </div>
                </div>
                <button class="thobot-close" id="btnThobotClose">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="thobot-body" id="thobotBody">
                <div class="msg-bubble msg-bot">
                    Halo! Saya ThoBot 🐰<br>Silakan pilih pertanyaan dari menu di bawah ini.
                </div>
            </div>

            <!-- Sliding Drawer -->
            <div class="chat-questions-drawer" id="chatDrawer">
                <div class="drawer-header">
                    Pilih Topik:
                    <button class="drawer-close-btn" id="btnCloseDrawer"><i class="fas fa-chevron-down"></i></button>
                </div>
                <div class="quick-replies" id="quickRepliesContainer">
                    <button class="qr-btn" onclick="handleMenuClick('🍪 Varian Best Seller', 'Varian best seller kami adalah <strong>Classic Choco</strong> yang renyah di luar lumer di dalam, serta <strong>Red Velvet</strong> dengan cream cheese premium.')">🍪 Varian Best Seller</button>
                    <button class="qr-btn" onclick="handleMenuClick('💰 Daftar Harga', 'Daftar harga spesial kami:<br>🍪 Classic Choco: Rp 25.450<br>🍰 Red Velvet: Rp 26.300<br>🍦 Vanilla Cream: Rp 26.300<br>🍵 Susu Matcha: Rp 28.000')">💰 Daftar Harga</button>
                    <button class="qr-btn" onclick="handleMenuClick('⏰ Jam Operasional', 'Kami siap melayani Anda setiap hari mulai pukul <strong>10.00 hingga 22.00 WIB</strong>.')">⏰ Jam Operasional</button>
                    <button class="qr-btn" onclick="handleMenuClick('📍 Lokasi & Alamat', 'Temukan kami di <strong>Ruko Premium Boulevard Blok C-10</strong>. Mampir untuk mencium aroma cookies segar dari oven!')">📍 Lokasi & Alamat</button>
                    <button class="qr-btn" onclick="handleMenuClick('🔥 Cara Memanaskan', 'Untuk sensasi lumer maksimal:<br>🔥 <strong>Microwave:</strong> 15-20 detik<br>🔥 <strong>Oven:</strong> 175°C selama 3-5 menit.')">🔥 Cara Memanaskan</button>
                    <button class="qr-btn" onclick="handleMenuClick('🥛 Rekomendasi Susu', 'Pasangan sempurna untuk cookies kami adalah <strong>Susu Matcha Dingin</strong> yang creamy atau <strong>Susu Vanilla Fresh</strong>.')">🥛 Rekomendasi Susu</button>
                    <button class="qr-btn" onclick="handleMenuClick('🛍️ Cara Memesan', 'Pesan langsung di kasir toko kami, atau order praktis melalui layanan antar seperti GoFood dan GrabFood.')">🛍️ Cara Memesan</button>
                    <button class="qr-btn" onclick="handleMenuClick('📦 Info Pengiriman', 'Kami melayani Instant Courier untuk area dalam kota, dan Same Day / Next Day untuk area luar kota dengan kemasan pengiriman ultra-aman.')">📦 Info Pengiriman</button>
                    <button class="qr-btn" onclick="handleMenuClick('🌾 Menu Gluten-Free', 'Saat ini kami masih dalam tahap riset varian gluten-free terbaik. Pantau terus Instagram kami untuk update peluncurannya!')">🌾 Menu Gluten-Free</button>
                    <button class="qr-btn" onclick="handleMenuClick('🎁 Hampers & Kado', 'Tentu! Kami punya paket <em>Gift Box</em> isi 4 dan 6 cookies manis, lengkap dengan pita cantik dan kartu ucapan gratis.')">🎁 Hampers & Kado</button>
                </div>
            </div>

            <!-- Bottom Menu Button -->
            <div class="thobot-drawer-btn" id="btnToggleDrawer">
                <i class="fas fa-bars me-2"></i> Pilih Pertanyaan...
            </div>
        </div>

        <div class="thobot-btn" id="btnThobotToggle">
            <i class="fas fa-comment-dots"></i>
        </div>
    </div>

    <script>
        // ThoBot Menu-Driven Logic
        const thobotToggle = document.getElementById('btnThobotToggle');
        const thobotClose = document.getElementById('btnThobotClose');
        const thobotWindow = document.getElementById('thobotWindow');
        const thobotBody = document.getElementById('thobotBody');
        const chatDrawer = document.getElementById('chatDrawer');
        const btnToggleDrawer = document.getElementById('btnToggleDrawer');
        const btnCloseDrawer = document.getElementById('btnCloseDrawer');

        function toggleChat() {
            thobotWindow.classList.toggle('active');
            if (!thobotWindow.classList.contains('active')) {
                chatDrawer.classList.remove('open-full');
            }
        }

        thobotToggle.addEventListener('click', toggleChat);
        thobotClose.addEventListener('click', toggleChat);

        // Drawer Toggle Logic
        function toggleDrawer() {
            chatDrawer.classList.toggle('open-full');
        }
        
        function closeDrawer() {
            chatDrawer.classList.remove('open-full');
        }

        btnToggleDrawer.addEventListener('click', toggleDrawer);
        btnCloseDrawer.addEventListener('click', closeDrawer);

        function appendMessage(text, isUser = false) {
            const div = document.createElement('div');
            div.className = 'msg-bubble ' + (isUser ? 'msg-user' : 'msg-bot');
            div.innerHTML = text;
            thobotBody.appendChild(div);
            scrollToBottom();
        }

        function showTyping() {
            const div = document.createElement('div');
            div.className = 'typing-indicator';
            div.id = 'typingIndicator';
            div.innerHTML = '<div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>';
            thobotBody.appendChild(div);
            scrollToBottom();
        }

        function removeTyping() {
            const indicator = document.getElementById('typingIndicator');
            if (indicator) indicator.remove();
        }

        function scrollToBottom() {
            thobotBody.scrollTop = thobotBody.scrollHeight;
        }

        // Handle Question Click
        function handleMenuClick(question, answer) {
            // Instantly close the drawer
            closeDrawer();
            
            // Append User Question
            appendMessage(question, true);
            
            // Show realistic typing animation
            showTyping();

            // Fake 800ms delay for realism
            setTimeout(() => {
                removeTyping();
                appendMessage(answer);
            }, 800);
        }
    </script>
    <!-- ============================================== -->
    <!-- THOBOT AI WIDGET END                           -->
    <!-- ============================================== -->

</body>

</html>
