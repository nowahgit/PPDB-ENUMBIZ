<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftarController extends Controller
{
    /**
     * Tampilkan Dashboard Pendaftar.
     */
    public function dashboard()
    {
        $user = Auth::user()->load(['berkas', 'seleksis' => function($query) {
            $query->latest()->limit(1);
        }]);

        $berkasStatus = $user->berkas->status_validasi ?? 'MENUNGGU';
        $seleksi = $user->seleksis->first();
        
        // Hitung rata-rata jika ada data seleksi
        $average = $seleksi ? round(
            ($seleksi->nilai_smt1 + $seleksi->nilai_smt2 + $seleksi->nilai_smt3 + 
             $seleksi->nilai_smt4 + $seleksi->nilai_smt5) / 5, 
            2
        ) : 0;

        return view('pendaftar.dashboard', compact('user', 'berkasStatus', 'seleksi', 'average'));
    }
}
