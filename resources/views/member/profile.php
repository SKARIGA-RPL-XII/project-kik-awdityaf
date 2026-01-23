<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">My Profile</h6>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>
                
                <form action="<?= base_url('member/profile/update'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Full Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name']; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" value="<?= $user['email']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= isset($member['phone']) ? $member['phone'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="address" class="col-sm-3 col-form-label">Address</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="address" name="address" rows="3" required><?= isset($member['address']) ? $member['address'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-success">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Member Information</h6>
            </div>
            <div class="card-body text-center">
                <img class="img-profile rounded-circle mb-3" width="100" height="100" src="<?= base_url('assets/img/profile/' . (isset($user['image']) ? $user['image'] : 'default.jpg')); ?>">
                <h5 class="mb-1"><?= $user['name']; ?></h5>
                <?php if (isset($member['member_code'])): ?>
                    <p class="text-muted mb-3">Member ID: <strong><?= $member['member_code']; ?></strong></p>
                <?php endif; ?>
                <p class="text-muted mb-0">
                    <strong>Join Date:</strong> <?= isset($member['join_date']) ? date('M d, Y', strtotime($member['join_date'])) : '-'; ?><br>
                    <strong>Status:</strong> <span class="badge badge-<?= isset($member['status']) && $member['status'] == 'Active' ? 'success' : 'danger'; ?>"><?= isset($member['status']) ? $member['status'] : 'Inactive'; ?></span>
                </p>
            </div>
        </div>
    </div>
</div>
