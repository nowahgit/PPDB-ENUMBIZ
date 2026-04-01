<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seleksi;

class DataDiriController extends Controller
{
    /** Tampilkan halaman edit Data Diri & Nilai Rapor. */
    public function index()
    {
        $user = Auth::user()->load('berkas');
        
        // Ambil data seleksi jika sudah diinput (untuk menampilkan nilai rapor)
        $seleksi = Seleksi::where('user_id', $user->id)->first();

        return view('pendaftar.data-diri', compact('user', 'seleksi'));
    }
}
