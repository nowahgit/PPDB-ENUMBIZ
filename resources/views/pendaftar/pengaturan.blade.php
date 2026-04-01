@extends('layouts.pendaftar')

@section('title', 'Pengaturan — Enumbiz School')

@section('content')
<div class="space-y-10 max-w-5xl">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">Pengaturan Keamanan & Profil</h1>
        <p class="text-sm text-[#6b7280]">Kelola informasi dasar akun dan amankan akses login Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        <!-- Update Profil Dasar -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm flex flex-col">
            <div class="p-6 border-b border-[#f1f5f9] flex items-center justify-between">
                <div class="flex items-center gap-3 text-[#111827]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#6b7280]"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <h3 class="text-sm font-bold uppercase tracking-wider">Lengkapi Profil</h3>
                </div>
            </div>
            <div class="p-8">
                <form action="{{ route('pendaftar.pengaturan.profil') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#374151] uppercase tracking-tight">Username Sistem</label>
                        <input type="text" value="{{ auth()->user()->username }}" class="w-full bg-[#f1f5f9] border border-[#e2e8f0] rounded py-3 px-4 text-xs font-bold text-[#6b7280] cursor-not-allowed" readonly>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#374151] uppercase tracking-tight">Email Terdaftar</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="border border-[#d1d5db] w-full rounded py-3 px-4 text-sm focus:border-[#1e3a8a] outline-none transition-opacity duration-200" placeholder="nama@email.com">
                        @error('email') <p class="text-[10px] font-bold text-red-600 uppercase">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#374151] uppercase tracking-tight">Asal Instansi Sekolah</label>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', auth()->user()->asal_sekolah) }}" class="border border-[#d1d5db] w-full rounded py-3 px-4 text-sm focus:border-[#1e3a8a] outline-none transition-opacity duration-200" placeholder="Nama SMP / MTs Sederajat">
                        @error('asal_sekolah') <p class="text-[10px] font-bold text-red-600 uppercase">{{ $message }}</p> @enderror
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full py-3.5 bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold text-xs uppercase tracking-widest rounded transition-opacity duration-200">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Kata Sandi -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm flex flex-col">
            <div class="p-6 border-b border-[#f1f5f9] flex items-center justify-between">
                <div class="flex items-center gap-3 text-[#111827]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[#6b7280]"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <h3 class="text-sm font-bold uppercase tracking-wider">Keamanan Akun</h3>
                </div>
            </div>
            <div class="p-8">
                <form action="{{ route('pendaftar.pengaturan.password') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#374151] uppercase tracking-tight text-red-700">Password Saat Ini</label>
                        <input type="password" name="current_password" class="border border-[#d1d5db] w-full rounded py-3 px-4 text-sm focus:border-[#1e3a8a] outline-none transition-opacity duration-200" required>
                        @error('current_password') <p class="text-[10px] font-bold text-red-600 uppercase">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#374151] uppercase tracking-tight">Password Baru</label>
                        <input type="password" name="new_password" class="border border-[#d1d5db] w-full rounded py-3 px-4 text-sm focus:border-[#1e3a8a] outline-none transition-opacity duration-200" required>
                        @error('new_password') <p class="text-[10px] font-bold text-red-600 uppercase">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-[#374151] uppercase tracking-tight">Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="border border-[#d1d5db] w-full rounded py-3 px-4 text-sm focus:border-[#1e3a8a] outline-none transition-opacity duration-200" required>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full py-3.5 bg-[#111827] hover:bg-black text-white font-bold text-xs uppercase tracking-widest rounded transition-opacity duration-200">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <!-- Note Section Detail -->
    <div class="bg-gray-50 border border-[#e2e8f0] rounded-lg p-6 flex gap-4 transition-opacity duration-200">
        <div class="text-[#6b7280]">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        </div>
        <div class="space-y-1">
            <p class="text-xs font-bold text-[#111827] uppercase tracking-widest">Informasi Keamanan</p>
            <p class="text-[11px] text-[#6b7280] leading-relaxed italic">Disarankan untuk mengganti password secara berkala dan tidak menggunakan informasi yang mudah ditebak. Sistem secara otomatis mencatat setiap percobaan login yang gagal.</p>
        </div>
    </div>

</div>
@endsection
