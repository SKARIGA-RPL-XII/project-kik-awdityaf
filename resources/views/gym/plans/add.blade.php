@extends('layouts.app')

@section('title', 'Add Membership Plan')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">Add New Membership Plan</h1>

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
                    Plan Information
                </h6>
            </div>


            <div class="card-body">

                <form action="{{ route('gym.plans.store') }}" method="POST" class="user">

                    @csrf


                    <!-- NAME & DURATION -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>
                                Plan Name <span class="text-danger">*</span>
                            </label>

                            <input type="text" class="form-control form-control-user" id="plan_name" name="plan_name"
                                value="{{ old('plan_name') }}" required>

                            @error('plan_name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>


                        <div class="col-sm-6">

                            <label>
                                Duration (Months) <span class="text-danger">*</span>
                            </label>

                            <select class="form-control" id="duration_months" name="duration_months" required>

                                <option value="">Select Duration</option>

                                @foreach([1,3,6,12,24] as $month)

                                <option value="{{ $month }}" {{ old('duration_months') == $month ? 'selected' : '' }}>

                                    {{ $month }} Month{{ $month > 1 ? 's' : '' }}

                                </option>

                                @endforeach

                            </select>

                            @error('duration_months')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>


                    <!-- PRICE -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>
                                Price (Rp) <span class="text-danger">*</span>
                            </label>

                            <input type="number" class="form-control form-control-user" id="price" name="price"
                                value="{{ old('price') }}" min="0" step="1000" required>

                            @error('price')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>


                        <div class="col-sm-6">

                            <label>Price per Month</label>

                            <input type="text" class="form-control form-control-user" id="price_per_month" readonly>

                            <small class="text-muted">
                                Calculated automatically
                            </small>

                        </div>

                    </div>


                    <!-- DESCRIPTION -->
                    <div class="form-group">

                        <label>Description</label>

                        <textarea class="form-control" id="description" name="description"
                            rows="3">{{ old('description') }}</textarea>

                    </div>


                    <!-- FEATURES -->
                    <div class="form-group">

                        <label>
                            Features <span class="text-danger">*</span>
                        </label>

                        <textarea class="form-control" id="features" name="features"
                            rows="4">{{ old('features') }}</textarea>

                        <small class="text-muted">
                            Separate each feature with comma
                        </small>

                        @error('features')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror

                    </div>


                    <!-- ACTIVE -->
                    <div class="form-group">

                        <div class="custom-control custom-checkbox">

                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                value="1" {{ old('is_active', true) ? 'checked' : '' }}>

                            <label class="custom-control-label" for="is_active">
                                Active Plan
                            </label>

                        </div>

                        <small class="text-muted">
                            Only active plans will be visible
                        </small>

                    </div>


                    <hr>


                    <!-- BUTTON -->
                    <div class="form-group row">

                        <div class="col-sm-6">

                            <button type="submit" class="btn btn-success btn-user btn-block">

                                <i class="fas fa-plus mr-2"></i> Create Plan

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



    <!-- RIGHT -->
    <div class="col-lg-4">


        <!-- PREVIEW -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    Plan Preview
                </h6>
            </div>


            <div class="card-body">

                <div class="card border-success">

                    <div class="card-header bg-success text-white text-center">

                        <h6 id="preview_name">
                            Plan Name
                        </h6>

                    </div>


                    <div class="card-body text-center">

                        <h2 class="text-success" id="preview_price">
                            Rp 0
                        </h2>

                        <p class="text-muted" id="preview_duration">
                            0 Months
                        </p>

                        <p id="preview_description">
                            Description here
                        </p>


                        <h6 class="text-success">Features</h6>

                        <ul class="list-unstyled" id="features_list">

                            <li>
                                <i class="fas fa-check text-success mr-2"></i>
                                Feature here
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>


        <!-- GUIDELINES -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    Pricing Guidelines
                </h6>
            </div>


            <div class="card-body">

                <div class="alert alert-info">

                    <h6>
                        <i class="fas fa-lightbulb mr-2"></i>
                        Pricing Tips
                    </h6>

                    <ul>
                        <li>Consider market rates</li>
                        <li>Longer plans = better value</li>
                        <li>Clear features</li>
                        <li>Test pricing</li>
                    </ul>

                </div>


                <div class="alert alert-success">

                    <h6>
                        <i class="fas fa-chart-line mr-2"></i>
                        Popular Durations
                    </h6>

                    <ul>
                        <li><strong>1 Month</strong> Trial</li>
                        <li><strong>3 Months</strong> Popular</li>
                        <li><strong>6 Months</strong> Committed</li>
                        <li><strong>12 Months</strong> Best Value</li>
                    </ul>

                </div>

            </div>

        </div>


        <!-- FEATURES BUTTON -->
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Common Features
                </h6>
            </div>


            <div class="card-body">

                <button class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Gym Access')">Gym
                    Access</button>

                <button class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Locker')">Locker</button>

                <button class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Shower')">Shower</button>

                <button class="btn btn-outline-success btn-sm mb-2"
                    onclick="addFeature('Personal Trainer')">Trainer</button>

                <button class="btn btn-outline-success btn-sm mb-2"
                    onclick="addFeature('Group Classes')">Classes</button>

                <button class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Sauna')">Sauna</button>

                <button class="btn btn-outline-success btn-sm mb-2" onclick="addFeature('Swimming Pool')">Pool</button>

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


planName.addEventListener('input', updatePreview);
price.addEventListener('input', updatePrice);
duration.addEventListener('change', updatePrice);
features.addEventListener('input', updateFeatures);


function updatePreview() {

    document.getElementById('preview_name').textContent =
        planName.value || 'Plan Name';

    document.getElementById('preview_description').textContent =
        document.getElementById('description').value || 'Description here';
}


function updatePrice() {

    const p = parseInt(price.value) || 0;
    const d = parseInt(duration.value) || 1;

    document.getElementById('preview_price').textContent =
        'Rp ' + p.toLocaleString('id-ID');

    document.getElementById('preview_duration').textContent =
        d + ' Month' + (d > 1 ? 's' : '');

    document.getElementById('price_per_month').value =
        'Rp ' + Math.round(p / d).toLocaleString('id-ID');
}


function updateFeatures() {

    const list = document.getElementById('features_list');

    list.innerHTML = '';

    if (!features.value.trim()) {
        list.innerHTML =
            '<li><i class="fas fa-check text-success mr-2"></i>Feature here</li>';
        return;
    }

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


function addFeature(text) {

    if (!features.value.includes(text)) {

        features.value =
            features.value ?
            features.value + ', ' + text :
            text;

        updateFeatures();
    }
}


document.addEventListener('DOMContentLoaded', updatePrice);
</script>

@endsection