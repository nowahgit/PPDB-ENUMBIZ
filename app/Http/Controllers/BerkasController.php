<?php

namespace App\Http\Controllers;

use App\Models\Berkas;
use App\Models\AuditLog;
use App\Models\Seleksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BerkasController extends Controller
{
    /** Tampilkan halaman upload Berkas (KK, Akte, SKL). */
    public function index()
    {
        $berkas = Auth::user()->berkas;

        // Cek apakah data sudah divalidasi VALID
        if ($berkas && $berkas->status_validasi === 'VALID') {
            session()->flash('info', 'Data berkas Anda telah divalidasi oleh Admin dan sudah tidak dapat diubah.');
        }

        return view('pendaftar.berkas', compact('berkas'));
    }

    /** Simpan/Update Data Diri & Nilai Rapor (Dijalankan dari halaman Data Diri). */
    public function storeIdentity(Request $request)
    {
        $user = Auth::user();
        $berkas = $user->berkas;

        // Perbaikan 1: Lock Data VALID
        if ($berkas && $berkas->status_validasi === 'VALID') {
            return back()->with('error', 'Maaf, data Anda sudah divalidasi (VALID) dan tidak dapat diubah lagi.');
        }

        $request->validate([
            'nisn_pendaftar'         => ['required', 'string', 'max:20'],
            'nama_pendaftar'         => ['required', 'string', 'max:50'],
            'jenis_kelamin'          => ['required', 'in:LAKI-LAKI,PEREMPUAN'],
            'tanggallahir_pendaftar' => ['required', 'date'],
            'alamat_pendaftar'       => ['required', 'string'],
            'agama'                  => ['required', 'in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu'],
            'nama_ortu'              => ['required', 'string', 'max:50'],
            'pekerjaan_ortu'         => ['required', 'string', 'max:50'],
            'no_hp_ortu'             => ['required', 'string', 'max:15'],
            'alamat_ortu'            => ['required', 'string'],
            // Nilai Rapor
            'nilai_smt1'             => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_smt2'             => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_smt3'             => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_smt4'             => ['required', 'numeric', 'min:0', 'max:100'],
            'nilai_smt5'             => ['required', 'numeric', 'min:0', 'max:100'],
            // Prestasi Opsional
            'prestasi_1'             => ['nullable', 'string', 'max:255'],
            'prestasi_1_file'        => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'prestasi_2'             => ['nullable', 'string', 'max:255'],
            'prestasi_2_file'        => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'prestasi_3'             => ['nullable', 'string', 'max:255'],
            'prestasi_3_file'        => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $user = Auth::user();

        // 1. Simpan Data Diri, Orang Tua, & Nilai Langsung ke tabel USERS (Sesuai Skema Anda)
        $user->update([
            'nisn_pendaftar'         => $request->nisn_pendaftar,
            'nama_pendaftar'         => $request->nama_pendaftar,
            'jenis_kelamin'          => $request->jenis_kelamin,
            'tanggallahir_pendaftar' => $request->tanggallahir_pendaftar,
            'alamat_pendaftar'       => $request->alamat_pendaftar,
            'agama'                  => $request->agama,
            'prestasi'               => $request->prestasi_1 . ($request->prestasi_2 ? ", " . $request->prestasi_2 : "") . ($request->prestasi_3 ? ", " . $request->prestasi_3 : ""), // Menggabungkan deskripsi prestasi ke field prestasi (TEXT) sesuai skema
            'nama_ortu'              => $request->nama_ortu,
            'pekerjaan_ortu'         => $request->pekerjaan_ortu,
            'no_hp_ortu'             => $request->no_hp_ortu,
            'alamat_ortu'            => $request->alamat_ortu,
            'nilai_smt1'             => $request->nilai_smt1,
            'nilai_smt2'             => $request->nilai_smt2,
            'nilai_smt3'             => $request->nilai_smt3,
            'nilai_smt4'             => $request->nilai_smt4,
            'nilai_smt5'             => $request->nilai_smt5,
        ]);

        // 2. Inisialisasi/Update Tabel Berkas (Hanya untuk Dokumen, sesuaikan seadanya)
        $berkas = Berkas::updateOrCreate(
            ['user_id' => $user->id],
            ['status_validasi' => 'MENUNGGU']
        );

        // Handle Achievement File Paths (Tetap di tabel Berkas karena skema tidak mencantumkan kolom file di users)
        for ($i = 1; $i <= 3; $i++) {
            $fName = "prestasi_{$i}_file";
            if ($request->hasFile($fName)) {
                $file = $request->file($fName);
                $path = $file->storeAs('berkas-ppdb', "prestasi_{$i}_" . time() . "_{$user->id}." . $file->getClientOriginalExtension(), 'public');
                $berkas->update(["{$fName}" => $path]);
            }
        }

        // 3. Inisialisasi Tabel Seleksi (Tanpa Nilai, karena nilai sudah di USERS)
        Seleksi::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_seleksi'  => 'Validasi Berkas Pendaftar',
                'waktu_seleksi' => now(),
                'status_seleksi'=> 'MENUNGGU',
            ]
        );

        return back()->with('success', 'Data diri, prestasi, dan nilai rapor berhasil disimpan.');
    }

    /** Unggah Dokumen Fisik (KK, Akte, SKL). */
    public function storeDocuments(Request $request)
    {
        $user = Auth::user();
        $berkas = $user->berkas;

        // Perbaikan 1: Lock Data VALID
        if ($berkas && $berkas->status_validasi === 'VALID') {
            return back()->with('error', 'Maaf, berkas Anda sudah divalidasi (VALID) dan tidak dapat diperbarui lagi.');
        }

        $request->validate([
            'file_kk'   => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_akte' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'file_skl'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $user = Auth::user();
        
        // Cari atau buat entitas Berkas untuk user ini
        $berkas = Berkas::firstOrCreate(['user_id' => $user->id]);

        $data = [];
        foreach (['file_kk', 'file_akte', 'file_skl'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Hapus file lama jika ada (Clean up)
                if ($berkas->$fileKey) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($berkas->$fileKey);
                }
                
                $file = $request->file($fileKey);
                $filename = $fileKey . '_' . time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
                $data[$fileKey] = $file->storeAs('berkas-ppdb', $filename, 'public');
            }
        }

        if (!empty($data)) {
            $berkas->update(array_merge($data, [
                'status_validasi' => 'MENUNGGU',
                'tanggal_validasi' => null // Reset jika upload ulang
            ]));
            
            // Log Aktivitas
            \App\Models\AuditLog::create([
                'action' => 'UPLOAD_DOKUMEN',
                'entity_type' => 'Berkas',
                'entity_id' => $berkas->id_berkas,
                'keterangan' => 'Pendaftar memperbarui/mengunggah dokumen fisik pendaftaran.'
            ]);
        }

        return back()->with('success', 'Dokumen fisik pendaftaran berhasil diperbarui.');
    }
}
