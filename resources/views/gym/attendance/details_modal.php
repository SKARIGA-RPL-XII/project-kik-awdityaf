<div class="row">
    <div class="col-md-6">
        <h6 class="font-weight-bold text-primary mb-3">
            <i class="fas fa-user mr-2"></i>Member Information
        </h6>
        <table class="table table-borderless table-sm">
            <tr>
                <td width="40%"><strong>Name:</strong></td>
                <td><?= $member['name'] ?? 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Member Code:</strong></td>
                <td><?= $member['member_code'] ?? 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Phone:</strong></td>
                <td><?= $member['phone'] ?? 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Gender:</strong></td>
                <td><?= $member['gender'] ?? 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Join Date:</strong></td>
                <td><?= $member['join_date'] ? date('M d, Y', strtotime($member['join_date'])) : 'N/A'; ?></td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    <span class="badge badge-<?= ($member['status'] ?? '') == 'Active' ? 'success' : 'secondary'; ?>">
                        <?= $member['status'] ?? 'Unknown'; ?>
                    </span>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="col-md-6">
        <h6 class="font-weight-bold text-success mb-3">
            <i class="fas fa-calendar-check mr-2"></i>Attendance Details
        </h6>
        <table class="table table-borderless table-sm">
            <tr>
                <td width="40%"><strong>Date:</strong></td>
                <td><?= date('M d, Y', strtotime($attendance['date'])); ?></td>
            </tr>
            <tr>
                <td><strong>Check In Time:</strong></td>
                <td>
                    <span class="badge badge-success">
                        <?= date('H:i:s', strtotime($attendance['check_in_time'])); ?>
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>Check Out Time:</strong></td>
                <td>
                    <?php if ($attendance['check_out_time']): ?>
                        <span class="badge badge-secondary">
                            <?= date('H:i:s', strtotime($attendance['check_out_time'])); ?>
                        </span>
                    <?php else: ?>
                        <span class="badge badge-warning">Still In Gym</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Duration:</strong></td>
                <td>
                    <?php if ($attendance['check_out_time']): ?>
                        <?php
                        $check_in = new DateTime($attendance['check_in_time']);
                        $check_out = new DateTime($attendance['check_out_time']);
                        $duration = $check_in->diff($check_out);
                        echo $duration->format('%h hours %i minutes');
                        ?>
                    <?php else: ?>
                        <?php
                        $check_in = new DateTime($attendance['check_in_time']);
                        $now = new DateTime();
                        $duration = $check_in->diff($now);
                        echo '<span class="text-info">' . $duration->format('%h hours %i minutes') . ' (ongoing)</span>';
                        ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    <?php if ($attendance['check_out_time']): ?>
                        <span class="badge badge-secondary">Completed</span>
                    <?php else: ?>
                        <span class="badge badge-success">In Gym</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php if ($subscription): ?>
<div class="row mt-4">
    <div class="col-12">
        <h6 class="font-weight-bold text-info mb-3">
            <i class="fas fa-id-card mr-2"></i>Current Subscription
        </h6>
        <div class="card border-left-info">
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-md-3">
                        <strong>Plan:</strong><br>
                        <span class="text-info"><?= $subscription['plan_name'] ?? 'N/A'; ?></span>
                    </div>
                    <div class="col-md-3">
                        <strong>Start Date:</strong><br>
                        <?= $subscription['start_date'] ? date('M d, Y', strtotime($subscription['start_date'])) : 'N/A'; ?>
                    </div>
                    <div class="col-md-3">
                        <strong>End Date:</strong><br>
                        <?= $subscription['end_date'] ? date('M d, Y', strtotime($subscription['end_date'])) : 'N/A'; ?>
                    </div>
                    <div class="col-md-3">
                        <strong>Status:</strong><br>
                        <span class="badge badge-success">Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Warning:</strong> This member does not have an active subscription.
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="font-weight-bold text-secondary mb-3">
            <i class="fas fa-cogs mr-2"></i>Quick Actions
        </h6>
        <div class="btn-group" role="group">
            <?php if (!$attendance['check_out_time']): ?>
                <button type="button" class="btn btn-warning" onclick="manualCheckOut(<?= $attendance['id']; ?>)">
                    <i class="fas fa-sign-out-alt mr-2"></i>Manual Check Out
                </button>
            <?php endif; ?>
            <button type="button" class="btn btn-info" onclick="printAttendanceDetails(<?= $attendance['id']; ?>)">
                <i class="fas fa-print mr-2"></i>Print Details
            </button>
            <button type="button" class="btn btn-danger" onclick="deleteAttendance(<?= $attendance['id']; ?>)">
                <i class="fas fa-trash mr-2"></i>Delete Record
            </button>
        </div>
    </div>
</div>

<script>
function printAttendanceDetails(id) {
    // Close modal first
    $('#attendanceModal').modal('hide');
    
    // Open print window with attendance details
    var printWindow = window.open('<?= base_url("gym/print_attendance_details/"); ?>' + id, '_blank');
    printWindow.focus();
}
</script>
