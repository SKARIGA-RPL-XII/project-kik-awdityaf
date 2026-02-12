@extends('layouts.member.app')

@section('content')

<!-- Page Header -->
<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #ff006e;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-calendar-check mr-2"></i>
                    My Attendance
                </h1>
                <p class="text-light mb-2">
                    Track your gym attendance and workout history
                </p>
            </div>
            <div class="col-auto">
                @if($isInGym ?? false)
                <form action="{{ url('member/check-out') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-gym-secondary">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Check Out
                    </button>
                </form>
                @else
                <form action="{{ url('member/check-in') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-gym-primary">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Check In
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Attendance Stats -->
    <div class="col-lg-4 mb-4">

        <div class="card-gym shadow mb-4">

            <div class="card-header"
                style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h6 class="gym-accent font-weight-bold mb-0">
                    Attendance Statistics
                </h6>
            </div>

            <div class="card-body" style="background-color: rgba(0,0,0,0.2);">

                <div class="text-center mb-4">

                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="attendanceChart"></canvas>
                    </div>

                    <h4 class="gym-accent-secondary font-weight-bold mt-3">
                        {{ $attendanceRate }}%
                    </h4>

                    <p class="text-light">
                        Attendance Rate (Last 30 days)
                    </p>

                </div>


                <!-- Check In / Check Out Status -->
                <div class="text-center">

                    @if ($isInGym)

                    <div class="alert alert-success"
                        style="background-color: rgba(45,206,137,0.2); border-left: 3px solid #2dce89; color: #2dce89; border-radius: 4px;">
                        <i class="fas fa-check-circle me-2"></i>
                        You are currently checked in
                    </div>

                    <a href="{{ url('member/check-out') }}" class="btn btn-gym-secondary w-100">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Check Out
                    </a>

                    @else

                    <div class="alert alert-secondary"
                        style="background-color: rgba(133,141,158,0.2); border-left: 3px solid #858d9e; color: #858d9e; border-radius: 4px;">
                        <i class="fas fa-times-circle me-2"></i>
                        You are not checked in
                    </div>

                    <a href="{{ url('member/check-in') }}" class="btn btn-gym-primary w-100">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Check In
                    </a>

                    @endif

                </div>

            </div>
        </div>
    </div>



    <!-- Attendance History -->
    <div class="col-lg-8 mb-4">

        <div class="card-gym shadow mb-4">

            <div class="card-header"
                style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h6 class="gym-accent font-weight-bold mb-0">
                    Attendance History
                </h6>
            </div>

            <div class="card-body" style="background-color: rgba(0,0,0,0.2);">

                @if (!empty($attendance) && count($attendance) > 0)

                <div class="table-responsive">

                    <table class="table table-bordered" width="100%">

                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Duration</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($attendance as $record)

                            <tr>

                                <!-- Date -->
                                <td>
                                    {{ \Carbon\Carbon::parse($record['date'])->format('M d, Y') }}
                                </td>


                                <!-- Check In -->
                                <td>
                                    {{ \Carbon\Carbon::parse($record['check_in_time'])->format('h:i A') }}
                                </td>


                                <!-- Check Out -->
                                <td>

                                    @if (!empty($record['check_out_time']))

                                    {{ \Carbon\Carbon::parse($record['check_out_time'])->format('h:i A') }}

                                    @else

                                    <span class="text-muted">
                                        Not checked out
                                    </span>

                                    @endif

                                </td>


                                <!-- Duration -->
                                <td>

                                    @if (!empty($record['check_out_time']))

                                    @php
                                    $checkIn = \Carbon\Carbon::parse($record['check_in_time']);
                                    $checkOut = \Carbon\Carbon::parse($record['check_out_time']);

                                    $diff = $checkIn->diff($checkOut);
                                    @endphp

                                    {{ $diff->h }} hr {{ $diff->i }} min

                                    @else

                                    <span class="text-muted">-</span>

                                    @endif

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @else

                <!-- Empty Data -->
                <div class="text-center py-4">

                    <i class="fas fa-calendar-check fa-3x text-gray-300 mb-3"></i>

                    <p class="text-muted">
                        No attendance records found.
                        Start your fitness journey by checking in!
                    </p>

                </div>

                @endif

            </div>
        </div>
    </div>

</div>
@endsection