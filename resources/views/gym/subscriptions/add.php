<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Subscription</h1>
    <a href="<?= base_url('gym/subscriptions'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Subscriptions
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Subscription Information</h6>
            </div>
            <div class="card-body">
                <?= form_open('gym/add_subscription', ['class' => 'user']); ?>
                
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="member_id">Select Member <span class="text-danger">*</span></label>
                        <select class="form-control" id="member_id" name="member_id" required>
                            <option value="">Choose Member</option>
                            <?php foreach ($members as $member): ?>
                                <option value="<?= $member['id']; ?>" <?= set_select('member_id', $member['id']); ?>>
                                    <?= $member['name']; ?> (<?= $member['member_code']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('member_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="membership_plan_id">Select Plan <span class="text-danger">*</span></label>
                        <select class="form-control" id="membership_plan_id" name="membership_plan_id" required onchange="updatePlanDetails()">
                            <option value="">Choose Plan</option>
                            <?php foreach ($plans as $plan): ?>
                                <option value="<?= $plan['id']; ?>" 
                                        data-price="<?= $plan['price']; ?>" 
                                        data-duration="<?= $plan['duration_months']; ?>"
                                        <?= set_select('membership_plan_id', $plan['id']); ?>>
                                    <?= $plan['plan_name']; ?> - Rp <?= number_format($plan['price'], 0, ',', '.'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?= form_error('membership_plan_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control form-control-user" id="start_date" name="start_date" 
                               value="<?= set_value('start_date', date('Y-m-d')); ?>" required onchange="calculateEndDate()">
                        <?= form_error('start_date', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date">End Date</label>
                        <input type="date" class="form-control form-control-user" id="end_date" readonly>
                        <small class="text-muted">Calculated automatically based on plan duration</small>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="amount_paid">Amount Paid <span class="text-danger">*</span></label>
                        <input type="number" class="form-control form-control-user" id="amount_paid" name="amount_paid" 
                               placeholder="Enter amount paid" value="<?= set_value('amount_paid'); ?>" min="0" step="1000" required>
                        <?= form_error('amount_paid', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="col-sm-6">
                        <label for="payment_status">Payment Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="payment_status" name="payment_status" required>
                            <option value="Paid" <?= set_select('payment_status', 'Paid', true); ?>>Paid</option>
                            <option value="Pending" <?= set_select('payment_status', 'Pending'); ?>>Pending</option>
                            <option value="Overdue" <?= set_select('payment_status', 'Overdue'); ?>>Overdue</option>
                        </select>
                        <?= form_error('payment_status', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes (Optional)</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3" 
                              placeholder="Enter any additional notes"><?= set_value('notes'); ?></textarea>
                </div>

                <hr>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btn-user btn-block">
                            <i class="fas fa-plus mr-2"></i>Create Subscription
                        </button>
                    </div>
                    <div class="col-sm-6">
                        <a href="<?= base_url('gym/subscriptions'); ?>" class="btn btn-secondary btn-user btn-block">
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
                <h6 class="m-0 font-weight-bold text-info">Subscription Preview</h6>
            </div>
            <div class="card-body">
                <div id="subscription_preview">
                    <div class="text-center mb-3">
                        <i class="fas fa-credit-card fa-3x text-gray-300"></i>
                        <p class="text-muted mt-2">Select member and plan to see preview</p>
                    </div>
                </div>
                
                <div id="plan_details" style="display: none;">
                    <h6 class="text-success">Plan Details</h6>
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>Plan:</strong></td>
                            <td id="preview_plan_name">-</td>
                        </tr>
                        <tr>
                            <td><strong>Duration:</strong></td>
                            <td id="preview_duration">-</td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td id="preview_price">-</td>
                        </tr>
                        <tr>
                            <td><strong>Start Date:</strong></td>
                            <td id="preview_start_date">-</td>
                        </tr>
                        <tr>
                            <td><strong>End Date:</strong></td>
                            <td id="preview_end_date">-</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Important Notes</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle mr-2"></i>Subscription Guidelines</h6>
                    <ul class="mb-0">
                        <li>End date is calculated automatically</li>
                        <li>Payment status can be changed later</li>
                        <li>Member will receive access immediately if paid</li>
                        <li>Subscription starts on the selected start date</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle mr-2"></i>Before Creating</h6>
                    <ul class="mb-0">
                        <li>Verify member information</li>
                        <li>Confirm payment received</li>
                        <li>Check for existing active subscriptions</li>
                        <li>Ensure plan is still active</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePlanDetails() {
    const planSelect = document.getElementById('membership_plan_id');
    const selectedOption = planSelect.options[planSelect.selectedIndex];
    
    if (selectedOption.value) {
        const price = selectedOption.getAttribute('data-price');
        const duration = selectedOption.getAttribute('data-duration');
        
        document.getElementById('preview_plan_name').textContent = selectedOption.text.split(' - ')[0];
        document.getElementById('preview_duration').textContent = duration + ' month' + (duration > 1 ? 's' : '');
        document.getElementById('preview_price').textContent = 'Rp ' + parseInt(price).toLocaleString('id-ID');
        document.getElementById('amount_paid').value = price;
        
        document.getElementById('plan_details').style.display = 'block';
        calculateEndDate();
    } else {
        document.getElementById('plan_details').style.display = 'none';
    }
}

function calculateEndDate() {
    const startDate = document.getElementById('start_date').value;
    const planSelect = document.getElementById('membership_plan_id');
    const selectedOption = planSelect.options[planSelect.selectedIndex];
    
    if (startDate && selectedOption.value) {
        const duration = parseInt(selectedOption.getAttribute('data-duration'));
        const start = new Date(startDate);
        const end = new Date(start.getFullYear(), start.getMonth() + duration, start.getDate());
        
        const endDateString = end.toISOString().split('T')[0];
        document.getElementById('end_date').value = endDateString;
        document.getElementById('preview_start_date').textContent = new Date(startDate).toLocaleDateString('id-ID');
        document.getElementById('preview_end_date').textContent = end.toLocaleDateString('id-ID');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updatePlanDetails();
    calculateEndDate();
});

// Format amount input
document.getElementById('amount_paid').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, ''); // Remove non-digits
    this.value = value;
});
</script>
