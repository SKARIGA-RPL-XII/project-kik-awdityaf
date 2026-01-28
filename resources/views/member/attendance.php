<div class="row">

    <!-- Attendance Stats -->
    <div class="col-lg-4 mb-4">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Attendance Statistics
                </h6>
            </div>

            <div class="card-body">

                <div class="text-center mb-4">

                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="attendanceChart"></canvas>
                    </div>

                    <h4 class="mt-3">
                        {{ $attendance_rate }}%
                    </h4>

                    <p class="text-muted">
                        Attendance Rate (Last 30 days)
                    </p>

                </div>


                <!-- Check In / Check Out Status -->
                <div class="text-center">

                    @if ($is_in_gym)

                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        You are currently checked in
                    </div>

                    <a href="{{ url('member/check-out') }}" class="btn btn-warning w-100">

                        <i class="fas fa-sign-out-alt me-2"></i>
                        Check Out
                    </a>

                    @else

                    <div class="alert alert-secondary">
                        <i class="fas fa-times-circle me-2"></i>
                        You are not checked in
                    </div>

                    <a href="{{ url('member/check-in') }}" class="btn btn-success w-100">

                        <i class="fas fa-sign-in-alt me-2"></i>
                        Check In
                    </a>

                    @endif

                </div>

            </div>
        </div>
    </div>



    <!-- Attendance History -->
    <div class="col-lg-8 mb-4">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Attendance History
                </h6>
            </div>

            <div class="card-body">

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