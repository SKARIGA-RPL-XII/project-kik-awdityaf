@extends('layouts.app')

@section('title', 'Edit Membership Plan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Membership Plan</h1>

    <a href="{{ route('gym.plans.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Plans
    </a>
</div>

<div class="row">

    <!-- FORM -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Edit Plan Information
                </h6>
            </div>

            <div class="card-body">

                <form action="{{ route('gym.plans.update', $plan->id) }}" method="POST" class="user">

                    @csrf
                    @method('PUT')

                    <!-- Plan Name & Duration -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>Plan Name <span class="text-danger">*</span></label>

                            <input type="text" class="form-control form-control-user" id="plan_name" name="plan_name"
                                value="{{ old('plan_name', $plan->plan_name) }}" required>

                            @error('plan_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-sm-6">

                            <label>Duration (Months) <span class="text-danger">*</span></label>

                            <select class="form-control" id="duration_months" name="duration_months" required>

                                <option value="">Select Duration</option>

                                @foreach([1,3,6,12,24] as $month)
                                <option value="{{ $month }}"
                                    {{ old('duration_months', $plan->duration_months) == $month ? 'selected' : '' }}>
                                    {{ $month }} Month{{ $month > 1 ? 's' : '' }}
                                </option>
                                @endforeach

                            </select>

                            @error('duration_months')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>


                    <!-- Price -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>Price (Rp) <span class="text-danger">*</span></label>

                            <input type="number" class="form-control form-control-user" id="price" name="price"
                                value="{{ old('price', $plan->price) }}" min="0" step="1000" required>

                            @error('price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-sm-6">

                            <label>Price per Month</label>

                            <input type="text" class="form-control form-control-user" id="price_per_month" readonly>

                            <small class="text-muted">Calculated automatically</small>

                        </div>

                    </div>


                    <!-- Description -->
                    <div class="form-group">

                        <label>Description</label>

                        <textarea class="form-control" id="description" name="description"
                            rows="3">{{ old('description', $plan->description) }}</textarea>

                    </div>


                    <!-- Features -->
                    <div class="form-group">

                        <label>Features <span class="text-danger">*</span></label>

                        <textarea class="form-control" id="features" name="features"
                            rows="4">{{ old('features', $plan->features) }}</textarea>

                        <small class="text-muted">Separate with comma</small>

                        @error('features')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>


                    <!-- Active -->
                    <div class="form-group">

                        <div class="custom-control custom-checkbox">

                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>

                            <label class="custom-control-label" for="is_active">
                                Active Plan
                            </label>

                        </div>

                        <small class="text-muted">
                            Only active plans visible to members
                        </small>

                    </div>

                    <hr>


                    <!-- Buttons -->
                    <div class="form-group row">

                        <div class="col-sm-6">

                            <button type="submit" class="btn btn-success btn-user btn-block">

                                <i class="fas fa-save mr-2"></i> Update Plan

                            </button>

                        </div>

                        <div class="col-sm-6">

                            <a href="{{ route('gym.plans.index') }}" class="btn btn-secondary btn-user btn-block">

                                <i class="fas fa-times mr-2"></i> Cancel

                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>


    <!-- RIGHT PANEL -->
    <div class="col-lg-4">

        <!-- Preview -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Plan Preview</h6>
            </div>

            <div class="card-body">

                <div class="card border-success">

                    <div class="card-header bg-success text-white text-center">

                        <h6 id="preview_name">
                            {{ $plan->plan_name }}
                        </h6>

                    </div>

                    <div class="card-body text-center">

                        <h2 class="text-success" id="preview_price">
                            Rp {{ number_format($plan->price,0,',','.') }}
                        </h2>

                        <p class="text-muted" id="preview_duration">
                            {{ $plan->duration_months }} Month{{ $plan->duration_months > 1 ? 's' : '' }}
                        </p>

                        <p id="preview_description">
                            {{ $plan->description }}
                        </p>


                        <h6 class="text-success">Features:</h6>

                        <ul class="list-unstyled" id="features_list">

                            @foreach(explode(',', $plan->features ?? '') as $feature)

                            @if(trim($feature))

                            <li>
                                <i class="fas fa-check text-success mr-2"></i>
                                {{ trim($feature) }}
                            </li>

                            @endif

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        </div>


        <!-- Info -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Plan Information</h6>
            </div>

            <div class="card-body">

                <table class="table table-borderless table-sm">

                    <tr>
                        <td><strong>Created</strong></td>
                        <td>{{ $plan->created_at->format('M d, Y') }}</td>
                    </tr>

                    <tr>
                        <td><strong>Updated</strong></td>
                        <td>{{ $plan->updated_at->format('M d, Y') }}</td>
                    </tr>

                    <tr>
                        <td><strong>Status</strong></td>

                        <td>
                            @if($plan->is_active)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>

                    </tr>

                </table>

            </div>

        </div>


        <!-- Actions -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Quick Actions</h6>
            </div>

            <div class="card-body">

                <a href="{{ route('gym.plans.index') }}" class="btn btn-outline-primary btn-block mb-2">

                    <i class="fas fa-list mr-2"></i> View All

                </a>

                <a href="{{ route('gym.plans.create') }}" class="btn btn-outline-success btn-block mb-2">

                    <i class="fas fa-plus mr-2"></i> Add New

                </a>

                <button class="btn btn-outline-danger btn-block" data-toggle="modal" data-target="#deleteModal">

                    <i class="fas fa-trash mr-2"></i> Delete

                </button>

            </div>

        </div>

    </div>

</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5>Delete Plan</h5>

                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>

            </div>

            <div class="modal-body">

                <p>
                    Delete <strong>{{ $plan->plan_name }}</strong> ?
                </p>

                <p class="text-danger">Cannot be undone.</p>

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>

                <form action="{{ route('gym.plans.destroy', $plan->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-danger">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>
const planName = document.getElementById('plan_name');
const price = document.getElementById('price');
const duration = document.getElementById('duration_months');
const features = document.getElementById('features');


planName.addEventListener('input', () => {
    document.getElementById('preview_name').textContent =
        planName.value || 'Plan Name';
});


price.addEventListener('input', updatePrice);
duration.addEventListener('change', updatePrice);
features.addEventListener('input', updateFeatures);


function updatePrice() {

    const p = parseInt(price.value) || 0;
    const d = parseInt(duration.value) || 1;

    document.getElementById('preview_price').textContent =
        'Rp ' + p.toLocaleString('id-ID');

    document.getElementById('price_per_month').value =
        'Rp ' + Math.round(p / d).toLocaleString('id-ID');
}


function updateFeatures() {

    const list = document.getElementById('features_list');

    list.innerHTML = '';

    if (!features.value.trim()) return;

    features.value.split(',')
        .map(f => f.trim())
        .filter(f => f)
        .forEach(f => {

            const li = document.createElement('li');

            li.innerHTML =
                '<i class="fas fa-check text-success mr-2"></i>' + f;

            list.appendChild(li);
        });
}


document.addEventListener('DOMContentLoaded', updatePrice);
</script>

@endsection