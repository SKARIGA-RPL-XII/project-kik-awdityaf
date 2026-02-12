@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Admin Management</h1>
        <a href="{{ route('admin.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Admin
        </a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Admin List</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Username</th>
                            <th>Job</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phonenumber }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->job }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role == 'admin' ? 'success' : 'warning' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy') }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this admin?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection