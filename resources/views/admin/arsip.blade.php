@extends('layouts.admin')

@section('title', 'Arsip & Histori Seleksi — Enumbiz')

@section('content')
<div class="space-y-8 max-w-6xl" x-data="{ selectedArchive: null }">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-[#111827]">Arsip & Histori Seleksi</h1>
            <p class="text-sm text-[#6b7280]">Daftar permanen periode pendaftaran yang telah selesai dan di-reset.</p>
        </div>
    </div>

    @if($archives->isEmpty())
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-12 text-center shadow-sm">
            <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="5" x="2" y="3" rx="1"/><path d="M4 8v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8"/><path d="M10 12h4"/></svg>
            </div>
            <h3 class="text-sm font-bold text-[#111827]">Belum Ada Arsip</h3>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-widest">Gunakan tombol 'Arsipkan Periode' di halaman Seleksi.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($archives as $archive)
                <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm hover:border-[#1e3a8a] transition-all overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-[#f1f5f9] bg-slate-50 flex justify-between items-start">
                        <div>
                            <h3 class="text-sm font-black text-[#111827] uppercase tracking-tighter">{{ $archive->nama_periode }}</h3>
                            <p class="text-[10px] text-gray-400 mt-0.5 tracking-widest">{{ $archive->tanggal_arsip->format('F Y') }}</p>
                        </div>
                        <span class="bg-[#111827] text-white text-[9px] font-bold px-2 py-0.5 rounded uppercase">ARCHIVED</span>
                    </div>
                    <div class="p-6 flex-1 space-y-4">
                        <div class="grid grid-cols-3 gap-2">
                            <div class="text-center p-2 bg-slate-50 rounded border border-[#f1f5f9]">
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Total</p>
                                <p class="text-lg font-black text-[#111827]">{{ $archive->total_pendaftar }}</p>
                            </div>
                            <div class="text-center p-2 bg-green-50 rounded border border-green-100">
                                <p class="text-[10px] font-bold text-green-400 uppercase tracking-tighter">Lulus</p>
                                <p class="text-lg font-black text-green-700">{{ $archive->total_lulus }}</p>
                            </div>
                            <div class="text-center p-2 bg-red-50 rounded border border-red-100">
                                <p class="text-[10px] font-bold text-red-400 uppercase tracking-tighter">Gagal</p>
                                <p class="text-lg font-black text-red-700">{{ $archive->total_tidak_lulus }}</p>
                            </div>
                        </div>
                        <div class="pt-4 mt-auto">
                            <button @click="selectedArchive = {{ json_encode($archive) }}" 
                                    class="w-full bg-[#1e3a8a] text-white py-3 rounded text-[10px] font-black uppercase tracking-[.2em] hover:bg-black transition-all shadow-lg shadow-blue-900/20">
                                Detail Dokumen SQL
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Modal View Snapshot JSON -->
    <div x-show="selectedArchive" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/40 backdrop-blur-sm" style="display: none;" x-transition>
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col h-[85vh]">
            <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center bg-slate-50">
                <div class="flex items-center gap-3">
                    <h3 class="text-sm font-bold text-[#111827] uppercase tracking-widest" x-text="'Snapshot: ' + selectedArchive?.nama_periode"></h3>
                    <span class="text-[10px] font-mono bg-blue-100 text-[#1e3a8a] px-2 py-0.5 rounded">SQL Database Mode</span>
                </div>
                <button @click="selectedArchive = null" class="text-gray-400 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto p-0 flex-1">
                <table class="w-full text-left border-collapse text-[11px]">
                    <thead class="sticky top-0 z-10 bg-white border-b border-[#f1f5f9]">
                        <tr class="bg-slate-50">
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase tracking-widest">ID / NISN</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase tracking-widest">Nama Lengkap</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase tracking-widest text-center">Avg Nilai</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase tracking-widest text-right">Status Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        <template x-for="p in selectedArchive?.detail_pendaftar" :key="p.nomor_pendaftaran">
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4">
                                    <p class="font-mono text-[#1e3a8a] font-bold" x-text="p.nomor_pendaftaran"></p>
                                    <p class="text-[9px] text-gray-400 uppercase mt-0.5" x-text="'NISN: ' + p.nisn"></p>
                                </td>
                                <td class="px-6 py-4 font-bold text-[#111827]" x-text="p.nama"></td>
                                <td class="px-6 py-4 text-center font-black" x-text="p.rata_rata_nilai"></td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-[9px] font-black px-2 py-1 rounded"
                                          :class="p.status_seleksi === 'LULUS' ? 'bg-green-100 text-green-700' : (p.status_seleksi === 'TIDAK_LULUS' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700')"
                                          x-text="p.status_seleksi"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-slate-50 border-t border-[#f1f5f9] flex justify-between items-center">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest italic">Data ini bersifat statis dan tersimpan secara permanen sebagai arsip histori.</p>
                <button @click="selectedArchive = null" class="px-6 py-2 border border-[#d1d5db] rounded text-[10px] font-black uppercase tracking-widest hover:bg-white">Tutup Arsip</button>
            </div>
        </div>
    </div>

</div>
@endsection
