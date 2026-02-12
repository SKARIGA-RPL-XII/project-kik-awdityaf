@extends('layouts.app')

@section('title', 'Login')

@section('content')

<style>
.gym-login-gradient {
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
    background: linear-gradient(135deg, #00d4ff 0%, #00b8d4 100%);
    color: #000;
    font-weight: bold;
    transition: all 0.3s ease;
}

.gym-btn:hover {
    background: linear-gradient(135deg, #00b8d4 0%, #0095a3 100%);
    box-shadow: 0 0 20px rgba(0, 212, 255, 0.4);
}

.gym-link {
    color: #00d4ff;
    transition: all 0.3s ease;
}

.gym-link:hover {
    color: #ff006e;
}
</style>

<div class="min-h-screen gym-login-gradient flex items-center justify-center px-4 py-8">
    <a href="{{ route('home') }}" class="gym-btn fixed top-5 left-5 px-5 py-2 rounded-lg font-semibold z-50">

        <i class="fas fa-arrow-left mr-2"></i> Kembali

    </a>


    {{-- Card --}}
    <div class="w-full max-w-md gym-card rounded-xl shadow-2xl overflow-hidden">

        {{-- Header --}}
        <div style="background: linear-gradient(135deg, rgba(0,212,255,0.15) 0%, rgba(255,0,110,0.15) 100%); border-bottom: 2px solid #00d4ff;"
            class="text-center p-8">

            <i class="fas fa-dumbbell text-5xl mb-4" style="color: #00d4ff;"></i>

            <h1 class="text-3xl font-bold" style="color: #00d4ff;">
                Welcome Back!
            </h1>

            <p class="text-sm mt-2" style="color: #aaa;">
                💪 Sign in to crush your fitness goals
            </p>

        </div>

        {{-- Body --}}
        <div class="p-8">

            <form method="POST" action="{{ url('/login') }}" class="space-y-5">

                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #00d4ff;">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>

                    <input type="email" name="email" placeholder="your@email.com"
                        class="gym-input w-full px-4 py-3 rounded-lg" required>
                </div>


                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: #00d4ff;">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>

                    <input type="password" name="password" placeholder="••••••••"
                        class="gym-input w-full px-4 py-3 rounded-lg" required>
                </div>


                {{-- Button --}}
                <button type="submit" class="gym-btn w-full py-3 rounded-lg font-semibold mt-6">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In Now
                </button>



            </form>


            {{-- Register --}}
            <p class="text-center mt-6 text-sm" style="color: #aaa;">

                Don't have an account yet?

                <a href="{{ url('/auth/registration') }}" class="gym-link font-semibold">

                    Join Our Community

                </a>

            </p>

        </div>

    </div>

</div>

@endsection