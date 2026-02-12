@extends('layouts.app')

@section('title', 'Laporan Uang Masuk')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-arrow-up text-success mr-2"></i>
        Laporan Uang Masuk
    </h1>

    <div>

        <button class="btn btn-sm btn-success shadow-sm mr-2" onclick="exportIncomeReport()">
            <i class="fas fa-download fa-sm text-white-50"></i>
            Export Excel
        </button>

        <button class="btn btn-sm btn-info shadow-sm" onclick="printIncomeReport()">
            <i class="fas fa-print fa-sm text-white-50"></i>
            Print
        </button>

    </div>

</div>


<!-- Filter -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">
            Filter Periode
        </h6>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('gym.income_report') }}">

            <div class="row">

                <div class="col-md-4">
                    <label>Tanggal Mulai</label>

                    <input type="date" class="form-control" name="start_date" value="{{ $start_date }}" required>
                </div>


                <div class="col-md-4">
                    <label>Tanggal Akhir</label>

                    <input type="date" class="form-control" name="end_date" value="{{ $end_date }}" required>
                </div>


                <div class="col-md-4">

                    <label>&nbsp;</label>

                    <button type="submit" class="btn btn-primary btn-block">

                        <i class="fas fa-search mr-2"></i>
                        Filter

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<!-- Statistik -->
<div class="row">

    <!-- Total -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-success shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Pendapatan
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($total_income,0,',','.') }}
                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Rata-rata -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-info shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Rata-rata Harian
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($income_stats['daily_average'],0,',','.') }}
                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Transaksi -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-warning shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Transaksi
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ count($subscription_income) }}
                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Periode -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-primary shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Periode
                        </div>

                        <div class="h6 mb-0 font-weight-bold text-gray-800">

                            {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
                            -
                            {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}

                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Charts -->
<div class="row">

    <!-- Line -->
    <div class="col-xl-8 col-lg-7">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Pendapatan Harian
                </h6>
            </div>

            <div class="card-body">
                <canvas id="dailyIncomeChart"></canvas>
            </div>

        </div>

    </div>


    <!-- Pie -->
    <div class="col-xl-4 col-lg-5">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Pendapatan per Paket
                </h6>
            </div>

            <div class="card-body">

                <canvas id="planIncomeChart"></canvas>

                <div class="mt-4 text-center small">

                    @foreach($income_stats['by_plan'] as $plan)

                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i>
                        {{ $plan['plan_name'] }}
                    </span>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Table -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Detail Transaksi Pendapatan
        </h6>
    </div>

    <div class="card-body">

        <table class="table table-bordered" id="incomeTable">

            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Member</th>
                    <th>Kode</th>
                    <th>Paket</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($subscription_income as $inc)

                <tr>

                    <td>
                        {{ \Carbon\Carbon::parse($inc['payment_date'])->format('d/m/Y') }}
                    </td>

                    <td>{{ $inc['member_name'] }}</td>

                    <td>{{ $inc['member_code'] }}</td>

                    <td>{{ $inc['plan_name'] }}</td>

                    <td>
                        Rp {{ number_format($inc['amount_paid'],0,',','.') }}
                    </td>

                    <td>
                        <span class="badge badge-success">
                            {{ $inc['payment_status'] }}
                        </span>
                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada data pendapatan
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection


@push('scripts')

<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(function() {

    $('#incomeTable').DataTable({
        pageLength: 25,
        order: [
            [0, 'desc']
        ]
    });


    // Daily
    const dailyData = @json($daily_income);

    let labels = [];
    let values = [];

    if (dailyData.length) {

        labels = dailyData.map(i => {

            const d = new Date(i.date);

            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short'
            });

        });

        values = dailyData.map(i => parseFloat(i.total));

    }


    new Chart(document.getElementById('dailyIncomeChart'), {

        type: 'line',

        data: {
            labels: labels,
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: values,
                backgroundColor: 'rgba(78,115,223,.1)',
                borderColor: 'rgba(78,115,223,1)',
                borderWidth: 2,
                fill: true,
                tension: .4
            }]
        }

    });


    // Pie
    const planData = @json($income_stats['by_plan']);

    let planLabels = [];
    let planValues = [];

    const colors = [
        '#4e73df', '#1cc88a', '#36b9cc',
        '#f6c23e', '#e74a3b', '#f39c12', '#9b59b6'
    ];


    if (planData.length) {

        planLabels = planData.map(i => i.plan_name);
        planValues = planData.map(i => parseFloat(i.total));

    }


    new Chart(document.getElementById('planIncomeChart'), {

        type: 'doughnut',

        data: {
            labels: planLabels,
            datasets: [{
                data: planValues,
                backgroundColor: colors
            }]
        }

    });

});



function exportIncomeReport() {

    window.open(
        "{{ route('gym.export_income') }}?start_date={{ $start_date }}&end_date={{ $end_date }}",
        '_blank'
    );

}


function printIncomeReport() {
    window.print();
}
</script>

@endpush


@push('styles')

<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush