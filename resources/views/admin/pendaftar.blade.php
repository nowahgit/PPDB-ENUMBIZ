@extends('layouts.admin')

@section('title', 'Master Data Pendaftar — Enterprise Control')

@section('content')
<div class="space-y-8 w-full">
    
    <!-- Unified Header (Consistent across all admin pages) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-1 border-b border-[#f1f5f9] pb-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-[#111827]">Master Data Pendaftar</h1>
            <p class="text-xs text-[#6b7280] uppercase tracking-widest font-black">Sistem Administrasi Database Utama Pendaftar</p>
        </div>
        
        <div class="flex gap-3">
            <a href="{{ route('admin.pendaftar.create') }}" class="bg-[#111827] text-white px-6 py-2 rounded text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg shadow-black/10">Input Manual</a>
            <button class="bg-white border border-[#f1f5f9] text-[#6b7280] px-6 py-2 rounded text-[10px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Ekspor Excel</button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-100 rounded text-sm font-bold text-green-700 shadow-sm">{{ session('success') }}</div>
    @endif

    <!-- Search Cockpit (Consistent with selection hub) -->
    <div class="bg-white border border-[#f1f5f9] p-4 shadow-sm">
        <form action="{{ route('admin.pendaftar') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4 w-full">
            <div class="w-full md:flex-1 flex items-center border border-[#f1f5f9] bg-slate-50 px-4 py-2 mt-2 md:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-400 mr-2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama, NISN, atau ID..." 
                       class="w-full text-xs outline-none bg-transparent font-bold text-slate-700">
            </div>
            <div class="w-full md:w-auto flex flex-1 md:flex-none items-center border border-[#f1f5f9] bg-slate-50 px-4 py-2">
                <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest mr-3">Status:</span>
                <select name="status" class="text-[10px] w-full md:w-auto font-bold uppercase outline-none bg-transparent">
                    <option value="">Semua</option>
                    <option value="MENUNGGU" {{ $status == 'MENUNGGU' ? 'selected' : '' }}>Menunggu</option>
                    <option value="VALID" {{ $status == 'VALID' ? 'selected' : '' }}>Valid</option>
                    <option value="DITOLAK" {{ $status == 'DITOLAK' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <button type="submit" class="w-full md:w-auto bg-[#1e3a8a] text-white px-10 py-3 rounded text-[10px] font-black uppercase tracking-widest hover:bg-black">Terapkan Filter</button>
        </form>
    </div>

    <!-- Master Sheet (Grid System with Thin Borders) -->
    <div class="bg-white border border-[#f1f5f9] overflow-hidden" style="border: 1px solid #e2e8f0; border-radius: 8px; margin-top: 20px;">
        <div class="overflow-x-auto w-full max-w-full">
            <table class="w-full text-left border-collapse text-[10px]" style="min-width: 1400px; width: max-content;">
                <thead>
                    <tr class="bg-slate-50 border-b border-[#f1f5f9]">
                        <th class="px-6 py-5 font-black border-r border-[#f1f5f9] text-[#6b7280] uppercase tracking-widest bg-slate-50 sticky left-0 z-20 shadow-[2px_0_5px_rgba(0,0,0,0.1)]">ID & Nama Pendaftar</th>
                        <th class="px-6 py-5 font-black border-r border-[#f1f5f9] text-[#6b7280] uppercase tracking-widest">Informasi Dasar</th>
                        <th class="px-6 py-5 font-black border-r border-[#f1f5f9] text-[#6b7280] uppercase tracking-widest">Wali & Kontak</th>
                        <th class="px-6 py-5 font-black border-r border-[#f1f5f9] text-[#6b7280] uppercase tracking-widest text-center">Berkas Utama</th>
                        <th class="px-6 py-5 font-black border-r border-[#f1f5f9] text-[#6b7280] uppercase tracking-widest text-center">Prestasi / Sertifikat</th>
                        <th class="px-6 py-5 font-black border-r border-[#f1f5f9] text-[#6b7280] uppercase tracking-widest text-center">Rapor (S1 - S5)</th>
                        <th class="px-6 py-5 font-black border-r border-[#f1f5f9] text-[#6b7280] uppercase tracking-widest text-center">Akumulasi</th>
                        <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-right sticky right-0 z-20 bg-slate-50 shadow-[-2px_0_5px_rgba(0,0,0,0.1)]">Validasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @foreach($users as $user)
                        @php
                            $st = $user->berkas->status_validasi ?? 'MENUNGGU';
                            $total = ($user->nilai_smt1 ?? 0) + ($user->nilai_smt2 ?? 0) + ($user->nilai_smt3 ?? 0) + ($user->nilai_smt4 ?? 0) + ($user->nilai_smt5 ?? 0);
                            $avg = $total > 0 ? $total / 5 : 0;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-none">
                            <!-- ID & Nama (Sticky) -->
                            <td class="px-6 py-5 border-r border-slate-200 sticky left-0 z-10 bg-white">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-black text-black">{{ strtoupper($user->nama_pendaftar ?? $user->username) }}</span>
                                    <span class="font-mono text-[9px] text-[#1e3a8a] mt-1 font-bold">{{ $user->nomor_pendaftaran }}</span>
                                </div>
                            </td>

                            <!-- Personal Info -->
                            <td class="px-6 py-5 border-r border-slate-200 leading-relaxed">
                                <p class="font-bold text-slate-600">NISN: {{ $user->nisn_pendaftar ?? '-' }}</p>
                                <p class="text-slate-400 mt-0.5 text-[9px] uppercase tracking-wider">
                                    {{ $user->agama ?? '-' }} &bull; {{ $user->jenis_kelamin ?? '-' }}
                                </p>
                                <p class="text-slate-400 text-[9px] mt-1 max-w-[200px]">{{ $user->alamat_pendaftar ?? '-' }}</p>
                            </td>

                            <!-- Wali -->
                            <td class="px-6 py-5 border-r border-slate-200 leading-relaxed">
                                <p class="font-bold text-slate-800">{{ strtoupper($user->nama_ortu ?? '-') }}</p>
                                <p class="text-slate-500 font-mono text-[9px] mt-0.5">{{ $user->no_hp_ortu ?? '-' }}</p>
                                <p class="text-[9px] text-slate-400 mt-2">{{ strtoupper($user->pekerjaan_ortu ?? '-') }}</p>
                            </td>

                            <!-- Dokumen Pokok (Solid Squares) -->
                            <td class="px-6 py-5 border-r border-slate-200 bg-slate-50/50">
                                <div class="flex justify-center gap-2">
                                    @foreach(['file_kk' => 'KK', 'file_akte' => 'AKTE', 'file_skl' => 'SKL'] as $col => $lbl)
                                        @if($user->berkas && $user->berkas->$col)
                                            <a href="{{ Storage::url($user->berkas->$col) }}" target="_blank" class="w-12 h-12 flex flex-col items-center justify-center border-2 border-slate-800 font-black text-[8px] hover:bg-black hover:text-white transition-none uppercase leading-none">
                                                <span>{{ $lbl }}</span>
                                                <svg class="mt-1" width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                                            </a>
                                        @else
                                            <div class="w-12 h-12 flex items-center justify-center border border-slate-200 text-slate-200 font-black text-[8px] uppercase">N/A</div>
                                        @endif
                                    @endforeach
                                </div>
                            </td>

                            <!-- Prestasi (Grid Style) -->
                            <td class="px-6 py-5 border-r border-slate-200 text-center">
                                <div class="flex justify-center gap-1 mb-2">
                                    @foreach(['prestasi_1_file', 'prestasi_2_file', 'prestasi_3_file'] as $i => $col)
                                        @if($user->berkas && $user->berkas->$col)
                                            <a href="{{ Storage::url($user->berkas->$col) }}" target="_blank" class="w-8 h-8 flex items-center justify-center border-2 border-blue-800 text-blue-800 font-black text-[7px] hover:bg-blue-800 hover:text-white transition-none uppercase">S{{ $i+1 }}</a>
                                        @else
                                            <div class="w-8 h-8 flex items-center justify-center border border-slate-100 text-slate-200 text-[7px] font-black uppercase">-</div>
                                        @endif
                                    @endforeach
                                </div>
                                <p class="text-[8px] text-slate-500 max-w-[150px] mx-auto line-clamp-1 italic uppercase tracking-tighter">{{ $user->berkas->prestasi ?? '-' }}</p>
                            </td>

                            <!-- Nilai -->
                            <td class="px-6 py-5 border-r border-slate-200">
                                <div class="grid grid-cols-5 gap-0.5 border border-slate-200 bg-slate-200 p-0.5">
                                    @foreach(['nilai_smt1','nilai_smt2','nilai_smt3','nilai_smt4','nilai_smt5'] as $col)
                                        <div class="bg-white py-2 px-1 text-center font-bold text-slate-700 min-w-[35px]">{{ number_format($user->$col ?? 0, 0) }}</div>
                                    @endforeach
                                </div>
                            </td>

                            <!-- Rata-rata -->
                            <td class="px-6 py-5 border-r border-slate-200 text-center">
                                <div class="border-2 border-[#1e3a8a] py-2 px-3 inline-block font-black text-xs text-[#1e3a8a] bg-slate-50">
                                    {{ number_format($avg, 2) }}
                                </div>
                            </td>

                            <!-- Aksi (Sticky Right) -->
                            <td class="px-6 py-5 sticky right-0 z-10 bg-slate-50 shadow-[-2px_0_10px_rgba(0,0,0,0.02)]">
                                <div class="flex flex-col items-end gap-3">
                                    <span class="text-[9px] font-black tracking-widest @if($st == 'VALID') text-green-700 @elseif($st == 'DITOLAK') text-red-700 @else text-blue-700 @endif uppercase">
                                        Status: {{ $st }}
                                    </span>
                                    <div class="flex items-center gap-1">
                                        <form action="{{ route('admin.berkas.validate', $user->id) }}" method="POST"> @csrf <input type="hidden" name="status" value="VALID">
                                            <button type="submit" class="bg-green-700 text-white px-3 py-2 font-bold text-[9px] uppercase hover:bg-black transition-none tracking-widest">Ya</button>
                                        </form>
                                        <form action="{{ route('admin.berkas.validate', $user->id) }}" method="POST"> @csrf <input type="hidden" name="status" value="DITOLAK">
                                            <button type="submit" class="bg-red-700 text-white px-3 py-2 font-bold text-[9px] uppercase hover:bg-black transition-none tracking-widest">Tidak</button>
                                        </form>
                                        <a href="{{ route('admin.pendaftar.edit', $user->id) }}" class="bg-slate-800 text-white px-3 py-2 font-bold text-[9px] uppercase hover:bg-black transition-none tracking-widest">Edit</a>
                                        <form id="del-{{ $user->id }}" action="{{ route('admin.pendaftar.destroy', $user->id) }}" method="POST" class="hidden"> @csrf @method('DELETE') </form>
                                        <button type="button" @click="triggerConfirm('Hapus data pendaftar?', () => document.getElementById('del-{{ $user->id }}').submit())"
                                                class="bg-slate-200 text-slate-500 px-3 py-2 font-bold text-[9px] uppercase hover:bg-red-700 hover:text-white transition-none tracking-widest">Hps</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- STYLED PAGINATION -->
        <div class="px-6 py-6 bg-white border-t border-slate-300">
            <div class="flex items-center justify-between">
                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    Menampilkan {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} Data Pendaftar
                </div>
                <div class="pagination-custom font-black">
                     {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    /* Menghilangkan AI-Shadows */
    * { box-shadow: none !important; }
    
    /* Pagination Styling Kaku */
    .pagination-custom nav svg { width: 1.5rem; height: 1.5rem; }
    .pagination-custom nav div:first-child { display: none; }
    .pagination-custom nav div:last-child { margin-top: 0; }
    .pagination-custom nav span[aria-current="page"] > span { background-color: #1e3a8a !important; color: white !important; border-radius: 0; border: 1px solid #1e3a8a; }
    .pagination-custom nav a, .pagination-custom nav span { border-radius: 0 !important; font-size: 10px; padding: 8px 14px; border: 1px solid #cbd5e1; }
</style>
@endsection
