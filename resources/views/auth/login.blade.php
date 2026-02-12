@extends('layouts.index')

@section('title', 'Login')

@section('content')
<div class="auth-wrapper">

    <div class="auth-card">
        <div class="gym-card rounded-4 shadow-lg overflow-hidden">

            <div class="text-center p-4" style="background: linear-gradient(135deg, rgba(0,212,255,0.15) 0%, rgba(255,0,110,0.15) 100%);
                border-bottom: 2px solid #00d4ff;">

                <i class="fas fa-dumbbell fa-2x mb-3" style="color:#00d4ff;"></i>
                <h3 class="fw-bold mb-1" style="color:#00d4ff;">Welcome Back!</h3>
                <p class="text-muted small mb-0">
                    Sign in to continue your fitness journey
                </p>
            </div>

            <div class="p-4">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:#00d4ff;">
                            Email Address
                        </label>
                        <input type="email" name="email" class="form-control gym-input"
                            placeholder="Enter your email address" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color:#00d4ff;">
                            Password
                        </label>
                        <input type="password" name="password" class="form-control gym-input"
                            placeholder="Enter your password" required>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 py-2 fw-semibold">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Sign In Now
                    </button>
                </form>

                <p class="text-center mt-4 small text-muted">
                    Don't have an account?
                    <a href="{{ url('/auth/registration') }}" class="gym-link fw-semibold">
                        Join Our Community
                    </a>
                </p>
            </div>

        </div>
    </div>

</div>
@endsection