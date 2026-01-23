<div class="row">
    <!-- Attendance Stats -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Attendance Statistics</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="attendanceChart"></canvas>
                    </div>
                    <h4 class="mt-3"><?= $attendance_rate; ?>%</h4>
                    <p class="text-muted">Attendance Rate (Last 30 days)</p>
                </div>

                <div class="text-center">
                    <?php if ($is_in_gym): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle mr-2"></i>
                            You are currently checked in
                        </div>
                        <a href="<?= base_url('member/check_out'); ?>" class="btn btn-warning btn-block">
                            <i class="fas fa-sign-out-alt mr-2"></i>Check Out
                        </a>
                    <?php else: ?>
                        <div class="alert alert-secondary">
                            <i class="fas fa-times-circle mr-2"></i>
                            You are not checked in
                        </div>
                        <a href="<?= base_url('member/check_in'); ?>" class="btn btn-success btn-block">
                            <i class="fas fa-sign-in-alt mr-2"></i>Check In
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance History -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Attendance History</h6>
            </div>
            <div class="card-body">
                <?php if (!empty($attendance)): ?>
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
                                <?php foreach ($attendance as $record): ?>
                                    <tr>
                                        <td><?= date('M d, Y', strtotime($record['date'])); ?></td>
                                        <td><?= date('h:i A', strtotime($record['check_in_time'])); ?></td>
                                        <td>
                                            <?= !empty($record['check_out_time']) ? date('h:i A', strtotime($record['check_out_time'])) : '<span class="text-muted">Not checked out</span>'; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (!empty($record['check_out_time'])) {
                                                $check_in = new DateTime($record['check_in_time']);
                                                $check_out = new DateTime($record['check_out_time']);
                                                $interval = $check_in->diff($check_out);
                                                echo $interval->format('%h hr %i min');
                                            } else {
                                                echo '<span class="text-muted">-</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-check fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">No attendance records found. Start your fitness journey by checking in!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>