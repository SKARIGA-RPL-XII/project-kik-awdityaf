@extends('layouts.admin')

@section('title', 'Edit Member')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Member</h1>

    <a href="{{ route('members.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Members
    </a>
</div>

<div class="row">

    <!-- FORM -->
    <div class="col-lg-8">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Edit Member Information
                </h6>
            </div>

            <div class="card-body">

                <form action="{{ route('members.update', $member->id) }}" method="POST" class="user">

                    @csrf
                    @method('PUT')

                    <!-- NAME -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3">

                            <label>Full Name *</label>

                            <input type="text" name="name" class="form-control form-control-user"
                                value="{{ old('name', $member->name) }}" required>

                            @error('name')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                        <div class="col-sm-6">

                            <label>Member Code</label>

                            <input type="text" class="form-control" value="{{ $member->member_code }}" readonly>

                            <small class="text-muted">Cannot be changed</small>

                        </div>

                    </div>

                    <!-- EMAIL + PHONE -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3">

                            <label>Email</label>

                            <input type="email" class="form-control" value="{{ $member->email }}" readonly>

                        </div>

                        <div class="col-sm-6">

                            <label>Phone *</label>

                            <input type="text" name="phone" id="phone" class="form-control form-control-user"
                                value="{{ old('phone', $member->phone) }}" required>

                            @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror

                        </div>

                    </div>

                    <!-- BIRTH + GENDER -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3">

                            <label>Birth Date *</label>

                            <input type="date" name="birth_date" class="form-control"
                                value="{{ old('birth_date', $member->birth_date) }}" required>

                        </div>

                        <div class="col-sm-6">

                            <label>Gender *</label>

                            <select name="gender" class="form-control" required>

                                <option value="">Select</option>

                                <option value="Male" {{ old('gender', $member->gender) == 'Male' ? 'selected' : '' }}>
                                    Male
                                </option>

                                <option value="Female"
                                    {{ old('gender', $member->gender) == 'Female' ? 'selected' : '' }}>
                                    Female
                                </option>

                            </select>

                        </div>

                    </div>

                    <!-- STATUS + JOIN -->
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3">

                            <label>Status *</label>

                            <select name="status" class="form-control" required>

                                <option value="Active" {{ $member->status == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="Inactive" {{ $member->status == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                                <option value="Suspended" {{ $member->status == 'Suspended' ? 'selected' : '' }}>
                                    Suspended
                                </option>

                            </select>

                        </div>

                        <div class="col-sm-6">

                            <label>Join Date</label>

                            <input type="date" class="form-control" value="{{ $member->join_date }}" readonly>

                        </div>

                    </div>

                    <!-- ADDRESS -->
                    <div class="form-group">

                        <label>Address</label>

                        <textarea name="address" class="form-control"
                            rows="3">{{ old('address', $member->address) }}</textarea>

                    </div>

                    <hr>

                    <!-- EMERGENCY -->
                    <h6 class="text-success mb-3">Emergency Contact</h6>

                    <div class="form-group row">

                        <div class="col-sm-6 mb-3">

                            <label>Contact Name</label>

                            <input type="text" name="emergency_contact" class="form-control"
                                value="{{ old('emergency_contact', $member->emergency_contact) }}">

                        </div>

                        <div class="col-sm-6">

                            <label>Phone</label>

                            <input type="text" name="emergency_phone" id="emergency_phone" class="form-control"
                                value="{{ old('emergency_phone', $member->emergency_phone) }}">

                        </div>

                    </div>

                    <hr>

                    <!-- BUTTON -->
                    <div class="form-group row">

                        <div class="col-sm-6">

                            <button class="btn btn-success btn-block">
                                <i class="fas fa-save"></i> Update
                            </button>

                        </div>

                        <div class="col-sm-6">

                            <a href="{{ route('members.index') }}" class="btn btn-secondary btn-block">
                                Cancel
                            </a>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>


    <!-- SIDEBAR INFO -->
    <div class="col-lg-4">

        <div class="card shadow mb-4">

            <div class="card-body text-center">

                <img width="80" height="80" class="rounded-circle mb-2"
                    src="{{ asset('assets/img/profile/'.$member->image ?? 'default.jpg') }}">

                <h6>{{ $member->name }}</h6>

            </div>

        </div>


        <!-- ACTIONS -->
        <div class="card shadow">

            <div class="card-header text-warning font-weight-bold">
                Quick Actions
            </div>

            <div class="card-body">

                <a href="{{ route('subscriptions.index',['member'=>$member->id]) }}"
                    class="btn btn-outline-primary btn-block mb-2">
                    Subscriptions
                </a>

                <a href="{{ route('attendance.index',['member'=>$member->id]) }}"
                    class="btn btn-outline-info btn-block mb-2">
                    Attendance
                </a>

                <form action="{{ route('members.destroy',$member->id) }}" method="POST">

                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outline-danger btn-block">
                        Delete
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>
function formatPhone(el) {

    el.addEventListener('input', function() {

        let val = this.value.replace(/\D/g, '');

        if (val && !val.startsWith('0')) {
            val = '0' + val;
        }

        this.value = val;
    });

}

formatPhone(document.getElementById('phone'));
formatPhone(document.getElementById('emergency_phone'));
</script>

@endpush