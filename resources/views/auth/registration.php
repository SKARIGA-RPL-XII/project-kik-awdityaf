<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="auth-card">

                <div class="auth-header">
                    <i class="fas fa-user-plus fa-3x mb-3"></i>
                    <h1>Join FitGym Today!</h1>
                    <p>Start your fitness journey with us</p>
                </div>

                <div class="auth-body">

                    <form method="POST" action="{{ url('/auth/registration') }}">

                        @csrf

                        {{-- Full Name --}}
                        <div class="mb-4">

                            <label for="name" class="form-label fw-semibold">
                                Full Name
                            </label>

                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter your full name" value="{{ old('name') }}" required>

                            @error('name')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div class="mb-4">

                            <label for="email" class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email address" value="{{ old('email') }}" required>

                            @error('email')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Phone --}}
                        <div class="mb-4">

                            <label for="phone" class="form-label fw-semibold">
                                Phone Number <span class="text-danger">*</span>
                            </label>

                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Enter phone number" value="{{ old('phone') }}" required>

                            @error('phone')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Gender --}}
                        <div class="mb-4">

                            <label for="gender" class="form-label fw-semibold">
                                Gender <span class="text-danger">*</span>
                            </label>

                            <select class="form-control" id="gender" name="gender" required>

                                <option value="">Select Gender</option>

                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>
                                    Male
                                </option>

                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                    Female
                                </option>

                            </select>

                            @error('gender')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                            @enderror

                        </div>

                        {{-- Password --}}
                        <div class="row">

                            <div class="col-md-6 mb-4">

                                <label for="password" class="form-label fw-semibold">
                                    Password
                                </label>

                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Create password" required>

                                @error('password')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                                @enderror

                            </div>

                            <div class="col-md-6 mb-4">

                                <label for="password_confirmation" class="form-label fw-semibold">
                                    Confirm Password
                                </label>

                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm password" required>

                            </div>

                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="btn btn-primary-custom mb-4">
                            <i class="fas fa-dumbbell me-2"></i>
                            Join Our Gym Community
                        </button>

                    </form>

                    <div class="text-center">

                        <p class="mb-0">
                            Already have an account?

                            <a href="{{ url('/login') }}" class="auth-link">
                                <i class="fas fa-sign-in-alt me-1"></i>
                                Sign In Here
                            </a>

                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>