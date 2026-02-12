@extends('layouts.admin')

@section('title', 'Add New Member')

@section('content')

{{-- Page Heading --}}
<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        Add New Member
    </h1>

    <a href="{{ route('gym.members.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">

        <i class="fas fa-arrow-left fa-sm text-white-50"></i>
        Back to Members
    </a>

</div>


<div class="row">

    {{-- Form --}}
    <div class="col-lg-8">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Member Information
                </h6>
            </div>


            <div class="card-body">

                <form method="POST" action="{{ route('gym.members.store') }}" class="user">

                    @csrf


                    {{-- Name & Email --}}
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>
                                Full Name
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                class="form-control form-control-user @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" placeholder="Enter full name" required>

                            @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>


                        <div class="col-sm-6">

                            <label>
                                Email Address
                                <span class="text-danger">*</span>
                            </label>

                            <input type="email"
                                class="form-control form-control-user @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" placeholder="Enter email" required>

                            @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>

                    </div>


                    {{-- Phone & Birth --}}
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>
                                Phone Number
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" id="phone"
                                class="form-control form-control-user @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone') }}" placeholder="Enter phone" required>

                            @error('phone')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>


                        <div class="col-sm-6">

                            <label>
                                Birth Date
                                <span class="text-danger">*</span>
                            </label>

                            <input type="date" id="birth_date"
                                class="form-control form-control-user @error('birth_date') is-invalid @enderror"
                                name="birth_date" value="{{ old('birth_date') }}" required>

                            @error('birth_date')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>

                    </div>


                    {{-- Gender & Address --}}
                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>
                                Gender
                                <span class="text-danger">*</span>
                            </label>

                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>

                                <option value="">Select Gender</option>

                                <option value="Male" {{ old('gender')=='Male'?'selected':'' }}>
                                    Male
                                </option>

                                <option value="Female" {{ old('gender')=='Female'?'selected':'' }}>
                                    Female
                                </option>

                            </select>

                            @error('gender')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>


                        <div class="col-sm-6">

                            <label>Address</label>

                            <textarea name="address" class="form-control" rows="3"
                                placeholder="Enter address">{{ old('address') }}</textarea>

                        </div>

                    </div>


                    <hr>

                    {{-- Emergency --}}
                    <h6 class="text-success mb-3">
                        Emergency Contact
                    </h6>


                    <div class="form-group row">

                        <div class="col-sm-6 mb-3 mb-sm-0">

                            <label>Emergency Contact Name</label>

                            <input type="text" class="form-control form-control-user" name="emergency_contact"
                                value="{{ old('emergency_contact') }}">

                        </div>


                        <div class="col-sm-6">

                            <label>Emergency Contact Phone</label>

                            <input type="text" id="emergency_phone" class="form-control form-control-user"
                                name="emergency_phone" value="{{ old('emergency_phone') }}">

                        </div>

                    </div>


                    <hr>


                    {{-- Submit --}}
                    <div class="form-group">

                        <button type="submit" class="btn btn-success btn-user btn-block">

                            <i class="fas fa-user-plus mr-2"></i>
                            Add Member

                        </button>

                    </div>


                </form>

            </div>
        </div>

    </div>



    {{-- Right Panel --}}
    <div class="col-lg-4">

        {{-- Info --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="font-weight-bold text-info">
                    Information
                </h6>
            </div>


            <div class="card-body">

                <div class="alert alert-info">

                    <h6>
                        <i class="fas fa-info-circle mr-2"></i>
                        Member Registration
                    </h6>

                    <ul class="mb-0">
                        <li>Member code auto generated</li>
                        <li>Default password: <b>123456</b></li>
                        <li>Can change after login</li>
                        <li>All * fields required</li>
                        <li>Status Active by default</li>
                    </ul>

                </div>


                <div class="alert alert-warning">

                    <h6>
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Next Steps
                    </h6>

                    <ol class="mb-0">
                        <li>Assign membership</li>
                        <li>Process payment</li>
                        <li>Give credentials</li>
                        <li>Orientation</li>
                    </ol>

                </div>

            </div>
        </div>


        {{-- Quick Actions --}}
        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="font-weight-bold text-success">
                    Quick Actions
                </h6>
            </div>


            <div class="card-body">

                <a href="{{ route('gym.plans.index') }}" class="btn btn-outline-success btn-block mb-2">

                    <i class="fas fa-tags mr-2"></i>
                    Membership Plans
                </a>


                <a href="{{ route('gym.members.index') }}" class="btn btn-outline-primary btn-block mb-2">

                    <i class="fas fa-users mr-2"></i>
                    All Members
                </a>


                <a href="{{ route('gym.subscriptions.index') }}" class="btn btn-outline-info btn-block">

                    <i class="fas fa-credit-card mr-2"></i>
                    Subscriptions
                </a>

            </div>
        </div>

    </div>

</div>

@endsection


@section('scripts')

<script>
// Age Validation
document.getElementById('birth_date')
    .addEventListener('change', function() {

        const birth = new Date(this.value);
        const today = new Date();

        let age = today.getFullYear() - birth.getFullYear();

        if (
            today.getMonth() < birth.getMonth() ||
            (today.getMonth() === birth.getMonth() &&
                today.getDate() < birth.getDate())
        ) {
            age--;
        }

        if (age < 16) {
            alert('Member must be at least 16 years old.');
            this.value = '';
        }

    });


// Phone format
function formatPhone(id) {

    document.getElementById(id)
        .addEventListener('input', function() {

            let val = this.value.replace(/\D/g, '');

            if (val && !val.startsWith('0')) {
                val = '0' + val;
            }

            this.value = val;

        });

}

formatPhone('phone');
formatPhone('emergency_phone');
</script>

@endsection