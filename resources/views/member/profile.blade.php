@extends('layouts.member.app')

@section('content')

<div class="card-gym shadow mb-4" style="background-color: #0f1419; border-left: 4px solid #00d4ff;">
    <div class="p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(255,0,110,0.1) 100%);">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="gym-accent font-weight-bold mb-2">
                    <i class="fas fa-user mr-2"></i>
                    My Profile
                </h1>
                <p class="text-light mb-2">
                    Update your personal information and account details
                </p>
            </div>
            <div class="col-auto">
                <a href="{{ url('member') }}" class="btn btn-gym-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">

    {{-- Form Profile --}}
    <div class="col-lg-8">

        <div class="card-gym shadow mb-4">

            <div class="card-header"
                style="background: linear-gradient(135deg, rgba(0,212,255,0.2) 0%, rgba(255,0,110,0.2) 100%); border-bottom: 1px solid rgba(255,255,255,0.1);">
                <h6 class="gym-accent font-weight-bold mb-0">My Profile</h6>
            </div>

            <div class="card-body" style="background-color: rgba(0,0,0,0.2);">

                {{-- Success Alert --}}
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}

                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                @endif


                <form action="{{ url('member/profile/update') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    {{-- Name --}}
                    <div class="form-group row">

                        <label for="name" class="col-sm-3 col-form-label">
                            Full Name
                        </label>

                        <div class="col-sm-9">

                            <input type="text" class="form-control" id="name" name="name" value="{{ $user['name'] }}"
                                required>

                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="form-group row">

                        <label for="email" class="col-sm-3 col-form-label">
                            Email
                        </label>

                        <div class="col-sm-9">

                            <input type="email" class="form-control" id="email" value="{{ $user['email'] }}" readonly>

                        </div>

                    </div>


                    {{-- Phone --}}
                    <div class="form-group row">

                        <label for="phone" class="col-sm-3 col-form-label">
                            Phone
                        </label>

                        <div class="col-sm-9">

                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $member['phone'] ?? '' }}" required>

                        </div>

                    </div>


                    {{-- Address --}}
                    <div class="form-group row">

                        <label for="address" class="col-sm-3 col-form-label">
                            Address
                        </label>

                        <div class="col-sm-9">

                            <textarea class="form-control" id="address" name="address" rows="3"
                                required>{{ $member['address'] ?? '' }}</textarea>

                        </div>

                    </div>


                    {{-- Submit --}}
                    <div class="form-group row">

                        <div class="col-sm-9 offset-sm-3">

                            <button type="submit" class="btn btn-success">
                                Update Profile
                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>


    {{-- Member Info --}}
    <div class="col-lg-4">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Member Information
                </h6>
            </div>

            <div class="card-body text-center">

                <img class="img-profile rounded-circle mb-3" width="100" height="100"
                    src="{{ asset('assets/img/profile/' . ($user['image'] ?? 'default.jpg')) }}">

                <h5 class="mb-1">
                    {{ $user['name'] }}
                </h5>


                @if(isset($member['member_code']))
                <p class="text-muted mb-3">
                    Member ID:
                    <strong>{{ $member['member_code'] }}</strong>
                </p>
                @endif


                <p class="text-muted mb-0">

                    <strong>Join Date:</strong>

                    {{ isset($member['join_date'])
                        ? \Carbon\Carbon::parse($member['join_date'])->format('M d, Y')
                        : '-'
                    }}

                    <br>


                    <strong>Status:</strong>

                    <span
                        class="badge badge-{{ (isset($member['status']) && $member['status'] == 'Active') ? 'success' : 'danger' }}">

                        {{ $member['status'] ?? 'Inactive' }}

                    </span>

                </p>

            </div>

        </div>

    </div>

</div>
@endsection