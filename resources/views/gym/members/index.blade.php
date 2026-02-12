@extends('layouts.app')

@section('title', 'Member Management')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Member Management</h1>

    <a href="{{ route('gym.add_member') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
        <i class="fas fa-user-plus fa-sm text-white-50"></i> Add New Member
    </a>
</div>

<!-- Members Table -->
<div class="card shadow mb-4">

    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-success">All Members</h6>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%">
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

@endpush