<div class="row">

    <div class="col-lg-6 mx-auto">

        <div class="card shadow mb-4">

            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    Change Password
                </h6>
            </div>

            <div class="card-body">


                {{-- Flash Error Message --}}
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif


                {{-- Flash Success Message --}}
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif


                {{-- Form --}}
                <form action="{{ route('member.change-password') }}" method="POST">

                    @csrf


                    <!-- Current Password -->
                    <div class="mb-3">

                        <label for="current_password" class="form-label">
                            Current Password
                        </label>

                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                            id="current_password" name="current_password" required>

                        @error('current_password')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                    </div>


                    <!-- New Password -->
                    <div class="mb-3">

                        <label for="new_password" class="form-label">
                            New Password
                        </label>

                        <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                            id="new_password" name="new_password" required>

                        <small class="text-muted">
                            Password must be at least 6 characters long
                        </small>

                        @error('new_password')
                        <small class="text-danger d-block">
                            {{ $message }}
                        </small>
                        @enderror

                    </div>


                    <!-- Confirm Password -->
                    <div class="mb-4">

                        <label for="confirm_password" class="form-label">
                            Confirm New Password
                        </label>

                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                            id="confirm_password" name="confirm_password" required>

                        @error('confirm_password')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                    </div>


                    <!-- Buttons -->
                    <div class="d-flex gap-2">

                        <button type="submit" class="btn btn-success">
                            Change Password
                        </button>

                        <a href="{{ route('member.profile') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>


                </form>

            </div>
        </div>
    </div>

</div>