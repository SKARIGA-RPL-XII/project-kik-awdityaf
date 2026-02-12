<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ $title ?? 'Payment Unfinished' }} - Gym Management</title>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-warning">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        <div class="row">
                            <div class="col-lg-12">

                                <div class="p-5 text-center">

                                    <div class="mb-4">
                                        <i class="fas fa-pause-circle fa-5x text-warning"></i>
                                    </div>

                                    <h1 class="h4 text-gray-900 mb-4">
                                        Payment Unfinished
                                    </h1>


                                    <div class="alert alert-warning">

                                        <h6>
                                            <i class="fas fa-info-circle mr-2"></i>
                                            What happened?
                                        </h6>

                                        <p class="mb-0">
                                            Your payment process was not completed. This could be due to:
                                        </p>

                                        <ul class="text-left mt-2 mb-0">
                                            <li>Payment window was closed before completion</li>
                                            <li>Session timeout</li>
                                            <li>Network connectivity issues</li>
                                            <li>Payment method selection was cancelled</li>
                                        </ul>

                                    </div>


                                    <p class="text-muted mb-4">
                                        Don't worry! You can try again or choose a different payment method.
                                    </p>


                                    {{-- BUTTONS --}}
                                    <div class="row">

                                        <div class="col-md-6 mb-2">
                                            <a href="{{ url('member/membership_plans') }}"
                                                class="btn btn-warning btn-block">

                                                <i class="fas fa-redo mr-2"></i>
                                                Try Again
                                            </a>
                                        </div>

                                        <div class="col-md-6 mb-2">
                                            <a href="{{ url('member') }}" class="btn btn-secondary btn-block">

                                                <i class="fas fa-home mr-2"></i>
                                                Go to Dashboard
                                            </a>
                                        </div>

                                    </div>


                                    <div class="mt-4">
                                        <small class="text-muted">
                                            <i class="fas fa-question-circle mr-1"></i>
                                            Need help? Contact our support team for assistance.
                                        </small>
                                    </div>


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

</body>

</html>