<!-- Page Header -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow border-left-success">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-dumbbell text-success mr-2"></i>Membership Plans
                        </h1>
                        <p class="mb-0 text-muted">Choose the perfect plan for your fitness journey</p>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('member/my_subscriptions'); ?>" class="btn btn-outline-success">
                            <i class="fas fa-history mr-2"></i>My Subscriptions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Current Subscription Alert -->
<?php if (isset($current_subscription) && $current_subscription): ?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-2"></i>
                <strong>Active Membership:</strong> You currently have an active <strong><?= $current_subscription['plan_name']; ?></strong>
                membership valid until <strong><?= date('M d, Y', strtotime($current_subscription['end_date'])); ?></strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Membership Plans -->
<div class="row">
    <?php if (!empty($plans)): ?>
        <?php
        $plan_colors = ['primary', 'success', 'warning', 'info'];
        $plan_icons = ['fas fa-user', 'fas fa-star', 'fas fa-crown', 'fas fa-gem'];
        foreach ($plans as $index => $plan):
            $color = $plan_colors[$index % count($plan_colors)];
            $icon = $plan_icons[$index % count($plan_icons)];
            $features = explode(',', $plan['features']);
        ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-left-<?= $color; ?> shadow h-100 plan-card">
                    <div class="card-header bg-<?= $color; ?> text-white text-center">
                        <i class="<?= $icon; ?> fa-2x mb-2"></i>
                        <h5 class="m-0 font-weight-bold"><?= $plan['plan_name']; ?></h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="price-section mb-4">
                            <h2 class="text-<?= $color; ?> font-weight-bold mb-1">
                                Rp <?= number_format($plan['price'], 0, ',', '.'); ?>
                            </h2>
                            <p class="text-muted small">for <?= $plan['duration_months']; ?> month<?= $plan['duration_months'] > 1 ? 's' : ''; ?></p>
                        </div>

                        <p class="text-muted mb-4"><?= $plan['description']; ?></p>

                        <div class="features-section mb-4">
                            <h6 class="font-weight-bold text-gray-800 mb-3">What's Included:</h6>
                            <ul class="list-unstyled">
                                <?php foreach ($features as $feature): ?>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-<?= $color; ?> mr-2"></i>
                                        <?= trim($feature); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="duration-info mb-4">
                            <div class="badge badge-<?= $color; ?> badge-pill">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                <?= $plan['duration_months']; ?> Month<?= $plan['duration_months'] > 1 ? 's' : ''; ?> Access
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent text-center">
                        <?php if (isset($current_subscription) && $current_subscription): ?>
                            <button class="btn btn-outline-<?= $color; ?> btn-block" disabled>
                                <i class="fas fa-lock mr-2"></i>Already Subscribed
                            </button>
                        <?php else: ?>
                            <a href="<?= base_url('member/subscribe/' . $plan['id']); ?>"
                                class="btn btn-<?= $color; ?> btn-block btn-subscribe">
                                <i class="fas fa-credit-card mr-2"></i>Subscribe Now
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5 class="text-gray-800">No Membership Plans Available</h5>
                    <p class="text-muted">No membership plans are currently available. Please check back later or contact our staff for assistance.</p>
                    <a href="<?= base_url('member'); ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Additional Information -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle mr-2"></i>Membership Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Benefits of Membership:</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success mr-2"></i>Access to all gym equipment</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Professional guidance from trainers</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Clean and secure facilities</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Flexible workout hours</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="font-weight-bold">Payment Methods:</h6>
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