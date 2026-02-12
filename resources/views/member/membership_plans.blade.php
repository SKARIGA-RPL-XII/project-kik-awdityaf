@extends('layouts.member.app')

@section('content')

<!-- Page Header -->
<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-dumbbell mr-2"></i>
                    Membership Plans
                </h1>
                <p class="text-light mb-2">
                    Choose the perfect plan for your fitness journey
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ url('member/subscriptions') }}" class="btn btn-gym-secondary">
                    <i class="fas fa-history mr-2"></i>
                    My Subscriptions
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Current Subscription Alert -->
@if(!empty($current_subscription))

<div class="row">
    <div class="col-12 mb-4">

        <div class="alert alert-success alert-dismissible fade show">

            <i class="fas fa-check-circle mr-2"></i>

            <strong>Active Membership:</strong>
            You currently have an active
            <strong>{{ $current_subscription['plan_name'] }}</strong>
            membership valid until
            <strong>
                {{ \Carbon\Carbon::parse($current_subscription['end_date'])->format('M d, Y') }}
            </strong>

            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>

        </div>

    </div>
</div>

@endif


<!-- Membership Plans -->
<div class="row">

    @if(!empty($plans))

    @php
    $plan_colors = ['primary', 'success', 'warning', 'info'];
    $plan_icons = ['fas fa-user', 'fas fa-star', 'fas fa-crown', 'fas fa-gem'];
    @endphp


    @foreach($plans as $index => $plan)

    @php
    $color = $plan_colors[$index % count($plan_colors)];
    $icon = $plan_icons[$index % count($plan_icons)];
    $features = explode(',', $plan['features']);
    @endphp


    <div class="col-lg-4 col-md-6 mb-4">

        <div class="card-gym shadow h-100 plan-card"
            style="border-left: 4px solid #{{ $color == 'primary' ? '00d4ff' : ($color == 'success' ? '2dce89' : ($color == 'warning' ? 'f5365c' : '11cdef')) }};">

            <div class="card-header"
                style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
                <div class="text-center">
                    <i class="{{ $icon }} fa-2x mb-2"
                        style="color: #{{ $color == 'primary' ? '00d4ff' : ($color == 'success' ? '2dce89' : ($color == 'warning' ? 'f5365c' : '11cdef')) }};"></i>
                    <h5 class="gym-accent font-weight-bold mb-0">
                        {{ $plan['plan_name'] }}
                    </h5>
                </div>
            </div>

            <div class="card-body text-center" style="background-color: rgba(0,0,0,0.2);">

                <div class="price-section mb-4">

                    <h2 class="gym-accent-secondary font-weight-bold mb-1" style="font-size: 2.5rem;">
                        Rp {{ number_format($plan['price'], 0, ',', '.') }}
                    </h2>

                    <p class="text-light small mb-0">
                        for {{ $plan['duration_months'] }}
                        month{{ $plan['duration_months'] > 1 ? 's' : '' }}
                    </p>

                </div>


                <p class="text-light mb-4">
                    {{ $plan['description'] }}
                </p>


                <div class="features-section mb-4">

                    <h6 class="gym-accent font-weight-bold mb-3">
                        What's Included:
                    </h6>

                    <ul class="list-unstyled">

                        @foreach($features as $feature)

                        <li class="mb-2 text-light">

                            <i class="fas fa-check"
                                style="color: #{{ $color == 'primary' ? '00d4ff' : ($color == 'success' ? '2dce89' : ($color == 'warning' ? 'f5365c' : '11cdef')) }}; margin-right: 8px;"></i>

                            {{ trim($feature) }}

                        </li>

                        @endforeach

                    </ul>

                </div>


                <div class="duration-info mb-4">

                    <div class="badge badge-pill"
                        style="background-color: rgba(255,255,255,0.1); border: 1px solid #{{ $color == 'primary' ? '00d4ff' : ($color == 'success' ? '2dce89' : ($color == 'warning' ? 'f5365c' : '11cdef')) }}; color: #{{ $color == 'primary' ? '00d4ff' : ($color == 'success' ? '2dce89' : ($color == 'warning' ? 'f5365c' : '11cdef')) }};">

                        <i class="fas fa-calendar-alt mr-1"></i>

                        {{ $plan['duration_months'] }}
                        Month{{ $plan['duration_months'] > 1 ? 's' : '' }}
                        Access

                    </div>

                </div>

            </div>


            <div class="card-footer bg-transparent text-center" style="border-top: 1px solid rgba(255,255,255,0.1);">

                @if(!empty($current_subscription))

                <button class="btn btn-gym-secondary btn-block" disabled style="opacity: 0.6;">
                    <i class="fas fa-lock mr-2"></i>
                    Already Subscribed
                </button>

                @else

                <a href="{{ url('member/subscribe/'.$plan['id']) }}"
                    class="btn btn-gym-primary btn-block btn-subscribe">

                    <i class="fas fa-credit-card mr-2"></i>
                    Subscribe Now

                </a>

                @endif

            </div>

        </div>

    </div>

    @endforeach


    @else

    <!-- Empty Plans -->

    <div class="col-12">

        <div class="card shadow">

            <div class="card-body text-center py-5">

                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>

                <h5 class="text-gray-800">
                    No Membership Plans Available
                </h5>

                <p class="text-muted">
                    No membership plans are currently available.
                </p>

                <a href="{{ url('member') }}" class="btn btn-primary">

                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard

                </a>

            </div>

        </div>

    </div>

    @endif

</div>


<!-- Additional Information -->
<div class="row mt-4">

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header">

                <h6 class="m-0 font-weight-bold text-primary">

                    <i class="fas fa-info-circle mr-2"></i>
                    Membership Information

                </h6>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">

                        <h6 class="font-weight-bold">
                            Benefits of Membership:
                        </h6>

                        <ul class="list-unstyled">

                            <li><i class="fas fa-check text-success mr-2"></i>Access to all gym equipment</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Professional guidance from trainers</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Clean and secure facilities</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Flexible workout hours</li>

                        </ul>

                    </div>

                    <div class="col-md-6">

                        <h6 class="font-weight-bold">
                            Payment Methods:
                        </h6>

                        <ul class="list-unstyled">

                            <li><i class="fas fa-money-bill text-success mr-2"></i>Cash Payment</li>
                            <li><i class="fas fa-university text-success mr-2"></i>Bank Transfer</li>
                            <li><i class="fas fa-credit-card text-success mr-2"></i>Credit/Debit Card</li>
                            <li><i class="fas fa-mobile-alt text-success mr-2"></i>E-Wallet (OVO, GoPay, DANA)</li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>
.plan-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.plan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.btn-subscribe {
    transition: all 0.3s ease;
}

.btn-subscribe:hover {
    transform: translateY(-2px);
}

.price-section h2 {
    font-size: 2.5rem;
}

.features-section li {
    text-align: left;
}
</style>

@endsection