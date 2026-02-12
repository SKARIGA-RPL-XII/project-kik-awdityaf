<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'FitGym' }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
    * {
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 100%);
        color: #fff;
        overflow-x: hidden;
    }

    /* NAVBAR */
    .navbar {
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.95) 0%, rgba(22, 33, 62, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(0, 212, 255, 0.1);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
    }

    .navbar-brand {
        color: #00d4ff !important;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .nav-link {
        color: #aaa !important;
        font-weight: 500;
        transition: all 0.3s ease;
        margin: 0 0.5rem;
    }

    .nav-link:hover {
        color: #00d4ff !important;
        text-shadow: 0 0 10px rgba(0, 212, 255, 0.3);
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #00d4ff 0%, #00b8d4 100%);
        color: #000;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .btn-primary-custom:hover {
        background: linear-gradient(135deg, #00b8d4 0%, #0095a3 100%);
        box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
        color: #000;
    }

    /* HERO SECTION */
    .hero-section {
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.05) 0%, rgba(255, 0, 110, 0.05) 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        padding: 120px 0 60px;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(0, 212, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        top: -100px;
        right: -100px;
        animation: float 6s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 0, 110, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        bottom: 0;
        left: -50px;
        animation: float-reverse 8s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(30px);
        }
    }

    @keyframes float-reverse {

        0%,
        100% {
            transform: translateY(30px);
        }

        50% {
            transform: translateY(0px);
        }
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #00d4ff 0%, #ff006e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1.2;
        margin-bottom: 20px;
        text-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: #aaa;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    /* SECTION TITLES */
    .section-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: #00d4ff;
        margin-bottom: 50px;
        text-shadow: 0 0 20px rgba(0, 212, 255, 0.2);
    }

    /* MEMBERSHIP SECTION */
    #membership {
        padding: 80px 0;
        position: relative;
    }

    .pricing-card {
        background: linear-gradient(135deg, rgba(15, 20, 25, 0.9) 0%, rgba(26, 35, 50, 0.9) 100%);
        border: 2px solid rgba(0, 212, 255, 0.2);
        border-radius: 15px;
        padding: 40px 30px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .pricing-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, #00d4ff, transparent);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .pricing-card:hover {
        border-color: #00d4ff;
        box-shadow: 0 0 30px rgba(0, 212, 255, 0.2), inset 0 0 30px rgba(0, 212, 255, 0.05);
        transform: translateY(-10px);
    }

    .pricing-card:hover::before {
        opacity: 1;
    }

    .pricing-card.featured {
        border-color: #ff006e;
        background: linear-gradient(135deg, rgba(15, 20, 25, 0.95) 0%, rgba(26, 35, 50, 0.95) 100%);
        box-shadow: 0 0 40px rgba(255, 0, 110, 0.2);
    }

    .pricing-card.featured:hover {
        border-color: #ff006e;
        box-shadow: 0 0 50px rgba(255, 0, 110, 0.3), inset 0 0 30px rgba(255, 0, 110, 0.05);
    }

    .pricing-card h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        color: #00d4ff;
    }

    .pricing-card.featured h4 {
        color: #ff006e;
    }

    .pricing-card .price {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 25px 0;
        color: #00d4ff;
    }

    .pricing-card.featured .price {
        color: #ff006e;
    }

    .pricing-card ul li {
        padding: 12px 0;
        border-bottom: 1px solid rgba(0, 212, 255, 0.1);
        font-size: 0.95rem;
        color: #ccc;
    }

    .pricing-card ul li:last-child {
        border-bottom: none;
    }

    .pricing-card ul li i {
        color: #00d4ff;
        margin-right: 10px;
        transition: all 0.3s ease;
    }

    .pricing-card.featured ul li i {
        color: #ff006e;
    }

    /* FOOTER */
    .footer {
        background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 100%);
        border-top: 1px solid rgba(0, 212, 255, 0.1);
        padding: 40px 0;
        margin-top: 80px;
    }

    .footer p {
        color: #aaa;
    }

    /* UTILITIES */
    .btn-outline-light {
        color: #00d4ff;
        border: 2px solid #00d4ff;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background: #00d4ff;
        color: #000;
        box-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
    }

    .text-muted {
        color: #666 !important;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }

    .auth-card {
        width: 100%;
        max-width: 420px;
    }

    .auth-card-large {
        width: 100%;
        max-width: 520px;
    }


    /* RESPONSIVE */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .pricing-card {
            padding: 30px 20px;
        }

        .gym-card {
            background-color: #0f1419;
            border: 1px solid rgba(0, 212, 255, 0.2);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .gym-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(0, 212, 255, 0.8), transparent);
            opacity: 0.8;
        }

        .gym-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 0, 110, 0.6), transparent);
            opacity: 0.6;
        }

        /* Efek hover supaya lebih hidup */
        .gym-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.7), inset 0 0 40px rgba(0, 212, 255, 0.25);
        }

    }
    </style>
</head>

<body>

    <main class="flex-1">
        @yield('content')
    </main>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
    AOS.init({
        duration: 1000,
        once: true
    });
    </script>

</body>

</html>