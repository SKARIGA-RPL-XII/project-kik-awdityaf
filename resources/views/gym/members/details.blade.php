@extends('layouts.admin')

@section('title', 'Member Detail')

@section('content')

<div class="row">

    {{-- Profile --}}
    <div class="col-md-4">

        <div class="text-center mb-3">

            <img class="img-profile rounded-circle" width="100" height="100"
                src="{{ asset('assets/img/profile/' . ($member->image ?? 'default.jpg')) }}" alt="{{ $member->name }}">

        </div>

        <h5 class="text-center">
            {{ $member->name }}
        </h5>

        <p class="text-center text-muted">
            {{ $member->member_code }}
        </p>

    </div>


    {{-- Info --}}
    <div class="col-md-8">

        <table class="table table-borderless">

            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $member->email }}</td>
            </tr>

            <tr>
                <td><strong>Phone:</strong></td>
                <td>{{ $member->phone ?? '-' }}</td>
            </tr>

            <tr>
                <td><strong>Gender:</strong></td>
                <td>{{ $member->gender ?? '-' }}</td>
            </tr>

            <tr>
                <td><strong>Birth Date:</strong></td>
                <td>
                    {{ $member->birth_date
                        ? \Carbon\Carbon::parse($member->birth_date)->format('M d, Y')
                        : '-' }}
                </td>
            </tr>

            <tr>
                <td><strong>Address:</strong></td>
                <td>{{ $member->address ?? '-' }}</td>
            </tr>

            <tr>
                <td><strong>Join Date:</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($member->join_date)->format('M d, Y') }}
                </td>
            </tr>

            <tr>
                <td><strong>Status:</strong></td>
                <td>

                    @if ($member->status == 'Active')
                    <span class="badge badge-success">Active</span>

                    @elseif ($member->status == 'Inactive')
                    <span class="badge badge-secondary">Inactive</span>

                    @else
                    <span class="badge badge-warning">Suspended</span>
                    @endif

                </td>
            </tr>

        </table>

    </div>

</div>

<hr>


{{-- Current Subscription --}}
<div class="row">

    <div class="col-12">

        <h6 class="text-success">
            Current Subscription
        </h6>


        @if ($member->currentSubscription)

        @php
        $end = \Carbon\Carbon::parse($member->currentSubscription->end_date);
        $daysLeft = now()->diffInDays($end, false);
        @endphp


        <div class="card border-success">

            <div class="card-body">

                <h6 class="card-title text-success">
                    {{ $member->currentSubscription->plan_name }}
                </h6>


                <p class="card-text">

                    <strong>Start Date:</strong>
                    {{ \Carbon\Carbon::parse($member->currentSubscription->start_date)->format('M d, Y') }}
                    <br>

                    <strong>End Date:</strong>
                    {{ $end->format('M d, Y') }}
                    <br>

                    <strong>Amount Paid:</strong>
                    Rp {{ number_format($member->currentSubscription->amount_paid,0,',','.') }}

                </p>


                @if ($daysLeft > 0)

                <small class="text-success">
                    {{ $daysLeft }} days remaining
                </small>

                @else

                <small class="text-danger">
                    {{ abs($daysLeft) }} days overdue
                </small>

                @endif


            </div>
        </div>


        @else

        <div class="alert alert-warning">

            <i class="fas fa-exclamation-triangle mr-2"></i>
            No active subscription found.

        </div>

        @endif

    </div>

</div>


<hr>


{{-- Attendance Rate --}}
<div class="row">

    <div class="col-md-6">

        <h6 class="text-success">
            Attendance Rate (30 days)
        </h6>


        <div class="progress mb-2">

            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $member->attendance_rate }}%"
                aria-valuenow="{{ $member->attendance_rate }}" aria-valuemin="0" aria-valuemax="100">

                {{ $member->attendance_rate }}%

            </div>

        </div>

    </div>


    {{-- Emergency --}}
    <div class="col-md-6">

        <h6 class="text-success">
            Emergency Contact
        </h6>


        @if ($member->emergency_contact)

        <p class="mb-0">

            <strong>
                {{ $member->emergency_contact }}
            </strong>
            <br>

            <small class="text-muted">
                {{ $member->emergency_phone ?? 'No phone' }}
            </small>

        </p>

        @else

        <p class="text-muted">
            No emergency contact set
        </p>

        @endif

    </div>

</div>


<hr>


{{-- Recent Attendance --}}
<div class="row">

    <div class="col-12">

        <h6 class="text-success">
            Recent Attendance
        </h6>


        @if ($member->recentAttendance->count())

        <div class="table-responsive">

            <table class="table table-sm">

                <thead>

                    <tr>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Duration</th>
                    </tr>

                </thead>


                <tbody>

                    @foreach ($member->recentAttendance as $attendance)

                    <tr>

                        <td>
                            {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') }}
                        </td>


                        <td>

                            @if ($attendance->check_out_time)

                            {{ \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') }}

                            @else

                            <span class="badge badge-success">
                                Still In
                            </span>

                            @endif

                        </td>


                        <td>

                            @if ($attendance->check_out_time)

                            @php
                            $in = \Carbon\Carbon::parse($attendance->check_in_time);
                            $out = \Carbon\Carbon::parse($attendance->check_out_time);
                            @endphp

                            {{ $in->diff($out)->format('%h:%I') }}

                            @else

                            -

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        @else

        <div class="alert alert-info">

            <i class="fas fa-info-circle mr-2"></i>
            No recent attendance records found.

        </div>

        @endif

    </div>

</div>

@endsection