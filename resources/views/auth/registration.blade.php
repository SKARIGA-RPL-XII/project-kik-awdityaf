@extends('layouts.index')

@section('title', 'Register')

@section('content')
<div class="auth-wrapper">

    <div class="auth-card-large">
        <div class="gym-card rounded-4 shadow-lg overflow-hidden">

            <div class="text-center p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.15) 0%, rgba(255,0,110,0.15) 100%);
                border-bottom: 2px solid #ff006e;">

                <i class="fas fa-user-plus fa-2x mb-3" style="color:#ff006e;"></i>
                <h3 class="fw-bold mb-1" style="color:#ff006e;">Join FitGym!</h3>
                <p class="text-muted small mb-0">
                    Start your transformation today
                </p>
            </div>

            <div class="p-4">
                <form method="POST" action="{{ url('/auth/registration') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#00d4ff;">
                            Full Name
                        </label>
                        <input type="text" name="name" class="form-control gym-input" placeholder="Enter your full name"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#00d4ff;">
                            Email Address
                        </label>
                        <input type="email" name="email" class="form-control gym-input"
                            placeholder="Enter your email address" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#00d4ff;">
                            Phone Number
                        </label>
                        <input type="text" name="phone" class="form-control gym-input" placeholder="08123456789"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#00d4ff;">
                            Gender
                        </label>
                        <select name="gender" class="form-control gym-input" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" style="color:#00d4ff;">
                                Password
                            </label>
                            <input type="password" name="password" class="form-control gym-input"
                                placeholder="Create password" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold" style="color:#ff006e;">
                                Confirm Password
                            </label>
                            <input type="password" name="password_confirmation" class="form-control gym-input"
                                placeholder="Confirm password" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-semibold mt-3">
                        <i class="fas fa-dumbbell me-2"></i>
                        Join Our Gym Community
                    </button>
                </form>

                <p class="text-center mt-4 small text-muted">
                    Already have an account?
                    <a href="{{ url('/login') }}" class="gym-link fw-semibold">
                        Sign In Here
                    </a>
                </p>
            </div>

        </div>
    </div>

</div>
@endsection