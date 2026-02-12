@extends('layouts.app')

@section('title', 'Gym Settings')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-cog text-primary mr-2"></i> Gym Settings
    </h1>

    <div>
        <button class="btn btn-primary btn-sm" onclick="saveSettings()">
            <i class="fas fa-save fa-sm text-white-50"></i> Save Settings
        </button>
    </div>
</div>

<!-- Settings Cards -->
<div class="row">

    <!-- Gym Information -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-dumbbell mr-2"></i> Gym Information
                </h6>
            </div>
            <div class="card-body">
                <form id="gymInfoForm">
                    <div class="form-group">
                        <label for="gymName">Gym Name</label>
                        <input type="text" class="form-control" id="gymName" name="gym_name" value="FitGym" required>
                    </div>

                    <div class="form-group">
                        <label for="gymAddress">Address</label>
                        <textarea class="form-control" id="gymAddress" name="gym_address" rows="3" required>
123 Fitness Street, Jakarta
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="gymPhone">Phone</label>
                        <input type="text" class="form-control" id="gymPhone" name="gym_phone" value="+62 21 1234 5678"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="gymEmail">Email</label>
                        <input type="email" class="form-control" id="gymEmail" name="gym_email" value="info@fitgym.com"
                            required>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Business Hours -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock mr-2"></i> Business Hours
                </h6>
            </div>
            <div class="card-body">
                <form id="businessHoursForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="openTime">Opening Time</label>
                                <input type="time" class="form-control" id="openTime" name="open_time" value="06:00"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="closeTime">Closing Time</label>
                                <input type="time" class="form-control" id="closeTime" name="close_time" value="22:00"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Days Open</label>
                        <div class="row">
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as
                            $day)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $day }}"
                                        id="day{{ $day }}" checked>
                                    <label class="form-check-label" for="day{{ $day }}">
                                        {{ $day }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Membership Settings -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users mr-2"></i> Membership Settings
                </h6>
            </div>
            <div class="card-body">
                <form id="membershipForm">
                    <div class="form-group">
                        <label for="trialDays">Free Trial Days</label>
                        <input type="number" class="form-control" id="trialDays" name="trial_days" value="7" min="0"
                            max="30">
                    </div>

                    <div class="form-group">
                        <label for="maxMembers">Maximum Members</label>
                        <input type="number" class="form-control" id="maxMembers" name="max_members" value="500"
                            min="0">
                    </div>

                    <div class="form-group">
                        <label for="autoRenew">Auto Renew Subscriptions</label>
                        <select class="form-control" id="autoRenew" name="auto_renew">
                            <option value="1" selected>Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notificationDays">Notification Days Before Expiry</label>
                        <input type="number" class="form-control" id="notificationDays" name="notification_days"
                            value="3" min="1" max="10">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Settings -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-credit-card mr-2"></i> Payment Settings
                </h6>
            </div>
            <div class="card-body">
                <form id="paymentForm">
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select class="form-control" id="currency" name="currency">
                            <option value="IDR" selected>Indonesian Rupiah (IDR)</option>
                            <option value="USD">US Dollar (USD)</option>
                            <option value="EUR">Euro (EUR)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="taxRate">Tax Rate (%)</label>
                        <input type="number" class="form-control" id="taxRate" name="tax_rate" value="11" min="0"
                            max="100" step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="paymentMethods">Payment Methods</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="cash" id="paymentCash" checked>
                            <label class="form-check-label" for="paymentCash">
                                Cash
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="transfer" id="paymentTransfer"
                                checked>
                            <label class="form-check-label" for="paymentTransfer">
                                Bank Transfer
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="midtrans" id="paymentMidtrans"
                                checked>
                            <label class="form-check-label" for="paymentMidtrans">
                                Midtrans
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
function saveSettings() {
    // This would typically send an AJAX request to save settings
    // For now, we'll just show a success message
    alert('Settings saved successfully!');

    // In a real application, you would do something like:
    /*
    $.ajax({
        url: '{{ route("admin.settings.update") }}',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            gym_name: $('#gymName').val(),
            gym_address: $('#gymAddress').val(),
            gym_phone: $('#gymPhone').val(),
            gym_email: $('#gymEmail').val(),
            open_time: $('#openTime').val(),
            close_time: $('#closeTime').val(),
            // ... other form data
        },
        success: function(response) {
            alert('Settings saved successfully!');
        },
        error: function() {
            alert('Error saving settings. Please try again.');
        }
    });
    */
}
</script>
@endpush