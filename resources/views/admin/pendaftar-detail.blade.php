@extends('layouts.admin')

@section('title', 'Detail Pendaftar — Admin Panel')

@section('content')
<div class="space-y-8 w-full">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.pendaftar') }}" class="text-[#1e3a8a] font-bold text-xs uppercase tracking-widest hover:underline">← Kembali ke Daftar</a>
            </div>
            <h1 class="text-2xl font-bold text-[#111827] mt-2">Detail Calon Siswa: {{ $user->username }}</h1>
        </div>

        <div class="flex flex-wrap items-center gap-4">
             <!-- 1. Validasi Berkas Form -->
             <div class="flex items-center gap-2 border-r border-[#e2e8f0] pr-4">
                 <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mr-2">Validasi Berkas:</p>
                 <form action="{{ route('admin.berkas.validate', $user->id) }}" method="POST" class="flex items-center gap-1">
                    @csrf
                    <input type="hidden" name="status" id="berkas_status">
                    <button type="submit" onclick="document.getElementById('berkas_status').value='VALID'" class="px-4 py-2 rounded text-[10px] font-black uppercase tracking-widest transition-all {{ ($user->berkas->status_validasi ?? '') == 'VALID' ? 'bg-green-600 text-white shadow-lg shadow-green-900/20' : 'bg-white border border-green-200 text-green-700 hover:bg-green-50' }}">Valid</button>
                    <button type="submit" onclick="document.getElementById('berkas_status').value='DITOLAK'" class="px-4 py-2 rounded text-[10px] font-black uppercase tracking-widest transition-all {{ ($user->berkas->status_validasi ?? '') == 'DITOLAK' ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'bg-white border border-red-200 text-red-700 hover:bg-red-50' }}">Tolak</button>
                 </form>
             </div>

             @php 
                $isRejected = ($user->berkas->status_validasi ?? '') === 'DITOLAK';
             @endphp

             <!-- 2. Status Kelulusan (Seleksi) Form -->
             <div class="flex items-center gap-2 {{ $isRejected ? 'opacity-50 cursor-not-allowed' : '' }}">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mr-2">Status Seleksi:</p>
                @if($isRejected)
                    <div class="flex items-center gap-2">
                        <span class="bg-red-50 text-red-700 border border-red-200 px-4 py-2 rounded text-[9px] font-black uppercase tracking-widest">⚠️ Berkas Ditolak (Seleksi Terkunci)</span>
                    </div>
                @else
                    <form action="{{ route('admin.seleksi.store') }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="nama_seleksi" value="Validasi Akhir Panitia">
                        <input type="hidden" name="waktu_seleksi" value="{{ now() }}">
                        
                        <select name="status_seleksi" class="border border-[#d1d5db] rounded px-3 py-2 text-[10px] font-black uppercase tracking-tight focus:border-[#1e3a8a] outline-none bg-white font-sans">
                            <option value="MENUNGGU" {{ ($user->seleksis->first()->status_seleksi ?? '') == 'MENUNGGU' ? 'selected' : '' }}>MENUNGGU</option>
                            <option value="LULUS" {{ ($user->seleksis->first()->status_seleksi ?? '') == 'LULUS' ? 'selected' : '' }}>LULUS</option>
                            <option value="TIDAK_LULUS" {{ ($user->seleksis->first()->status_seleksi ?? '') == 'TIDAK_LULUS' ? 'selected' : '' }}>TIDAK LULUS</option>
                        </select>
                        <button type="submit" class="bg-[#1e3a8a] text-white px-5 py-2 rounded text-[10px] font-black uppercase tracking-widest hover:bg-black transition-colors shadow-lg shadow-blue-900/20">Simpan Seleksi</button>
                    </form>
                @endif
             </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Informasi Siswa -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Data Diri Card (Membaca dari tabel USERS) -->
            <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
                <div class="p-5 border-b border-[#f1f5f9]">
                    <h3 class="text-sm font-bold text-[#111827]">01. Data Diri Calon Siswa</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nomor Pendaftaran</p>
                        <p class="text-sm font-black text-[#1e3a8a]">{{ $user->nomor_pendaftaran ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Email</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->email ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nama Lengkap</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->nama_pendaftar ?? $user->username }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">NISN</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->nisn_pendaftar ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Jenis Kelamin</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : ($user->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Tanggal Lahir</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->tanggallahir_pendaftar ? \Carbon\Carbon::parse($user->tanggallahir_pendaftar)->format('d F Y') : '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Asal Sekolah</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->asal_sekolah ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Agama</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->agama ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">No. HP Pendaftar</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->no_hp ?? '-' }}</p>
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Alamat Lengkap</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->alamat_pendaftar ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Orang Tua Card -->
            <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
                <div class="p-5 border-b border-[#f1f5f9]">
                    <h3 class="text-sm font-bold text-[#111827]">02. Data Orang Tua / Wali</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-10">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nama Orang Tua</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->nama_ortu ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">No. HP Orang Tua</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->no_hp_ortu ?? '-' }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Pekerjaan Orang Tua</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->pekerjaan_ortu ?? '-' }}</p>
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Alamat Orang Tua</p>
                        <p class="text-sm font-bold text-[#111827]">{{ $user->alamat_ortu ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Dokumen Fisik Card -->
            <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
                <div class="p-5 border-b border-[#f1f5f9]">
                    <h3 class="text-sm font-bold text-[#111827]">03. Dokumen Lampiran</h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach([
                        'file_kk' => 'Kartu Keluarga',
                        'file_akte' => 'Akte Kelahiran',
                        'file_skl' => 'SKL / Ijazah'
                    ] as $key => $label)
                        <div class="p-5 bg-slate-50 border border-[#e2e8f0] rounded-lg">
                            <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest mb-3">{{ $label }}</p>
                            @if($user->berkas && $user->berkas->$key)
                                <a href="{{ Storage::url($user->berkas->$key) }}" target="_blank" class="w-full py-2 bg-white border border-[#1e3a8a] text-[#1e3a8a] hover:bg-slate-50 text-[10px] font-bold uppercase tracking-widest text-center rounded block transition-all">Buka File</a>
                            @else
                                <div class="w-full py-2 bg-slate-100 text-slate-400 text-[10px] font-bold uppercase tracking-widest text-center rounded">Belum Unggah</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

             <!-- Prestasi Card -->
             <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
                <div class="p-5 border-b border-[#f1f5f9]">
                    <h3 class="text-sm font-bold text-[#111827]">03. Prestasi & Sertifikat</h3>
                </div>
                <div class="p-6">
                    @php $hasP = false; @endphp
                    <div class="space-y-4">
                        @for($i = 1; $i <= 3; $i++)
                            @php $f = "prestasi_{$i}_file"; @endphp
                            @if($user->berkas && $user->berkas->$f)
                                @php $hasP = true; @endphp
                                <div class="flex items-center justify-between p-4 border border-[#e2e8f0] rounded-lg bg-slate-50">
                                    <span class="text-xs font-bold text-[#111827]">Sertifikat Prestasi {{ $i }}</span>
                                    <a href="{{ Storage::url($user->berkas->$f) }}" target="_blank" class="text-xs font-bold text-[#1e3a8a] hover:underline uppercase">Lihat Bukti</a>
                                </div>
                            @endif
                        @endfor
                        <div class="p-4 bg-slate-50 border border-[#e2e8f0] rounded-lg">
                             <p class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest mb-1">Deskripsi Prestasi</p>
                             <p class="text-sm text-[#111827]">{{ $user->prestasi ?? 'Tidak ada data prestasi.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Nilai Rapor (Membaca dari tabel USERS) -->
        <div class="space-y-6">
            <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
                <div class="p-5 border-b border-[#f1f5f9]">
                    <h3 class="text-sm font-bold text-[#111827]">Ringkasan Nilai</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach(['nilai_smt1' => 'Semester 1', 'nilai_smt2' => 'Semester 2', 'nilai_smt3' => 'Semester 3', 'nilai_smt4' => 'Semester 4', 'nilai_smt5' => 'Semester 5'] as $key => $label)
                            <div class="flex justify-between items-center py-2 border-b border-[#f1f5f9] last:border-0">
                                <span class="text-xs font-bold text-[#6b7280] uppercase tracking-widest">{{ $label }}</span>
                                <span class="text-sm font-black text-[#1e3a8a]">{{ number_format($user->$key ?? 0, 2) }}</span>
                            </div>
                        @endforeach
                        <div class="mt-6 p-5 bg-[#111827] rounded-lg text-center">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-1 text-white">Rata-rata Akumulasi</p>
                            @php
                                $total = ($user->nilai_smt1 ?? 0) + ($user->nilai_smt2 ?? 0) + ($user->nilai_smt3 ?? 0) + ($user->nilai_smt4 ?? 0) + ($user->nilai_smt5 ?? 0);
                                $avg = $total > 0 ? $total / 5 : 0;
                            @endphp
                            <p class="text-2xl font-black text-white">{{ number_format($avg, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-[#e2e8f0] p-6 rounded-lg shadow-sm">
                <h4 class="text-xs font-bold text-[#111827] uppercase tracking-widest mb-3">Catatan Panitia</h4>
                <p class="text-xs text-[#6b7280] leading-relaxed italic">
                    Periksa semua dokumen fisik satu-persatu sebelum melakukan finalisasi kelulusan pendaftar. Pastikan nilai rapor di sistem sesuai dengan pindaian rapor asli.
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
