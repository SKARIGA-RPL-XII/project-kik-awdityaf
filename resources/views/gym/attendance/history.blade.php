@extends('layout.admin')

@section('title', 'Attendance History')

@section('content')

<!-- PAGE HEADER -->
<div class="row">
    <div class="col-12 mb-4">

        <div class="card shadow border-left-primary">

            <div class="card-body">

                <div class="row align-items-center">

                    <div class="col">

                        <h1 class="h3 mb-0 text-gray-800">
                            <i class="fas fa-history text-primary mr-2"></i>
                            Attendance History
                        </h1>

                        <p class="mb-0 text-muted">
                            View and manage historical attendance records
                        </p>

                    </div>

                    <div class="col-auto">

                        <a href="{{ url('gym/attendance') }}" class="btn btn-outline-secondary">

                            <i class="fas fa-arrow-left mr-2"></i>
                            Back

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>



<!-- FILTER -->
<div class="row mb-4">

    <div class="col-12">

        <div class="card shadow">

            <div class="card-header py-3">

                <h6 class="m-0 font-weight-bold text-primary">

                    <i class="fas fa-filter mr-2"></i>
                    Filter by Date

                </h6>

            </div>

            <div class="card-body">

                <form method="GET" action="{{ url('gym/attendance-history') }}">

                    <div class="row">


                        <div class="col-md-4">

                            <label class="font-weight-bold">
                                Start Date
                            </label>

                            <input type="date" name="start_date" class="form-control" value="{{ $startDate }}" required>

                        </div>


                        <div class="col-md-4">

                            <label class="font-weight-bold">
                                End Date
                            </label>

                            <input type="date" name="end_date" class="form-control" value="{{ $endDate }}" required>

                        </div>


                        <div class="col-md-4">

                            <label>&nbsp;</label>

                            <div class="d-flex">

                                <button class="btn btn-primary mr-2">

                                    <i class="fas fa-search mr-2"></i>
                                    Filter

                                </button>


                                <a href="{{ url('gym/attendance-history') }}" class="btn btn-secondary">

                                    <i class="fas fa-sync mr-2"></i>
                                    Reset

                                </a>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>



<!-- SUMMARY -->
<div class="row mb-4">

    <!-- TOTAL -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-primary mb-1">
                            Total Records
                        </div>

                        <div class="h5 font-weight-bold text-gray-800">
                            {{ $attendance->count() }}
                        </div>

                    </div>

                    <div class="col-auto">

                        <i class="fas fa-list fa-2x text-gray-300"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- UNIQUE -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-success shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-success mb-1">
                            Unique Members
                        </div>

                        <div class="h5 font-weight-bold text-gray-800">

                            {{ $attendance->pluck('member_id')->unique()->count() }}

                        </div>

                    </div>

                    <div class="col-auto">

                        <i class="fas fa-users fa-2x text-gray-300"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- DATE RANGE -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-info shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-info mb-1">
                            Date Range
                        </div>

                        <div class="h6 font-weight-bold text-gray-800">

                            {{ \Carbon\Carbon::parse($startDate)->format('M d') }}
                            -
                            {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}

                        </div>

                    </div>

                    <div class="col-auto">

                        <i class="fas fa-calendar fa-2x text-gray-300"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- AVERAGE -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-warning shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-warning mb-1">
                            Avg Daily
                        </div>

                        <div class="h5 font-weight-bold text-gray-800">

                            {{ $avgDaily }}

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



<!-- TABLE -->
<div class="card shadow mb-4">

    <div class="card-header py-3 d-flex justify-content-between">

        <h6 class="m-0 font-weight-bold text-primary">

            Attendance Records
            ({{ \Carbon\Carbon::parse($startDate)->format('M d') }}
            -
            {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }})

        </h6>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="historyTable">


                <thead>

                    <tr>
                        <th>Date</th>
                        <th>Member</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($attendance as $row)

                    <tr>

                        <td>

                            <span class="badge badge-light">

                                {{ \Carbon\Carbon::parse($row->date)->format('M d, Y') }}

                            </span>

                        </td>


                        <td>

                            <strong>{{ $row->member_name }}</strong><br>

                            <small class="text-muted">
                                {{ $row->member_code }}
                            </small>

                        </td>


                        <td>

                            <span class="badge badge-success">

                                {{ \Carbon\Carbon::parse($row->check_in_time)->format('H:i') }}

                            </span>

                        </td>


                        <td>

                            @if($row->check_out_time)

                            <span class="badge badge-secondary">

                                {{ \Carbon\Carbon::parse($row->check_out_time)->format('H:i') }}

                            </span>

                            @else

                            <span class="badge badge-warning">
                                Still In
                            </span>

                            @endif

                        </td>


                        <td>

                            @if($row->check_out_time)

                            @php
                            $in = \Carbon\Carbon::parse($row->check_in_time);
                            $out = \Carbon\Carbon::parse($row->check_out_time);
                            @endphp

                            {{ $in->diff($out)->format('%h:%I') }}

                            @else

                            -

                            @endif

                        </td>


                        <td>

                            @if($row->check_out_time)

                            <span class="badge badge-secondary">
                                Completed
                            </span>

                            @else

                            <span class="badge badge-success">
                                In Gym
                            </span>

                            @endif

                        </td>


                        <td>

                            <div class="btn-group btn-group-sm">

                                <a href="{{ url('gym/attendance/'.$row->id) }}" class="btn btn-info">

                                    <i class="fas fa-eye"></i>

                                </a>


                                <form method="POST" action="{{ url('gym/attendance/'.$row->id) }}"
                                    onsubmit="return confirm('Delete this record?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center py-4">

                            <i class="fas fa-calendar-times fa-3x text-gray-300 mb-3"></i>

                            <p class="text-muted">
                                No attendance records found
                            </p>

                            <a href="{{ url('gym/attendance-history') }}" class="btn btn-primary">

                                Reset Filter

                            </a>

                        </td>

                    </tr>

                    @endforelse

                </tbody>


            </table>

        </div>

    </div>

</div>

@endsection



@push('scripts')

<script>
$(function() {

    $('#historyTable').DataTable({

        pageLength: 25,

        order: [
            [0, 'desc']
        ],

        columnDefs: [

            {
                orderable: false,
                targets: 6
            }

        ]

    });

});
</script>

@endpush