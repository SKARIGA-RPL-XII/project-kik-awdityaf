@extends('layouts.app')

@section('title','Gym Reports & Analytics')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">Gym Reports & Analytics</h1>

    <div>

        <button class="btn btn-sm btn-success shadow-sm" onclick="exportAllReports()">

            <i class="fas fa-download fa-sm text-white-50"></i>
            Export All Reports

        </button>

        <button class="btn btn-sm btn-info shadow-sm" onclick="refreshReports()">

            <i class="fas fa-sync fa-sm text-white-50"></i>
            Refresh

        </button>

    </div>

</div>


<!-- Report Period -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">Report Period</h6>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('gym.reports') }}">

            <div class="row">

                <div class="col-md-3">

                    <label>Period</label>

                    <select name="period" id="period" class="form-control" onchange="toggleCustomDate()">

                        @php
                        $period = request('period','month');
                        @endphp

                        <option value="today" {{ $period=='today'?'selected':'' }}>Today</option>
                        <option value="week" {{ $period=='week'?'selected':'' }}>This Week</option>
                        <option value="month" {{ $period=='month'?'selected':'' }}>This Month</option>
                        <option value="quarter" {{ $period=='quarter'?'selected':'' }}>This Quarter</option>
                        <option value="year" {{ $period=='year'?'selected':'' }}>This Year</option>
                        <option value="custom" {{ $period=='custom'?'selected':'' }}>Custom Range</option>

                    </select>

                </div>


                <div class="col-md-3" id="start_date_div" style="display:none;">

                    <label>Start Date</label>

                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">

                </div>


                <div class="col-md-3" id="end_date_div" style="display:none;">

                    <label>End Date</label>

                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">

                </div>


                <div class="col-md-3">

                    <label>&nbsp;</label>

                    <button class="btn btn-primary btn-block">
                        Generate Report
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- Summary -->
<div class="row mb-4">

    <!-- Revenue -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-primary mb-1">
                            Total Revenue
                        </div>

                        <div class="h5 mb-0 font-weight-bold">

                            Rp {{ number_format($subscription_stats['monthly_revenue'] ?? 0,0,',','.') }}

                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Active -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-success shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-success mb-1">
                            Active Members
                        </div>

                        <div class="h5 mb-0 font-weight-bold">

                            {{ $member_stats['total_active'] ?? 0 }}

                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- New -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-info shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-info mb-1">
                            New Members
                        </div>

                        <div class="h5 mb-0 font-weight-bold">

                            {{ $member_stats['new_this_month'] ?? 0 }}

                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Attendance -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-warning shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-warning mb-1">
                            Avg Attendance
                        </div>

                        <div class="h5 mb-0 font-weight-bold">

                            {{ $attendance_stats['avg_daily'] ?? 0 }}

                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Charts -->
<div class="row">

    <!-- Revenue -->
    <div class="col-xl-8">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Revenue Overview
                </h6>
            </div>

            <div class="card-body">
                <canvas id="revenueChart"></canvas>
            </div>

        </div>

    </div>


    <!-- Plans -->
    <div class="col-xl-4">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Plan Distribution
                </h6>
            </div>

            <div class="card-body">

                <canvas id="plansChart"></canvas>

                <div class="mt-3 text-center small">

                    @foreach($plan_stats ?? [] as $i=>$plan)

                    <span class="mr-2">

                        <i class="fas fa-circle"
                            style="color:{{ ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b'][$i%5] }}"></i>

                        {{ $plan['plan_name'] }}

                    </span>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Tables -->
<div class="row">

    <!-- Plans -->
    <div class="col-lg-6 mb-4">

        <div class="card shadow">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Top Performing Plans
                </h6>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-sm">

                    <thead>
                        <tr>
                            <th>Plan</th>
                            <th>Subscribers</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($plan_stats ?? [] as $plan)

                        <tr>

                            <td>{{ $plan['plan_name'] }}</td>

                            <td>{{ $plan['total_subscriptions'] }}</td>

                            <td>
                                Rp {{ number_format($plan['total_revenue'] ?? 0,0,',','.') }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="3" class="text-center">
                                No data
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function toggleCustomDate() {

    let p = document.getElementById('period').value;

    document.getElementById('start_date_div').style.display =
        p === 'custom' ? 'block' : 'none';

    document.getElementById('end_date_div').style.display =
        p === 'custom' ? 'block' : 'none';
}


document.addEventListener('DOMContentLoaded', function() {

    toggleCustomDate();


    // Revenue
    new Chart(document.getElementById('revenueChart'), {

        type: 'line',

        data: {
            labels: @json($revenue_labels ?? []),

            datasets: [{
                label: 'Revenue',
                data: @json($revenue_values ?? []),
                borderWidth: 2,
                fill: true
            }]
        }

    });


    // Plans
    new Chart(document.getElementById('plansChart'), {

        type: 'doughnut',

        data: {
            labels: @json(collect($plan_stats ?? []) - > pluck('plan_name')),
            datasets: [{
                data: @json(collect($plan_stats ?? []) - > pluck('total_subscriptions'))
            }]
        }

    });

});


function exportAllReports() {

    window.open(
        "{{ route('gym.export_reports') }}",
        '_blank'
    );

}


function refreshReports() {
    location.reload();
}
</script>

@endpush