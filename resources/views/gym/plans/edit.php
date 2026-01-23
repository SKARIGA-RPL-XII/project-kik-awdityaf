<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Membership Plan</h1>
    <a href="<?= base_url('gym/membership_plans'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Plans
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Edit Plan Information</h6>
            </div>
            <div class="card-body">
                <?= form_open('gym/edit_plan/' . $plan['id'], ['class' => 'user']); ?>
                
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="plan_name">Plan Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-user" id="plan_name" name="plan_name" 
                               placeholder="Enter plan name" value="<?= set_value('plan_name', $plan['plan_name']); ?>" required>
                        <?= form_error('plan_name', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="duration_months">Duration (Months) <span class="text-danger">*</span></label>
                        <select class="form-control" id="duration_months" name="duration_months" required>
                            <option value="">Select Duration</option>
                            <option value="1" <?= set_select('duration_months', '1', $plan['duration_months'] == 1); ?>>1 Month</option>
                            <option value="3" <?= set_select('duration_months', '3', $plan['duration_months'] == 3); ?>>3 Months</option>
                            <option value="6" <?= set_select('duration_months', '6', $plan['duration_months'] == 6); ?>>6 Months</option>
                            <option value="12" <?= set_select('duration_months', '12', $plan['duration_months'] == 12); ?>>12 Months</option>
                            <option value="24" <?= set_select('duration_months', '24', $plan['duration_months'] == 24); ?>>24 Months</option>
                        </select>
                        <?= form_error('duration_months', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="price">Price (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-user" id="price" name="price" 
                               placeholder="Enter price" value="<?= set_value('price', $plan['price']); ?>" min="0" step="1000" required>
                        <?= form_error('price', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="price_per_month">Price per Month</label>
                        <input type="text" class="form-control form-control-user" id="price_per_month" readonly>
                        <small class="text-muted">Calculated automatically</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" 
                              placeholder="Enter plan description"><?= set_value('description', $plan['description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="features">Features <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="features" name="features" rows="4" 
                              placeholder="Enter features separated by commas"><?= set_value('features', $plan['features']); ?></textarea>
                    <small class="text-muted">Separate each feature with a comma</small>
                    <?= form_error('features', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                               <?= set_checkbox('is_active', '1', $plan['is_active']); ?>>
                        <label class="custom-control-label" for="is_active">Active Plan</label>
                    </div>
                    <small class="text-muted">Only active plans will be visible to members</small>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btn-user btn-block">
                            <i class="fas fa-save mr-2"></i>Update Plan
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= base_url('gym/membership_plans'); ?>" class="btn btn-secondary btn-user btn-block">
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
                <h6 class="m-0 font-weight-bold text-info">Plan Preview</h6>
            </div>
            <div class="card-body">
                <div class="card border-success">
                    <div class="card-header bg-success text-white text-center">
                        <h6 class="m-0" id="preview_name"><?= $plan['plan_name']; ?></h6>
                    </div>
                    <div class="card-body text-center">
                        <h2 class="text-success" id="preview_price">Rp <?= number_format($plan['price'], 0, ',', '.'); ?></h2>
                        <p class="text-muted" id="preview_duration"><?= $plan['duration_months']; ?> Month<?= $plan['duration_months'] > 1 ? 's' : ''; ?></p>
                        <p class="text-muted" id="preview_description"><?= $plan['description']; ?></p>
                        <div id="preview_features">
                            <h6 class="text-success">Features:</h6>
                            <ul class="list-unstyled" id="features_list">
                                <?php if (!empty($plan['features'])): ?>
                                    <?php 
                                    $features = explode(',', $plan['features']);
                                    foreach ($features as $feature): 
                                    ?>
                                        <li><i class="fas fa-check text-success mr-2"></i><?= trim($feature); ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Plan Information</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <td><strong>Created:</strong></td>
                        <td><?= date('M d, Y', strtotime($plan['created_at'])); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Updated:</strong></td>
                        <td><?= date('M d, Y', strtotime($plan['updated_at'])); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            <?php if ($plan['is_active']): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Quick Actions</h6>
            </div>
            <div class="card-body">
                <a href="<?= base_url('gym/membership_plans'); ?>" class="btn btn-outline-primary btn-block mb-2">
                    <i class="fas fa-list mr-2"></i>View All Plans
                </a>
                <a href="<?= base_url('gym/add_plan'); ?>" class="btn btn-outline-success btn-block mb-2">
                    <i class="fas fa-plus mr-2"></i>Add New Plan
                </a>
                <button type="button" class="btn btn-outline-danger btn-block" onclick="confirmDelete()">
                    <i class="fas fa-trash mr-2"></i>Delete Plan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Plan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete plan <strong><?= $plan['plan_name']; ?></strong>?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a href="<?= base_url('gym/delete_plan/' . $plan['id']); ?>" class="btn btn-danger">Delete Plan</a>
            </div>
        </div>
    </div>
</div>

<script>
// Real-time preview updates
document.getElementById('plan_name').addEventListener('input', function() {
    document.getElementById('preview_name').textContent = this.value || 'Plan Name';
});

document.getElementById('price').addEventListener('input', function() {
    const price = parseInt(this.value) || 0;
    document.getElementById('preview_price').textContent = 'Rp ' + price.toLocaleString('id-ID');
    updatePricePerMonth();
});

document.getElementById('duration_months').addEventListener('change', function() {
    const duration = parseInt(this.value) || 0;
    document.getElementById('preview_duration').textContent = duration + ' Month' + (duration > 1 ? 's' : '');
    updatePricePerMonth();
});

document.getElementById('description').addEventListener('input', function() {
    document.getElementById('preview_description').textContent = this.value || 'Plan description will appear here';
});

document.getElementById('features').addEventListener('input', function() {
    updateFeaturesPreview();
});

function updatePricePerMonth() {
    const price = parseInt(document.getElementById('price').value) || 0;
    const duration = parseInt(document.getElementById('duration_months').value) || 1;
    const pricePerMonth = Math.round(price / duration);
    document.getElementById('price_per_month').value = 'Rp ' + pricePerMonth.toLocaleString('id-ID');
}

function updateFeaturesPreview() {
    const features = document.getElementById('features').value;
    const featuresList = document.getElementById('features_list');
    
    if (features.trim()) {
        const featuresArray = features.split(',').map(f => f.trim()).filter(f => f);
        featuresList.innerHTML = '';
        featuresArray.forEach(feature => {
            const li = document.createElement('li');
            li.innerHTML = '<i class="fas fa-check text-success mr-2"></i>' + feature;
            featuresList.appendChild(li);
        });
    }
}

function confirmDelete() {
    $('#deleteModal').modal('show');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePricePerMonth();
});

// Format price input
document.getElementById('price').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, ''); // Remove non-digits
    this.value = value;
});
</script>
