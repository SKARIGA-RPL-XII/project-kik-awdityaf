<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Member Subscriptions</h1>
    <a href="<?= base_url('gym/add_subscription'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Subscription
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active Subscriptions</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($subscription_stats['active_subscriptions']) ? $subscription_stats['active_subscriptions'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            Expiring Soon (7 days)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($subscription_stats['expiring_soon']) ? $subscription_stats['expiring_soon'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Overdue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($subscription_stats['overdue']) ? $subscription_stats['overdue'] : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Monthly Revenue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp <?= isset($subscription_stats['monthly_revenue']) ? number_format($subscription_stats['monthly_revenue'], 0, ',', '.') : 0; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Options -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Filter Subscriptions</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="<?= base_url('gym/subscriptions'); ?>">
            <div class="row">
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="active" <?= $this->input->get('status') == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="expiring" <?= $this->input->get('status') == 'expiring' ? 'selected' : ''; ?>>Expiring Soon</option>
                        <option value="overdue" <?= $this->input->get('status') == 'overdue' ? 'selected' : ''; ?>>Overdue</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="plan" class="form-control">
                        <option value="">All Plans</option>
                        <!-- Plans will be loaded here -->
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="month" name="month" class="form-control" value="<?= $this->input->get('month'); ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="<?= base_url('gym/subscriptions'); ?>" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Subscriptions Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">All Subscriptions</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Plan</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Amount</th>
                        <th>Payment Status</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($subscriptions)): ?>
                        <?php foreach ($subscriptions as $subscription): ?>
                            <?php
                            $today = date('Y-m-d');
                            $end_date = $subscription['end_date'];
                            $days_left = (strtotime($end_date) - strtotime($today)) / (60 * 60 * 24);
                            
                            if ($days_left < 0) {
                                $status_class = 'danger';
                                $status_text = 'Expired';
                            } elseif ($days_left <= 7) {
                                $status_class = 'warning';
                                $status_text = 'Expiring Soon';
                            } else {
                                $status_class = 'success';
                                $status_text = 'Active';
                            }
                            ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="mr-2">
                                            <strong><?= $subscription['member_name']; ?></strong><br>
                                            <small class="text-muted"><?= $subscription['member_code']; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-info"><?= $subscription['plan_name']; ?></span>
                                </td>
                                <td><?= date('M d, Y', strtotime($subscription['start_date'])); ?></td>
                                <td>
                                    <?= date('M d, Y', strtotime($subscription['end_date'])); ?>
                                    <?php if ($days_left >= 0): ?>
                                        <br><small class="text-muted"><?= ceil($days_left); ?> days left</small>
                                    <?php else: ?>
                                        <br><small class="text-danger"><?= abs(ceil($days_left)); ?> days overdue</small>
                                    <?php endif; ?>
                                </td>
                                <td>Rp <?= number_format($subscription['amount_paid'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($subscription['payment_status'] == 'Paid'): ?>
                                        <span class="badge badge-success">Paid</span>
                                    <?php elseif ($subscription['payment_status'] == 'Pending'): ?>
                                        <span class="badge badge-warning">Pending</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Overdue</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?= $status_class; ?>"><?= $status_text; ?></span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= base_url('gym/edit_subscription/' . $subscription['id']); ?>" 
                                           class="btn btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-info" 
                                                onclick="viewSubscription(<?= $subscription['id']; ?>)" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($subscription['payment_status'] != 'Paid'): ?>
                                            <button type="button" class="btn btn-success" 
                                                    onclick="markAsPaid(<?= $subscription['id']; ?>)" title="Mark as Paid">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-warning" 
                                                onclick="renewSubscription(<?= $subscription['id']; ?>)" title="Renew">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" 
                                                onclick="deleteSubscription(<?= $subscription['id']; ?>)" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No subscriptions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Subscription Details Modal -->
<div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subscription Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="subscriptionModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "pageLength": 25,
        "order": [[ 3, "asc" ]], // Sort by end date
        "columnDefs": [
            { "orderable": false, "targets": 7 } // Disable sorting for Actions column
        ]
    });
});

function viewSubscription(subscriptionId) {
    $.ajax({
        url: '<?= base_url("gym/get_subscription_details/"); ?>' + subscriptionId,
        type: 'GET',
        success: function(response) {
            $('#subscriptionModalBody').html(response);
            $('#subscriptionModal').modal('show');
        },
        error: function() {
            alert('Error loading subscription details');
        }
    });
}

function markAsPaid(subscriptionId) {
    if (confirm('Mark this subscription as paid?')) {
        window.location.href = '<?= base_url("gym/mark_subscription_paid/"); ?>' + subscriptionId;
    }
}

function renewSubscription(subscriptionId) {
    if (confirm('Create a renewal for this subscription?')) {
        window.location.href = '<?= base_url("gym/renew_subscription/"); ?>' + subscriptionId;
    }
}

function deleteSubscription(subscriptionId) {
    if (confirm('Are you sure you want to delete this subscription? This action cannot be undone.')) {
        window.location.href = '<?= base_url("gym/delete_subscription/"); ?>' + subscriptionId;
    }
}
</script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
