<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">My Subscription History</h6>
                <a href="<?= base_url('member/membership_plans'); ?>" class="btn btn-sm btn-success">View Plans</a>
            </div>
            <div class="card-body">
                <?php if (!empty($subscriptions)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Plan</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Payment Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subscriptions as $subscription): ?>
                                    <tr>
                                        <td><?= $subscription['plan_name']; ?></td>
                                        <td><?= date('M d, Y', strtotime($subscription['start_date'])); ?></td>
                                        <td><?= date('M d, Y', strtotime($subscription['end_date'])); ?></td>
                                        <td>Rp <?= number_format($subscription['amount_paid'], 0, ',', '.'); ?></td>
                                        <td>
                                            <?php
                                            $today = date('Y-m-d');
                                            $status = ($today <= $subscription['end_date']) ? 'Active' : 'Expired';
                                            $badge_class = ($status == 'Active') ? 'success' : 'danger';
                                            ?>
                                            <span class="badge badge-<?= $badge_class; ?>"><?= $status; ?></span>
                                        </td>
                                        <td>
                                            <?= !empty($subscription['payment_date'])
                                                ? date('M d, Y', strtotime($subscription['payment_date']))
                                                : '<span class="text-muted">-</span>'; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-credit-card fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">You don't have any subscription history yet.</p>
                        <a href="<?= base_url('member/membership_plans'); ?>" class="btn btn-success">View Membership
                            Plans</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>