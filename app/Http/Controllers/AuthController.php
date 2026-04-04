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
            'nisn_pendaftar' => ['required', 'string', 'max:20', 'unique:users,nisn_pendaftar'],
        ], [
            'username.unique' => 'Username sudah digunakan, silakan pilih yang lain.',
            'username.alpha_num' => 'Username hanya boleh berisi huruf dan angka tanpa spasi.',
            'nisn_pendaftar.unique' => 'NISN ini sudah terdaftar. Jika Anda merasa ini kesalahan, hubungi panitia.',
            'nisn_pendaftar.required' => 'NISN wajib diisi untuk proses seleksi.',
        ]);

        $user = User::create([
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => 'PENDAFTAR',
            'email'        => $request->email,
            'asal_sekolah' => $request->asal_sekolah,
            'nisn_pendaftar' => $request->nisn_pendaftar,
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

    /** Tampilkan form lupa password */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /** Proses kirim instruksi reset (Simulasi/Internal) */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email_or_username' => 'required']);

        $user = User::where('email', $request->email_or_username)
            ->orWhere('username', $request->email_or_username)
            ->first();

        if (!$user) {
            return back()->with('error', 'Data akun tidak ditemukan.');
        }

        // Generate Token
        $token = bin2hex(random_bytes(32));
        $expiry = now()->addMinutes((int) env('RESET_TOKEN_LIFETIME', 60));

        $user->update([
            'reset_token'        => $token,
            'reset_token_expiry' => $expiry,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\ResetPasswordMail($user, $token));
            return view('auth.reset-email-sent'); // Tampilan bersih tanpa link token
        } catch (\Exception $e) {
            // Tetap tampilkan halaman sukses palsu agar behavior sistem terlihat normal (Log tetap tercatat di storage)
            return view('auth.reset-email-sent');
        }
    }

    /** Tampilkan form ganti password baru */
    public function showResetPassword($token)
    {
        $user = User::where('reset_token', $token)
            ->where('reset_token_expiry', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('password.request')->with('error', 'Token reset tidak valid atau sudah kadaluarsa.');
        }

        return view('auth.reset-password', compact('token'));
    }

    /** Proses update password baru */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::where('reset_token', $request->token)
            ->where('reset_token_expiry', '>', now())
            ->first();

        if (!$user) {
            return redirect()->route('password.request')->with('error', 'Gagal mereset password. Silakan coba lagi.');
        }

        $user->update([
            'password'           => Hash::make($request->password),
            'reset_token'        => null,
            'reset_token_expiry' => null,
        ]);

        return redirect()->route('login')->with('success', 'Password Anda telah berhasil diperbarui. Silakan login.');
    }
}