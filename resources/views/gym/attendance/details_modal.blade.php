@extends('layout.admin')

@section('title', 'Attendance Detail')

@section('content')

<div class="row">

    <!-- MEMBER INFO -->
    <div class="col-md-6">

        <h6 class="font-weight-bold text-primary mb-3">
            <i class="fas fa-user mr-2"></i>
            Member Information
        </h6>

        <table class="table table-borderless table-sm">

            <tr>
                <td width="40%"><strong>Name:</strong></td>
                <td>{{ $member->name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td><strong>Member Code:</strong></td>
                <td>{{ $member->member_code ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $member->phone ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td><strong>Gender:</strong></td>
                <td>{{ $member->gender ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td><strong>Join Date:</strong></td>
                <td>
                    {{ $member->join_date
                        ? \Carbon\Carbon::parse($member->join_date)->format('M d, Y')
                        : 'N/A' }}
                </td>
            </tr>

            <tr>
                <td><strong>Status:</strong></td>
                <td>

                    <span class="badge badge-{{ $member->status === 'Active' ? 'success' : 'secondary' }}">
                        {{ $member->status ?? 'Unknown' }}
                    </span>

                </td>
            </tr>

        </table>

    </div>


    <!-- ATTENDANCE -->
    <div class="col-md-6">

        <h6 class="font-weight-bold text-success mb-3">
            <i class="fas fa-calendar-check mr-2"></i>
            Attendance Details
        </h6>

        <table class="table table-borderless table-sm">

            <tr>
                <td width="40%"><strong>Date:</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                </td>
            </tr>


            <tr>
                <td><strong>Check In:</strong></td>
                <td>

                    <span class="badge badge-success">
                        {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i:s') }}
                    </span>

                </td>
            </tr>


            <tr>
                <td><strong>Check Out:</strong></td>
                <td>

                    @if($attendance->check_out_time)

                    <span class="badge badge-secondary">
                        {{ \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i:s') }}
                    </span>

                    @else

                    <span class="badge badge-warning">
                        Still In Gym
                    </span>

                    @endif

                </td>
            </tr>


            <!-- DURATION -->
            <tr>
                <td><strong>Duration:</strong></td>
                <td>

                    @php
                    $checkIn = \Carbon\Carbon::parse($attendance->check_in_time);

                    $checkOut = $attendance->check_out_time
                    ? \Carbon\Carbon::parse($attendance->check_out_time)
                    : now();

                    $diff = $checkIn->diff($checkOut);
                    @endphp


                    @if($attendance->check_out_time)

                    {{ $diff->format('%h hours %i minutes') }}

                    @else

                    <span class="text-info">
                        {{ $diff->format('%h hours %i minutes') }} (ongoing)
                    </span>

                    @endif

                </td>
            </tr>


            <!-- STATUS -->
            <tr>
                <td><strong>Status:</strong></td>
                <td>

                    @if($attendance->check_out_time)

                    <span class="badge badge-secondary">
                        Completed
                    </span>

                    @else

                    <span class="badge badge-success">
                        In Gym
                    </span>

                    @endif

                </td>
            </tr>

        </table>

    </div>

</div>



<!-- SUBSCRIPTION -->
@if($subscription)

<div class="row mt-4">

    <div class="col-12">

        <h6 class="font-weight-bold text-info mb-3">
            <i class="fas fa-id-card mr-2"></i>
            Current Subscription
        </h6>


        <div class="card border-left-info">

            <div class="card-body py-3">

                <div class="row">

                    <div class="col-md-3">

                        <strong>Plan:</strong><br>

                        <span class="text-info">
                            {{ $subscription->plan_name ?? 'N/A' }}
                        </span>

                    </div>


                    <div class="col-md-3">

                        <strong>Start Date:</strong><br>

                        {{ $subscription->start_date
                            ? \Carbon\Carbon::parse($subscription->start_date)->format('M d, Y')
                            : 'N/A' }}

                    </div>


                    <div class="col-md-3">

                        <strong>End Date:</strong><br>

                        {{ $subscription->end_date
                            ? \Carbon\Carbon::parse($subscription->end_date)->format('M d, Y')
                            : 'N/A' }}

                    </div>


                    <div class="col-md-3">

                        <strong>Status:</strong><br>

                        <span class="badge badge-success">
                            Active
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@else

<div class="row mt-4">

    <div class="col-12">

        <div class="alert alert-warning">

            <i class="fas fa-exclamation-triangle mr-2"></i>

            <strong>Warning:</strong>
            This member does not have an active subscription.

        </div>

    </div>

</div>

@endif



<!-- QUICK ACTIONS -->
<div class="row mt-4">

    <div class="col-12">

        <h6 class="font-weight-bold text-secondary mb-3">
            <i class="fas fa-cogs mr-2"></i>
            Quick Actions
        </h6>


        <div class="btn-group" role="group">

            @if(!$attendance->check_out_time)

            <button class="btn btn-warning" onclick="manualCheckOut({{ $attendance->id }})">

                <i class="fas fa-sign-out-alt mr-2"></i>
                Manual Check Out

            </button>

            @endif


            <button class="btn btn-info" onclick="printAttendanceDetails({{ $attendance->id }})">

                <i class="fas fa-print mr-2"></i>
                Print Details

            </button>


            <button class="btn btn-danger" onclick="deleteAttendance({{ $attendance->id }})">

                <i class="fas fa-trash mr-2"></i>
                Delete Record

            </button>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>
function printAttendanceDetails(id) {
    $('#attendanceModal').modal('hide');

    window.open("{{ url('gym/print-attendance-details') }}/" + id, '_blank');
}
</script>

@endpush