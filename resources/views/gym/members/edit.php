<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Member</h1>
    <a href="<?= base_url('gym/members'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Members
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Edit Member Information</h6>
            </div>
            <div class="card-body">
                <?= form_open('gym/edit_member/' . $member['id'], ['class' => 'user']); ?>
                
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-user" id="name" name="name" 
                               placeholder="Enter full name" value="<?= set_value('name', $member['name']); ?>" required>
                        <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="member_code">Member Code</label>
                        <input type="text" class="form-control form-control-user" id="member_code" 
                               value="<?= $member['member_code']; ?>" readonly>
                        <small class="text-muted">Member code cannot be changed</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control form-control-user" id="email" 
                               value="<?= $member['email']; ?>" readonly>
                        <small class="text-muted">Email cannot be changed</small>
                    </div>
                    <div class="col-sm-6">
                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-user" id="phone" name="phone" 
                               placeholder="Enter phone number" value="<?= set_value('phone', $member['phone']); ?>" required>
                        <?= form_error('phone', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="birth_date">Birth Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-user" id="birth_date" name="birth_date" 
                               value="<?= set_value('birth_date', $member['birth_date']); ?>" required>
                        <?= form_error('birth_date', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="gender">Gender <span class="text-danger">*</span></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?= set_select('gender', 'Male', $member['gender'] == 'Male'); ?>>Male</option>
                            <option value="Female" <?= set_select('gender', 'Female', $member['gender'] == 'Female'); ?>>Female</option>
                        </select>
                        <?= form_error('gender', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Active" <?= set_select('status', 'Active', $member['status'] == 'Active'); ?>>Active</option>
                            <option value="Inactive" <?= set_select('status', 'Inactive', $member['status'] == 'Inactive'); ?>>Inactive</option>
                            <option value="Suspended" <?= set_select('status', 'Suspended', $member['status'] == 'Suspended'); ?>>Suspended</option>
                        </select>
                        <?= form_error('status', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="join_date">Join Date</label>
                        <input type="date" class="form-control form-control-user" id="join_date" 
                               value="<?= $member['join_date']; ?>" readonly>
                        <small class="text-muted">Join date cannot be changed</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" 
                              placeholder="Enter address"><?= set_value('address', $member['address']); ?></textarea>
                </div>

                <hr>

                <h6 class="text-success mb-3">Emergency Contact</h6>
                
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="emergency_contact">Emergency Contact Name</label>
                        <input type="text" class="form-control form-control-user" id="emergency_contact" name="emergency_contact" 
                               placeholder="Enter emergency contact name" value="<?= set_value('emergency_contact', $member['emergency_contact']); ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="emergency_phone">Emergency Contact Phone</label>
                        <input type="text" class="form-control form-control-user" id="emergency_phone" name="emergency_phone" 
                               placeholder="Enter emergency contact phone" value="<?= set_value('emergency_phone', $member['emergency_phone']); ?>">
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btn-user btn-block">
                            <i class="fas fa-save mr-2"></i>Update Member
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= base_url('gym/members'); ?>" class="btn btn-secondary btn-user btn-block">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Member Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img class="img-profile rounded-circle" width="80" height="80"
                         src="<?= base_url('assets/img/profile/' . ($member['image'] ?? 'default.jpg')); ?>"
                         alt="<?= $member['name']; ?>">
                </div>
                
                <table class="table table-borderless table-sm">
                    <tr>
                        <td><strong>Member Code:</strong></td>
                        <td><?= $member['member_code']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td><?= $member['email']; ?></td>
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

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Quick Actions</h6>
            </div>
            <div class="card-body">
                <a href="<?= base_url('gym/subscriptions?member=' . $member['id']); ?>" class="btn btn-outline-primary btn-block mb-2">
                    <i class="fas fa-credit-card mr-2"></i>View Subscriptions
                </a>
                <a href="<?= base_url('gym/attendance?member=' . $member['id']); ?>" class="btn btn-outline-info btn-block mb-2">
                    <i class="fas fa-calendar-check mr-2"></i>View Attendance
                </a>
                <button type="button" class="btn btn-outline-warning btn-block mb-2" onclick="resetPassword()">
                    <i class="fas fa-key mr-2"></i>Reset Password
                </button>
                <button type="button" class="btn btn-outline-danger btn-block" onclick="confirmDelete()">
                    <i class="fas fa-trash mr-2"></i>Delete Member
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to reset password for <strong><?= $member['name']; ?></strong>?</p>
                <p>The password will be reset to: <strong>123456</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?= base_url('gym/reset_password/' . $member['id']); ?>" class="btn btn-warning">Reset Password</a>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Member</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete member <strong><?= $member['name']; ?></strong>?</p>
                <p class="text-danger">This action cannot be undone and will also delete all related data including subscriptions and attendance records.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?= base_url('gym/delete_member/' . $member['id']); ?>" class="btn btn-danger">Delete Member</a>
            </div>
        </div>
    </div>
</div>

<script>
function resetPassword() {
    $('#resetPasswordModal').modal('show');
}

function confirmDelete() {
    $('#deleteModal').modal('show');
}

// Phone number formatting
document.getElementById('phone').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value.length > 0 && !value.startsWith('0')) {
        value = '0' + value;
    }
    this.value = value;
});

document.getElementById('emergency_phone').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value.length > 0 && !value.startsWith('0')) {
        value = '0' + value;
    }
    this.value = value;
});
</script>
