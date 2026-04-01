<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    /** Tampilkan form login */
    public function showLogin()
    {
        return view('auth.login');
    }

    /** Proses Login */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            return $user->role === 'PANITIA' 
                ? redirect()->intended('/admin/dashboard')
                : redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /** Tampilkan form registrasi (Pendaftar) */
    public function showRegister()
    {
        $periode = \App\Models\SelectionPeriod::where('status', 'AKTIF')->first();
        
        if (!$periode || !now()->between($periode->tanggal_buka, $periode->tanggal_tutup)) {
            return view('auth.register-closed', compact('periode'));
        }

        return view('auth.register');
    }

    /** Proses Registrasi Pendaftar */
    public function register(Request $request)
    {
        $periode = \App\Models\SelectionPeriod::where('status', 'AKTIF')->first();
        if (!$periode || !now()->between($periode->tanggal_buka, $periode->tanggal_tutup)) {
            return back()->with('error', 'Maaf, pendaftaran akun untuk periode ini belum dibuka atau sudah ditutup.');
        }

        $request->validate([
            'username'     => ['required', 'string', 'max:20', 'alpha_num', 'unique:users'],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
            'email'        => ['nullable', 'email', 'unique:users', 'max:100'],
            'asal_sekolah' => ['nullable', 'string', 'max:100'],
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'username.alpha_num' => 'Username hanya boleh berisi huruf dan angka.',
        ]);

        $user = User::create([
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => 'PENDAFTAR',
            'email'        => $request->email,
            'asal_sekolah' => $request->asal_sekolah,
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Akun berhasil dibuat!');
    }

    /** Proses Logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah keluar.');
    }
}