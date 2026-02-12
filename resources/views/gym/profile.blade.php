<!-- Page Header -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow border-left-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-user-cog text-primary mr-2"></i>Admin Profile
                        </h1>
                        <p class="mb-0 text-muted">Manage your admin account settings</p>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('gym/change_password'); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-key mr-2"></i>Change Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Profile Information -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit mr-2"></i>Profile Information
                </h6>
            </div>
            <div class="card-body">
                <form method="post" action="<?= base_url('gym/update_profile'); ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= set_value('name', $user['name']); ?>" required>
                                <?= form_error('name', '<div class="text-danger mt-1">', '</div>'); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label font-weight-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= set_value('email', $user['email']); ?>" required>
                                <?= form_error('email', '<div class="text-danger mt-1">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role" class="form-label font-weight-bold">Role</label>
                                <input type="text" class="form-control" id="role" value="Administrator" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="member_since" class="form-label font-weight-bold">Admin Since</label>
                                <input type="text" class="form-control" id="member_since" 
                                       value="<?= date('M d, Y', $user['date_created']); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                        <a href="<?= base_url('gym'); ?>" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Profile Summary -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user mr-2"></i>Admin Information
                </h6>
            </div>
            <div class="card-body text-center">
                <img class="img-profile rounded-circle mb-3" width="100" height="100" 
                     src="<?= base_url('assets/img/profile/' . ($user['image'] ?? 'default.jpg')); ?>" alt="Admin Profile">
                <h5 class="mb-1"><?= $user['name']; ?></h5>
                <p class="text-muted mb-3">System Administrator</p>
                
                <div class="text-left">
                    <p class="mb-2">
                        <strong><i class="fas fa-envelope text-primary mr-2"></i>Email:</strong><br>
                        <span class="text-muted"><?= $user['email']; ?></span>
                    </p>
                    <p class="mb-2">
                        <strong><i class="fas fa-calendar text-primary mr-2"></i>Admin Since:</strong><br>
                        <span class="text-muted"><?= date('M d, Y', $user['date_created']); ?></span>
                    </p>
                    <p class="mb-2">
                        <strong><i class="fas fa-shield-alt text-primary mr-2"></i>Status:</strong><br>
                        <span class="badge badge-success">Active</span>
                    </p>
                    <p class="mb-0">
                        <strong><i class="fas fa-key text-primary mr-2"></i>Last Login:</strong><br>
                        <span class="text-muted">Today</span>
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt mr-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="<?= base_url('gym/change_password'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-key text-warning mr-2"></i>Change Password
                    </a>
                    <a href="<?= base_url('gym/members'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-users text-info mr-2"></i>Manage Members
                    </a>
                    <a href="<?= base_url('gym/membership_plans'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags text-success mr-2"></i>Membership Plans
                    </a>
                    <a href="<?= base_url('gym/reports'); ?>" class="list-group-item list-group-item-action">
                        <i class="fas fa-chart-bar text-primary mr-2"></i>View Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.img-profile {
    border: 3px solid #e3e6f0;
}

.list-group-item-action:hover {
    background-color: #f8f9fc;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}
</style>
