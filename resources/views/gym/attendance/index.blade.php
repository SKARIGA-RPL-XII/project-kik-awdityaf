@extends('layouts.app')

@section('title', 'Gym Attendance')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-check text-success mr-2"></i> Gym Attendance
    </h1>

    <div>
        <a href="{{ url('gym/manual-checkin') }}" class="btn btn-sm btn-success shadow-sm mr-2">
            <i class="fas fa-user-plus fa-sm text-white-50"></i> Manual Check-in
        </a>

        <button class="btn btn-sm btn-info shadow-sm mr-2" onclick="refreshAttendance()">
            <i class="fas fa-sync fa-sm text-white-50"></i> Refresh
        </button>

        <a href="{{ url('gym/attendance-history') }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-history fa-sm text-white-50"></i> View History
        </a>
    </div>
</div>


<!-- Statistics Cards -->
<div class="row mb-4">

    <!-- Today -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Today's Attendance
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $attendance_stats['today'] ?? 0 }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- In Gym -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Currently In Gym
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $attendance_stats['currently_in_gym'] ?? 0 }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- This Month -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            This Month
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $attendance_stats['this_month'] ?? 0 }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <!-- Avg -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Daily Average
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $attendance_stats['avg_daily'] ?? 0 }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>


<!-- Attendance Table -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">
            Today's Attendance - {{ now()->format('F d, Y') }}
        </h6>
    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="todayTable">

                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse ($attendances as $record)

                    <tr>

                        <td>
                            <strong>{{ $record->member->user->name ?? 'Unknown' }}</strong><br>
                            <small class="text-muted">{{ $record->member->member_code ?? 'N/A' }}</small>
                        </td>


                        <td>
                            <span class="badge badge-success">
                                {{ \Carbon\Carbon::parse($record->check_in_time)->format('H:i') }}
                            </span>
                        </td>


                        <td>
                            @if ($record->check_out_time)

                            <span class="badge badge-secondary">
                                {{ \Carbon\Carbon::parse($record->check_out_time)->format('H:i') }}
                            </span>

                            @else
                            <span class="badge badge-warning">Still In</span>
                            @endif
                        </td>


                        <td>
                            @if ($record->check_out_time)

                            {{ \Carbon\Carbon::parse($record->check_in_time)
                                        ->diff(\Carbon\Carbon::parse($record->check_out_time))
                                        ->format('%H:%I') }}

                            @else

                            <span class="text-info">
                                {{ \Carbon\Carbon::parse($record->check_in_time)
                                            ->diff(now())
                                            ->format('%H:%I') }}
                            </span>

                            @endif
                        </td>


                        <td>
                            @if ($record->check_out_time)
                            <span class="badge badge-secondary">Completed</span>
                            @else
                            <span class="badge badge-success">In Gym</span>
                            @endif
                        </td>


                        <td>

                            <div class="btn-group btn-group-sm">

                                <button class="btn btn-info" onclick="viewAttendanceDetails({{ $record->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>


                                @if (!$record->check_out_time)

                                <button class="btn btn-warning" onclick="manualCheckOut({{ $record->id }})">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>

                                @endif


                                <button class="btn btn-danger" onclick="deleteAttendance({{ $record->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No attendance records today</p>
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<!-- Datatables -->
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>


<script>
$(function() {

    $('#todayTable').DataTable({
        pageLength: 25,
        order: [
            [1, 'desc']
        ],
        columnDefs: [{
            orderable: false,
            targets: 5
        }]
    });

});


function refreshAttendance() {
    location.reload();
}


function viewAttendanceDetails(id) {

    $.get("{{ url('gym/attendance-details') }}/" + id, function(res) {

        $('#attendanceModalBody').html(res);
        $('#attendanceModal').modal('show');

    });

}


function manualCheckOut(id) {

    if (!confirm('Check out this member?')) return;

    $.post("{{ url('gym/manual-checkout') }}/" + id, {
        _token: "{{ csrf_token() }}"
    }, function() {

        location.reload();

    });

}


function deleteAttendance(id) {

    if (confirm('Delete this record?')) {

        window.location.href =
            "{{ url('gym/delete-attendance') }}/" + id;

    }

}
</script>

@endsection