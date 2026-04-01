<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Berkas;
use App\Models\Admin;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Tampilkan Dashboard Utama Admin.
     */
    public function dashboard()
    {
        $totalPendaftar = User::where('role', 'PENDAFTAR')->count();
        $menunggu = Berkas::where('status_validasi', 'MENUNGGU')->count();
        $valid = Berkas::where('status_validasi', 'VALID')->count();
        $ditolak = Berkas::where('status_validasi', 'DITOLAK')->count();
        $totalAdmin = Admin::count();
        $admins = Admin::all(); // Mengambil daftar seluruh panitia
        
        $recentApplicants = User::with('berkas')
            ->where('role', 'PENDAFTAR')
            ->latest('id')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPendaftar', 'menunggu', 'valid', 'ditolak', 'totalAdmin', 'admins', 'recentApplicants'
        ));
    }

    /**
     * Daftar Semua Pendaftar dengan Filter & Search.
     */
    public function pendaftar(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = User::with('berkas')->where('role', 'PENDAFTAR');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhereHas('berkas', fn($b) => 
                      $b->where('nama_pendaftar', 'like', "%$search%")
                        ->orWhere('nisn_pendaftar', 'like', "%$search%")
                  );
            });
        }

        if ($status) {
            $query->whereHas('berkas', fn($q) => $q->where('status_validasi', $status));
        }

        $users = $query->latest('id')->paginate(20)->withQueryString();

        return view('admin.pendaftar', compact('users', 'search', 'status'));
    }

    /**
     * Detail Pendaftar & Form Validasi Berkas.
     */
    public function showPendaftar($id)
    {
        $user = User::with(['berkas', 'seleksis'])->findOrFail($id);
        return view('admin.pendaftar-detail', compact('user'));
    }

    /**
     * Proses Validasi/Penolakan Berkas oleh Admin.
     */
    public function validateBerkas(Request $request, $id)
    {
        $request->validate([
            'status'  => ['required', 'in:VALID,DITOLAK'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $berkas = Berkas::where('user_id', $id)->firstOrFail();
        
        $berkas->update([
            'status_validasi'  => $request->status,
            'catatan'          => $request->catatan,
            'tanggal_validasi' => now(),
        ]);

        // Catat di Audit Log
        AuditLog::create([
            'action'      => 'VALIDASI_BERKAS',
            'entity_type' => 'Berkas',
            'entity_id'   => $berkas->id_berkas,
            'panitia_id'  => Auth::id(),
            'keterangan'  => "Status berkas user #{$id} diubah menjadi {$request->status}."
        ]);

        return back()->with('success', 'Status validasi berkas berhasil diperbarui.');
    }

    /** Tambah Pendaftar Manual (Admin) */
    public function pendaftarCreate()
    {
        return view('admin.pendaftar-form', ['user' => null]);
    }

    public function pendaftarStore(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:20', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'nama_pendaftar' => ['required', 'string', 'max:50'],
            'nisn_pendaftar' => ['required', 'string', 'max:20'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => 'PENDAFTAR',
            'nomor_pendaftaran' => strtoupper(uniqid('E-')),
            'nama_pendaftar'    => $request->nama_pendaftar,
            'nisn_pendaftar'    => $request->nisn_pendaftar,
            'agama'             => $request->agama,
            'alamat_pendaftar'  => $request->alamat_pendaftar,
            'nama_ortu'         => $request->nama_ortu,
            'no_hp_ortu'        => $request->no_hp_ortu,
            'nilai_smt1'        => $request->nilai_smt1 ?? 0,
            'nilai_smt2'        => $request->nilai_smt2 ?? 0,
            'nilai_smt3'        => $request->nilai_smt3 ?? 0,
            'nilai_smt4'        => $request->nilai_smt4 ?? 0,
            'nilai_smt5'        => $request->nilai_smt5 ?? 0,
        ]);

        \App\Models\Berkas::create(['user_id' => $user->id, 'status_validasi' => 'MENUNGGU']);
        \App\Models\Seleksi::create(['user_id' => $user->id, 'status_seleksi' => 'MENUNGGU', 'nama_seleksi' => 'Pendaftaran Manual']);

        return redirect()->route('admin.pendaftar')->with('success', 'Pendaftar baru berhasil didaftarkan secara manual.');
    }

    /** Edit Pendaftar (Admin) */
    public function pendaftarEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pendaftar-form', compact('user'));
    }

    public function pendaftarUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'username' => ['required', 'string', 'max:20', 'unique:users,username,' . $id],
            'nama_pendaftar' => ['required', 'string', 'max:50'],
        ]);

        $data = $request->only([
            'username', 'nama_pendaftar', 'nisn_pendaftar', 'agama', 'alamat_pendaftar',
            'nama_ortu', 'no_hp_ortu', 'pekerjaan_ortu', 'alamat_ortu',
            'nilai_smt1', 'nilai_smt2', 'nilai_smt3', 'nilai_smt4', 'nilai_smt5'
        ]);

        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.pendaftar.show', $id)->with('success', 'Data pendaftar berhasil diperbarui.');
    }

    /** Hapus Pendaftar (Admin) */
    public function pendaftarDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Cascading handle deleting berkas & seleksi
        return redirect()->route('admin.pendaftar')->with('success', 'Akun pendaftar dan seluruh datanya telah dihapus.');
    }

    /** Manajemen Staf: Tampilkan Daftar */
    public function stafIndex()
    {
        $admins = Admin::with('user')->get();
        return view('admin.staf', compact('admins'));
    }

    /** Manajemen Staf: Tambah Staf Baru */
    public function stafStore(Request $request)
    {
        $request->validate([
            'nama_panitia' => ['required', 'string', 'max:50'],
            'username'     => ['required', 'string', 'max:20', 'unique:users,username'],
            'password'     => ['required', 'string', 'min:6'],
        ]);

        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role'     => 'PANITIA',
        ]);

        Admin::create([
            'user_id'      => $user->id,
            'nama_panitia' => $request->nama_panitia,
        ]);

        return back()->with('success', 'Staf panitia baru berhasil didaftarkan.');
    }

    /** Manajemen Staf: Update Profil Staf */
    public function stafUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_panitia' => ['required', 'string', 'max:50'],
            'username'     => ['required', 'string', 'max:20', 'unique:users,username,' . $id],
            'password'     => ['nullable', 'string', 'min:6'],
        ]);

        $admin = Admin::where('user_id', $id)->firstOrFail();
        $user = User::findOrFail($id);

        $admin->update(['nama_panitia' => $request->nama_panitia]);
        $user->update(['username' => $request->username]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return back()->with('success', 'Data profil staf berhasil diperbarui.');
    }

    /** Manajemen Staf: Hapus Akun Staf */
    public function stafDestroy($id)
    {
        if (Auth::id() == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete(); // Cascading will delete Admin record

        return back()->with('success', 'Akun staf panitia telah berhasil dihapus.');
    }

    /** Manajemen Periode: Tampilkan Daftar */
    public function periodeIndex()
    {
        $periods = \App\Models\SelectionPeriod::orderBy('tanggal_buka', 'desc')->get();
        return view('admin.periode', compact('periods'));
    }

    /** Manajemen Periode: Tambah Periode Baru */
    public function periodeStore(Request $request)
    {
        $request->validate([
            'nama_periode' => ['required', 'string', 'max:100'],
            'tanggal_buka' => ['required', 'date'],
            'tanggal_tutup' => ['required', 'date', 'after:tanggal_buka'],
        ]);

        \App\Models\SelectionPeriod::create([
            'nama_periode'  => $request->nama_periode,
            'deskripsi'     => $request->deskripsi,
            'tanggal_buka'  => $request->tanggal_buka,
            'tanggal_tutup' => $request->tanggal_tutup,
            'status'        => 'AKTIF',
        ]);

        return back()->with('success', 'Periode pendaftaran baru berhasil dibuka.');
    }

    /** Manajemen Periode: Update Status/Data */
    public function periodeUpdate(Request $request, $id)
    {
        $period = \App\Models\SelectionPeriod::findOrFail($id);
        $period->update($request->all());
        return back()->with('success', 'Data periode berhasil diperbarui.');
    }

    /** Manajemen Periode: Hapus */
    public function periodeDestroy($id)
    {
        $period = \App\Models\SelectionPeriod::findOrFail($id);
        $period->delete();
        return back()->with('success', 'Periode pendaftaran telah dihapus.');
    }
}
