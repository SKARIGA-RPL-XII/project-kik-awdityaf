<!-- Page Header -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow border-left-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-history text-primary mr-2"></i>Attendance History
                        </h1>
                        <p class="mb-0 text-muted">View and manage historical attendance records</p>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('gym/attendance'); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Today's Attendance
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-filter mr-2"></i>Filter by Date Range
                </h6>
            </div>
            <div class="card-body">
                <form method="get" action="<?= base_url('gym/attendance_history'); ?>">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label font-weight-bold">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="<?= $start_date; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label font-weight-bold">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="<?= $end_date; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label font-weight-bold">&nbsp;</label>
                            <div class="d-flex">
                                <button type="submit" class="btn btn-primary mr-2">
                                    <i class="fas fa-search mr-2"></i>Filter
                                </button>
                                <a href="<?= base_url('gym/attendance_history'); ?>" class="btn btn-secondary">
                                    <i class="fas fa-refresh mr-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Records</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count($attendance); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Unique Members</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count(array_unique(array_column($attendance, 'member_id'))); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Date Range</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            <?= date('M d', strtotime($start_date)); ?> - <?= date('M d, Y', strtotime($end_date)); ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Avg Daily</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php 
                            $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1;
                            echo $days > 0 ? round(count($attendance) / $days, 1) : 0;
                            ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Attendance History Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            Attendance Records (<?= date('M d', strtotime($start_date)); ?> - <?= date('M d, Y', strtotime($end_date)); ?>)
        </h6>
        <div class="dropdown no-arrow">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                <div class="dropdown-header">Export Options:</div>
                <a class="dropdown-item" href="#" onclick="exportToCSV()">
                    <i class="fas fa-file-csv mr-2"></i>Export to CSV
                </a>
                <a class="dropdown-item" href="#" onclick="exportToPDF()">
                    <i class="fas fa-file-pdf mr-2"></i>Export to PDF
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="printTable()">
                    <i class="fas fa-print mr-2"></i>Print Table
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="historyTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Member</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($attendance)): ?>
                        <?php foreach ($attendance as $record): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-light">
                                        <?= date('M d, Y', strtotime($record['date'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <div>
                                        <strong><?= $record['member_name']; ?></strong><br>
                                        <small class="text-muted"><?= $record['member_code']; ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        <?= date('H:i', strtotime($record['check_in_time'])); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($record['check_out_time']): ?>
                                        <span class="badge badge-secondary">
                                            <?= date('H:i', strtotime($record['check_out_time'])); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Still In</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($record['check_out_time']): ?>
                                        <?php
                                        $check_in = new DateTime($record['check_in_time']);
                                        $check_out = new DateTime($record['check_out_time']);
                                        $duration = $check_in->diff($check_out);
                                        echo $duration->format('%h:%I');
                                        ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($record['check_out_time']): ?>
                                        <span class="badge badge-secondary">Completed</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">In Gym</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-info" 
                                                onclick="viewAttendanceDetails(<?= $record['id']; ?>)" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="deleteAttendance(<?= $record['id']; ?>)" title="Delete Record">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">No attendance records found for the selected date range.</p>
                                <a href="<?= base_url('gym/attendance_history'); ?>" class="btn btn-primary">
                                    <i class="fas fa-refresh mr-2"></i>Reset Filter
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#historyTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            { "orderable": false, "targets": 6 }
        ]
    });
});

function exportToCSV() {
    alert('CSV export functionality will be implemented');
}

function exportToPDF() {
    alert('PDF export functionality will be implemented');
}

function printTable() {
    window.print();
}

function viewAttendanceDetails(id) {
    // Implementation for viewing attendance details
    alert('View details for attendance ID: ' + id);
}

function deleteAttendance(id) {
    if (confirm('Are you sure you want to delete this attendance record?')) {
        window.location.href = '<?= base_url("gym/delete_attendance/"); ?>' + id;
    }
}
</script>
