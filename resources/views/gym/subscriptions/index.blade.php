@extends('layouts.app')

@section('content')

<!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Member Subscriptions</h1>


    <a href="{{ route('subscriptions.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Subscription
    </a>


</div>

<!-- Statistics Cards -->

<div class="row mb-4">


    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Active Subscriptions
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['active_subscriptions'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Expiring Soon (7 days)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['expiring_soon'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Overdue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stats['overdue'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Monthly Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($stats['monthly_revenue'] ?? 0,0,',','.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Filter -->

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Filter Subscriptions</h6>
    </div>


    <div class="card-body">
        <form method="GET" action="{{ route('subscriptions.index') }}">

            <div class="row">

                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                        <option value="expiring" {{ request('status')=='expiring'?'selected':'' }}>Expiring</option>
                        <option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>Overdue</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="plan" class="form-control">
                        <option value="">All Plans</option>
                        @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan')==$plan->id?'selected':'' }}>
                            {{ $plan->plan_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-secondary">Reset</a>
                </div>

            </div>
        </form>
    </div>


</div>

<!-- Table -->

<div class="card shadow mb-4">


    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">All Subscriptions</h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable">

                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Plan</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($subscriptions as $sub)

                    @php
                    $days = now()->diffInDays($sub->end_date,false);

                    if($days < 0){ $cls='danger' ; $txt='Expired' ; }elseif($days<=7){ $cls='warning' ; $txt='Expiring'
                        ; }else{ $cls='success' ; $txt='Active' ; } @endphp <tr>

                        <td>
                            <strong>{{ $sub->member->name }}</strong><br>
                            <small>{{ $sub->member->member_code }}</small>
                        </td>

                        <td>
                            <span class="badge badge-info">
                                {{ $sub->plan->plan_name }}
                            </span>
                        </td>

                        <td>{{ $sub->start_date->format('M d, Y') }}</td>

                        <td>
                            {{ $sub->end_date->format('M d, Y') }}
                            <br>
                            <small>
                                {{ abs($days) }} days {{ $days<0?'overdue':'left' }}
                            </small>
                        </td>

                        <td>
                            Rp {{ number_format($sub->amount_paid,0,',','.') }}
                        </td>

                        <td>
                            @if($sub->payment_status=='Paid')
                            <span class="badge badge-success">Paid</span>
                            @elseif($sub->payment_status=='Pending')
                            <span class="badge badge-warning">Pending</span>
                            @else
                            <span class="badge badge-danger">Overdue</span>
                            @endif
                        </td>

                        <td>
                            <span class="badge badge-{{ $cls }}">{{ $txt }}</span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">

                                <a href="{{ route('subscriptions.edit',$sub->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button class="btn btn-info" onclick="viewSub({{ $sub->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>

                                @if($sub->payment_status!='Paid')
                                <a href="{{ route('subscriptions.pay',$sub->id) }}" class="btn btn-success">
                                    <i class="fas fa-check"></i>
                                </a>
                                @endif

                                <a href="{{ route('subscriptions.renew',$sub->id) }}" class="btn btn-warning">
                                    <i class="fas fa-redo"></i>
                                </a>

                                <form method="POST" action="{{ route('subscriptions.destroy',$sub->id) }}"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger" onclick="return confirm('Delete?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center">
                                No subscriptions found
                            </td>
                        </tr>

                        @endforelse

                </tbody>

            </table>

        </div>
    </div>


</div>

<!-- Modal -->

<div class="modal fade" id="subModal">


    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Subscription Detail</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body" id="modalBody"></div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>


</div>

@endsection

@push('scripts')

<script>
$(function() {
    $('#dataTable').DataTable({
        pageLength: 25,
        order: [
            [3, 'asc']
        ],
        columnDefs: [{
            orderable: false,
            targets: 7
        }]
    });
});

function viewSub(id) {
    $.get("/subscriptions/" + id, function(res) {
        $('#modalBody').html(res);
        $('#subModal').modal('show');
    });
}
</script>

@endpush