@extends('layouts.app')

@section('title', 'Register')

@section('content')

<style>
.gym-register-gradient {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}

.gym-card {
    background-color: #0f1419;
    border: 1px solid rgba(0, 212, 255, 0.2);
}

.gym-input {
    background-color: #1a2332;
    border: 1px solid #00d4ff;
    color: #fff;
}

.gym-input::placeholder {
    color: #888;
}

.gym-input:focus {
    background-color: #1a2332;
    border-color: #ff006e;
    box-shadow: 0 0 10px rgba(255, 0, 110, 0.3);
    outline: none;
}

.gym-btn {
    background: linear-gradient(135deg, #ff006e 0%, #ff4d8f 100%);
    color: #fff;
    font-weight: bold;
    transition: all 0.3s ease;
}

.gym-btn:hover {
    background: linear-gradient(135deg, #ff4d8f 0%, #ff0066 100%);
    box-shadow: 0 0 20px rgba(255, 0, 110, 0.4);
}

.gym-link {
    color: #00d4ff;
    transition: all 0.3s ease;
}

.gym-link:hover {
    color: #ff006e;
}

.gym-error {
    color: #ff006e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}
</style>

<div class="min-h-screen gym-register-gradient flex items-center justify-center px-4 py-8">
    <a href="{{ route('login') }}" class="gym-btn fixed top-5 left-5 px-5 py-2 rounded-lg font-semibold z-50">

        <i class="fas fa-arrow-left mr-2"></i> Kembali

    </a>

    {{-- Card --}}
    <div class="w-full max-w-lg gym-card rounded-xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, rgba(0,212,255,0.15) 0%, rgba(255,0,110,0.15) 100%); border-bottom: 2px solid #ff006e;"
            class="text-center p-8">

            <i class="fas fa-user-plus text-5xl mb-4" style="color: #ff006e;"></i>

            <h1 class="text-3xl font-bold" style="color: #ff006e;">
                Join FitGym!
            </h1>

            <p class="text-sm mt-2" style="color: #aaa;">
                Start your transformation today 🔥
            </p>

        </div>


        {{-- Body --}}
        <div class="p-8">

            <form method="POST" action="{{ url('/auth/registration') }}" class="space-y-4">

                @csrf


                {{-- Full Name --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #00d4ff;">
                        <i class="fas fa-user mr-2"></i>Full Name
                    </label>

                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter your full name"
                        class="gym-input w-full px-4 py-3 rounded-lg" required>

                    @error('name')
                    <p class="gym-error">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #00d4ff;">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>

                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address"
                        class="gym-input w-full px-4 py-3 rounded-lg" required>

                    @error('email')
                    <p class="gym-error">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Phone --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #00d4ff;">
                        <i class="fas fa-phone mr-2"></i>Phone Number <span style="color: #ff006e;">*</span>
                    </label>

                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08123456789"
                        class="gym-input w-full px-4 py-3 rounded-lg" required>

                    @error('phone')
                    <p class="gym-error">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Gender --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #00d4ff;">
                        <i class="fas fa-venus-mars mr-2"></i>Gender <span style="color: #ff006e;">*</span>
                    </label>

                    <select name="gender" class="gym-input w-full px-4 py-3 rounded-lg" required>

                        <option value="" style="background-color: #1a2332; color: #888;">Select Gender</option>

                        <option value="Male" style="background-color: #1a2332; color: #fff;"
                            {{ old('gender') == 'Male' ? 'selected' : '' }}>
                            👨 Male
                        </option>

                        <option value="Female" style="background-color: #1a2332; color: #fff;"
                            {{ old('gender') == 'Female' ? 'selected' : '' }}>
                            👩 Female
                        </option>

                    </select>

                    @error('gender')
                    <p class="gym-error">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Password --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: #00d4ff;">
                            <i class="fas fa-lock mr-2"></i>Password
                        </label>

                        <input type="password" name="password" placeholder="Create password"
                            class="gym-input w-full px-4 py-3 rounded-lg" required>

                        @error('password')
                        <p class="gym-error">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Confirm --}}
                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color: #ff006e;">
                            <i class="fas fa-lock mr-2"></i>Confirm Password
                        </label>

                        <input type="password" name="password_confirmation" placeholder="Confirm password"
                            class="gym-input w-full px-4 py-3 rounded-lg" required>
                    </div>

                </div>


                {{-- Submit --}}
                <button type="submit" class="gym-btn w-full py-3 rounded-lg font-semibold mt-6">
                    <i class="fas fa-dumbbell mr-2"></i>
                    Join Our Gym Community
                </button>

            </form>


            {{-- Login Link --}}
            <p class="text-center mt-6 text-sm" style="color: #aaa;">

                Already have an account?

                <a href="{{ url('/login') }}" class="gym-link font-semibold">

                    Sign In Here

                </a>

            </p>

        </div>

    </div>

</div>

@endsection