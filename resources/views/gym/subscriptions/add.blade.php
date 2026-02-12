@extends('layouts.app')

@section('content')

<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Add New Subscription</h1>
    <a href="{{ route('subscriptions.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
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


                <form action="{{ route('subscriptions.store') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label> Select Member <span class="text-danger">*</span></label>
                            <select name="member_id" class="form-control" required>
                                <option value="">Choose Member</option>
                                @foreach ($members as $member)
                                <option value="{{ $member->id }}"
                                    {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                    {{ $member->name }} ({{ $member->member_code }})
                                </option>
                                @endforeach
                            </select>
                            @error('member_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label>Select Plan <span class="text-danger">*</span></label>
                            <select name="membership_plan_id" id="membership_plan_id" class="form-control" required
                                onchange="updatePlanDetails()">
                                <option value="">Choose Plan</option>
                                @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" data-price="{{ $plan->price }}"
                                    data-duration="{{ $plan->duration_months }}"
                                    {{ old('membership_plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->plan_name }} - Rp {{ number_format($plan->price,0,',','.') }}
                                </option>
                                @endforeach
                            </select>
                            @error('membership_plan_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label>Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date', date('Y-m-d')) }}" required onchange="calculateEndDate()">

                            @error('start_date')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label>End Date</label>
                            <input type="date" id="end_date" class="form-control" readonly>
                            <small class="text-muted">Calculated automatically</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label>Amount Paid <span class="text-danger">*</span></label>
                            <input type="number" name="amount_paid" id="amount_paid" class="form-control"
                                value="{{ old('amount_paid') }}" min="0" step="1000" required>

                            @error('amount_paid')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label>Payment Status <span class="text-danger">*</span></label>
                            <select name="payment_status" class="form-control" required>
                                <option value="Paid" {{ old('payment_status','Paid')=='Paid'?'selected':'' }}>Paid
                                </option>
                                <option value="Pending" {{ old('payment_status')=='Pending'?'selected':'' }}>Pending
                                </option>
                                <option value="Overdue" {{ old('payment_status')=='Overdue'?'selected':'' }}>Overdue
                                </option>
                            </select>

                            @error('payment_status')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-plus mr-2"></i>Create Subscription
                            </button>
                        </div>

                        <div class="col-sm-6">
                            <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Preview -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Subscription Preview</h6>
            </div>
            <div class="card-body">

                <div id="plan_details" style="display:none;">
                    <h6 class="text-success">Plan Details</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><b>Plan</b></td>
                            <td id="preview_plan_name"></td>
                        </tr>
                        <tr>
                            <td><b>Duration</b></td>
                            <td id="preview_duration"></td>
                        </tr>
                        <tr>
                            <td><b>Price</b></td>
                            <td id="preview_price"></td>
                        </tr>
                        <tr>
                            <td><b>Start</b></td>
                            <td id="preview_start_date"></td>
                        </tr>
                        <tr>
                            <td><b>End</b></td>
                            <td id="preview_end_date"></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>


</div>
@endsection

@push('scripts')

<script>
    function updatePlanDetails() {
        const select = document.getElementById('membership_plan_id');
        const option = select.options[select.selectedIndex];

        if (option.value) {
            const price = option.dataset.price;
            const duration = option.dataset.duration;

            document.getElementById('preview_plan_name').innerText = option.text.split(' - ')[0];
            document.getElementById('preview_duration').innerText = duration + ' month(s)';
            document.getElementById('preview_price').innerText = 'Rp ' + Number(price).toLocaleString('id-ID');
            document.getElementById('amount_paid').value = price;

            document.getElementById('plan_details').style.display = 'block';
            calculateEndDate();
        } else {
            document.getElementById('plan_details').style.display = 'none';
        }
    }

    function calculateEndDate() {
        const start = document.getElementById('start_date').value;
        const select = document.getElementById('membership_plan_id');
        const option = select.options[select.selectedIndex];

        if (start && option.value) {
            const duration = parseInt(option.dataset.duration);
            const s = new Date(start);
            const e = new Date(s.getFullYear(), s.getMonth() + duration, s.getDate());

            document.getElementById('end_date').value = e.toISOString().split('T')[0];
            document.getElementById('preview_start_date').innerText = s.toLocaleDateString('id-ID');
            document.getElementById('preview_end_date').innerText = e.toLocaleDateString('id-ID');
        }
    }

    window.addEventListener('load', () => {
        updatePlanDetails();
        calculateEndDate();
    });
</script>

@endpush