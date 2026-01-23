<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Membership Plan</h1>
    <a href="<?= base_url('gym/membership_plans'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Plans
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Plan Information</h6>
            </div>
            <div class="card-body">
                <?= form_open('gym/add_plan', ['class' => 'user']); ?>
                
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="plan_name">Plan Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-user" id="plan_name" name="plan_name" 
                               placeholder="Enter plan name" value="<?= set_value('plan_name'); ?>" required>
                        <?= form_error('plan_name', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="duration_months">Duration (Months) <span class="text-danger">*</span></label>
                        <select class="form-control" id="duration_months" name="duration_months" required>
                            <option value="">Select Duration</option>
                            <option value="1" <?= set_select('duration_months', '1'); ?>>1 Month</option>
                            <option value="3" <?= set_select('duration_months', '3'); ?>>3 Months</option>
                            <option value="6" <?= set_select('duration_months', '6'); ?>>6 Months</option>
                            <option value="12" <?= set_select('duration_months', '12'); ?>>12 Months</option>
                            <option value="24" <?= set_select('duration_months', '24'); ?>>24 Months</option>
                        </select>
                        <?= form_error('duration_months', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="price">Price (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-user" id="price" name="price" 
                               placeholder="Enter price" value="<?= set_value('price'); ?>" min="0" step="1000" required>
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
                              placeholder="Enter plan description"><?= set_value('description'); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="features">Features <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="features" name="features" rows="4" 
                              placeholder="Enter features separated by commas (e.g., Gym Access, Locker, Shower, Personal Trainer)"><?= set_value('features'); ?></textarea>
                    <small class="text-muted">Separate each feature with a comma</small>
                    <?= form_error('features', '<small class="text-danger">', '</small>'); ?>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                               <?= set_checkbox('is_active', '1', true); ?>>
                        <label class="custom-control-label" for="is_active">Active Plan</label>
                    </div>
                    <small class="text-muted">Only active plans will be visible to members</small>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btn-user btn-block">
                            <i class="fas fa-plus mr-2"></i>Create Plan
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
                        <h6 class="m-0" id="preview_name">Plan Name</h6>
                    </div>
                    <div class="card-body text-center">
                        <h2 class="text-success" id="preview_price">Rp 0</h2>
                        <p class="text-muted" id="preview_duration">0 Months</p>
                        <p class="text-muted" id="preview_description">Plan description will appear here</p>
                        <div id="preview_features">
                            <h6 class="text-success">Features:</h6>
                            <ul class="list-unstyled" id="features_list">
                                <li><i class="fas fa-check text-success mr-2"></i>Feature will appear here</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Pricing Guidelines</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb mr-2"></i>Pricing Tips</h6>
                    <ul class="mb-0">
                        <li>Consider market rates in your area</li>
                        <li>Longer plans should offer better value</li>
                        <li>Include clear feature descriptions</li>
                        <li>Test pricing with potential customers</li>
                    </ul>
                </div>

                <div class="alert alert-success">
                    <h6><i class="fas fa-chart-line mr-2"></i>Popular Durations</h6>
                    <ul class="mb-0">
                        <li><strong>1 Month:</strong> Trial/Flexible</li>
                        <li><strong>3 Months:</strong> Most Popular</li>
                        <li><strong>6 Months:</strong> Committed Users</li>
                        <li><strong>12 Months:</strong> Best Value</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Common Features</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Gym Access')">Gym Access</button>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Locker')">Locker</button>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Shower')">Shower</button>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Personal Trainer')">Personal Trainer</button>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Group Classes')">Group Classes</button>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Sauna')">Sauna</button>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Swimming Pool')">Swimming Pool</button>
                        <button type="button" class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Nutrition Consultation')">Nutrition Consultation</button>
                    </div>
                </div>
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
    } else {
        featuresList.innerHTML = '<li><i class="fas fa-check text-success mr-2"></i>Feature will appear here</li>';
    }
}

function addFeature(feature) {
    const featuresTextarea = document.getElementById('features');
    const currentFeatures = featuresTextarea.value;
    
    if (currentFeatures.trim()) {
        if (!currentFeatures.includes(feature)) {
            featuresTextarea.value = currentFeatures + ', ' + feature;
        }
    } else {
        featuresTextarea.value = feature;
    }
    
    updateFeaturesPreview();
}

// Format price input
document.getElementById('price').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, ''); // Remove non-digits
    this.value = value;
});
</script>
