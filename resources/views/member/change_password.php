<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Change Password</h6>
            </div>
            <div class="card-body">
                <?php if ($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>
                
                <?= form_open('member/change_password'); ?>
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <?= form_error('current_password', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <small class="text-muted">Password must be at least 6 characters long</small>
                        <?= form_error('new_password', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <?= form_error('confirm_password', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <button type="submit" class="btn btn-success">Change Password</button>
                    <a href="<?= base_url('member/profile'); ?>" class="btn btn-secondary">Cancel</a>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>