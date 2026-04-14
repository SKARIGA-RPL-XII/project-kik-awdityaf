@extends('layouts.app')

@section('content')

<!-- Page Heading -->

<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-id-card mr-2"></i>
                    Member Subscriptions
                </h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('subscriptions.create') }}" class="btn btn-gym-primary">
                    <i class="fas fa-plus mr-2"></i> Add New Subscription
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->

<div class="row mb-4">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #2dce89;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #2dce89;">
                            Active Subscriptions
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">
                            {{ $stats['active_subscriptions'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x" style="color: #2dce89; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #ffc107;">
                            Expiring Soon (7 days)
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">
                            {{ $stats['expiring_soon'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x" style="color: #ffc107; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #f5365c;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #f5365c;">
                            Overdue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">
                            {{ $stats['overdue'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x" style="color: #f5365c; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #00d4ff;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold gym-accent text-uppercase mb-1">
                            Monthly Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-light-custom">
                            Rp {{ number_format($stats['monthly_revenue'] ?? 0,0,',','.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x gym-accent" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Filter -->

<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">
    <div class="card-header py-3" style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
        <h6 class="m-0 font-weight-bold gym-accent">Filter Subscriptions</h6>
    </div>


    <div class="card-body" style="background-color: rgba(0,0,0,0.2);">
        <form method="GET" action="{{ route('subscriptions.index') }}">

            <div class="row">

                <div class="col-md-3">
                    <select name="status" class="form-control dark-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                        <option value="expiring" {{ request('status')=='expiring'?'selected':'' }}>Expiring</option>
                        <option value="overdue" {{ request('status')=='overdue'?'selected':'' }}>Overdue</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="plan" class="form-control dark-input">
                        <option value="">All Plans</option>
                        @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ request('plan')==$plan->id?'selected':'' }}>
                            {{ $plan->plan_name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <input type="month" name="month" class="form-control dark-input" value="{{ request('month') }}">
                </div>

                <div class="col-md-3">
                    <button class="btn btn-gym-primary">Filter</button>
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-gym-secondary">Reset</a>
                </div>

            </div>
        </form>
    </div>


</div>

<!-- Table -->

<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">


    <div class="card-header py-3" style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
        <h6 class="m-0 font-weight-bold gym-accent">All Subscriptions</h6>
    </div>

    <div class="card-body" style="background-color: rgba(0,0,0,0.2);">

        <div class="table-responsive">

            <table class="table table-bordered table-gym" id="dataTable">

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

<style>
.dark-input {
    background-color: rgba(255, 255, 255, 0.05) !important;
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    color: #cbd5e1 !important;
    transition: all 0.3s ease;
}
.dark-input::placeholder {
    color: #64748b !important;
}
.dark-input:focus {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border-color: #00d4ff !important;
    color: #ffffff !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 212, 255, 0.25) !important;
}
.dark-input option {
    background-color: #0f1419;
    color: #cbd5e1;
}

.table-gym {
    color: #cbd5e1; 
}
.table-gym td {
    border-color: rgba(255, 255, 255, 0.05) !important;
    vertical-align: middle;
}
.table-gym th {
    border-color: rgba(255, 255, 255, 0.05) !important;
    border-bottom-color: rgba(255, 255, 255, 0.1) !important;
    color: #94a3b8; 
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #cbd5e1 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #cbd5e1 !important;
}
</style>

@endpush