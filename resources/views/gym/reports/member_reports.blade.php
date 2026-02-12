@extends('layouts.app')

@section('title','Kelola Laporan Member')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-comments text-primary mr-2"></i>
        Kelola Laporan Member
    </h1>

    <div>

        <button onclick="exportReports()" class="btn btn-sm btn-success shadow-sm">

            <i class="fas fa-download fa-sm text-white-50"></i>
            Export Excel

        </button>

        <button onclick="printReports()" class="btn btn-sm btn-secondary shadow-sm">

            <i class="fas fa-print fa-sm text-white-50"></i>
            Print

        </button>

    </div>

</div>


<!-- Flash -->
@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="fas fa-check-circle mr-2"></i>
    {{ session('success') }}

    <button class="close" data-dismiss="alert">
        &times;
    </button>

</div>

@endif


@if(session('error'))

<div class="alert alert-danger alert-dismissible fade show">

    <i class="fas fa-exclamation-triangle mr-2"></i>
    {{ session('error') }}

    <button class="close" data-dismiss="alert">
        &times;
    </button>

</div>

@endif


<!-- Statistics -->
<div class="row mb-4">

    @php
    $stats = $report_stats ?? [];
    @endphp


    @foreach([
    ['Total Laporan','primary','comments',$stats['total'] ?? 0],
    ['Laporan Baru','warning','clock',$stats['open'] ?? 0],
    ['Sedang Diproses','info','cog',$stats['in_progress'] ?? 0],
    ['Selesai','success','check',$stats['resolved'] ?? 0]
    ] as $item)

    <div class="col-xl-3 col-md-6 mb-4">

        <div class="card border-left-{{ $item[1] }} shadow h-100 py-2">

            <div class="card-body">

                <div class="row no-gutters align-items-center">

                    <div class="col mr-2">

                        <div class="text-xs font-weight-bold text-{{ $item[1] }} mb-1">
                            {{ $item[0] }}
                        </div>

                        <div class="h5 mb-0 font-weight-bold">

                            {{ $item[3] }}

                        </div>

                    </div>

                    <div class="col-auto">

                        <i class="fas fa-{{ $item[2] }} fa-2x text-gray-300"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @endforeach

</div>


<!-- Filter -->
<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary">

            <i class="fas fa-filter mr-2"></i>
            Filter Laporan

        </h6>

    </div>


    <div class="card-body">

        <form method="GET" action="{{ route('gym.member_report') }}" class="row">


            <div class="col-md-3">

                <label>Status</label>

                <select name="status" class="form-control">

                    <option value="all">Semua</option>

                    @foreach(['Open','In Progress','Resolved','Closed'] as $s)

                    <option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>

                        {{ $s }}

                    </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-3">

                <label>Kategori</label>

                <select name="category" class="form-control">

                    <option value="all">Semua</option>

                    @foreach($categories as $key=>$val)

                    <option value="{{ $key }}" {{ request('category')==$key?'selected':'' }}>

                        {{ $val }}

                    </option>

                    @endforeach

                </select>

            </div>


            <div class="col-md-2">

                <label>Dari</label>

                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">

            </div>


            <div class="col-md-2">

                <label>Sampai</label>

                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">

            </div>


            <div class="col-md-2">

                <label>&nbsp;</label>

                <button class="btn btn-primary btn-block">

                    <i class="fas fa-search"></i>
                    Filter

                </button>

            </div>

        </form>

    </div>

</div>


<!-- Table -->
<div class="card shadow mb-4">

    <div class="card-header py-3">

        <h6 class="m-0 font-weight-bold text-primary">
            Daftar Laporan
        </h6>

    </div>


    <div class="card-body">


        @if($reports->count())

        <div class="table-responsive">

            <table class="table table-bordered" id="reportsTable">

                <thead>

                    <tr>
                        <th>Tanggal</th>
                        <th>Member</th>
                        <th>Kategori</th>
                        <th>Subjek</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                </thead>


                <tbody>

                    @foreach($reports as $r)

                    <tr>

                        <td>
                            {{ $r->created_at->format('d/m/Y H:i') }}
                        </td>


                        <td>

                            <strong>{{ $r->member_name ?? 'N/A' }}</strong><br>

                            <small>{{ $r->member_code }}</small><br>

                            <small>{{ $r->member_email }}</small>

                        </td>


                        <td>

                            <span class="badge badge-primary">

                                {{ $categories[$r->category] ?? $r->category }}

                            </span>

                        </td>


                        <td>
                            {{ \Str::limit($r->subject,40) }}
                        </td>


                        <td>

                            @php
                            $priorityClass=[
                            'Low'=>'secondary',
                            'Medium'=>'warning',
                            'High'=>'danger'
                            ];
                            @endphp

                            <span class="badge badge-{{ $priorityClass[$r->priority] ?? 'secondary' }}">

                                {{ $r->priority }}

                            </span>

                        </td>


                        <td>

                            @php
                            $statusClass=[
                            'Open'=>'warning',
                            'In Progress'=>'info',
                            'Resolved'=>'success',
                            'Closed'=>'secondary'
                            ];
                            @endphp

                            <span class="badge badge-{{ $statusClass[$r->status] ?? 'secondary' }}">

                                {{ $r->status }}

                            </span>

                        </td>


                        <td>

                            <button class="btn btn-info btn-sm" onclick="viewReport({{ $r->id }})" data-toggle="modal"
                                data-target="#reportModal">

                                <i class="fas fa-eye"></i>

                            </button>


                            <button class="btn btn-primary btn-sm" onclick="updateStatus({{ $r->id }})"
                                data-toggle="modal" data-target="#statusModal">

                                <i class="fas fa-edit"></i>

                            </button>

                        </td>


                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        @else

        <div class="text-center py-5">

            <i class="fas fa-inbox fa-3x text-gray-300"></i>

            <h5>Tidak Ada Data</h5>

        </div>

        @endif


    </div>

</div>


<!-- Detail Modal -->
@include('gym.member-report.modal-detail')


<!-- Status Modal -->
@include('gym.member-report.modal-status')


@endsection



@push('scripts')

<script>
$(function() {

    $('#reportsTable').DataTable({

        pageLength: 25,
        order: [
            [0, 'desc']
        ],

        language: {
            search: "Cari:",
            lengthMenu: "Tampil _MENU_",
            info: "_START_ - _END_ / _TOTAL",
            paginate: {
                next: "Next",
                previous: "Prev"
            }
        }

    });

});


const reports = @json($reports);
const categories = @json($categories);


function viewReport(id) {

    let r = reports.find(x => x.id == id);

    if (!r) return alert('Data tidak ditemukan');


    $('#reportModalBody').html(`

<h6>${r.subject}</h6>

<p>${r.description.replace(/\n/g,'<br>')}</p>

`);

}


function updateStatus(id) {

    let r = reports.find(x => x.id == id);

    $('#update_report_id').val(id);
    $('#update_status').val(r.status);
    $('#admin_response').val(r.admin_response);

}


function exportReports() {

    let p = new URLSearchParams(location.search);

    p.set('export', 'excel');

    window.open("{{ route('gym.member_report') }}?" + p.toString());

}


function printReports() {

    window.print();

}
</script>

@endpush