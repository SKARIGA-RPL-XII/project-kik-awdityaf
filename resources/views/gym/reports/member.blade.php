# Laporan Member (Laravel 12 - Blade)

blade
{{-- resources/views/gym/member-report.blade.php --}}
@extends('layouts.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-users text-info mr-2"></i>Laporan Member
    </h1>
    <div>
        <button class="btn btn-sm btn-success shadow-sm mr-2" onclick="exportMemberReport()">
            <i class="fas fa-download fa-sm text-white-50"></i> Export Excel
        </button>
        <button class="btn btn-sm btn-info shadow-sm" onclick="printMemberReport()">
            <i class="fas fa-print fa-sm text-white-50"></i> Print
        </button>
    </div>
</div>

<!-- Date Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-info">Filter Periode</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('gym.member.report') }}">
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
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Member Statistics -->
<div class="row">

    <!-- Total Member -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Member</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $member_stats['total'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Member -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Member Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $member_stats['active'] ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New Member -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Member Baru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ count($new_members) }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Unique Visits -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Kunjungan Unik</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $attendance_summary['unique_members'] ?? 0 }}
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

    <!-- Gender Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Gender</h6>
            </div>
            <div class="card-body">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Membership Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Paket</h6>
            </div>
            <div class="card-body">
                <canvas id="membershipChart"></canvas>

                <div class="mt-4 text-center small">
                    @foreach ($membership_distribution as $plan)
                    <span class="mr-2">
                        <i class="fas fa-circle text-primary"></i> {{ $plan['plan_name'] }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Members Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            Member Baru (Periode: {{ date('d/m/Y', strtotime($start_date)) }} -
            {{ date('d/m/Y', strtotime($end_date)) }})
        </h6>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="newMembersTable">
                <thead>
                    <tr>
                        <th>Tanggal Bergabung</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Kode Member</th>
                        <th>Gender</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($new_members as $member)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($member['join_date'])) }}</td>
                        <td>{{ $member['name'] }}</td>
                        <td>{{ $member['email'] }}</td>
                        <td>{{ $member['member_code'] }}</td>
                        <td>
                            <span class="badge badge-{{ $member['gender'] == 'Male' ? 'primary' : 'pink' }}">
                                {{ $member['gender'] }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $member['status'] == 'Active' ? 'success' : 'secondary' }}">
                                {{ $member['status'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada member baru</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Active Member Summary -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Ringkasan Member Aktif</h6>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="font-weight-bold">Statistik Gender</h6>
                <ul class="list-unstyled">
                    <li>Laki-laki: {{ $member_stats['male'] ?? 0 }} orang</li>
                    <li>Perempuan: {{ $member_stats['female'] ?? 0 }} orang</li>
                </ul>
            </div>

            <div class="col-md-6">
                <h6 class="font-weight-bold">Aktivitas</h6>
                <ul class="list-unstyled">
                    <li>Total Kunjungan: {{ $attendance_summary['total_visits'] ?? 0 }}</li>
                    <li>Member Unik: {{ $attendance_summary['unique_members'] ?? 0 }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        $('#newMembersTable').DataTable({
            pageLength: 25,
            order: [
                [0, 'desc']
            ]
        });

        // Gender Chart
        new Chart(document.getElementById('genderChart'), {
            type: 'bar',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'Jumlah Member',
                    data: [{
                        {
                            $member_stats['male'] ?? 0
                        }
                    }, {
                        {
                            $member_stats['female'] ?? 0
                        }
                    }],
                    backgroundColor: ['#4e73df', '#e74a3b']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Membership Chart
        const membershipData = @json($membership_distribution);

        new Chart(document.getElementById('membershipChart'), {
            type: 'doughnut',
            data: {
                labels: membershipData.map(i => i.plan_name),
                datasets: [{
                    data: membershipData.map(i => i.count),
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
                }]
            },
            options: {
                responsive: true
            }
        });
    });

    function exportMemberReport() {
        const url = "{{ route('gym.export.member.report') }}" +
            "?start_date={{ $start_date }}&end_date={{ $end_date }}";

        window.open(url, '_blank');
    }

    function printMemberReport() {
        window.print();
    }
</script>
@endpush