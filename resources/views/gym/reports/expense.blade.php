@extends('layouts.app')

@section('title', 'Laporan Uang Keluar')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-arrow-down text-danger mr-2"></i>
        Laporan Uang Keluar
    </h1>

    <div>

        <a href="{{ route('gym.add_expense') }}" class="btn btn-sm btn-primary shadow-sm mr-2">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Tambah Pengeluaran
        </a>

        <button class="btn btn-sm btn-success shadow-sm mr-2" onclick="exportExpenseReport()">
            <i class="fas fa-download fa-sm text-white-50"></i>
            Export Excel
        </button>

        <button class="btn btn-sm btn-info shadow-sm" onclick="printExpenseReport()">
            <i class="fas fa-print fa-sm text-white-50"></i>
            Print
        </button>

    </div>
</div>


<!-- Filter -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger">
            Filter Periode
        </h6>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('gym.expense_report') }}">

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


<!-- Statistics -->
<div class="row">

    <!-- Total -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-danger shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Pengeluaran
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($total_expenses,0,',','.') }}
                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Average -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-warning shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Rata-rata Harian
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($expense_stats['daily_average'],0,',','.') }}
                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Total Transaksi -->
    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-info shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Transaksi
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ count($expenses) }}
                        </div>

                    </div>

                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Period -->
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

    <!-- Bar -->
    <div class="col-xl-8 col-lg-7">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Pengeluaran per Kategori
                </h6>
            </div>

            <div class="card-body">
                <canvas id="expenseCategoryChart"></canvas>
            </div>

        </div>

    </div>


    <!-- Pie -->
    <div class="col-xl-4 col-lg-5">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Distribusi Pengeluaran
                </h6>
            </div>

            <div class="card-body">

                <canvas id="expenseDistributionChart"></canvas>

                <div class="mt-4 text-center small">

                    @foreach($expense_categories as $cat)

                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i>
                        {{ $cat['category'] }}
                    </span>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Info -->
<div class="alert alert-info">

    <i class="fas fa-info-circle mr-2"></i>

    <strong>Catatan:</strong>
    Fitur pencatatan pengeluaran akan segera tersedia.

</div>


<!-- Table -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Kategori Pengeluaran
        </h6>
    </div>

    <div class="card-body">

        <table class="table table-bordered" id="expenseTable">

            <thead>

                <tr>
                    <th>Kategori</th>
                    <th>Total</th>
                    <th>Persentase</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

                @foreach($expense_categories as $cat)

                @php
                $percentage = $total_expenses > 0
                ? ($cat['total'] / $total_expenses) * 100
                : 0;
                @endphp

                <tr>

                    <td>
                        <i class="fas fa-tag mr-2"></i>
                        {{ $cat['category'] }}
                    </td>

                    <td>
                        Rp {{ number_format($cat['total'],0,',','.') }}
                    </td>

                    <td>
                        {{ number_format($percentage,1) }}%
                    </td>

                    <td>
                        <span class="badge badge-secondary">
                            Belum Ada Data
                        </span>
                    </td>

                </tr>

                @endforeach

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

    $('#expenseTable').DataTable({
        pageLength: 25,
        order: [
            [1, 'desc']
        ]
    });


    const categoryData = @json($expense_categories);

    let labels = [];
    let data = [];

    const colors = [
        '#e74a3b', '#f39c12', '#3498db',
        '#2ecc71', '#9b59b6', '#e67e22'
    ];

    if (categoryData.length) {

        labels = categoryData.map(i => i.category);
        data = categoryData.map(i => parseFloat(i.total));

    }


    // Bar
    new Chart(document.getElementById('expenseCategoryChart'), {

        type: 'bar',

        data: {
            labels: labels,
            datasets: [{
                label: 'Pengeluaran (Rp)',
                data: data,
                backgroundColor: colors
            }]
        }

    });


    // Pie
    new Chart(document.getElementById('expenseDistributionChart'), {

        type: 'doughnut',

        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors
            }]
        }

    });

});


function exportExpenseReport() {

    window.open(
        "{{ route('gym.export_expense') }}?start_date={{ $start_date }}&end_date={{ $end_date }}",
        '_blank'
    );

}


function printExpenseReport() {
    window.print();
}
</script>

@endpush


@push('styles')

<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

@endpush