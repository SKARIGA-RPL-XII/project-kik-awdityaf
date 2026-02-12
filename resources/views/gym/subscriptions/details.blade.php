<div class="row">
    <div class="col-md-4">
        <div class="text-center mb-3">
            <img class="img-profile rounded-circle" width="100" height="100"
                src="{{ asset('assets/img/plan/' . ($subscription->image ?? 'default.jpg')) }}"
                alt="{{ $subscription->plan_name }}">
        </div>

        <h5 class="text-center">{{ $subscription->plan_name }}</h5>
        <p class="text-center text-muted">{{ $subscription->plan_name }}</p>
    </div>

    <div class="col-md-8">
        <table class="table table-borderless">
            <tr>
                <td><strong>Price:</strong></td>
                <td>
                    Rp {{ number_format($subscription->price, 0, ',', '.') }}
                </td>
            </tr>

            <tr>
                <td><strong>Duration:</strong></td>
                <td>
                    {{ $subscription->duration_months }}
                    month{{ $subscription->duration_months > 1 ? 's' : '' }}
                </td>
            </tr>

            <tr>
                <td><strong>Start Date:</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($subscription->start_date)->format('M d, Y') }}
                </td>
            </tr>

            <tr>
                <td><strong>End Date:</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($subscription->end_date)->format('M d, Y') }}
                </td>
            </tr>

            <tr>
                <td><strong>Status:</strong></td>
                <td>
                    @if ($subscription->status == 'Active')
                    <span class="badge badge-success">Active</span>
                    @elseif ($subscription->status == 'Expiring Soon')
                    <span class="badge badge-warning">Expiring Soon</span>
                    @else
                    <span class="badge badge-danger">Expired</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<hr>

<!-- Payment History -->
<div class="row">
    <div class="col-12">
        <h6 class="text-success">Payment History</h6>

        @if (!empty($subscription->payment_history) && count($subscription->payment_history) > 0)

        <div class="table-responsive">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($subscription->payment_history as $payment)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                        </td>

                        <td>
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>

                        <td>
                            @if ($payment->status == 'Paid')
                            <span class="badge badge-success">Paid</span>
                            @elseif ($payment->status == 'Pending')
                            <span class="badge badge-warning">Pending</span>
                            @else
                            <span class="badge badge-danger">Failed</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else

        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            No payment history available.
        </div>

        @endif
    </div>
</div>