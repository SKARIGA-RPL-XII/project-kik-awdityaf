<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title; ?> - Gym Management</title>
    
    <!-- Bootstrap CSS -->
    <link href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
</head>

<body class="bg-gradient-danger">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <div class="mb-4">
                                            <i class="fas fa-exclamation-triangle fa-5x text-danger"></i>
                                        </div>
                                        <h1 class="h4 text-gray-900 mb-4">Payment Error</h1>
                                        
                                        <div class="alert alert-danger">
                                            <h6><i class="fas fa-times-circle mr-2"></i>Payment Failed</h6>
                                            <p class="mb-0">An error occurred while processing your payment. Common causes include:</p>
                                            <ul class="text-left mt-2 mb-0">
                                                <li>Insufficient funds in your account</li>
                                                <li>Invalid payment information</li>
                                                <li>Bank or payment provider declined the transaction</li>
                                                <li>Technical issues with the payment gateway</li>
                                            </ul>
                                        </div>
                                        
                                        <p class="text-muted mb-4">
                                            Please check your payment details and try again, or contact your bank if the problem persists.
                                        </p>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <a href="<?= base_url('member/membership_plans'); ?>" class="btn btn-danger btn-block">
                                                    <i class="fas fa-redo mr-2"></i>Try Again
                                                </a>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <a href="<?= base_url('member'); ?>" class="btn btn-secondary btn-block">
                                                    <i class="fas fa-home mr-2"></i>Go to Dashboard
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <div class="card border-left-info">
                                                <div class="card-body py-3">
                                                    <h6 class="text-info mb-2">
                                                        <i class="fas fa-lightbulb mr-2"></i>Alternative Payment Options
                                                    </h6>
                                                    <p class="text-muted mb-0 small">
                                                        You can also visit our gym location to make a cash payment or try a different payment method.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-3">
                                            <small class="text-muted">
                                                <i class="fas fa-phone mr-1"></i>
                                                Need immediate assistance? Contact our support team.
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
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
</body>
</html>
