@extends('layouts.admin')

@section('title', 'Manajemen Staf Panitia — Enumbiz')

@section('content')
<div class="space-y-8 w-full">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-1 border-b border-[#f1f5f9] pb-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-[#111827]">Manajemen Staf / Panitia</h1>
            <p class="text-sm text-[#6b7280]">Kelola hak akses dan data personel panitia PPDB.</p>
        </div>
        <button @click="showAddStaff = true" class="bg-[#1e3a8a] text-white px-6 py-2.5 rounded font-bold text-xs uppercase tracking-widest hover:bg-blue-800 transition-colors shadow-sm">
            Tambah Staf Baru
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-200 rounded text-sm font-bold text-green-700 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-200 rounded text-sm font-bold text-red-700 shadow-sm">{{ session('error') }}</div>
    @endif

    <!-- Table List -->
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-[#f1f5f9]">
                        <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest">Nama Panitia</th>
                        <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest">Username</th>
                        <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @foreach($admins as $adm)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-[#111827]">{{ $adm->nama_panitia }}</p>
                                <p class="text-[10px] text-[#1e3a8a] font-mono mt-0.5">#ADM-{{ str_pad($adm->id_panitia, 3, '0', STR_PAD_LEFT) }}</p>
                            </td>
                            <td class="px-6 py-4 text-[#6b7280]">{{ optional($adm->user)->username ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="editStaff = {{ json_encode(['id' => $adm->user_id, 'nama' => $adm->nama_panitia, 'username' => optional($adm->user)->username ?? '', 'no_hp' => $adm->no_hp]) }}; showAddStaff = true" 
                                            title="Edit" class="w-8 h-8 flex items-center justify-center rounded bg-slate-50 border border-slate-200 text-[#1e3a8a] hover:bg-[#1e3a8a] hover:text-white transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/></svg>
                                    </button>
                                    
                                    @if(auth()->id() != $adm->user_id)
                                        <form id="delete-staf-{{ $adm->user_id }}" action="{{ route('admin.staf.destroy', $adm->user_id) }}" method="POST" class="hidden">
                                            @csrf @method('DELETE')
                                        </form>
                                        <button type="button" @click="triggerConfirm('Hapus staf {{ $adm->nama_panitia }}?', () => document.getElementById('delete-staf-{{ $adm->user_id }}').submit())" 
                                                title="Hapus" class="w-8 h-8 flex items-center justify-center rounded bg-slate-50 border border-slate-200 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('modals')
    <!-- Modal Form (Tambah / Edit) -->
    <div x-show="showAddStaff" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/60" style="display: none;" x-transition>
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-md overflow-hidden" @click.away="showAddStaff = false; editStaff = null">
            <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center bg-slate-50">
                <h3 class="text-sm font-bold text-[#111827] uppercase tracking-widest" x-text="editStaff ? 'Edit Staf' : 'Tambah Staf Baru'"></h3>
                <button @click="showAddStaff = false; editStaff = null" class="text-gray-400 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            
            <form :action="editStaff ? '/admin/staf/' + editStaff.id : '{{ route('admin.staf.store') }}'" method="POST" class="p-6 space-y-5">
                @csrf
                <template x-if="editStaff"><input type="hidden" name="_method" value="PUT"></template>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nama Lengkap Panitia</label>
                    <input type="text" name="nama_panitia" x-model="editStaff ? editStaff.nama : ''" required 
                           class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Username Akun</label>
                    <input type="text" name="username" x-model="editStaff ? editStaff.username : ''" required 
                           class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Nomor HP</label>
                    <input type="text" name="no_hp" x-model="editStaff ? editStaff.no_hp : ''" required placeholder="Contoh: 08123456789"
                           class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Password</label>
                    <input type="password" name="password" :placeholder="editStaff ? 'Kosongkan jika tidak ubah' : 'Min. 6 karakter'" :required="!editStaff"
                           class="w-full border border-[#d1d5db] rounded px-4 py-2.5 text-sm focus:border-[#1e3a8a] outline-none bg-slate-50">
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="showAddStaff = false; editStaff = null" 
                            class="flex-1 px-6 py-3 border border-[#d1d5db] rounded text-xs font-bold uppercase tracking-widest hover:bg-slate-50">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-[#1e3a8a] text-white rounded text-xs font-bold uppercase tracking-widest hover:bg-blue-800 shadow-lg shadow-blue-900/20">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endpush

</div>
@endsection