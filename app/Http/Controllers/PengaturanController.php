<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PengaturanController extends Controller
{
    /** Tampilkan halaman pengaturan. */
    public function index()
    {
        return view('pendaftar.pengaturan', ['user' => Auth::user()]);
    }

    /** Perbarui profil (email, no_hp, dll). */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email'         => ['nullable', 'email', 'max:100', 'unique:users,email,'.$user->id],
            'no_hp'         => ['nullable', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'asal_sekolah'  => ['nullable', 'string', 'max:100'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
        ], [
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil Anda telah berhasil diperbarui.');
    }

    /** Ganti password user. */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Kata sandi Anda telah berhasil diubah.');
    }
}
