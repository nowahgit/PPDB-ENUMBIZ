@extends('layouts.admin')

@section('title', ($user ? 'Edit' : 'Tambah') . ' Pendaftar — Admin')

@section('content')
<div class="max-w-4xl space-y-8 pb-20">
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">{{ $user ? 'Perbarui Data Pendaftar' : 'Tambah Pendaftar Baru' }}</h1>
        <p class="text-sm text-[#6b7280]">Pastikan seluruh informasi yang diinput sesuai dengan identitas asli calon siswa.</p>
    </div>

    <form action="{{ $user ? route('admin.pendaftar.update', $user->id) : route('admin.pendaftar.store') }}" method="POST" class="space-y-8">
        @csrf
        @if($user) @method('PUT') @endif

        <!-- Akun & Data Utama -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
            <div class="p-5 border-b border-[#f1f5f9] bg-slate-50">
                <h3 class="text-xs font-black text-[#111827] uppercase tracking-widest">01. Informasi Akun & Dasar</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Username</label>
                    <input type="text" name="username" value="{{ $user->username ?? old('username') }}" required class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Password {{ $user ? '(Kosongkan jika tidak diubah)' : '' }}</label>
                    <input type="password" name="password" {{ $user ? '' : 'required' }} class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nomor Pendaftaran {{ $user ? '' : '(Otomatis)' }}</label>
                    <input type="text" name="nomor_pendaftaran" value="{{ $user->nomor_pendaftaran ?? old('nomor_pendaftaran', 'AUTO-GENERATED') }}" 
                           readonly 
                           class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none bg-slate-100 text-gray-500 font-bold cursor-not-allowed">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Email</label>
                    <input type="email" name="email" value="{{ $user->email ?? old('email') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nama Lengkap</label>
                    <input type="text" name="nama_pendaftar" value="{{ $user->nama_pendaftar ?? old('nama_pendaftar') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">NISN</label>
                    <input type="text" name="nisn_pendaftar" value="{{ $user->nisn_pendaftar ?? old('nisn_pendaftar') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Asal Sekolah</label>
                    <input type="text" name="asal_sekolah" value="{{ $user->asal_sekolah ?? old('asal_sekolah') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">No. HP Pendaftar</label>
                    <input type="text" name="no_hp" value="{{ $user->no_hp ?? old('no_hp') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                        <option value="">Pilih —</option>
                        <option value="L" {{ ($user->jenis_kelamin ?? old('jenis_kelamin')) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ ($user->jenis_kelamin ?? old('jenis_kelamin')) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Tanggal Lahir</label>
                    <input type="date" name="tanggallahir_pendaftar" value="{{ $user && $user->tanggallahir_pendaftar ? \Carbon\Carbon::parse($user->tanggallahir_pendaftar)->format('Y-m-d') : old('tanggallahir_pendaftar') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Agama</label>
                    <select name="agama" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                        <option value="">Pilih —</option>
                        @foreach(['ISLAM', 'KRISTEN', 'KATHOLIK', 'HINDU', 'BUDHA', 'KONGHUCU', 'LAINNYA'] as $ag)
                            <option value="{{ $ag }}" {{ ($user->agama ?? old('agama')) == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Alamat & Ortu -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
            <div class="p-5 border-b border-[#f1f5f9] bg-slate-50">
                <h3 class="text-xs font-black text-[#111827] uppercase tracking-widest">02. Alamat & Data Orang Tua</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Alamat Lengkap Pendaftar</label>
                    <textarea name="alamat_pendaftar" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50 h-24">{{ $user->alamat_pendaftar ?? old('alamat_pendaftar') }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nama Orang Tua</label>
                        <input type="text" name="nama_ortu" value="{{ $user->nama_ortu ?? old('nama_ortu') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">No. HP Orang Tua</label>
                        <input type="text" name="no_hp_ortu" value="{{ $user->no_hp_ortu ?? old('no_hp_ortu') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Pekerjaan Orang Tua</label>
                        <input type="text" name="pekerjaan_ortu" value="{{ $user->pekerjaan_ortu ?? old('pekerjaan_ortu') }}" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Alamat Orang Tua</label>
                        <textarea name="alamat_ortu" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50 h-20">{{ $user->alamat_ortu ?? old('alamat_ortu') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi & Nilai -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Data Prestasi -->
            <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
                <div class="p-5 border-b border-[#f1f5f9] bg-slate-50">
                    <h3 class="text-xs font-black text-[#111827] uppercase tracking-widest">03. Prestasi</h3>
                </div>
                <div class="p-6">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Deskripsi Prestasi</label>
                    <textarea name="prestasi" class="w-full border border-[#d1d5db] rounded px-4 py-2 text-sm outline-none focus:border-[#1e3a8a] bg-slate-50 h-32 mt-2" placeholder="Sebutkan prestasi yang pernah diraih...">{{ $user->prestasi ?? old('prestasi') }}</textarea>
                </div>
            </div>
            
            <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
                <div class="p-5 border-b border-[#f1f5f9] bg-slate-50">
                    <h3 class="text-xs font-black text-[#111827] uppercase tracking-widest">04. Nilai Rapor (Smtr 1-5)</h3>
                </div>
                <div class="p-6 grid grid-cols-3 gap-4">
                    @foreach(['nilai_smt1', 'nilai_smt2', 'nilai_smt3', 'nilai_smt4', 'nilai_smt5'] as $smt)
                        <div class="space-y-1">
                            <label class="text-[9px] font-bold text-[#6b7280] uppercase tracking-widest">Smt {{ substr($smt, -1) }}</label>
                            <input type="number" step="0.01" name="{{ $smt }}" value="{{ $user->$smt ?? old($smt) }}" class="w-full border border-[#d1d5db] rounded px-2 py-2 text-xs outline-none focus:border-[#1e3a8a] bg-slate-50 text-center font-bold">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('admin.pendaftar') }}" class="px-8 py-3 border border-[#d1d5db] rounded text-xs font-bold uppercase tracking-widest hover:bg-slate-50">Batal</a>
            <button type="submit" class="px-12 py-3 bg-[#111827] text-white rounded text-xs font-bold uppercase tracking-widest hover:bg-black shadow-lg">
                {{ $user ? 'Perbarui Data' : 'Daftarkan Pendaftar' }}
            </button>
        </div>
    </form>
</div>
@endsection
