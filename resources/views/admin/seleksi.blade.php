@extends('layouts.admin')

@section('title', 'Pusat Seleksi & Periode — Enumbiz')

@section('content')
<div class="space-y-10 max-w-[2800px]">
    
    <!-- Unified Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#f1f5f9] pb-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-black text-[#111827]">Pusat Seleksi Terpadu</h1>
            <p class="text-sm font-bold text-[#6b7280] uppercase tracking-widest">Manajemen Alur Pendaftaran & Penilaian PPDB</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.arsip.index') }}" class="bg-white border border-[#e2e8f0] text-[#111827] px-5 py-2.5 rounded-md text-[10px] font-black uppercase tracking-widest hover:border-blue-500 hover:text-blue-600 transition-all shadow-sm flex items-center justify-center">
                Lihat Histori Arsip
            </a>
            <a href="{{ route('admin.periode.index') }}" class="bg-[#111827] text-white px-5 py-2.5 rounded-md text-[10px] font-black uppercase tracking-widest hover:bg-blue-800 transition-all shadow-sm flex items-center justify-center">
                Kelola Semua Periode
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50/50 border-l-4 border-green-500 rounded text-sm font-bold text-green-700 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50/50 border-l-4 border-red-500 rounded text-sm font-bold text-red-700 shadow-sm">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-red-50/50 border-l-4 border-red-500 rounded text-sm font-bold text-red-700 shadow-sm">
            <p>Terjadi kesalahan validasi:</p>
            <ul class="list-disc list-inside mt-1 font-medium italic">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- 1. Kondisi Periode Aktif & Kontrol Utarma -->
    @php
        $activePeriod = collect($periods)->first(fn($p) => $p->status === 'AKTIF' && now()->between($p->tanggal_buka, $p->tanggal_tutup));
        $allActive = collect($periods)->filter(fn($p) => $p->status === 'AKTIF');
    @endphp

    <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm p-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none">
            <svg class="w-48 h-48" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        
        <div class="flex flex-col md:flex-row gap-8 justify-between z-10 relative">
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status Periode Saat Ini</p>
                @if($activePeriod)
                    <h2 class="text-3xl font-black text-[#1e3a8a] mb-2">{{ $activePeriod->nama_periode }}</h2>
                    <div class="flex items-center gap-3 text-sm text-gray-500 font-medium">
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-[10px] font-black uppercase">Berjalan</span>
                        <span>Berakhir pada: <strong class="text-gray-800">{{ $activePeriod->tanggal_tutup->format('d M Y') }}</strong></span>
                    </div>
                @elseif($allActive->count() > 0)
                    <h2 class="text-3xl font-black text-amber-500 mb-2">Ada Periode Terjadwal</h2>
                    <p class="text-sm text-gray-500">Ada periode dengan status AKTIF namun di luar rentang tanggal saat ini.</p>
                @else
                    <h2 class="text-3xl font-black text-red-600 mb-2">TIDAK ADA PERIODE AKTIF</h2>
                    <p class="text-sm text-gray-500">Pendaftar tidak dapat melengkapi berkas atau mendaftar pada saat ini.</p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3 items-start md:items-center">
                @if($activePeriod || $allActive->count() > 0)
                    <button @click="showOtomatis = true" class="bg-blue-50 border border-blue-200 text-blue-700 px-6 py-3.5 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-blue-600 hover:text-white transition-all shadow-sm flex items-center gap-2 group">
                        <svg class="w-4 h-4 text-blue-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Jalankan Seleksi Otomatis
                    </button>
                    <button @click="showArchiveConfirm = true" class="bg-red-50 border border-red-200 text-red-700 px-6 py-3.5 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-red-600 hover:text-white transition-all shadow-sm flex items-center gap-2 group">
                        <svg class="w-4 h-4 text-red-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        Tutup & Arsipkan
                    </button>
                @else
                    <button @click="showAddPeriod = true; editPeriod = null" class="bg-[#28a745] text-white px-8 py-3.5 rounded-lg text-xs font-black uppercase tracking-widest hover:bg-[#218838] transition-all shadow-sm flex items-center gap-2">
                        + BUKA PERIODE BARU
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- 2. Data Peserta (Penilaian Utama) -->
    <div class="space-y-4">
        <div class="flex justify-between items-end border-b border-[#f1f5f9] pb-2">
            <h3 class="text-xl font-bold text-[#111827]">Data Penilaian & Pendaftar</h3>
            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Menampilkan record saat ini</span>
        </div>

        <div class="bg-white border border-[#e2e8f0] rounded-xl shadow-sm overflow-hidden auto-cols-auto">
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-[#f1f5f9]">
                            <th class="px-6 py-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest">Siswa</th>
                            <th class="px-6 py-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest text-center">Status Berkas</th>
                            <th class="px-6 py-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest text-center">Avg Nilai</th>
                            <th class="px-6 py-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest">Status Seleksi</th>
                            <th class="px-6 py-4 font-bold text-gray-500 uppercase text-[10px] tracking-widest text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @forelse($users as $user)
                            @php
                                $total = ($user->nilai_smt1 ?? 0) + ($user->nilai_smt2 ?? 0) + ($user->nilai_smt3 ?? 0) + ($user->nilai_smt4 ?? 0) + ($user->nilai_smt5 ?? 0);
                                $avg = $total > 0 ? $total / 5 : 0;
                                $statusBerkas = $user->berkas->status_validasi ?? 'MENUNGGU';
                                $st = $user->seleksis->first()->status_seleksi ?? 'MENUNGGU';
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-blue-50 flex items-center justify-center font-bold text-blue-800 border border-blue-100">
                                            {{ strtoupper(substr($user->nama_pendaftar ?? $user->username, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#111827]">{{ $user->nama_pendaftar ?? $user->username }}</p>
                                            <p class="text-[10px] text-gray-400 font-mono tracking-tighter mt-0.5">{{ $user->nomor_pendaftaran }} • NISN: {{ $user->nisn_pendaftar ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider
                                          @if($statusBerkas == 'VALID') bg-green-100 text-green-700 @elseif($statusBerkas == 'DITOLAK') bg-red-100 text-red-700 @else bg-amber-100 text-amber-700 @endif">
                                        {{ $statusBerkas }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($statusBerkas === 'VALID')
                                        <span class="font-black text-lg text-[#1e3a8a]">{{ number_format($avg, 2) }}</span>
                                    @else
                                        <span class="text-[10px] text-gray-300 font-bold uppercase italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($statusBerkas === 'VALID')
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full @if($st == 'LULUS') bg-green-500 @elseif($st == 'TIDAK_LULUS') bg-red-500 @else bg-blue-500 @endif"></div>
                                            <span class="text-[10px] font-bold uppercase tracking-wider 
                                                  @if($st == 'LULUS') text-green-700 @elseif($st == 'TIDAK_LULUS') text-red-700 @else text-blue-700 @endif">
                                                {{ str_replace('_', ' ', $st) }}
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-gray-400 font-bold uppercase italic">Menunggu Validasi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.pendaftar.show', $user->id) }}" class="inline-flex items-center gap-1 text-[10px] font-bold text-[#1e3a8a] hover:bg-blue-50 px-3 py-1.5 rounded transition-all uppercase tracking-widest border border-transparent hover:border-blue-100">
                                        <span>Periksa</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <p class="text-sm font-bold">Belum ada data pendaftar</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('modals')
    @endpush

    <!-- ALL OTHER LOGIC MODALS (Seleksi Otomatis, Tutup, Tambah Periode) -->
    @include('admin.seleksi-modals')

</div>
@endsection

