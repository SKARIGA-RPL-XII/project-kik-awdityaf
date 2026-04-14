@extends('layouts.app')

@section('title', 'Gym Attendance')

@section('content')

<!-- Page Heading -->
<!-- Page Heading -->
<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-user-check text-success mr-2"></i> Gym Attendance
                </h1>
            </div>
            <div class="col-auto">
                <a href="{{ url('gym/manual-checkin') }}" class="btn btn-gym-primary shadow-sm mr-2">
                    <i class="fas fa-user-plus mr-2"></i> Manual Check-in
                </a>

                <button class="btn btn-gym-secondary shadow-sm mr-2" onclick="refreshAttendance()">
                    <i class="fas fa-sync mr-2"></i> Refresh
                </button>

                <a href="{{ url('gym/attendance-history') }}" class="btn btn-gym-secondary shadow-sm">
                    <i class="fas fa-history mr-2"></i> View History
                </a>
            </div>
        </div>
    </div>
</div>


<!-- Statistics Cards -->
<div class="row mb-4">

    <!-- Today -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #2dce89;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #4ade80; letter-spacing: 0.5px;">
                            Today's Attendance
                        </div>
                        <div class="h4 mb-0 font-weight-bold" style="color: #ffffff;">
                            {{ $attendance_stats['today'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x" style="color: #2dce89; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- In Gym -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #00d4ff;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold gym-accent text-uppercase mb-1" style="letter-spacing: 0.5px;">
                            Currently In Gym
                        </div>
                        <div class="h4 mb-0 font-weight-bold" style="color: #ffffff;">
                            {{ $attendance_stats['currently_in_gym'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x gym-accent" style="opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- This Month -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #ffc107;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #fbbf24; letter-spacing: 0.5px;">
                            This Month
                        </div>
                        <div class="h4 mb-0 font-weight-bold" style="color: #ffffff;">
                            {{ $attendance_stats['this_month'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x" style="color: #ffc107; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Avg -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card-gym shadow h-100 py-2" style="border-left: 4px solid #aab2bd;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #cbd5e1; letter-spacing: 0.5px;">
                            Daily Average
                        </div>
                        <div class="h4 mb-0 font-weight-bold" style="color: #ffffff;">
                            {{ $attendance_stats['avg_daily'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x" style="color: #aab2bd; opacity: 0.7;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Attendance Table -->
<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">

    <div class="card-header py-3" style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
        <h6 class="m-0 font-weight-bold" style="color: #ffffff; letter-spacing: 1px;">
            Today's Attendance - {{ now()->format('F d, Y') }}
        </h6>
    </div>


    <div class="card-body" style="background-color: rgba(0,0,0,0.2);">

        <div class="table-responsive">

            <table class="table table-bordered table-gym" id="todayTable">

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
                            <strong style="color: #f1f5f9;">{{ $record->member->user->name ?? 'Unknown' }}</strong><br>
                            <small style="color: #94a3b8;">{{ $record->member->member_code ?? 'N/A' }}</small>
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


                        <td style="color: #e2e8f0; font-weight: 500;">
                            @if ($record->check_out_time)

                            {{ \Carbon\Carbon::parse($record->check_in_time)
                                        ->diff(\Carbon\Carbon::parse($record->check_out_time))
                                        ->format('%H:%I') }}

                            @else

                            <span class="gym-accent">
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

<style>
.table-gym {
    color: #cbd5e1; 
}
.table-gym td {
    border-color: rgba(255, 255, 255, 0.05) !important;
    vertical-align: middle;
}
.table-gym thead th, 
.table-gym th,
.table-gym thead tr th {
    background-color: #1e293b !important;
    color: #ffffff !important; 
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.85rem !important;
    letter-spacing: 1px !important;
    padding: 15px 12px !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
}

/* Card Headers Highlight */
.card-gym .card-header h6,
.card-gym h1,
.gym-accent {
    color: #ffffff !important; /* Make headers pop with pure white */
    text-shadow: 0 0 10px rgba(0, 212, 255, 0.2);
}

.table-gym td {
    border-color: rgba(255, 255, 255, 0.05) !important;
    vertical-align: middle;
    color: #cbd5e1;
}

.dataTables_wrapper .dataTables_length, 
.dataTables_wrapper .dataTables_filter, 
.dataTables_wrapper .dataTables_info, 
.dataTables_wrapper .dataTables_paginate {
    color: #ffffff !important; /* White for all helper text */
    font-weight: 500;
}

.dataTables_wrapper .dataTables_filter input {
    background-color: rgba(255,255,255,0.1) !important;
    border: 1px solid var(--gym-cyan) !important;
    color: #ffffff !important;
    outline: none;
}
</style>

@endsection