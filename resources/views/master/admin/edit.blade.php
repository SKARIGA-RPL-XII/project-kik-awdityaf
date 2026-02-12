@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Admin</h1>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Admin Information</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phonenumber">Phone Number</label>
                    <input type="text" class="form-control @error('phonenumber') is-invalid @enderror" id="phonenumber"
                        name="phonenumber" value="{{ old('phonenumber', $user->phonenumber) }}" required>
                    @error('phonenumber')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" value="{{ old('username', $user->username) }}" required>
                    @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">New Password (leave blank to keep current)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="form-group">
                    <label for="job">Job</label>
                    <input type="text" class="form-control @error('job') is-invalid @enderror" id="job" name="job"
                        value="{{ old('job', $user->job) }}" required>
                    @error('job')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Admin</button>
            </form>
        </div>
    </div>

</div>

@endsection