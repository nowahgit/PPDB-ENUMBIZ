@push('modals')
<!-- Modal Seleksi Otomatis -->
<div x-show="showOtomatis" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/60 backdrop-blur-sm" style="display: none;" x-transition x-cloak>
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-sm overflow-hidden" @click.away="showOtomatis = false">
        <div class="p-4 border-b border-[#f1f5f9] bg-slate-50 flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-[#1e3a8a]">Alat Seleksi Otomatis</div>
        <form action="{{ route('admin.seleksi.otomatis') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="space-y-2">
                <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Passing Grade (Ambang Batas Nilai)</label>
                <input type="number" step="0.01" name="passing_grade" required placeholder="Contoh: 85.00" 
                       class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50 text-center font-bold text-lg">
            </div>
            <button type="submit" class="w-full px-4 py-3 bg-[#1e3a8a] text-white rounded text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-colors shadow-lg">MULAI SELEKSI MASAL</button>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Arsip -->
@if($activePeriod)
<div x-show="showArchiveConfirm" x-data="{ confirmInput: '' }" 
     x-init="$watch('showArchiveConfirm', value => { if(!value) confirmInput = '' })"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/60 backdrop-blur-sm" style="display: none;" x-transition x-cloak>
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-sm overflow-hidden" @click.away="showArchiveConfirm = false">
        <div class="p-4 border-b border-[#f1f5f9] bg-slate-50 flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-red-600">Peringatan: Reset Sistem</div>
        <form action="{{ route('admin.arsip.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            <div class="text-center space-y-2">
                <p class="text-[11px] text-gray-500 leading-relaxed">Sistem akan memindahkan seluruh data PPDB ke **Database Arsip SQL Permanen** dan **MENGHAPUS SELURUH AKUN PENDAFTAR**.</p>
                <p class="text-[10px] font-bold text-red-600 uppercase tracking-widest bg-red-50 py-2 rounded border border-red-100">Ketik "{{ $activePeriod->nama_periode }}" untuk konfirmasi</p>
            </div>
            
            <div class="space-y-2">
                <input type="text" name="nama_periode" x-model="confirmInput" required placeholder="Ketik nama periode..." 
                       class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-red-500 outline-none bg-slate-50 text-center font-bold">
            </div>
            
            <button type="submit" 
                    :disabled="confirmInput !== '{{ $activePeriod->nama_periode }}'"
                    :class="confirmInput === '{{ $activePeriod->nama_periode }}' ? 'bg-[#dc2626] hover:bg-black opacity-100' : 'bg-gray-300 cursor-not-allowed opacity-50'"
                    class="w-full px-4 py-3 text-white rounded text-[10px] font-bold uppercase tracking-widest transition-all shadow-lg shadow-red-900/20 font-black">
                YA, ARSIPKAN & RESET
            </button>
        </form>
    </div>
</div>
@endif

<!-- Modal Form Periode (Tambah / Edit) -->
<div x-show="showAddPeriod" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/60 backdrop-blur-sm" style="display: none;" x-transition x-cloak>
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-md overflow-hidden" @click.away="showAddPeriod = false; editPeriod = null">
        <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center bg-slate-50"><h3 class="text-[10px] font-black text-[#111827] uppercase tracking-widest" x-text="editPeriod ? 'Edit Periode' : 'Buka Periode Pendaftaran Baru'"></h3></div>
        <form :action="editPeriod ? '/admin/periode/' + editPeriod.id_periode : '{{ route('admin.periode.store') }}'" method="POST" class="p-6 space-y-5">
            @csrf <template x-if="editPeriod"><input type="hidden" name="_method" value="PUT"></template>
            <div class="space-y-2"><label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nama Periode</label><input type="text" name="nama_periode" x-model="editPeriod ? editPeriod.nama_periode : ''" required class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm outline-none bg-slate-50"></div>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2"><label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Tanggal Buka</label><input type="date" name="tanggal_buka" :value="editPeriod ? editPeriod.tanggal_buka.split('T')[0] : ''" required class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm outline-none bg-slate-50"></div>
                <div class="space-y-2"><label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Tanggal Tutup</label><input type="date" name="tanggal_tutup" :value="editPeriod ? editPeriod.tanggal_tutup.split('T')[0] : ''" required class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm outline-none bg-slate-50"></div>
            </div>
            <button type="submit" class="w-full px-6 py-3 bg-[#1e3a8a] text-white rounded text-[10px] font-black uppercase tracking-widest hover:bg-black transition-colors shadow-lg shadow-blue-900/20 uppercase">Simpan Periode</button>
        </form>
    </div>
</div>

<!-- Modal View Archive Detail (SQL) -->
<div x-show="selectedArchive" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/60 backdrop-blur-sm" style="display: none;" x-transition x-cloak>
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-4xl overflow-hidden flex flex-col h-[85vh]">
        <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center bg-slate-50">
            <h3 class="text-[10px] font-bold text-[#111827] uppercase tracking-[.2em]" x-text="'Histori Snapshot: ' + selectedArchive?.nama_periode"></h3>
            <button @click="selectedArchive = null"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
        </div>
        <div class="overflow-y-auto flex-1">
            <table class="w-full text-left border-collapse text-[10px]">
                <thead class="sticky top-0 bg-slate-50 border-b border-[#f1f5f9] z-10">
                    <tr class="uppercase tracking-widest font-black text-[#6b7280]">
                        <th class="px-6 py-4">ID / NISN</th><th class="px-6 py-4">Nama Lengkap</th><th class="px-6 py-4 text-center">Avg</th><th class="px-6 py-4 text-right">Status Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    <template x-for="p in selectedArchive?.detail_pendaftar" :key="p.nomor_pendaftaran">
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-mono font-bold text-[#1e3a8a]" x-text="p.nomor_pendaftaran"></td>
                            <td class="px-6 py-4 font-bold text-[#111827]" x-text="p.nama"></td>
                            <td class="px-6 py-4 text-center font-black" x-text="p.rata_rata_nilai"></td>
                            <td class="px-6 py-4 text-right"><span class="px-2 py-0.5 rounded font-black uppercase text-[8px]" :class="p.status_seleksi == 'LULUS' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'" x-text="p.status_seleksi"></span></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-slate-50 border-t border-[#f1f5f9] text-right">
            <button @click="selectedArchive = null" class="px-6 py-2 border border-[#d1d5db] rounded text-[10px] font-black uppercase tracking-widest hover:bg-white">Tutup Riwayat</button>
        </div>
    </div>
</div>
@endpush
