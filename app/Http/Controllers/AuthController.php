<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Mengembalikan view login.blade.php
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // 2. Coba untuk melakukan otentikasi
        if (Auth::attempt($credentials)) {
            // Jika berhasil, regenerate session untuk keamanan
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role->name == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role->name == 'kasir') {
                return redirect()->route('kasir.dashboard');
            }

            // Fallback jika tidak punya role (seharusnya tidak terjadi)
            return redirect('/login');
        }

        // 3. Jika gagal, kembalikan ke form login dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau Password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan ke landing page setelah logout
        return redirect()->route('landing');
    }
}
