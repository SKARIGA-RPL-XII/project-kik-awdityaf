@extends('layouts.member.app')

@section('content')

{{-- Page Heading --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-list text-info mr-2"></i>Laporan Saya
    </h1>
    <div>
        <a href="{{ url('member/member_report') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Laporan Baru
        </a>
    </div>
</div>

{{-- Member Info --}}
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">
            <i class="fas fa-user mr-2"></i>Informasi Member
        </h6>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ $user['name'] ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $user['email'] ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Kode Member:</strong> {{ $member['member_code'] ?? 'N/A' }}</p>
                <p>
                    <strong>Total Laporan:</strong>
                    <span class="badge badge-info">{{ count($reports) }}</span>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Reports Statistics --}}
@php
$status_counts = [
'Open' => 0,
'In Progress' => 0,
'Resolved' => 0,
'Closed' => 0
];

foreach ($reports as $report) {
if (isset($status_counts[$report['status']])) {
$status_counts[$report['status']]++;
}
}
@endphp

<div class="row mb-4">

    {{-- Open --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Laporan Baru
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $status_counts['Open'] }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- In Progress --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Sedang Diproses
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $status_counts['In Progress'] }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-cog fa-2x text-gray-300"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Resolved --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Selesai
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $status_counts['Resolved'] }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Closed --}}
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Ditutup
                        </div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $status_counts['Closed'] }}
                        </div>
                    </div>

                    <div class="col-auto">
                        <i class="fas fa-archive fa-2x text-gray-300"></i>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

{{-- Reports List --}}
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan</h6>
    </div>

    <div class="card-body">

        @if(!empty($reports))

        <div class="table-responsive">

            <table class="table table-bordered" id="reportsTable" width="100%">

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Subjek</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($reports as $report)

                    <tr>

                        <td>
                            {{ \Carbon\Carbon::parse($report['created_at'])->format('d/m/Y H:i') }}
                        </td>

                        <td>
                            @php
                            $category_names = [
                            'facility' => 'Fasilitas',
                            'equipment' => 'Peralatan',
                            'service' => 'Pelayanan',
                            'cleanliness' => 'Kebersihan',
                            'staff' => 'Staff',
                            'suggestion' => 'Saran',
                            'complaint' => 'Keluhan',
                            'other' => 'Lainnya'
                            ];
                            @endphp

                            <span class="badge badge-primary">
                                {{ $category_names[$report['category']] ?? $report['category'] }}
                            </span>
                        </td>

                        <td>
                            {{ \Illuminate\Support\Str::limit($report['subject'], 50) }}
                        </td>

                        <td>
                            @php
                            $priority_class = [
                            'Low' => 'secondary',
                            'Medium' => 'warning',
                            'High' => 'danger'
                            ];

                            $priority_names = [
                            'Low' => 'Rendah',
                            'Medium' => 'Sedang',
                            'High' => 'Tinggi'
                            ];
                            @endphp

                            <span class="badge badge-{{ $priority_class[$report['priority']] ?? 'secondary' }}">
                                {{ $priority_names[$report['priority']] ?? $report['priority'] }}
                            </span>
                        </td>

                        <td>
                            @php
                            $status_class = [
                            'Open' => 'warning',
                            'In Progress' => 'info',
                            'Resolved' => 'success',
                            'Closed' => 'secondary'
                            ];

                            $status_names = [
                            'Open' => 'Baru',
                            'In Progress' => 'Diproses',
                            'Resolved' => 'Selesai',
                            'Closed' => 'Ditutup'
                            ];
                            @endphp

                            <span class="badge badge-{{ $status_class[$report['status']] ?? 'secondary' }}">
                                {{ $status_names[$report['status']] ?? $report['status'] }}
                            </span>
                        </td>

                        <td>
                            <button class="btn btn-sm btn-info" onclick="viewReport({{ $report['id'] }})"
                                data-toggle="modal" data-target="#reportModal">
                                <i class="fas fa-eye"></i> Detail
                            </button>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @else

        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>

            <h5 class="text-gray-500">Belum Ada Laporan</h5>

            <p class="text-muted">
                Anda belum pernah mengirim laporan.
            </p>

            <a href="{{ url('member/member_report') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>Buat Laporan Pertama
            </a>
        </div>

        @endif

    </div>
</div>

{{-- Modal --}}
@include('member.partials.report-modal')

{{-- JS --}}
<script>
$(document).ready(function() {

    $('#reportsTable').DataTable({
        pageLength: 10,
        order: [
            [0, "desc"]
        ],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_",
            paginate: {
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });

});

function viewReport(reportId) {

    const reports = @json($reports);

    const report = reports.find(r => r.id == reportId);

    if (!report) {
        alert('Data tidak ditemukan');
        return;
    }

    console.log(report); // debug
}
</script>