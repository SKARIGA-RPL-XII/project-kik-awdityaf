@extends('layouts.member.app')

@section('content')

<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #2dce89;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(45,206,137,0.2) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-credit-card mr-2"></i>
                    My Subscription History
                </h1>
                <p class="text-light mb-2">
                    View your subscription history and current status
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ url('member/membership_plans') }}" class="btn btn-gym-secondary">
                    <i class="fas fa-tags mr-2"></i>
                    View Plans
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">

        <div class="card-gym shadow mb-4">

            <div class="card-header"
                style="background: linear-gradient(135deg, rgba(45,206,137,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">

                <h6 class="gym-accent font-weight-bold mb-0">
                    Subscription Details
                </h6>

            </div>


            <div class="card-body" style="background-color: rgba(0,0,0,0.2);">

                @if(!empty($subscriptions))

                <div class="table-responsive">

                    <table class="table table-bordered" width="100%" cellspacing="0">

                        <thead>
                            <tr>
                                <th>Plan</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($subscriptions as $subscription)

                            @php
                            $today = now()->format('Y-m-d');

                            $status = ($today <= $subscription['end_date']) ? 'Active' : 'Expired' ;
                                $badge_class=($status=='Active' ) ? 'success' : 'danger' ; @endphp <tr>

                                <td>
                                    {{ $subscription['plan_name'] }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($subscription['start_date'])->format('M d, Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($subscription['end_date'])->format('M d, Y') }}
                                </td>

                                <td>
                                    <span class="text-light font-weight-bold">
                                        Rp {{ number_format($subscription['amount_paid'],0,',','.') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge badge-pill"
                                        style="background-color: rgba(255,255,255,0.1); border: 1px solid #{{ $badge_class == 'success' ? '2dce89' : 'f5365c' }}; color: #{{ $badge_class == 'success' ? '2dce89' : 'f5365c' }};">
                                        {{ $status }}
                                    </span>
                                </td>

                                <td>

                                    @if(!empty($subscription['payment_date']))

                                    {{ \Carbon\Carbon::parse($subscription['payment_date'])->format('M d, Y') }}

                                    @else

                                    <span class="text-muted">-</span>

                                    @endif

                                </td>

                                </tr>

                                @endforeach

                        </tbody>

                    </table>

                </div>

                @else

                <div class="text-center py-4">

                    <i class="fas fa-credit-card fa-3x text-gray-300 mb-3"></i>

                    <p class="text-muted">
                        You don't have any subscription history yet.
                    </p>

                    <a href="{{ url('member/membership_plans') }}" class="btn btn-gym-secondary">
                        <i class="fas fa-tags mr-2"></i>
                        View Membership Plans
                    </a>

                </div>

                @endif

            </div>

        </div>

    </div>
</div>
@endsection