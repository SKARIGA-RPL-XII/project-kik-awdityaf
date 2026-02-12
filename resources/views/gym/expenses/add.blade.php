@extends('layouts.admin')

@section('title', 'Manual Check-in')

@section('content')

<!-- Page Header -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow border-left-success">
            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col">
                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-user-check text-success mr-2"></i>
                            Manual Check-in
                        </h1>

                        <p class="mb-0 text-muted">
                            Check-in members manually to the gym
                        </p>
                    </div>

                    <div class="col-auto">
                        <a href="{{ url('gym/attendance') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Attendance
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>



<div class="row justify-content-center">

    <div class="col-lg-8">

        <div class="card shadow">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Member Check-in Form
                </h6>
            </div>


            <div class="card-body">

                <!-- Info -->
                <div class="alert alert-info">

                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Instructions:</strong>

                    <ul class="mb-0 mt-2">
                        <li>Select a member from the dropdown list</li>
                        <li>Only members with active subscriptions can check-in</li>
                        <li>Members can only check-in once per day</li>
                        <li>Check-in time will be recorded automatically</li>
                    </ul>

                </div>


                <!-- Form -->
                <form method="POST" action="{{ url('gym/process-manual-checkin') }}">

                    @csrf


                    <!-- Member -->
                    <div class="form-group">

                        <label for="member_id" class="font-weight-bold">
                            Select Member <span class="text-danger">*</span>
                        </label>


                        <select class="form-control" id="member_id" name="member_id" required>

                            <option value="">-- Select a Member --</option>

                            @foreach ($members as $member)

                            <option value="{{ $member->id }}" data-code="{{ $member->member_code }}">

                                {{ $member->name }}
                                ({{ $member->member_code }})

                            </option>

                            @endforeach

                        </select>


                        <small class="form-text text-muted">
                            Search by member name or member code
                        </small>

                    </div>


                    <!-- Checkin Info -->
                    <div class="form-group">

                        <label class="font-weight-bold">
                            Check-in Information
                        </label>


                        <div class="row">

                            <div class="col-md-6">

                                <label>Date</label>

                                <input type="text" class="form-control" value="{{ now()->format('F d, Y') }}" readonly>

                            </div>


                            <div class="col-md-6">

                                <label>Time</label>

                                <input type="text" class="form-control" id="checkin_time"
                                    value="{{ now()->format('H:i:s') }}" readonly>

                            </div>

                        </div>

                    </div>


                    <!-- Submit -->
                    <div class="form-group mb-0">

                        <button type="submit" class="btn btn-success btn-lg btn-block">

                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Check-in Member

                        </button>


                        <a href="{{ url('gym/attendance') }}" class="btn btn-secondary btn-block mt-2">

                            <i class="fas fa-times mr-2"></i>
                            Cancel

                        </a>

                    </div>

                </form>

            </div>
        </div>



        <!-- Quick Stats -->
        <div class="row mt-4">


            <!-- Total -->
            <div class="col-md-4">

                <div class="card border-left-success shadow">

                    <div class="card-body">

                        <div class="text-center">

                            <i class="fas fa-users fa-2x text-success mb-2"></i>

                            <h6 class="font-weight-bold text-success">
                                Total Members
                            </h6>

                            <h4 class="text-gray-800">
                                {{ $members->count() }}
                            </h4>

                        </div>

                    </div>
                </div>

            </div>


            <!-- Date -->
            <div class="col-md-4">

                <div class="card border-left-info shadow">

                    <div class="card-body">

                        <div class="text-center">

                            <i class="fas fa-calendar-day fa-2x text-info mb-2"></i>

                            <h6 class="font-weight-bold text-info">
                                Today's Date
                            </h6>

                            <h6 class="text-gray-800">
                                {{ now()->format('M d, Y') }}
                            </h6>

                        </div>

                    </div>
                </div>

            </div>


            <!-- Time -->
            <div class="col-md-4">

                <div class="card border-left-warning shadow">

                    <div class="card-body">

                        <div class="text-center">

                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>

                            <h6 class="font-weight-bold text-warning">
                                Current Time
                            </h6>

                            <h6 class="text-gray-800" id="current_time">
                                {{ now()->format('H:i:s') }}
                            </h6>

                        </div>

                    </div>
                </div>

            </div>


        </div>

    </div>
</div>

@endsection



@section('scripts')

<!-- Select2 -->
<link href="{{ asset('assets/vendor/select2/select2.min.css') }}" rel="stylesheet">

<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>


<script>
$(document).ready(function() {

    $('#member_id').select2({
        placeholder: "Search member by name or code...",
        allowClear: true,
        width: '100%'
    });


    // Update time
    setInterval(function() {

        const now = new Date();

        const time =
            now.toLocaleTimeString('en-US', {
                hour12: false
            });

        $('#checkin_time').val(time);
        $('#current_time').text(time);

    }, 1000);

});


// Validation
$('form').submit(function(e) {

    const memberId = $('#member_id').val();

    if (!memberId) {

        alert('Please select a member!');
        $('#member_id').focus();

        return false;
    }


    const memberText =
        $('#member_id option:selected').text();

    if (!confirm('Check-in ' + memberText + ' ?')) {

        return false;

    }

});
</script>


<style>
.select2-container--default .select2-selection--single {
    height: 38px;
    border: 1px solid #d1d3e2;
    border-radius: .35rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-left: 12px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}
</style>

@endsection