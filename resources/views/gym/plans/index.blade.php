@extends('layouts.app')

@section('title', 'Membership Plans')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Membership Plans</h1>
    <a href="{{ route('plans.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Add New Plan
    </a>
</div>

{{-- Plans Cards --}}

<div class="row">
    @forelse ($plans as $plan)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card shadow h-100">


            <div class="card-header py-3 {{ $plan->is_active ? 'bg-success' : 'bg-secondary' }} text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">{{ $plan->plan_name }}</h6>
                    <span class="badge {{ $plan->is_active ? 'badge-light' : 'badge-dark' }}">
                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <div class="card-body d-flex flex-column">

                <div class="text-center mb-3">
                    <h2 class="text-success">Rp {{ number_format($plan->price,0,',','.') }}</h2>
                    <p class="text-muted">
                        {{ $plan->duration_months }} Month{{ $plan->duration_months > 1 ? 's' : '' }}
                    </p>
                </div>

                <p class="text-muted">{{ $plan->description }}</p>

                @if($plan->features)
                <div class="mb-3">
                    <h6 class="text-success">Features:</h6>
                    <ul class="list-unstyled">
                        @foreach(explode(',', $plan->features) as $feature)
                        <li>
                            <i class="fas fa-check text-success mr-2"></i>
                            {{ trim($feature) }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="mt-auto">
                    <div class="btn-group btn-group-sm w-100">

                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <button type="button" class="btn btn-info" onclick="viewPlanDetails({{ $plan->id }})">
                            <i class="fas fa-eye"></i> Details
                        </button>

                        <form action="{{ route('plans.toggle', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Change plan status?')"
                                class="btn btn-{{ $plan->is_active ? 'warning' : 'success' }}">

                                <i class="fas fa-{{ $plan->is_active ? 'pause' : 'play' }}"></i>
                                {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this plan?')" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            <div class="card-footer text-muted">
                <small>Created: {{ $plan->created_at->format('M d, Y') }}</small>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card shadow">
            <div class="card-body text-center py-5">
                <i class="fas fa-tags fa-3x text-gray-300 mb-3"></i>
                <h5 class="text-gray-600">No Membership Plans Found</h5>
                <p class="text-muted">Create your first membership plan to get started.</p>
                <a href="{{ route('plans.create') }}" class="btn btn-success">
                    <i class="fas fa-plus mr-2"></i> Add First Plan
                </a>
            </div>
        </div>
    </div>
    @endforelse


</div>

{{-- Plans Table --}}
@if($plans->count())

<div class="card shadow mb-4">


    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Plans Overview</h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Plan Name</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Subscribers</th>
                        <th>Revenue</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($plans as $plan)
                    <tr>
                        <td>{{ $plan->plan_name }}</td>
                        <td>{{ $plan->duration_months }} Month{{ $plan->duration_months > 1 ? 's' : '' }}</td>
                        <td>Rp {{ number_format($plan->price,0,',','.') }}</td>

                        <td>
                            <span class="badge badge-{{ $plan->is_active ? 'success' : 'secondary' }}">
                                {{ $plan->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td>
                            <span class="badge badge-info">
                                {{ $plan->subscriptions_count ?? 0 }}
                            </span>
                        </td>

                        <td>Rp {{ number_format($plan->revenue ?? 0,0,',','.') }}</td>

                        <td>{{ $plan->created_at->format('M d, Y') }}</td>

                        <td>
                            <div class="btn-group btn-group-sm">

                                <a href="{{ route('plans.edit',$plan->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button class="btn btn-info" onclick="viewPlanDetails({{ $plan->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <form action="{{ route('plans.destroy',$plan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete plan?')" class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>


</div>
@endif

{{-- Detail Modal --}}

<div class="modal fade" id="planModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Plan Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="planModalBody"></div>
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
            [6, 'desc']
        ],
        columnDefs: [{
            orderable: false,
            targets: 7
        }]
    });
});

function viewPlanDetails(id) {
    $.get("/plans/" + id, function(res) {
        $('#planModalBody').html(res);
        $('#planModal').modal('show');
    });
}
</script>

@endpush