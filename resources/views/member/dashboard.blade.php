@extends('layouts.member.app')

@section('content')


<!-- Welcome Section -->
<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #ff006e;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-dumbbell mr-2"></i>Welcome back, {{ $user['name'] ?? 'Member' }}!
                </h2>
                <p class="text-light mb-2">
                    💪 Ready to crush your workout today?
                </p>
                @if(isset($member['member_code']))
                <small class="text-info">
                    Member ID: <strong>#{{ $member['member_code'] }}</strong>
                </small>
                @endif
            </div>
            <div class="col-auto">
                @if($isInGym ?? false)
                <form action="{{ url('member/check-out') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-gym-secondary btn-lg rounded-pill">
                        <i class="fas fa-sign-out-alt mr-2"></i>Check Out
                    </button>
                </form>
                @else
                <form action="{{ url('member/check-in') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-gym-primary btn-lg rounded-pill">
                        <i class="fas fa-sign-in-alt mr-2"></i>Check In
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Status Cards Row -->
<div class="row">

    <!-- Membership Status Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div
            class="card border-left-<?= isset($current_subscription) && $current_subscription ? 'success' : 'danger'; ?> shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div
                            class="text-xs font-weight-bold text-<?= isset($current_subscription) && $current_subscription ? 'success' : 'danger'; ?> text-uppercase mb-1">
                            Membership Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($current_subscription) && $current_subscription ? 'Active' : 'Inactive'; ?>
                        </div>
                        <?php if (isset($current_subscription) && $current_subscription): ?>
                        <div class="text-xs text-muted">Expires:
                            <?= date('M d, Y', strtotime($current_subscription['end_date'])); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-id-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Plan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Current Plan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($current_subscription['plan_name']) ? $current_subscription['plan_name'] : 'No Plan'; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Rate Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Attendance Rate (30 days)</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <?= isset($attendance_rate) ? $attendance_rate : 0; ?>%</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-warning" role="progressbar"
                                        style="width: <?= isset($attendance_rate) ? $attendance_rate : 0; ?>%"
                                        aria-valuenow="<?= isset($attendance_rate) ? $attendance_rate : 0; ?>"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>x

    <!-- Status Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div
            class="card border-left-<?= isset($is_in_gym) && $is_in_gym ? 'success' : 'secondary'; ?> shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div
                            class="text-xs font-weight-bold text-<?= isset($is_in_gym) && $is_in_gym ? 'success' : 'secondary'; ?> text-uppercase mb-1">
                            Current Status</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= isset($is_in_gym) && $is_in_gym ? 'In Gym' : 'Not In Gym'; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i
                            class="fas fa-<?= isset($is_in_gym) && $is_in_gym ? 'check-circle' : 'times-circle'; ?> fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



<div class="row mt-4">

    <!-- Recent Attendance -->
    <div class="col-lg-8 mb-4">
        <div class="card-gym shadow">
            <div class="p-4">
                <h3 class="gym-accent font-weight-bold mb-4">
                    <i class="fas fa-chart-line mr-2"></i>Recent Attendance
                </h3>

                @if(isset($recent_attendance) && count($recent_attendance) > 0)

                <div class="table-responsive">
                    <table class="table" style="color: #fff;">
                        <thead>
                            <tr style="border-bottom: 2px solid #00d4ff;">
                                <th class="gym-accent">Date</th>
                                <th class="gym-accent">Check In</th>
                                <th class="gym-accent">Check Out</th>
                                <th class="gym-accent">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($recent_attendance,0,5) as $attendance)
                            <tr
                                style="border-bottom: 1px solid rgba(0,212,255,0.2); background-color: rgba(0,212,255,0.03);">
                                <td>{{ date('M d, Y', strtotime($attendance['date'])) }}</td>
                                <td><span class="badge"
                                        style="background-color: #00d4ff; color: #000;">{{ date('H:i', strtotime($attendance['check_in_time'])) }}</span>
                                </td>
                                <td>
                                    @if($attendance['check_out_time'])
                                    <span class="badge"
                                        style="background-color: #ff006e; color: #fff;">{{ date('H:i', strtotime($attendance['check_out_time'])) }}</span>
                                    @else
                                    <span class="badge" style="background-color: #00d4ff; color: #000;">Still In
                                        🔴</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance['check_out_time'])
                                    @php
                                    $in = new DateTime($attendance['check_in_time']);
                                    $out = new DateTime($attendance['check_out_time']);
                                    $diff = $in->diff($out);
                                    @endphp
                                    <strong class="gym-accent-secondary">{{ $diff->format('%h:%I') }}</strong>
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

                <div class="text-center py-5">
                    <i class="fas fa-inbox" style="font-size: 48px; color: #00d4ff; opacity: 0.5;"></i>
                    <p class="text-light mt-3 mb-3">No attendance records found</p>
                    <a href="{{ url('member/check-in') }}" class="btn btn-gym-primary">Start Your First Workout</a>
                </div>

                @endif
            </div>
        </div>
    </div>



    <!-- Right Column -->
    <div class="col-lg-4">

        <!-- Quick Actions -->
        <div class="card-gym shadow mb-4">
            <div class="p-4">
                <h3 class="gym-accent font-weight-bold mb-4">
                    <i class="fas fa-flash mr-2"></i>Quick Actions
                </h3>
                <ul class="list-group list-group-flush" style="background: transparent;">
                    <li class="list-group-item"
                        style="background: rgba(0,212,255,0.1); border-left: 3px solid #00d4ff; margin-bottom: 8px; border-radius: 4px;">
                        <a href="{{ url('member/profile') }}" class="text-decoration-none text-light">
                            <i class="fas fa-user mr-2 gym-accent"></i> Update Profile
                        </a>
                    </li>
                    <li class="list-group-item"
                        style="background: rgba(255,0,110,0.1); border-left: 3px solid #ff006e; margin-bottom: 8px; border-radius: 4px;">
                        <a href="{{ url('member/plans') }}" class="text-decoration-none text-light">
                            <i class="fas fa-tags mr-2" style="color: #ff006e;"></i> View Plans
                        </a>
                    </li>
                    <li class="list-group-item"
                        style="background: rgba(0,212,255,0.1); border-left: 3px solid #00d4ff; margin-bottom: 8px; border-radius: 4px;">
                        <a href="{{ url('member/subscriptions') }}" class="text-decoration-none text-light">
                            <i class="fas fa-credit-card mr-2 gym-accent"></i> My Subscriptions
                        </a>
                    </li>
                    <li class="list-group-item"
                        style="background: rgba(255,0,110,0.1); border-left: 3px solid #ff006e; margin-bottom: 8px; border-radius: 4px;">
                        <a href="{{ url('member/attendance') }}" class="text-decoration-none text-light">
                            <i class="fas fa-calendar mr-2" style="color: #ff006e;"></i> Attendance History
                        </a>
                    </li>
                    <li class="list-group-item"
                        style="background: rgba(0,212,255,0.1); border-left: 3px solid #00d4ff; border-radius: 4px;">
                        <a href="{{ url('member/password') }}" class="text-decoration-none text-light">
                            <i class="fas fa-lock mr-2 gym-accent"></i> Change Password
                        </a>
                    </li>
                </ul>
            </div>
        </div>



        <!-- Membership Info -->
        @if(isset($current_subscription) && $current_subscription)

        <div class="card-gym shadow" style="border-left: 4px solid #00d4ff;">
            <div class="p-4">
                <h3 class="gym-accent font-weight-bold mb-3">
                    <i class="fas fa-star mr-2"></i>Current Membership
                </h3>
                <h5 class="text-light font-weight-bold">{{ $current_subscription['plan_name'] }}</h5>
                <p class="text-info small mt-3" style="line-height: 1.8;">
                    <i class="fas fa-calendar-alt mr-2"></i>Start:
                    {{ date('M d, Y', strtotime($current_subscription['start_date'])) }}<br>
                    <i class="fas fa-calendar-check mr-2"></i>End:
                    {{ date('M d, Y', strtotime($current_subscription['end_date'])) }}<br>
                    <i class="fas fa-money-bill mr-2"></i>Amount: Rp
                    {{ number_format($current_subscription['amount_paid'],0,',','.') }}
                </p>
                @php
                $days = (strtotime($current_subscription['end_date']) - time()) / 86400;
                @endphp
                @if($days > 0)
                <div class="alert mt-3 mb-0"
                    style="background-color: rgba(0,212,255,0.2); border-left: 3px solid #00d4ff; color: #00d4ff; border-radius: 4px;">
                    <i class="fas fa-check-circle mr-2"></i>{{ ceil($days) }} days remaining
                </div>
                @else
                <div class="alert mt-3 mb-0"
                    style="background-color: rgba(255,0,110,0.2); border-left: 3px solid #ff006e; color: #ff006e; border-radius: 4px;">
                    <i class="fas fa-exclamation-circle mr-2"></i>Membership expired
                </div>
                @endif
            </div>
        </div>

        @else

        <div class="card-gym shadow text-center">
            <div class="p-4">
                <i class="fas fa-inbox" style="font-size: 48px; color: #00d4ff; opacity: 0.5;"></i>
                <p class="text-light mt-3 mb-3">No Active Membership</p>
                <a href="{{ url('member/plans') }}" class="btn btn-gym-primary">Choose Your Plan</a>
            </div>
        </div>

        @endif

    </div>

</div>

@endsection