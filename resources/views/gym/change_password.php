<!-- Page Header -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow border-left-warning">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-key text-warning mr-2"></i>Change Password
                        </h1>
                        <p class="mb-0 text-muted">Update your admin account password</p>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('gym/profile'); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-lock mr-2"></i>Password Security
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Password Requirements:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Minimum 6 characters long</li>
                        <li>Use a combination of letters and numbers</li>
                        <li>Avoid using personal information</li>
                    </ul>
                </div>
                
                <form method="post" action="<?= base_url('gym/change_password'); ?>">
                    <div class="form-group">
                        <label for="current_password" class="form-label font-weight-bold">
                            Current Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="current_password" name="current_password" 
                                   placeholder="Enter your current password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_icon"></i>
                                </button>
                            </div>
                        </div>
                        <?= form_error('current_password', '<div class="text-danger mt-1">', '</div>'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password" class="form-label font-weight-bold">
                            New Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                   placeholder="Enter your new password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password_icon"></i>
                                </button>
                            </div>
                        </div>
                        <?= form_error('new_password', '<div class="text-danger mt-1">', '</div>'); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password" class="form-label font-weight-bold">
                            Confirm New Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                   placeholder="Confirm your new password" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('confirm_password')">
                                    <i class="fas fa-eye" id="confirm_password_icon"></i>
                                </button>
                            </div>
                        </div>
                        <?= form_error('confirm_password', '<div class="text-danger mt-1">', '</div>'); ?>
                    </div>
                    
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-save mr-2"></i>Change Password
                        </button>
                        <a href="<?= base_url('gym/profile'); ?>" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Security Tips -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-shield-alt mr-2"></i>Security Tips
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-success">
                            <i class="fas fa-check mr-2"></i>Do:
                        </h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success mr-2"></i>Use strong passwords</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Change passwords regularly</li>
                            <li><i class="fas fa-check text-success mr-2"></i>Keep passwords private</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="font-weight-bold text-danger">
                            <i class="fas fa-times mr-2"></i>Don't:
                        </h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-times text-danger mr-2"></i>Share your password</li>
                            <li><i class="fas fa-times text-danger mr-2"></i>Use simple passwords</li>
                            <li><i class="fas fa-times text-danger mr-2"></i>Write passwords down</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength indicator
document.getElementById('new_password').addEventListener('input', function() {
    const password = this.value;
    const strengthBar = document.getElementById('password_strength');
    
    if (password.length < 6) {
        this.style.borderColor = '#e74a3b';
    } else if (password.length < 8) {
        this.style.borderColor = '#f6c23e';
    } else {
        this.style.borderColor = '#1cc88a';
    }
});

// Confirm password validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword !== newPassword) {
        this.style.borderColor = '#e74a3b';
    } else {
        this.style.borderColor = '#1cc88a';
    }
});
</script>
