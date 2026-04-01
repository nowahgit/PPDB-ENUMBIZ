@extends('layouts.admin')

@section('title', 'Pusat Seleksi & Periode — Enumbiz')

@section('content')
<div class="space-y-8 max-w-6xl" x-data="{ 
    tab: 'penilaian', 
    showOtomatis: false, 
    showArchiveConfirm: false, 
    showAddPeriod: false, 
    editPeriod: null,
    selectedArchive: null 
}">
    
    <!-- Unified Header (Consistent across all admin pages) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-1 border-b border-[#f1f5f9] pb-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-[#111827]">Pusat Seleksi Terpadu</h1>
            <p class="text-xs text-[#6b7280] uppercase tracking-widest font-black">Kelola Seluruh Alur PPDB dalam Satu Pintu</p>
        </div>
        
        <div class="flex gap-3">
            <template x-if="tab === 'penilaian'">
                <div class="flex gap-2">
                    <button @click="showOtomatis = true" class="bg-[#1e3a8a] text-white px-4 py-2 rounded text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg hover:-translate-y-0.5">Seleksi Otomatis</button>
                    <button @click="showArchiveConfirm = true" class="bg-[#dc2626] text-white px-4 py-2 rounded text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg hover:-translate-y-0.5">Tutup & Arsipkan</button>
                </div>
            </template>
            <template x-if="tab === 'periode'">
                <button @click="showAddPeriod = true; editPeriod = null" class="bg-[#111827] text-white px-6 py-2 rounded text-[10px] font-black uppercase tracking-widest hover:bg-black transition-all shadow-lg">Buka Periode Baru</button>
            </template>
        </div>
    </div>

    <!-- TABS NAVBAR (UX FOCUS) -->
    <div class="flex border-b border-[#f1f5f9] -mt-4">
        <button @click="tab = 'penilaian'" :class="tab === 'penilaian' ? 'border-[#1e3a8a] text-[#1e3a8a]' : 'border-transparent text-gray-400 hover:text-gray-600'" class="px-8 py-4 border-b-2 font-bold text-xs uppercase tracking-widest transition-all">01. Penilaian Aktif</button>
        <button @click="tab = 'periode'" :class="tab === 'periode' ? 'border-[#1e3a8a] text-[#1e3a8a]' : 'border-transparent text-gray-400 hover:text-gray-600'" class="px-8 py-4 border-b-2 font-bold text-xs uppercase tracking-widest transition-all">02. Atur Periode</button>
        <button @click="tab = 'arsip'" :class="tab === 'arsip' ? 'border-[#1e3a8a] text-[#1e3a8a]' : 'border-transparent text-gray-400 hover:text-gray-600'" class="px-8 py-4 border-b-2 font-bold text-xs uppercase tracking-widest transition-all">03. Histori Arsip</button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 rounded text-sm font-bold text-green-700 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 rounded text-sm font-bold text-red-700 shadow-sm">{{ session('error') }}</div>
    @endif

    <!-- TAB 01: PENILAIAN (Penilaian Aktif) -->
    <div x-show="tab === 'penilaian'" class="space-y-6" x-transition:enter.duration.200ms>
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead>
                        <tr class="bg-slate-50 border-b border-[#f1f5f9]">
                            <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest">ID Pendaftaran</th>
                            <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest">Identitas Siswa</th>
                            <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-center">Validasi Berkas</th>
                            <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-center">Avg Nilai</th>
                            <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest">Status Seleksi</th>
                            <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-right">Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @foreach($users as $user)
                            @php
                                $total = ($user->nilai_smt1 ?? 0) + ($user->nilai_smt2 ?? 0) + ($user->nilai_smt3 ?? 0) + ($user->nilai_smt4 ?? 0) + ($user->nilai_smt5 ?? 0);
                                $avg = $total > 0 ? $total / 5 : 0;
                                $statusBerkas = $user->berkas->status_validasi ?? 'MENUNGGU';
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-5 font-mono font-bold text-[#1e3a8a]">{{ $user->nomor_pendaftaran }}</td>
                                <td class="px-6 py-5">
                                    <p class="font-bold text-[#111827] text-xs">{{ $user->nama_pendaftar ?? $user->username }}</p>
                                    <p class="text-[9px] text-gray-400 mt-1 uppercase tracking-widest">NISN: {{ $user->nisn_pendaftar ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <span class="text-[9px] font-black px-2 py-1 rounded uppercase 
                                          @if($statusBerkas == 'VALID') bg-green-50 text-green-700 @elseif($statusBerkas == 'DITOLAK') bg-red-50 text-red-700 @else bg-slate-50 text-slate-500 @endif">
                                        {{ $statusBerkas }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @if($statusBerkas === 'VALID')
                                        <span class="px-3 py-1 bg-[#111827] text-white rounded font-black text-[10px]">{{ number_format($avg, 2) }}</span>
                                    @else
                                        <span class="text-[9px] text-gray-400 font-bold italic tracking-tighter">BELUM VALIDASI</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    @php $st = $user->seleksis->first()->status_seleksi ?? 'MENUNGGU'; @endphp
                                    @if($statusBerkas === 'VALID')
                                        <span class="text-[9px] font-black px-2 py-1 rounded bg-slate-100 uppercase 
                                              @if($st == 'LULUS') text-green-700 @elseif($st == 'TIDAK_LULUS') text-red-700 @else text-blue-700 @endif">
                                            {{ str_replace('_', ' ', $st) }}
                                        </span>
                                    @else
                                        <span class="text-[8px] font-bold text-gray-400 uppercase italic">MENUNGGU BERKAS</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 text-right flex justify-end gap-2">
                                    <a href="{{ route('admin.pendaftar.show', $user->id) }}" class="p-2 bg-slate-50 rounded border border-slate-100 hover:bg-black transition-all hover:text-white" title="Validasi Berkas & Nilai">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><path d="M12 18v-6"/><path d="M8 15h8"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- TAB 02: PERIODE (Atur Periode) -->
    <div x-show="tab === 'periode'" class="space-y-6" x-transition:enter.duration.200ms>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($periods as $period)
                <div class="bg-white border border-[#e2e8f0] rounded-lg p-6 shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="font-black text-[#111827] text-sm uppercase tracking-tighter">{{ $period->nama_periode }}</h3>
                            <div class="flex items-center gap-2 mt-1 text-[10px] font-bold text-[#1e3a8a]">
                                <span>{{ $period->tanggal_buka->format('d/m/Y') }}</span>
                                <span>→</span>
                                <span>{{ $period->tanggal_tutup->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @php $isNow = now()->between($period->tanggal_buka, $period->tanggal_tutup); @endphp
                        <span class="text-[8px] font-black px-2 py-0.5 rounded {{ ($period->status === 'AKTIF' && $isNow) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} uppercase">
                             {{ ($period->status === 'AKTIF' && $isNow) ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </div>
                    <p class="text-xs text-[#6b7280] leading-relaxed line-clamp-2 h-8">{{ $period->deskripsi ?? 'Tanpa deskripsi periode.' }}</p>
                    <div class="mt-6 pt-4 border-t border-[#f1f5f9] flex justify-between gap-2">
                        <button @click="editPeriod = {{ json_encode($period) }}; showAddPeriod = true" 
                                class="flex-1 px-4 py-2.5 border border-[#d1d5db] rounded text-[10px] font-black uppercase tracking-widest hover:bg-slate-50">Atur Ulang</button>
                        <form action="{{ route('admin.periode.destroy', $period->id_periode) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus periode ini?')" class="w-full px-4 py-2.5 bg-[#dc2626] text-white rounded text-[10px] font-black uppercase tracking-widest hover:bg-black shadow-lg shadow-red-900/20">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TAB 03: ARSIP (Histori Arsip) -->
    <div x-show="tab === 'arsip'" class="space-y-6" x-transition:enter.duration.200ms>
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden">
             <table class="w-full text-left border-collapse text-[11px]">
                  <thead>
                      <tr class="bg-slate-50 border-b border-[#f1f5f9]">
                          <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest">Nama Periode Arsip</th>
                          <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-center">Data Snapshot</th>
                          <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-right">Lulus / Total</th>
                          <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-right">Tanggal Arsip</th>
                          <th class="px-6 py-5 font-black text-[#6b7280] uppercase tracking-widest text-right">Aksi</th>
                      </tr>
                  </thead>
                  <tbody class="divide-y divide-[#f1f5f9]">
                      @foreach($archives as $archive)
                          <tr class="hover:bg-slate-50 transition-all">
                               <td class="px-6 py-5 font-bold text-[#111827]">{{ $archive->nama_periode }}</td>
                               <td class="px-6 py-5 text-center">
                                    <span class="px-2 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded text-[9px] font-bold">STAINLESS JSON</span>
                               </td>
                               <td class="px-6 py-5 text-right font-black">
                                    <span class="text-green-600">{{ $archive->total_lulus }}</span> / <span class="text-gray-400">{{ $archive->total_pendaftar }}</span>
                               </td>
                               <td class="px-6 py-5 text-right text-gray-500 uppercase">{{ $archive->tanggal_arsip->format('d/m/Y H:i') }}</td>
                               <td class="px-6 py-5 text-right">
                                    <button @click="selectedArchive = {{ json_encode($archive) }}" class="text-[#1e3a8a] hover:underline font-bold uppercase tracking-tight">Detail Arsip</button>
                               </td>
                          </tr>
                      @endforeach
                  </tbody>
             </table>
        </div>
    </div>

    <!-- ALL MODALS (UX FOCUS) -->
    @include('admin.seleksi-modals')

</div>
@endsection
