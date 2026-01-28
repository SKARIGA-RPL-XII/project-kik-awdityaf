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

    {{-- CSS tetap --}}

</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">

            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-dumbbell me-2"></i>FitGym
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#membership">Membership</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>

                    <li class="nav-item ms-3">
                        <a class="btn btn-primary-custom" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section id="home" class="hero-section">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6" data-aos="fade-right">

                    <h1 class="hero-title">
                        Transform Your Body, Transform Your Life
                    </h1>

                    <p class="hero-subtitle">
                        Join FitGym today and discover the best version of yourself.
                    </p>

                    <div class="d-flex gap-3">

                        <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                            Start Your Journey
                        </a>

                        <a href="#membership" class="btn btn-outline-light btn-lg">
                            View Plans
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- MEMBERSHIP -->
    <section id="membership" class="py-5">

        <div class="container">

            <h2 class="section-title text-center">
                Choose Your Plan
            </h2>

            <div class="row justify-content-center">

                {{-- Jika ada data dari controller --}}
                @forelse ($plans as $index => $plan)

                <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index+1)*100 }}">

                    <div class="pricing-card {{ $index == 1 ? 'featured' : '' }}">

                        <h4>{{ $plan->plan_name }}</h4>

                        <div class="price">

                            Rp {{ number_format($plan->price,0,',','.') }}

                            <small class="d-block text-muted">
                                / {{ $plan->duration_months }} month
                            </small>

                        </div>

                        @if($plan->features)

                        <ul class="list-unstyled">

                            @foreach(explode(',', $plan->features) as $feature)

                            <li>
                                <i class="fas fa-check text-success"></i>
                                {{ trim($feature) }}
                            </li>

                            @endforeach

                        </ul>

                        @endif

                        <a href="{{ route('register') }}" class="btn btn-primary-custom w-100 mt-3">
                            Choose Plan
                        </a>

                    </div>

                </div>

                @empty

                {{-- Jika kosong --}}
                <p class="text-center">
                    No plans available.
                </p>

                @endforelse

            </div>

        </div>

    </section>

    <!-- FOOTER -->
    <footer class="footer">

        <div class="container">

            <div class="row">

                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        &copy; {{ date('Y') }} FitGym
                    </p>
                </div>

                <div class="col-md-6 text-end">
                    <a href="{{ route('login') }}" class="btn btn-primary-custom">
                        Member Login
                    </a>
                </div>

            </div>

        </div>

    </footer>


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