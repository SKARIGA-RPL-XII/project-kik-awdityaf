<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Member Management</h1>
    <a href="<?= base_url('gym/add_member'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Add New Member
    </a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">All Members</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Member Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th>Current Plan</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($members)): ?>
                    <?php foreach ($members as $member): ?>
                    <tr>
                        <td><?= $member['member_code']; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img class="rounded-circle mr-2" width="30" height="30"
                                    src="<?= base_url('assets/img/profile/' . ($member['image'] ?? 'default.jpg')); ?>"
                                    alt="<?= $member['name']; ?>">
                                <?= $member['name']; ?>
                            </div>
                        </td>
                        <td><?= $member['email']; ?></td>
                        <td><?= $member['phone'] ?? '-'; ?></td>
                        <td>
                            <?php if ($member['gender'] == 'Male'): ?>
                            <span class="badge badge-primary">Male</span>
                            <?php else: ?>
                            <span class="badge badge-pink">Female</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('M d, Y', strtotime($member['join_date'])); ?></td>
                        <td>
                            <?php if ($member['status'] == 'Active'): ?>
                            <span class="badge badge-success">Active</span>
                            <?php elseif ($member['status'] == 'Inactive'): ?>
                            <span class="badge badge-secondary">Inactive</span>
                            <?php else: ?>
                            <span class="badge badge-warning">Suspended</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($member['plan_name'])): ?>
                            <span class="badge badge-info"><?= $member['plan_name']; ?></span>
                            <?php if (!empty($member['membership_end'])): ?>
                            <br><small class="text-muted">Until:
                                <?= date('M d, Y', strtotime($member['membership_end'])); ?></small>
                            <?php endif; ?>
                            <?php else: ?>
                            <span class="badge badge-warning">No Plan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="<?= base_url('gym/edit_member/' . $member['id']); ?>"
                                    class="btn btn-sm btn-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-info"
                                    onclick="viewMember(<?= $member['id']; ?>)" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="deleteMember(<?= $member['id']; ?>, '<?= $member['name']; ?>')"
                                    title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No members found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Member Details Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">Member Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="memberModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete member <strong id="memberName"></strong>? This action cannot be undone.
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
        "order": [
            [5, "desc"]
        ], // Sort by join date
        "columnDefs": [{
                "orderable": false,
                "targets": 8
            } // Disable sorting for Actions column
        ]
    });
});

function viewMember(memberId) {
    // Load member details via AJAX
    $.ajax({
        url: '<?= base_url("gym/get_member_details/"); ?>' + memberId,
        type: 'GET',
        success: function(response) {
            $('#memberModalBody').html(response);
            $('#memberModal').modal('show');
        },
        error: function() {
            alert('Error loading member details');
        }
    });
}

function deleteMember(memberId, memberName) {
    $('#memberName').text(memberName);
    $('#confirmDelete').attr('href', '<?= base_url("gym/delete_member/"); ?>' + memberId);
    $('#deleteModal').modal('show');
}
</script>

<!-- Page level plugins -->
<script src="<?= base_url('assets/'); ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<link href="<?= base_url('assets/'); ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">