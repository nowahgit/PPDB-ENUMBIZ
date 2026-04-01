@extends('layouts.admin')

@section('title', 'Manajemen Periode Pendaftaran — Enumbiz')

@section('content')
<div class="space-y-8 max-w-6xl" x-data="{ showAdd: false, editPeriod: null }">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-[#111827]">Manajemen Periode Pendaftaran</h1>
            <p class="text-sm text-[#6b7280]">Kontrol kapan pendaftaran dibuka dan ditutup untuk publik.</p>
        </div>
        <button @click="showAdd = true" class="bg-[#1e3a8a] text-white px-6 py-2.5 rounded font-bold text-xs uppercase tracking-widest hover:bg-blue-800 transition-colors shadow-sm">
            Buka Periode Baru
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 rounded text-sm font-bold text-green-700 shadow-sm">{{ session('success') }}</div>
    @endif

    <!-- Table List -->
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-[#f1f5f9]">
                        <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest">Nama Periode</th>
                        <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest">Rentang Waktu</th>
                        <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest">Status</th>
                        <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @foreach($periods as $period)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-[#111827]">{{ $period->nama_periode }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $period->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 text-xs font-medium text-[#374151]">
                                    <span class="bg-slate-100 px-2 py-1 rounded">{{ $period->tanggal_buka->format('d/m/Y') }}</span>
                                    <span class="text-gray-300">→</span>
                                    <span class="bg-slate-100 px-2 py-1 rounded">{{ $period->tanggal_tutup->format('d/m/Y') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php $isNow = now()->between($period->tanggal_buka, $period->tanggal_tutup); @endphp
                                @if($period->status === 'AKTIF' && $isNow)
                                    <span class="text-[9px] font-black px-2 py-1 rounded bg-green-100 text-green-700 uppercase">Pendaftaran Terbuka</span>
                                @elseif($period->status === 'TUTUP' || !$isNow)
                                    <span class="text-[9px] font-black px-2 py-1 rounded bg-red-100 text-red-700 uppercase">Pendaftaran Ditutup</span>
                                @else
                                    <span class="text-[9px] font-black px-2 py-1 rounded bg-slate-100 text-slate-700 uppercase">{{ $period->status }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="editPeriod = {{ json_encode($period) }}; showAdd = true" 
                                            class="w-8 h-8 flex items-center justify-center rounded bg-slate-50 border border-slate-200 text-[#1e3a8a] hover:bg-[#1e3a8a] hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                    </button>
                                    <form id="delete-period-{{ $period->id_periode }}" action="{{ route('admin.periode.destroy', $period->id_periode) }}" method="POST" class="hidden">@csrf @method('DELETE')</form>
                                    <button type="button" @click="triggerConfirm('Hapus periode {{ $period->nama_periode }}?', () => document.getElementById('delete-period-{{ $period->id_periode }}').submit())"
                                            class="w-8 h-8 flex items-center justify-center rounded bg-slate-50 border border-slate-200 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form (Tambah / Edit) -->
    <div x-show="showAdd" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-[#111827]/40 backdrop-blur-sm" style="display: none;">
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-md overflow-hidden" @click.away="showAdd = false; editPeriod = null">
            <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center bg-slate-50">
                <h3 class="text-xs font-black text-[#111827] uppercase tracking-widest" x-text="editPeriod ? 'Edit Periode' : 'Buka Periode Pendaftaran Baru'"></h3>
                <button @click="showAdd = false; editPeriod = null" class="text-gray-400 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <form :action="editPeriod ? '/admin/periode/' + editPeriod.id_periode : '{{ route('admin.periode.store') }}'" method="POST" class="p-6 space-y-5">
                @csrf
                <template x-if="editPeriod"><input type="hidden" name="_method" value="PUT"></template>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nama Periode</label>
                    <input type="text" name="nama_periode" x-model="editPeriod ? editPeriod.nama_periode : ''" required placeholder="Contoh: PPDB TA 2024/2025"
                           class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Deskripsi Ringkas</label>
                    <textarea name="deskripsi" x-model="editPeriod ? editPeriod.deskripsi : ''" class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50 h-20"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Tanggal Buka</label>
                        <input type="date" name="tanggal_buka" :value="editPeriod ? editPeriod.tanggal_buka.split('T')[0] : ''" required 
                               class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Tanggal Tutup</label>
                        <input type="date" name="tanggal_tutup" :value="editPeriod ? editPeriod.tanggal_tutup.split('T')[0] : ''" required 
                               class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="showAdd = false; editPeriod = null" 
                            class="flex-1 px-6 py-3 border border-[#d1d5db] rounded text-[10px] font-bold uppercase tracking-widest hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-[#1e3a8a] text-white rounded text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-colors shadow-lg">
                        Simpan Periode
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
