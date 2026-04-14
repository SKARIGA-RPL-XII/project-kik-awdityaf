@extends('layouts.app')

@section('title', 'Member Management')

@section('content')

<!-- Page Heading -->
<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-users mr-2"></i>
                    Member Management
                </h1>
            </div>
            <div class="col-auto">
                <a href="{{ route('gym.add_member') }}" class="btn btn-gym-primary">
                    <i class="fas fa-user-plus mr-2"></i> Add New Member
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Members Table -->
<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">

    <div class="card-header py-3" style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
        <h6 class="m-0 font-weight-bold gym-accent">All Members</h6>
    </div>

    <div class="card-body" style="background-color: rgba(0,0,0,0.2);">

        <div class="table-responsive">

            <table class="table table-bordered table-gym" id="dataTable" width="100%">
                <thead>
                    <tr>
                        <th>Member Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th>Current Plan</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @if ($members->count())

                    @foreach ($members as $member)

                    <tr>

                        <td>{{ $member->member_code }}</td>

                        <td>
                            <div class="d-flex align-items-center">

                                <img class="rounded-circle mr-2" width="30" height="30"
                                    src="{{ asset('assets/img/profile/' . ($member->image ?? 'default.jpg')) }}"
                                    alt="{{ $member->name }}">

                                {{ $member->name }}

                            </div>
                        </td>

                        <td>{{ $member->email }}</td>

                        <td>{{ $member->phone ?? '-' }}</td>

                        <td>
                            @if ($member->gender == 'Male')
                            <span class="badge badge-primary">Male</span>
                            @else
                            <span class="badge badge-pink">Female</span>
                            @endif
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($member->join_date)->format('M d, Y') }}
                        </td>

                        <td>

                            @if ($member->status == 'Active')
                            <span class="badge badge-success">Active</span>

                            @elseif ($member->status == 'Inactive')
                            <span class="badge badge-secondary">Inactive</span>

                            @else
                            <span class="badge badge-warning">Suspended</span>
                            @endif

                        </td>

                        <td>

                            @if ($member->plan_name)

                            <span class="badge badge-info">
                                {{ $member->plan_name }}
                            </span>

                            @if ($member->membership_end)
                            <br>
                            <small class="text-muted">
                                Until:
                                {{ \Carbon\Carbon::parse($member->membership_end)->format('M d, Y') }}
                            </small>
                            @endif

                            @else

                            <span class="badge badge-warning">No Plan</span>

                            @endif

                        </td>

                        <td>

                            <div class="btn-group" role="group">

                                <a href="{{ route('gym.edit_member', $member->id) }}" class="btn btn-sm btn-primary"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-info"
                                    onclick="viewMember({{ $member->id }})" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="deleteMember({{ $member->id }}, '{{ $member->name }}')" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                    @else

                    <tr>
                        <td colspan="9" class="text-center">
                            No members found.
                        </td>
                    </tr>

                    @endif

                </tbody>
            </table>

        </div>

    </div>
</div>

<!-- Member Modal -->
<div class="modal fade" id="memberModal" tabindex="-1">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Member Details</h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>

            <div class="modal-body" id="memberModalBody">
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>

            </div>

        </div>

    </div>
</div>


<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">Confirm Delete</h5>

                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>

            </div>

            <div class="modal-body">

                Are you sure you want to delete member
                <strong id="memberName"></strong>?

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancel
                </button>

                <a href="#" id="confirmDelete" class="btn btn-danger">
                    Delete
                </a>

            </div>

        </div>

    </div>
</div>

@endsection


@push('scripts')

<!-- DataTables -->
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
$(document).ready(function() {

    $('#dataTable').DataTable({
        pageLength: 25,
        order: [
            [5, 'desc']
        ],
        columnDefs: [{
            orderable: false,
            targets: 8
        }]
    });

});


function viewMember(id) {

    $.ajax({
        url: "{{ url('gym/get-member-details') }}/" + id,
        type: "GET",

        success: function(res) {
            $('#memberModalBody').html(res);
            $('#memberModal').modal('show');
        },

        error: function() {
            alert('Failed to load data');
        }
    });

}


function deleteMember(id, name) {

    $('#memberName').text(name);

    $('#confirmDelete').attr(
        'href',
        "{{ url('gym/delete-member') }}/" + id
    );

    $('#deleteModal').modal('show');

}
</script>

@endpush


@push('styles')

<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

<style>
.table-gym {
    color: #cbd5e1; 
}
.table-gym td {
    border-color: rgba(255, 255, 255, 0.05) !important;
    vertical-align: middle;
}
.table-gym th {
    border-color: rgba(255, 255, 255, 0.05) !important;
    border-bottom-color: rgba(255, 255, 255, 0.1) !important;
    color: #94a3b8; 
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}
.dataTables_wrapper .dataTables_length, .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_processing, .dataTables_wrapper .dataTables_paginate {
    color: #cbd5e1 !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button {
    color: #cbd5e1 !important;
}
</style>

@endpush