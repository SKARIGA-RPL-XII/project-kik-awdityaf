<div class="row">
    <div class="col-md-4">
        <div class="text-center mb-3">
            <img class="img-profile rounded-circle" width="100" height="100"
                 src="<?= base_url('assets/img/profile/' . ($member['image'] ?? 'default.jpg')); ?>"
                 alt="<?= $member['name']; ?>">
        </div>
        <h5 class="text-center"><?= $member['name']; ?></h5>
        <p class="text-center text-muted"><?= $member['member_code']; ?></p>
    </div>
    <div class="col-md-8">
        <table class="table table-borderless">
            <tr>
                <td><strong>Email:</strong></td>
                <td><?= $member['email']; ?></td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td><?= $member['phone'] ?? '-'; ?></td>
            </tr>
            <tr>
                <td><strong>Gender:</strong></td>
                <td><?= $member['gender'] ?? '-'; ?></td>
            </tr>
            <tr>
                <td><strong>Birth Date:</strong></td>
                <td><?= $member['birth_date'] ? date('M d, Y', strtotime($member['birth_date'])) : '-'; ?></td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td><?= $member['address'] ?? '-'; ?></td>
            </tr>
            <tr>
                <td><strong>Join Date:</strong></td>
                <td><?= date('M d, Y', strtotime($member['join_date'])); ?></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    <?php if ($member['status'] == 'Active'): ?>
                        <span class="badge badge-success">Active</span>
                    <?php elseif ($member['status'] == 'Inactive'): ?>
                        <span class="badge badge-secondary">Inactive</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Suspended</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<hr>

<!-- Current Subscription -->
<div class="row">
    <div class="col-12">
        <h6 class="text-success">Current Subscription</h6>
        <?php if (!empty($member['current_subscription'])): ?>
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="card-title text-success"><?= $member['current_subscription']['plan_name']; ?></h6>
                    <p class="card-text">
                        <strong>Start Date:</strong> <?= date('M d, Y', strtotime($member['current_subscription']['start_date'])); ?><br>
                        <strong>End Date:</strong> <?= date('M d, Y', strtotime($member['current_subscription']['end_date'])); ?><br>
                        <strong>Amount Paid:</strong> Rp <?= number_format($member['current_subscription']['amount_paid'], 0, ',', '.'); ?>
                    </p>
                    <?php
                    $days_left = (strtotime($member['current_subscription']['end_date']) - time()) / (60 * 60 * 24);
                    if ($days_left > 0):
                    ?>
                        <small class="text-success"><?= ceil($days_left); ?> days remaining</small>
                    <?php else: ?>
                        <small class="text-danger"><?= abs(ceil($days_left)); ?> days overdue</small>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                No active subscription found.
            </div>
        <?php endif; ?>
    </div>
</div>

<hr>

<!-- Attendance Rate -->
<div class="row">
    <div class="col-md-6">
        <h6 class="text-success">Attendance Rate (30 days)</h6>
        <div class="progress mb-2">
            <div class="progress-bar bg-success" role="progressbar" 
                 style="width: <?= $member['attendance_rate']; ?>%" 
                 aria-valuenow="<?= $member['attendance_rate']; ?>" 
                 aria-valuemin="0" aria-valuemax="100">
                <?= $member['attendance_rate']; ?>%
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <h6 class="text-success">Emergency Contact</h6>
        <?php if (!empty($member['emergency_contact'])): ?>
            <p class="mb-0">
                <strong><?= $member['emergency_contact']; ?></strong><br>
                <small class="text-muted"><?= $member['emergency_phone'] ?? 'No phone'; ?></small>
            </p>
        <?php else: ?>
            <p class="text-muted">No emergency contact set</p>
        <?php endif; ?>
    </div>
</div>

<hr>

<!-- Recent Attendance -->
<div class="row">
    <div class="col-12">
        <h6 class="text-success">Recent Attendance</h6>
        <?php if (!empty($member['recent_attendance'])): ?>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($member['recent_attendance'] as $attendance): ?>
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
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                No recent attendance records found.
            </div>
        <?php endif; ?>
    </div>
</div>
