<!-- Welcome Section -->
<div class="row">
    <div class="col-12">
        <div class="card border-left-success shadow mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="text-success mb-2">Welcome back, <?= isset($user['name']) ? $user['name'] : 'Member'; ?>!</h4>
                        <p class="text-muted mb-0">Ready for your workout today? Let's achieve your fitness goals together!</p>
                        <?php if (isset($member['member_code'])): ?>
                            <small class="text-muted">Member ID: <strong><?= $member['member_code']; ?></strong></small>
                        <?php endif; ?>
                    </div>
                    <div class="col-4 text-right">
                        <?php if (isset($is_in_gym) && $is_in_gym): ?>
                            <a href="<?= base_url('member/check_out'); ?>" class="btn btn-warning btn-lg">
                                <i class="fas fa-sign-out-alt mr-2"></i>Check Out
                            </a>
                        <?php else: ?>
                            <a href="<?= base_url('member/check_in'); ?>" class="btn btn-success btn-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i>Check In
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Cards Row -->
<div class="row">

    <!-- Membership Status Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-<?= isset($current_subscription) && $current_subscription ? 'success' : 'danger'; ?> shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-<?= isset($current_subscription) && $current_subscription ? 'success' : 'danger'; ?> text-uppercase mb-1">
                            Membership Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($current_subscription) && $current_subscription ? 'Active' : 'Inactive'; ?>
                        </div>
                        <?php if (isset($current_subscription) && $current_subscription): ?>
                            <div class="text-xs text-muted">Expires: <?= date('M d, Y', strtotime($current_subscription['end_date'])); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-id-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Plan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Current Plan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($current_subscription['plan_name']) ? $current_subscription['plan_name'] : 'No Plan'; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Rate Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Attendance Rate (30 days)</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= isset($attendance_rate) ? $attendance_rate : 0; ?>%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: <?= isset($attendance_rate) ? $attendance_rate : 0; ?>%" aria-valuenow="<?= isset($attendance_rate) ? $attendance_rate : 0; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-<?= isset($is_in_gym) && $is_in_gym ? 'success' : 'secondary'; ?> shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-<?= isset($is_in_gym) && $is_in_gym ? 'success' : 'secondary'; ?> text-uppercase mb-1">
                            Current Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($is_in_gym) && $is_in_gym ? 'In Gym' : 'Not In Gym'; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-<?= isset($is_in_gym) && $is_in_gym ? 'check-circle' : 'times-circle'; ?> fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
<div class="row">

    <!-- Recent Attendance -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Recent Attendance</h6>
                <a href="<?= base_url('member/my_attendance'); ?>" class="btn btn-sm btn-success">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_attendance)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (array_slice($recent_attendance, 0, 5) as $attendance): ?>
                                    <tr>
                                        <td><?= date('M d, Y', strtotime($attendance['date'])); ?></td>
                                        <td><?= date('H:i', strtotime($attendance['check_in_time'])); ?></td>
                                        <td>
                                            <?php if ($attendance['check_out_time']): ?>
                                                <?= date('H:i', strtotime($attendance['check_out_time'])); ?>
                                            <?php else: ?>
                                                <span class="badge badge-success">Still In</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($attendance['check_out_time']): ?>
                                                <?php
                                                $check_in = new DateTime($attendance['check_in_time']);
                                                $check_out = new DateTime($attendance['check_out_time']);
                                                $duration = $check_in->diff($check_out);
                                                echo $duration->format('%h:%I');
                                                ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">No attendance records found. Start your fitness journey by checking in!</p>
                        <a href="<?= base_url('member/check_in'); ?>" class="btn btn-success">Check In Now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('member/profile'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-user text-success mr-3"></i>
                        Update Profile
                    </a>
                    <a href="<?= base_url('member/membership_plans'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags text-info mr-3"></i>
                        View Membership Plans
                    </a>
                    <a href="<?= base_url('member/my_subscriptions'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-credit-card text-primary mr-3"></i>
                        My Subscriptions
                    </a>
                    <a href="<?= base_url('member/my_attendance'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-calendar-check text-warning mr-3"></i>
                        Attendance History
                    </a>
                    <a href="<?= base_url('member/member_report'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-comment-alt text-danger mr-3"></i>
                        Laporan Member
                    </a>
                    <a href="<?= base_url('member/change_password'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-lock text-secondary mr-3"></i>
                        Change Password
                    </a>
                </div>
            </div>
        </div>

        <!-- Membership Info -->
        <?php if (isset($current_subscription) && $current_subscription): ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Current Membership</h6>
                </div>
                <div class="card-body">
                    <h5 class="text-success"><?= $current_subscription['plan_name']; ?></h5>
                    <p class="text-muted mb-2">
                        <strong>Start Date:</strong> <?= date('M d, Y', strtotime($current_subscription['start_date'])); ?><br>
                        <strong>End Date:</strong> <?= date('M d, Y', strtotime($current_subscription['end_date'])); ?><br>
                        <strong>Amount Paid:</strong> Rp <?= number_format($current_subscription['amount_paid'], 0, ',', '.'); ?>
                    </p>
                    <?php
                    $days_left = (strtotime($current_subscription['end_date']) - time()) / (60 * 60 * 24);
                    if ($days_left > 0):
                    ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <?= ceil($days_left); ?> days remaining
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Membership expired
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">No Active Membership</h6>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <p class="text-muted">You don't have an active membership. Choose a plan to start your fitness journey!</p>
                    <a href="<?= base_url('member/membership_plans'); ?>" class="btn btn-success">Choose Plan</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>