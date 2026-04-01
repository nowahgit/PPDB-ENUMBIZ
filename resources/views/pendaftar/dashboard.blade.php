@extends('layouts.pendaftar')

@section('title', 'Dashboard — Enumbiz School')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col gap-1">
        <h2 class="text-xl font-bold text-[#111827]">Ringkasan Pendaftaran</h2>
        <p class="text-sm text-[#6b7280]">Selamat datang, {{ $user->berkas->nama_pendaftar ?? $user->username }}. Pantau status PPDB Anda di sini.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Status Berkas -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-6 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[11px] font-bold text-[#6b7280] uppercase tracking-wider">Status Berkas</span>
                <span class="text-sm font-bold text-[#111827]">{{ $berkasStatus }}</span>
            </div>
            <div class="bg-gray-50 p-2.5 rounded-md text-[#6b7280]">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /><line x1="16" y1="13" x2="8" y2="13" /><line x1="16" y1="17" x2="8" y2="17" /><polyline points="10 9 9 9 8 9" /></svg>
            </div>
        </div>

        <!-- Status Seleksi -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-6 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[11px] font-bold text-[#6b7280] uppercase tracking-wider">Status Seleksi</span>
                <span class="text-sm font-bold text-[#111827]">{{ $seleksi->status_seleksi ?? 'MENUNGGU' }}</span>
            </div>
            <div class="bg-gray-50 p-2.5 rounded-md text-[#6b7280]">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 12 2 2 4-4" /><circle cx="12" cy="12" r="10" /></svg>
            </div>
        </div>

        <!-- Rata-rata Nilai -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-6 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[11px] font-bold text-[#6b7280] uppercase tracking-wider">Rata-rata Nilai</span>
                <span class="text-sm font-bold text-[#111827]">{{ number_format($average, 2) }}</span>
            </div>
            <div class="bg-gray-50 p-2.5 rounded-md text-[#6b7280]">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10" /><line x1="18" y1="20" x2="18" y2="4" /><line x1="6" y1="20" x2="6" y2="16" /></svg>
            </div>
        </div>

        <!-- Nomor Pendaftaran -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg p-6 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[11px] font-bold text-[#6b7280] uppercase tracking-wider">No Pendaftaran</span>
                <span class="text-xs font-bold text-[#111827] uppercase">{{ $user->nomor_pendaftaran ?? '-' }}</span>
            </div>
            <div class="bg-gray-50 p-2.5 rounded-md text-[#6b7280]">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="10" y1="13" x2="21" y2="13" /><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /></svg>
            </div>
        </div>

    </div>

    <!-- Details Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Informasi Pendaftaran -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm flex flex-col">
            <div class="p-6 border-b border-[#f1f5f9]">
                <h3 class="text-sm font-bold text-[#111827] uppercase tracking-wider">Detail Pendaftaran</h3>
            </div>
            <div class="p-6 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-100 text-xs">
                            <tr class="group">
                                <th class="py-3 font-medium text-[#6b7280] w-1/3">NISN</th>
                                <td class="py-3 text-[#111827] font-bold">{{ $user->berkas->nisn_pendaftar ?? '-' }}</td>
                            </tr>
                            <tr class="group">
                                <th class="py-3 font-medium text-[#6b7280]">Asal Sekolah</th>
                                <td class="py-3 text-[#111827] font-bold">{{ $user->asal_sekolah ?? '-' }}</td>
                            </tr>
                            <tr class="group">
                                <th class="py-3 font-medium text-[#6b7280]">Kontak Ortu</th>
                                <td class="py-3 text-[#111827] font-bold">{{ $user->berkas->no_hp_ortu ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <a href="{{ route('pendaftar.data-diri') }}" class="block text-center py-2.5 bg-[#f1f5f9] hover:bg-[#e2e8f0] text-[#111827] font-bold text-xs rounded transition-opacity duration-200">
                        Lengkapi Data Diri
                    </a>
                </div>
            </div>
        </div>

        <!-- Progress Berkas -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm flex flex-col">
            <div class="p-6 border-b border-[#f1f5f9]">
                <h3 class="text-sm font-bold text-[#111827] uppercase tracking-wider">Verifikasi Dokumen</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="space-y-4">
                    <div class="flex items-start gap-4">
                        <div class="p-2 rounded bg-[#dcfce7] text-[#15803d]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-[#111827]">Pendaftaran Akun</p>
                            <p class="text-[10px] text-[#6b7280]">Akun berhasil dibuat pada {{ $user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2 rounded {{ $user->berkas ? 'bg-[#dcfce7] text-[#15803d]' : 'bg-[#fee2e2] text-[#b91c1c]' }}">
                            @if($user->berkas)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12" /></svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-[#111827]">Kelengkapan Berkas</p>
                            <p class="text-[10px] text-[#6b7280]">{{ $user->berkas ? 'Dokumen sudah diupload dan sedang diproses' : 'Harap segera upload dokumen pendaftaran' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        @php $validStatus = ($user->berkas->status_validasi ?? '') === 'VALID'; @endphp
                        <div class="p-2 rounded {{ $validStatus ? 'bg-[#dcfce7] text-[#15803d]' : 'bg-gray-100 text-gray-400' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold text-[#111827]">Validasi Berkas</p>
                            <p class="text-[10px] text-[#6b7280]">{{ $validStatus ? 'Berkas Anda telah dinyatakan asli dan valid' : 'Menunggu peninjauan panitia' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-2">
                    <a href="{{ route('pendaftar.berkas') }}" class="block text-center py-2.5 bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold text-xs rounded transition-opacity duration-200">
                        Kirim Berkas Sekarang
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
