<div class="row">
    <div class="col-md-8">
        <h4 class="text-success"><?= $plan['plan_name']; ?></h4>
        <p class="text-muted"><?= $plan['description']; ?></p>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <h6>Duration</h6>
                <p><?= $plan['duration_months']; ?> Month<?= $plan['duration_months'] > 1 ? 's' : ''; ?></p>
            </div>
            <div class="col-md-6">
                <h6>Price</h6>
                <h4 class="text-success">Rp <?= number_format($plan['price'], 0, ',', '.'); ?></h4>
                <small class="text-muted">
                    Rp <?= number_format($plan['price'] / $plan['duration_months'], 0, ',', '.'); ?> per month
                </small>
            </div>
        </div>

        <?php if (!empty($plan['features'])): ?>
            <h6>Features</h6>
            <ul class="list-unstyled">
                <?php 
                $features = explode(',', $plan['features']);
                foreach ($features as $feature): 
                ?>
                    <li><i class="fas fa-check text-success mr-2"></i><?= trim($feature); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-header bg-success text-white text-center">
                <h6 class="m-0">Plan Status</h6>
            </div>
            <div class="card-body text-center">
                <?php if ($plan['is_active']): ?>
                    <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                    <h6 class="text-success">Active</h6>
                    <p class="text-muted">This plan is available for new subscriptions</p>
                <?php else: ?>
                    <i class="fas fa-pause-circle fa-3x text-warning mb-2"></i>
                    <h6 class="text-warning">Inactive</h6>
                    <p class="text-muted">This plan is not available for new subscriptions</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-3">
            <h6>Plan Information</h6>
            <table class="table table-borderless table-sm">
                <tr>
                    <td><strong>Created:</strong></td>
                    <td><?= date('M d, Y', strtotime($plan['created_at'])); ?></td>
                </tr>
                <tr>
                    <td><strong>Updated:</strong></td>
                    <td><?= date('M d, Y', strtotime($plan['updated_at'])); ?></td>
                </tr>
                <tr>
                    <td><strong>Duration:</strong></td>
                    <td><?= $plan['duration_months']; ?> months</td>
                </tr>
                <tr>
                    <td><strong>Price/Month:</strong></td>
                    <td>Rp <?= number_format($plan['price'] / $plan['duration_months'], 0, ',', '.'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-12">
        <h6>Plan Statistics</h6>
        <div class="row">
            <div class="col-md-3">
                <div class="card border-left-primary">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Subscribers
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        <!-- TODO: Add real subscriber count -->
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-success">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 0</div>
                        <!-- TODO: Add real revenue -->
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-info">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Active Subscriptions
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        <!-- TODO: Add real active subscriptions -->
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-left-warning">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Avg. Duration
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $plan['duration_months']; ?>m</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
