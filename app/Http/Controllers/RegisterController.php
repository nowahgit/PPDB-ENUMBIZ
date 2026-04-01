<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun baru.
     */
    public function register(Request $request)
    {
        $request->validate([
            'username'     => ['required', 'string', 'alpha_dash', 'max:20', 'unique:users'],
            'email'        => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password'     => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp'        => ['required', 'string', 'max:15'],
            'asal_sekolah' => ['required', 'string', 'max:100'],
        ], [
            'username.unique' => 'Username sudah digunakan.',
            'email.unique'    => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => 'PENDAFTAR',
            'no_hp'        => $request->no_hp,
            'asal_sekolah' => $request->asal_sekolah,
        ]);

        // Catat Audit Log
        AuditLog::create([
            'action'      => 'REGISTER',
            'entity_type' => 'User',
            'entity_id'   => $user->id,
            'keterangan'  => "User {$user->username} berhasil mendaftar sebagai PENDAFTAR.",
        ]);

        Auth::login($user);

        return redirect()->route('pendaftar.dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di PPDB Enumbiz School.');
    }
}
