<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use App\Models\Seleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeleksiController extends Controller
{
    /**
     * Tampilkan hasil seleksi bagi Pendaftar.
     */
    public function pendaftarStatus()
    {
        $seleksi = Seleksi::where('user_id', Auth::id())->latest()->first();
        return view('pendaftar.status-seleksi', compact('seleksi'));
    }

    /**
     * Tampilkan Pusat Seleksi Terpadu (Hub Seleksi, Periode, & Arsip).
     */
    public function adminIndex()
    {
        $users = User::where('role', 'PENDAFTAR')->with(['berkas', 'seleksis'])->latest()->paginate(20);
        $periods = \App\Models\SelectionPeriod::orderBy('id_periode', 'desc')->get();
        $archives = \App\Models\ArsipSeleksi::with('detailPendaftar')->orderBy('tanggal_arsip', 'desc')->get();

        return view('admin.seleksi', compact('users', 'periods', 'archives'));
    }

    /**
     * Simpan atau perbarui data seleksi pendaftar (Admin Only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'       => ['required', 'exists:users,id'],
            'nama_seleksi'  => ['required', 'string', 'max:50'],
            'status_seleksi'=> ['required', 'in:MENUNGGU,LULUS,TIDAK_LULUS'],
            'waktu_seleksi' => ['required', 'date'],
        ]);

        $admin = Admin::where('user_id', Auth::id())->firstOrFail();

        Seleksi::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'id_panitia'    => $admin->id_panitia,
                'nama_seleksi'  => $request->nama_seleksi,
                'waktu_seleksi' => $request->waktu_seleksi,
                'status_seleksi'=> $request->status_seleksi,
            ]
        );

        return back()->with('success', 'Status kelulusan dan seleksi pendaftar berhasil disimpan.');
    }

    /**
     * Perbarui status kelulusan pendaftar (Admin Only).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_seleksi' => ['required', 'in:MENUNGGU,LULUS,TIDAK_LULUS'],
        ]);

        $seleksi = Seleksi::findOrFail($id);
        $seleksi->update(['status_seleksi' => $request->status_seleksi]);

        return back()->with('success', "Status kelulusan berhasil diperbarui menjadi {$request->status_seleksi}.");
    }

    /**
     * Tampilkan daftar arsip histori PPDB.
     */
    public function archiveIndex()
    {
        $archives = \App\Models\ArsipSeleksi::with('detailPendaftar')->orderBy('tanggal_arsip', 'desc')->get();
        return view('admin.arsip', compact('archives'));
    }

    /**
     * Lakukan pengarsipan total dan pembersihan sistem (Reset).
     */
    public function archiveStore(Request $request)
    {
        $activePeriod = \App\Models\SelectionPeriod::where('status', 'AKTIF')->first();

        if (!$activePeriod) {
            return back()->with('error', 'Tidak ada periode aktif yang bisa diarsipkan.');
        }

        $request->validate([
            'nama_periode' => ['required', 'string', 'in:' . $activePeriod->nama_periode],
        ], [
            'nama_periode.in' => 'Konfirmasi nama periode tidak cocok. Harap ketik ulang sesuai nama periode aktif.',
        ]);

        // 1. Data Fetching (Ambil semua pendaftar aktif)
        $pendaftar = User::where('role', 'PENDAFTAR')->with(['berkas', 'seleksis'])->get();
        
        if ($pendaftar->isEmpty()) {
            return back()->with('error', 'Tidak ada data pendaftar yang bisa diarsipkan.');
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $activePeriod, $pendaftar) {
            // 2. Summarizing & Snapshotting
            $totalPendaftar = $pendaftar->count();
            $totalLulus = 0;
            $totalTidakLulus = 0;

            // 3. Permanent Archiving (Header)
            $arsipInduk = \App\Models\ArsipSeleksi::create([
                'nama_periode'      => $activePeriod->nama_periode,
                'deskripsi'         => $activePeriod->deskripsi ?? 'Arsip Otomatis',
                'tanggal_buka'      => $activePeriod->tanggal_buka ?? now(),
                'tanggal_tutup'     => $activePeriod->tanggal_tutup ?? now(),
                'total_pendaftar'   => $totalPendaftar,
                'total_lulus'       => 0, // Will be updated after loop
                'total_tidak_lulus' => 0, // Will be updated after loop
                'tanggal_arsip'     => now(),
            ]);

            foreach ($pendaftar as $p) {
                $status = $p->seleksis->first()->status_seleksi ?? 'MENUNGGU';
                if ($status === 'LULUS') $totalLulus++;
                if ($status === 'TIDAK_LULUS') $totalTidakLulus++;

                $totalNilai = ($p->nilai_smt1 ?? 0) + ($p->nilai_smt2 ?? 0) + ($p->nilai_smt3 ?? 0) + ($p->nilai_smt4 ?? 0) + ($p->nilai_smt5 ?? 0);
                $avg = $totalNilai > 0 ? $totalNilai / 5 : 0;

                // 4. Per Baris Simpan ke SQL sebagai Detail (Dinamis)
                \App\Models\ArsipPendaftar::create([
                    'arsip_seleksi_id'  => $arsipInduk->id_arsip,
                    'nomor_pendaftaran' => $p->nomor_pendaftaran,
                    'nama'              => $p->nama_pendaftar ?? $p->username,
                    'nisn'              => $p->nisn_pendaftar,
                    'rata_rata_nilai'   => $avg,
                    'status_seleksi'    => $status,
                ]);
            }

            // Update stats back to Header
            $arsipInduk->update([
                'total_lulus'       => $totalLulus,
                'total_tidak_lulus' => $totalTidakLulus,
            ]);

            // 5. Hard Cleanup (Reset System)
            foreach ($pendaftar as $p) {
                $p->delete(); 
            }
        });

        // 5. Cleanup Periods (DDL outside transaction to prevent implicit commit issues)
        \App\Models\SelectionPeriod::truncate();

        return redirect()->route('admin.seleksi')->with('success', 'Periode seleksi telah berhasil diarsipkan secara permanen dan sistem telah di-reset untuk periode baru.');
    }

    /**
     * Jalankan Seleksi Otomatis berdasarkan Passing Grade.
     */
    public function archiveOtomatis(Request $request)
    {
        $request->validate([
            'passing_grade' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $passingGrade = $request->passing_grade;
        
        // HANYA proses user yang berkasnya sudah VALID
        $users = User::where('role', 'PENDAFTAR')
                     ->whereHas('berkas', function($q) {
                         $q->where('status_validasi', 'VALID');
                     })->get();

        if ($users->isEmpty()) {
            return back()->with('error', 'Tidak ada data pendaftar dengan BERKAS VALID untuk diseleksi.');
        }

        $admin = Admin::where('user_id', Auth::id())->firstOrFail();

        foreach ($users as $user) {
            $total = ($user->nilai_smt1 ?? 0) + ($user->nilai_smt2 ?? 0) + ($user->nilai_smt3 ?? 0) + ($user->nilai_smt4 ?? 0) + ($user->nilai_smt5 ?? 0);
            $avg = $total > 0 ? $total / 5 : 0;
            $status = ($avg >= $passingGrade) ? 'LULUS' : 'TIDAK_LULUS';

            Seleksi::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'id_panitia'     => $admin->id_panitia,
                    'nama_seleksi'   => 'SELEKSI OTOMATIS GENERATED',
                    'waktu_seleksi'  => now(),
                    'status_seleksi' => $status,
                ]
            );
        }

        return back()->with('success', "Proses seleksi otomatis selesai. Ambang batas: {$passingGrade}.");
    }
}
