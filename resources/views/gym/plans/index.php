<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Membership Plans</h1>
    <a href="<?= base_url('gym/add_plan'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Plan
    </a>
</div>

<!-- Plans Cards -->
<div class="row">
    <?php if (!empty($plans)): ?>
        <?php foreach ($plans as $plan): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 <?= $plan['is_active'] ? 'bg-success' : 'bg-secondary'; ?> text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold"><?= $plan['plan_name']; ?></h6>
                            <?php if ($plan['is_active']): ?>
                                <span class="badge badge-light">Active</span>
                            <?php else: ?>
                                <span class="badge badge-dark">Inactive</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="text-center mb-3">
                            <h2 class="text-success">Rp <?= number_format($plan['price'], 0, ',', '.'); ?></h2>
                            <p class="text-muted"><?= $plan['duration_months']; ?> Month<?= $plan['duration_months'] > 1 ? 's' : ''; ?></p>
                        </div>
                        
                        <p class="text-muted"><?= $plan['description']; ?></p>
                        
                        <?php if (!empty($plan['features'])): ?>
                            <div class="mb-3">
                                <h6 class="text-success">Features:</h6>
                                <ul class="list-unstyled">
                                    <?php 
                                    $features = explode(',', $plan['features']);
                                    foreach ($features as $feature): 
                                    ?>
                                        <li><i class="fas fa-check text-success mr-2"></i><?= trim($feature); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-auto">
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <a href="<?= base_url('gym/edit_plan/' . $plan['id']); ?>" 
                                   class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-info" 
                                        onclick="viewPlanDetails(<?= $plan['id']; ?>)">
                                    <i class="fas fa-eye"></i> Details
                                </button>
                                <button type="button" class="btn btn-<?= $plan['is_active'] ? 'warning' : 'success'; ?>" 
                                        onclick="togglePlanStatus(<?= $plan['id']; ?>, <?= $plan['is_active']; ?>)">
                                    <i class="fas fa-<?= $plan['is_active'] ? 'pause' : 'play'; ?>"></i> 
                                    <?= $plan['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                </button>
                                <button type="button" class="btn btn-danger" 
                                        onclick="deletePlan(<?= $plan['id']; ?>, '<?= $plan['plan_name']; ?>')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Created: <?= date('M d, Y', strtotime($plan['created_at'])); ?></small>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="card shadow">
                <div class="card-body text-center py-5">
                    <i class="fas fa-tags fa-3x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-600">No Membership Plans Found</h5>
                    <p class="text-muted">Create your first membership plan to get started.</p>
                    <a href="<?= base_url('gym/add_plan'); ?>" class="btn btn-success">
                        <i class="fas fa-plus mr-2"></i>Add First Plan
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Plans Table -->
<?php if (!empty($plans)): ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Plans Overview</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Plan Name</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Subscribers</th>
                        <th>Revenue</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plans as $plan): ?>
                        <tr>
                            <td><?= $plan['plan_name']; ?></td>
                            <td><?= $plan['duration_months']; ?> Month<?= $plan['duration_months'] > 1 ? 's' : ''; ?></td>
                            <td>Rp <?= number_format($plan['price'], 0, ',', '.'); ?></td>
                            <td>
                                <?php if ($plan['is_active']): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-info">0</span>
                                <!-- TODO: Add subscriber count -->
                            </td>
                            <td>Rp 0</td>
                            <td><?= date('M d, Y', strtotime($plan['created_at'])); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="<?= base_url('gym/edit_plan/' . $plan['id']); ?>" 
                                       class="btn btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-info" 
                                            onclick="viewPlanDetails(<?= $plan['id']; ?>)" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" 
                                            onclick="deletePlan(<?= $plan['id']; ?>, '<?= $plan['plan_name']; ?>')" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Plan Details Modal -->
<div class="modal fade" id="planModal" tabindex="-1" role="dialog" aria-labelledby="planModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="planModalLabel">Plan Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="planModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete plan <strong id="planName"></strong>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        "pageLength": 25,
        "order": [[ 6, "desc" ]], // Sort by created date
        "columnDefs": [
            { "orderable": false, "targets": 7 } // Disable sorting for Actions column
        ]
    });
});

function viewPlanDetails(planId) {
    // Load plan details via AJAX
    $.ajax({
        url: '<?= base_url("gym/get_plan_details/"); ?>' + planId,
        type: 'GET',
        success: function(response) {
            $('#planModalBody').html(response);
            $('#planModal').modal('show');
        },
        error: function() {
            alert('Error loading plan details');
        }
    });
}

function togglePlanStatus(planId, currentStatus) {
    const action = currentStatus ? 'deactivate' : 'activate';
    if (confirm(`Are you sure you want to ${action} this plan?`)) {
        window.location.href = '<?= base_url("gym/toggle_plan_status/"); ?>' + planId;
    }
}

function deletePlan(planId, planName) {
    $('#planName').text(planName);
    $('#confirmDelete').attr('href', '<?= base_url("gym/delete_plan/"); ?>' + planId);
    $('#deleteModal').modal('show');
}
</script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
