@extends('layouts.pendaftar')

@section('title', 'Dashboard — Enumbiz School')

@section('content')
<div class="space-y-8">
    
    <!-- Welcome Header -->
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">Halo, {{ $user->berkas->nama_pendaftar ?? $user->username }}!</h1>
        <p class="text-sm text-[#6b7280]">Selamat datang di portal pendaftaran Enumbiz School. Berikut ringkasan status pendaftaran Anda.</p>
    </div>

    <!-- Stats Grid (5 Columns) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-5">
        
        <!-- Status Berkas -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm flex items-center justify-between transition-hover hover:shadow-md">
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-wider">Status Berkas</span>
                <span class="text-sm font-bold text-[#111827]">{{ $berkasStatus }}</span>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-md text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
        </div>

        <!-- Status Seleksi -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-wider">Status Seleksi</span>
                <span class="text-sm font-bold text-[#111827]">{{ $seleksi->status_seleksi ?? 'MENUNGGU' }}</span>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-md text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>

        <!-- Nilai Rata-rata -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-wider">Nilai Rata-rata</span>
                <span class="text-xl font-bold text-[#111827]">{{ number_format($average, 2) }}</span>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-md text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0V3h7.5v13.5m-7.5 0V6.75m0 0h7.5" />
                </svg>
            </div>
        </div>

        <!-- Periode Seleksi -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-wider">Periode Seleksi</span>
                <span class="text-xs font-bold text-[#111827] truncate max-w-[100px]">{{ $seleksi->nama_seleksi ?? 'N/A' }}</span>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-md text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-18 0h18" />
                </svg>
            </div>
        </div>

        <!-- Total Notifikasi/Pesan -->
        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-wider">Audit Log</span>
                <span class="text-sm font-bold text-[#111827]">Sistem Aktif</span>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-md text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
        </div>

    </div>

    <!-- Main Content Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Informasi Berkas Ringkasan -->
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
            <div class="p-5 border-b border-slate-100">
                <h3 class="text-sm font-bold text-[#111827]">Ringkasan Berkas</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-xs font-semibold text-gray-500">NISN</span>
                    <span class="text-xs font-bold text-[#111827]">{{ $user->berkas->nisn_pendaftar ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-xs font-semibold text-gray-500">Jalur Masuk</span>
                    <span class="text-xs font-bold text-[#111827]">{{ $user->berkas->jenis_berkas ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-xs font-semibold text-gray-500">Tanggal Upload</span>
                    <span class="text-xs font-bold text-[#111827]">{{ $user->berkas ? $user->berkas->created_at->format('d M Y') : '-' }}</span>
                </div>
                
                <div class="pt-4">
                    <a href="{{ route('pendaftar.berkas') }}" class="block text-center text-xs font-bold bg-[#1e3a8a] text-white py-2.5 rounded-md hover:bg-blue-800 transition-colors shadow-sm">Kelola Berkas Lengkap</a>
                </div>
            </div>
        </div>

        <!-- Informasi Akun -->
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm">
            <div class="p-5 border-b border-slate-100">
                <h3 class="text-sm font-bold text-[#111827]">Profil Akun Saya</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-xs font-semibold text-gray-500">Username</span>
                    <span class="text-xs font-bold text-[#111827]">{{ $user->username }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-xs font-semibold text-gray-500">Email</span>
                    <span class="text-xs font-bold text-[#111827]">{{ $user->email ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-xs font-semibold text-gray-500">Asal Sekolah</span>
                    <span class="text-xs font-bold text-[#111827] truncate max-w-[150px]">{{ $user->asal_sekolah ?? '-' }}</span>
                </div>

                <div class="pt-4">
                    <a href="{{ route('pendaftar.pengaturan') }}" class="block text-center text-xs font-bold border border-gray-200 text-[#111827] py-2.5 rounded-md hover:bg-gray-50 transition-colors shadow-sm">Buka Pengaturan Akun</a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
