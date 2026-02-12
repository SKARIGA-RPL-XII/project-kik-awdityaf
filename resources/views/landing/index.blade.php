@extends('layouts.index')
@section('content')


<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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
                    <a class="nav-link" href="#membership">Membership</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>

                <li class="nav-item ms-3">
                    <a class="btn btn-primary-custom" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
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

            <div class="col-lg-8 mx-auto text-center" data-aos="fade-up">

                <h1 class="hero-title">
                    Transform Your Body, Transform Your Life
                </h1>

                <p class="hero-subtitle">
                    Join FitGym today and discover the best version of yourself. Expert trainers, modern equipment,
                    and a supportive community await you.
                </p>

                <div class="d-flex gap-3 justify-content-center flex-wrap">

                    <a href="{{ route('register') }}" class="btn btn-primary-custom btn-lg">
                        <i class="fas fa-rocket mr-2"></i>Start Your Journey
                    </a>

                    <a href="#membership" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-list mr-2"></i>View Plans
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
            <i class="fas fa-star mr-2"></i>Choose Your Perfect Plan
        </h2>

        <div class="row justify-content-center">

            {{-- Jika ada data dari controller --}}
            @forelse ($plans as $index => $plan)

            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index+1)*100 }}">

                <div class="pricing-card {{ $index == 1 ? 'featured' : '' }}">

                    @if($index == 1)
                    <div style="position: absolute; top: 15px; right: 15px;">
                        <span
                            style="background: linear-gradient(135deg, #ff006e, #ff4d8f); padding: 5px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: 700;">⭐
                            POPULAR</span>
                    </div>
                    @endif

                    <h4><i class="fas fa-medal mr-2"></i>{{ $plan->plan_name }}</h4>

                    <div class="price">

                        Rp {{ number_format($plan->price,0,',','.') }}

                        <small style="display: block; color: #aaa; font-size: 0.75rem; margin-top: 10px;">
                            untuk {{ $plan->duration_months }} bulan
                        </small>

                    </div>

                    @if($plan->features)

                    <ul class="list-unstyled mt-4">

                        @foreach(explode(',', $plan->features) as $feature)

                        <li>
                            <i class="fas fa-check"></i>
                            {{ trim($feature) }}
                        </li>

                        @endforeach

                    </ul>

                    @endif

                    <a href="{{ route('register') }}" class="btn btn-primary-custom w-100 mt-4">
                        <i class="fas fa-arrow-right mr-2"></i>Pilih Paket Ini
                    </a>

                </div>

            </div>

            @empty

            {{-- Jika kosong --}}
            <div class="col-12 text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #00d4ff; opacity: 0.5;"></i>
                <p class="mt-3" style="color: #aaa;">Paket membership belum tersedia</p>
            </div>

            @endforelse

        </div>

    </div>

</section>

<!-- FOOTER -->
<footer class="footer">

    <div class="container">

        <div class="row">

            <div class="col-md-6">
                <p class="mb-0">
                    <i class="fas fa-copyright mr-2"></i> {{ date('Y') }} FitGym - Your Fitness Journey Starts Here
                </p>
            </div>

            <div class="col-md-6 text-end">
                <a href="{{ route('login') }}" class="btn btn-primary-custom btn-sm">
                    <i class="fas fa-sign-in-alt mr-2"></i>Member Login
                </a>
            </div>

        </div>

    </div>

</footer>

@endsection