<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-credit-card mr-2"></i>Subscribe to <?= $plan['plan_name']; ?>
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Plan Details -->
                    <div class="col-md-6">
                        <div class="card border-left-success h-100">
                            <div class="card-body">
                                <h5 class="text-success font-weight-bold"><?= $plan['plan_name']; ?></h5>
                                <h3 class="text-success mb-3">Rp <?= number_format($plan['price'], 0, ',', '.'); ?></h3>
                                <p class="text-muted mb-3"><?= $plan['description']; ?></p>

                                <h6 class="font-weight-bold mb-2">Plan Details:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-calendar-alt text-success mr-2"></i>Duration: <?= $plan['duration_months']; ?> months</li>
                                    <li><i class="fas fa-check text-success mr-2"></i>Features: <?= str_replace(',', ', ', $plan['features']); ?></li>
                                </ul>

                                <div class="mt-4">
                                    <h6 class="font-weight-bold">Subscription Period:</h6>
                                    <p class="mb-1"><strong>Start Date:</strong> <?= date('M d, Y'); ?></p>
                                    <p class="mb-0"><strong>End Date:</strong> <?= date('M d, Y', strtotime('+' . $plan['duration_months'] . ' months')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Form -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Payment Information</h5>

                                <form method="post" action="<?= base_url('member/process_subscription'); ?>">
                                    <input type="hidden" name="plan_id" value="<?= $plan['id']; ?>">

                                    <div class="form-group">
                                        <label for="member_name">Member Name</label>
                                        <input type="text" class="form-control" id="member_name"
                                            value="<?= $member['name']; ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="member_code">Member Code</label>
                                        <input type="text" class="form-control" id="member_code"
                                            value="<?= $member['member_code']; ?>" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="amount">Amount to Pay</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="text" class="form-control" id="amount"
                                                value="<?= number_format($plan['price'], 0, ',', '.'); ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                        <select class="form-control" id="payment_method" name="payment_method" required onchange="togglePaymentOptions()">
                                            <option value="">Select Payment Method</option>
                                            <option value="midtrans">Online Payment (Credit Card, Bank Transfer, E-Wallet)</option>
                                            <option value="cash">Cash Payment at Gym</option>
                                        </select>
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Online payment supports various methods including Credit Card, Bank Transfer, GoPay, OVO, DANA, and more.
                                        </small>
                                    </div>

                                    <!-- Midtrans Payment Info -->
                                    <div id="midtrans_info" class="alert alert-info" style="display: none;">
                                        <h6><i class="fas fa-credit-card mr-2"></i>Online Payment Options:</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fas fa-check text-success mr-1"></i> Credit/Debit Cards (Visa, MasterCard)</li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> Bank Transfer (BCA, BNI, BRI, Mandiri)</li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> E-Wallets (GoPay, OVO, DANA)</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fas fa-check text-success mr-1"></i> Indomaret/Alfamart</li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> Secure & Encrypted</li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> Instant Activation</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="terms_agreement" required>
                                            <label class="custom-control-label" for="terms_agreement">
                                                I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group mb-0">
                                        <button type="button" id="pay_button" class="btn btn-success btn-block" onclick="processPayment()">
                                            <i class="fas fa-credit-card mr-2"></i>
                                            <span id="button_text">Complete Subscription</span>
                                        </button>
                                        <button type="submit" id="cash_button" class="btn btn-warning btn-block" style="display: none;">
                                            <i class="fas fa-money-bill mr-2"></i>Submit Cash Payment Request
                                        </button>
                                        <a href="<?= base_url('member/membership_plans'); ?>" class="btn btn-secondary btn-block mt-2">
                                            <i class="fas fa-arrow-left mr-2"></i>Back to Plans
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Gym Membership Terms and Conditions</h6>
                <ol>
                    <li><strong>Membership Duration:</strong> Your membership is valid for the selected duration from the start date.</li>
                    <li><strong>Payment:</strong> Payment must be made in full before membership activation.</li>
                    <li><strong>Gym Access:</strong> Members have access to gym facilities during operating hours only.</li>
                    <li><strong>Equipment Usage:</strong> Members must follow proper equipment usage guidelines and safety protocols.</li>
                    <li><strong>Personal Belongings:</strong> The gym is not responsible for lost or stolen personal items.</li>
                    <li><strong>Health Requirements:</strong> Members must be in good health and consult a doctor before starting any exercise program.</li>
                    <li><strong>Cancellation Policy:</strong> Memberships are non-refundable once activated.</li>
                    <li><strong>Behavior:</strong> Members must maintain respectful behavior towards staff and other members.</li>
                    <li><strong>Facility Rules:</strong> All gym rules and regulations must be followed at all times.</li>
                    <li><strong>Liability:</strong> Members exercise at their own risk and the gym is not liable for injuries.</li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap JS -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key=""></script>

<script>
    // Get Midtrans client key
    let midtransClientKey = '';
    fetch('<?= base_url("payment/get_client_key"); ?>')
        .then(response => response.json())
        .then(data => {
            midtransClientKey = data.client_key;
            document.querySelector('[data-client-key]').setAttribute('data-client-key', midtransClientKey);
        });

    function togglePaymentOptions() {
        const paymentMethod = document.getElementById('payment_method').value;
        const midtransInfo = document.getElementById('midtrans_info');
        const payButton = document.getElementById('pay_button');
        const cashButton = document.getElementById('cash_button');
        const buttonText = document.getElementById('button_text');

        if (paymentMethod === 'midtrans') {
            midtransInfo.style.display = 'block';
            payButton.style.display = 'block';
            cashButton.style.display = 'none';
            buttonText.textContent = 'Pay Now';
            payButton.className = 'btn btn-success btn-block';
        } else if (paymentMethod === 'cash') {
            midtransInfo.style.display = 'none';
            payButton.style.display = 'none';
            cashButton.style.display = 'block';
        } else {
            midtransInfo.style.display = 'none';
            payButton.style.display = 'block';
            cashButton.style.display = 'none';
            buttonText.textContent = 'Complete Subscription';
            payButton.className = 'btn btn-success btn-block';
        }
    }

    function processPayment() {
        const paymentMethod = document.getElementById('payment_method').value;

        if (!paymentMethod) {
            alert('Please select a payment method');
            return;
        }

        if (!document.getElementById('terms_agreement').checked) {
            alert('Please agree to the terms and conditions');
            return;
        }

        if (paymentMethod === 'midtrans') {
            // Process Midtrans payment
            const payButton = document.getElementById('pay_button');
            const buttonText = document.getElementById('button_text');

            payButton.disabled = true;
            buttonText.textContent = 'Processing...';

            // Create transaction
            fetch('<?= base_url("payment/create_transaction"); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'plan_id': '<?= $plan["id"]; ?>',
                        'member_id': '<?= $member["id"]; ?>'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Open Midtrans Snap
                        snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert('Payment successful!');
                                window.location.href = '<?= base_url("payment/finish"); ?>?order_id=' + data.order_id + '&status_code=200&transaction_status=settlement';
                            },
                            onPending: function(result) {
                                alert('Payment pending. Please complete your payment.');
                                window.location.href = '<?= base_url("payment/finish"); ?>?order_id=' + data.order_id + '&status_code=201&transaction_status=pending';
                            },
                            onError: function(result) {
                                alert('Payment failed: ' + result.status_message);
                                payButton.disabled = false;
                                buttonText.textContent = 'Pay Now';
                            },
                            onClose: function() {
                                alert('Payment popup closed');
                                payButton.disabled = false;
                                buttonText.textContent = 'Pay Now';
                            }
                        });
                    } else {
                        alert('Error: ' + data.message);
                        payButton.disabled = false;
                        buttonText.textContent = 'Pay Now';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    payButton.disabled = false;
                    buttonText.textContent = 'Pay Now';
                });
        } else {
            // For other payment methods, submit the form normally
            document.getElementById('subscriptionForm').submit();
        }
    }

    // Initialize payment options on page load
    document.addEventListener('DOMContentLoaded', function() {
        togglePaymentOptions();
    });
</script>