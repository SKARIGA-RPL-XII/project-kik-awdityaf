<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =====================
    // FORM LOGIN
    // =====================
    public function loginForm()
    {
        return view('auth.login');
    }

    // =====================
    // PROSES LOGIN
    // =====================
    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $request->session()->regenerate();

        $user = Auth::user();

        // Cek status aktif (samakan dengan register)
        if (!$user->is_active) {
            Auth::logout();
            return back()->with('error', 'Akun belum aktif!');
        }

        // Redirect sesuai role
        if ($user->role === 'admin') {
            return redirect()->to('/gym');
        }

        // Default member
        if ($user->role === 'user') {
            return redirect()->route('plans');
        }

        // Fallback (jaga-jaga)
        return redirect()->route('dashboard');
    }

    return back()->with('error', 'Email atau password salah!');
}


    // =====================
    // FORM REGISTER
    // =====================
    public function registerForm()
    {
        return view('auth.registration');
    }

    // =====================
    // PROSES REGISTER
    // =====================
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
            'is_active' => true,
        ]);

        return redirect('/login')
            ->with('success', 'Registrasi berhasil, silakan login!');
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout()
    {
        Auth::logout();

        return redirect('/login')
            ->with('success', 'Berhasil logout!');
    }
}