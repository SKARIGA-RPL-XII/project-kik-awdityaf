@extends('layouts.member.app')

@section('content')

<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-credit-card mr-2"></i>
                    Subscribe to {{ $plan['plan_name'] }}
                </h6>
            </div>

            <div class="card-body">
                <div class="row">

                    <!-- Plan Details -->
                    <div class="col-md-6">
                        <div class="card border-left-success h-100">
                            <div class="card-body">

                                <h5 class="text-success font-weight-bold">
                                    {{ $plan['plan_name'] }}
                                </h5>

                                <h3 class="text-success mb-3">
                                    Rp {{ number_format($plan['price'],0,',','.') }}
                                </h3>

                                <p class="text-muted mb-3">
                                    {{ $plan['description'] }}
                                </p>

                                <h6 class="font-weight-bold mb-2">Plan Details:</h6>

                                <ul class="list-unstyled">
                                    <li>
                                        <i class="fas fa-calendar-alt text-success mr-2"></i>
                                        Duration: {{ $plan['duration_months'] }} months
                                    </li>

                                    <li>
                                        <i class="fas fa-check text-success mr-2"></i>
                                        Features: {{ str_replace(',', ', ', $plan['features']) }}
                                    </li>
                                </ul>

                                <div class="mt-4">
                                    <h6 class="font-weight-bold">Subscription Period:</h6>

                                    <p class="mb-1">
                                        <strong>Start Date:</strong>
                                        {{ now()->format('M d, Y') }}
                                    </p>

                                    <p class="mb-0">
                                        <strong>End Date:</strong>
                                        {{ now()->addMonths($plan['duration_months'])->format('M d, Y') }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>


                    <!-- Payment Form -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">

                                <h5 class="card-title">Payment Information</h5>

                                <form method="POST" action="{{ url('member/process_subscription') }}"
                                    id="subscriptionForm">

                                    @csrf

                                    <input type="hidden" name="plan_id" value="{{ $plan['id'] }}">

                                    <div class="form-group">
                                        <label>Member Name</label>
                                        <input type="text" class="form-control" value="{{ $member['name'] }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Member Code</label>
                                        <input type="text" class="form-control" value="{{ $member['member_code'] }}"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Amount to Pay</label>

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>

                                            <input type="text" class="form-control"
                                                value="{{ number_format($plan['price'],0,',','.') }}" readonly>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>
                                            Payment Method <span class="text-danger">*</span>
                                        </label>

                                        <select class="form-control" id="payment_method" name="payment_method" required
                                            onchange="togglePaymentOptions()">

                                            <option value="">Select Payment Method</option>

                                            <option value="midtrans">
                                                Online Payment (Credit Card, Bank, E-Wallet)
                                            </option>

                                            <option value="cash">
                                                Cash Payment at Gym
                                            </option>

                                        </select>
                                    </div>


                                    <!-- Midtrans Info -->
                                    <div id="midtrans_info" class="alert alert-info" style="display:none">

                                        <h6>
                                            <i class="fas fa-credit-card mr-2"></i>
                                            Online Payment Options:
                                        </h6>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fas fa-check text-success mr-1"></i> Credit Card</li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> Bank Transfer
                                                    </li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> E-Wallet</li>
                                                </ul>
                                            </div>

                                            <div class="col-md-6">
                                                <ul class="list-unstyled mb-0">
                                                    <li><i class="fas fa-check text-success mr-1"></i> Indomaret</li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> Secure</li>
                                                    <li><i class="fas fa-check text-success mr-1"></i> Instant</li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">

                                            <input type="checkbox" class="custom-control-input" id="terms_agreement"
                                                required>

                                            <label class="custom-control-label" for="terms_agreement">
                                                I agree to
                                                <a href="#" data-toggle="modal" data-target="#termsModal">
                                                    Terms and Conditions
                                                </a>
                                            </label>

                                        </div>
                                    </div>


                                    <div class="form-group mb-0">

                                        <button type="button" id="pay_button" class="btn btn-success btn-block"
                                            onclick="processPayment()">

                                            <i class="fas fa-credit-card mr-2"></i>
                                            <span id="button_text">Complete Subscription</span>

                                        </button>

                                        <button type="submit" id="cash_button" class="btn btn-warning btn-block"
                                            style="display:none">

                                            <i class="fas fa-money-bill mr-2"></i>
                                            Submit Cash Payment

                                        </button>


                                        <a href="{{ url('member/membership_plans') }}"
                                            class="btn btn-secondary btn-block mt-2">

                                            <i class="fas fa-arrow-left mr-2"></i>
                                            Back to Plans

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



<!-- Midtrans -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key=""></script>


<script>
let midtransClientKey = '';

fetch("{{ url('payment/get_client_key') }}")
    .then(res => res.json())
    .then(data => {

        midtransClientKey = data.client_key;

        document
            .querySelector('[data-client-key]')
            .setAttribute('data-client-key', midtransClientKey);

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

    } else if (paymentMethod === 'cash') {

        midtransInfo.style.display = 'none';
        payButton.style.display = 'none';
        cashButton.style.display = 'block';

    } else {

        midtransInfo.style.display = 'none';
        payButton.style.display = 'block';
        cashButton.style.display = 'none';

        buttonText.textContent = 'Complete Subscription';
    }
}



function processPayment() {

    const paymentMethod = document.getElementById('payment_method').value;

    if (!paymentMethod) {
        alert('Select payment method');
        return;
    }

    if (!document.getElementById('terms_agreement').checked) {
        alert('Please agree to terms');
        return;
    }


    if (paymentMethod === 'midtrans') {

        fetch("{{ url('payment/create_transaction') }}", {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                body: new URLSearchParams({

                    plan_id: '{{ $plan["id"] }}',
                    member_id: '{{ $member["id"] }}'

                })

            })

            .then(res => res.json())

            .then(data => {

                if (data.status === 'success') {

                    snap.pay(data.snap_token, {

                        onSuccess: function() {

                            window.location.href =
                                "{{ url('payment/finish') }}?order_id=" + data.order_id;

                        }

                    });

                } else {

                    alert(data.message);

                }

            });

    } else {

        document.getElementById('subscriptionForm').submit();

    }
}



document.addEventListener('DOMContentLoaded', function() {

    togglePaymentOptions();

});
</script>