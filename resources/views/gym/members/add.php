<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Member</h1>
    <a href="<?= base_url('gym/members'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Members
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Member Information</h6>
            </div>
            <div class="card-body">
                <?= form_open('gym/add_member', ['class' => 'user']); ?>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="name">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-user" id="name" name="name"
                            placeholder="Enter full name" value="<?= set_value('name'); ?>" required>
                        <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="email">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-user" id="email" name="email"
                            placeholder="Enter email address" value="<?= set_value('email'); ?>" required>
                        <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-user" id="phone" name="phone"
                            placeholder="Enter phone number" value="<?= set_value('phone'); ?>" required>
                        <?= form_error('phone', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="birth_date">Birth Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-user" id="birth_date" name="birth_date"
                            value="<?= set_value('birth_date'); ?>" required>
                        <?= form_error('birth_date', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="gender">Gender <span class="text-danger">*</span></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="Male" <?= set_select('gender', 'Male'); ?>>Male</option>
                            <option value="Female" <?= set_select('gender', 'Female'); ?>>Female</option>
                        </select>
                        <?= form_error('gender', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"
                            placeholder="Enter address"><?= set_value('address'); ?></textarea>
                    </div>
                </div>

                <hr>

                <h6 class="text-success mb-3">Emergency Contact</h6>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="emergency_contact">Emergency Contact Name</label>
                        <input type="text" class="form-control form-control-user" id="emergency_contact"
                            name="emergency_contact" placeholder="Enter emergency contact name"
                            value="<?= set_value('emergency_contact'); ?>">
                    </div>
                    <div class="col-sm-6">
                        <label for="emergency_phone">Emergency Contact Phone</label>
                        <input type="text" class="form-control form-control-user" id="emergency_phone"
                            name="emergency_phone" placeholder="Enter emergency contact phone"
                            value="<?= set_value('emergency_phone'); ?>">
                    </div>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-success btn-user btn-block">
                            <i class="fas fa-user-plus mr-2"></i>Add Member
                        </button>
                    </div>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Information</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle mr-2"></i>Member Registration</h6>
                    <ul class="mb-0">
                        <li>Member code will be generated automatically</li>
                        <li>Default password will be set to <strong>123456</strong></li>
                        <li>Member can change password after first login</li>
                        <li>All fields marked with <span class="text-danger">*</span> are required</li>
                        <li>Member will be set to Active status by default</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle mr-2"></i>Next Steps</h6>
                    <p class="mb-0">After adding the member:</p>
                    <ol class="mb-0">
                        <li>Assign a membership plan</li>
                        <li>Process payment</li>
                        <li>Provide member with login credentials</li>
                        <li>Give gym orientation</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Quick Actions</h6>
            </div>
            <div class="card-body">
                <a href="<?= base_url('gym/membership_plans'); ?>" class="btn btn-outline-success btn-block mb-2">
                    <i class="fas fa-tags mr-2"></i>View Membership Plans
                </a>
                <a href="<?= base_url('gym/members'); ?>" class="btn btn-outline-primary btn-block mb-2">
                    <i class="fas fa-users mr-2"></i>View All Members
                </a>
                <a href="<?= base_url('gym/subscriptions'); ?>" class="btn btn-outline-info btn-block">
                    <i class="fas fa-credit-card mr-2"></i>Manage Subscriptions
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Calculate age based on birth date
document.getElementById('birth_date').addEventListener('change', function() {
    const birthDate = new Date(this.value);
    const today = new Date();
    const age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();

    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }

    if (age < 16) {
        alert('Member must be at least 16 years old to join the gym.');
        this.value = '';
    }
});

// Phone number formatting
document.getElementById('phone').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length > 0 && !value.startsWith('0')) {
        value = '0' + value;
    }
    this.value = value;
});

document.getElementById('emergency_phone').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, ''); // Remove non-digits
    if (value.length > 0 && !value.startsWith('0')) {
        value = '0' + value;
    }
    this.value = value;
});
</script>