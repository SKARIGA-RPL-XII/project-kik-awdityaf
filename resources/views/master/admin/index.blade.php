@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">
        <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="gym-accent font-weight-bold mb-2">
                        <i class="fas fa-user-shield mr-2"></i>Admin Management
                    </h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('admin.index') }}" class="btn btn-gym-primary">
                        <i class="fas fa-plus mr-2"></i> Add New Admin
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #ff006e;">
        <div class="card-header py-3" style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
            <h6 class="m-0 font-weight-bold text-white" style="letter-spacing: 1px;">Admin List</h6>
        </div>
        <div class="card-body" style="background-color: rgba(0,0,0,0.2);">
            @if(session('success'))
            <div class="alert alert-success border-0" style="background-color: rgba(40, 167, 69, 0.2); color: #28a745; border-left: 4px solid #28a745;">
                {{ session('success') }}
                <button type="button" class="close text-white" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-gym" id="dataTable" width="100%" cellspacing="0">
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

<style>
.table-gym {
    color: #cbd5e1; 
}
.table-gym thead th {
    border-color: rgba(255, 255, 255, 0.1) !important;
    background-color: #1e293b !important;
    color: #ffffff !important;
    font-weight: 800 !important;
    text-transform: uppercase !important;
    font-size: 0.85rem !important;
    letter-spacing: 1px !important;
    padding: 15px 12px !important;
}
.table-gym td {
    border-color: rgba(255, 255, 255, 0.05) !important;
    vertical-align: middle;
    color: #cbd5e1;
}
.dataTables_wrapper .dataTables_length, 
.dataTables_wrapper .dataTables_filter, 
.dataTables_wrapper .dataTables_info, 
.dataTables_wrapper .dataTables_paginate {
    color: #ffffff !important;
    font-weight: 500;
}
.dataTables_wrapper .dataTables_filter input {
    background-color: rgba(255,255,255,0.1) !important;
    border: 1px solid var(--gym-cyan) !important;
    color: #ffffff !important;
    outline: none;
    border-radius: 4px;
    padding: 2px 8px;
}
</style>
@endsection