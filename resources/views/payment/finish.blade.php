<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ $title ?? 'Payment Status' }} - Gym Management</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="p-5 text-center">

                                    {{-- SUCCESS --}}
                                    @if(isset($transaction_status) && $transaction_status === 'settlement')

                                    <div class="mb-4">
                                        <i class="fas fa-check-circle fa-5x text-success"></i>
                                    </div>

                                    <h1 class="h4 text-gray-900 mb-4">
                                        Payment Successful!
                                    </h1>

                                    <div class="alert alert-success">

                                        <h6>
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Payment Details
                                        </h6>

                                        <p class="mb-1">
                                            <strong>Order ID:</strong> {{ $order_id ?? 'N/A' }}
                                        </p>

                                        <p class="mb-1">
                                            <strong>Status:</strong>
                                            <span class="badge badge-success">Paid</span>
                                        </p>

                                        <p class="mb-0">
                                            <strong>Date:</strong> {{ now()->format('d M Y H:i') }}
                                        </p>

                                    </div>


                                    {{-- MEMBERSHIP --}}
                                    @if(isset($subscription) && $subscription)

                                    <div class="alert alert-info">

                                        <h6>
                                            <i class="fas fa-dumbbell mr-2"></i>
                                            Membership Details
                                        </h6>

                                        <p class="mb-1">
                                            <strong>Plan:</strong> {{ $subscription['plan_name'] ?? 'N/A' }}
                                        </p>

                                        <p class="mb-1">
                                            <strong>Duration:</strong> {{ $subscription['duration_months'] ?? 'N/A' }}
                                            months
                                        </p>

                                        <p class="mb-1">
                                            <strong>Start Date:</strong>
                                            {{ \Carbon\Carbon::parse($subscription['start_date'])->format('d M Y') }}
                                        </p>

                                        <p class="mb-0">
                                            <strong>End Date:</strong>
                                            {{ \Carbon\Carbon::parse($subscription['end_date'])->format('d M Y') }}
                                        </p>

                                    </div>

                                    @endif


                                    <p class="text-muted mb-4">
                                        Your membership has been activated successfully! You can now access all gym
                                        facilities.
                                    </p>


                                    {{-- PENDING --}}
                                    @elseif(isset($transaction_status) && $transaction_status === 'pending')

                                    <div class="mb-4">
                                        <i class="fas fa-clock fa-5x text-warning"></i>
                                    </div>

                                    <h1 class="h4 text-gray-900 mb-4">
                                        Payment Pending
                                    </h1>

                                    <div class="alert alert-warning">

                                        <h6>
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Payment Details
                                        </h6>

                                        <p class="mb-1">
                                            <strong>Order ID:</strong> {{ $order_id ?? 'N/A' }}
                                        </p>

                                        <p class="mb-1">
                                            <strong>Status:</strong>
                                            <span class="badge badge-warning">Pending</span>
                                        </p>

                                        <p class="mb-0">
                                            <strong>Date:</strong> {{ now()->format('d M Y H:i') }}
                                        </p>

                                    </div>


                                    <p class="text-muted mb-4">
                                        Your payment is being processed. Please complete your payment to activate your
                                        membership.
                                    </p>


                                    {{-- FAILED --}}
                                    @else

                                    <div class="mb-4">
                                        <i class="fas fa-exclamation-triangle fa-5x text-danger"></i>
                                    </div>

                                    <h1 class="h4 text-gray-900 mb-4">
                                        Payment Failed
                                    </h1>

                                    <div class="alert alert-danger">

                                        <h6>
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Payment Details
                                        </h6>

                                        <p class="mb-1">
                                            <strong>Order ID:</strong> {{ $order_id ?? 'N/A' }}
                                        </p>

                                        <p class="mb-1">
                                            <strong>Status:</strong>
                                            <span class="badge badge-danger">Failed</span>
                                        </p>

                                        <p class="mb-0">
                                            <strong>Date:</strong> {{ now()->format('d M Y H:i') }}
                                        </p>

                                    </div>


                                    <p class="text-muted mb-4">
                                        Your payment could not be processed. Please try again or contact support.
                                    </p>

                                    @endif


                                    {{-- BUTTONS --}}
                                    <div class="row">

                                        <div class="col-md-6 mb-2">
                                            <a href="{{ url('member') }}" class="btn btn-primary btn-block">

                                                <i class="fas fa-home mr-2"></i>
                                                Go to Dashboard
                                            </a>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <a href="{{ url('member/membership_plans') }}"
                                                class="btn btn-secondary btn-block">

                                                <i class="fas fa-dumbbell mr-2"></i>
                                                View Plans
                                            </a>
                                        </div>

                                    </div>


                                    {{-- CHECK STATUS --}}
                                    @if(isset($transaction_status) && $transaction_status !== 'settlement')

                                    <div class="mt-3">
                                        <a href="{{ url('member/my_subscriptions') }}"
                                            class="btn btn-outline-info btn-sm">

                                            <i class="fas fa-list mr-1"></i>
                                            Check Subscription Status
                                        </a>
                                    </div>

                                    @endif


                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- JS -->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>


    {{-- Auto Redirect --}}
    @if(isset($transaction_status) && $transaction_status === 'settlement')

    <script>
    setTimeout(function() {
        window.location.href = "{{ url('member') }}";
    }, 10000);
    </script>

    @endif

</body>

</html>