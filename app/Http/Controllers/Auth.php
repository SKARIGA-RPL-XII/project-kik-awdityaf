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

            $user = Auth::user();

            // Cek status
            if ($user->status != 1) {
                Auth::logout();
                return back()->with('error', 'Akun belum aktif!');
            }

            // Cek role
            if ($user->role == 'admin') {
                return redirect('/admin');
            } else {
                return redirect('/member');
            }
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // =====================
    // FORM REGISTER
    // =====================
    public function registerForm()
    {
        return view('auth.register');
    }

    // =====================
    // PROSES REGISTER
    // =====================
    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:user',
            'password'  => 'required|min:6|confirmed'
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'image'    => 'default.jpg',
            'role'     => 'member',
            'status'   => 1,
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