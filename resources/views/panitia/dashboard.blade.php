@extends('layouts.panitia')

@section('title', 'Dashboard — Panitia — PPDB Enumbiz School')
@section('page-title', 'Dashboard Utama')

@section('content')
<div class="max-w-7xl space-y-10">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h3 class="text-2xl font-bold text-slate-900 tracking-tight italic">
                Selamat datang, {{ auth()->user()->admin?->nama_panitia ?? auth()->user()->username }}! 🏛️
            </h3>
            <p class="text-sm text-slate-500 italic">Hari ini: {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Pendaftar -->
        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm shadow-slate-200/20 space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg italic">Data pendaftar masuk</p>
            </div>
            <div>
                <h4 class="text-3xl font-bold text-slate-900 tracking-tight">0</h4>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Total Pendaftar</p>
            </div>
        </div>

        <!-- Menunggu Validasi -->
        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm shadow-slate-200/20 space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg italic">Berkas perlu ditinjau</p>
            </div>
            <div>
                <h4 class="text-3xl font-bold text-slate-900 tracking-tight">0</h4>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Menunggu Validasi</p>
            </div>
        </div>

        <!-- Berkas Valid -->
        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm shadow-slate-200/20 space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg italic">Berkas terverifikasi</p>
            </div>
            <div>
                <h4 class="text-3xl font-bold text-slate-900 tracking-tight">0</h4>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Berkas Valid</p>
            </div>
        </div>

        <!-- Berkas Ditolak -->
        <div class="bg-white p-7 rounded-3xl border border-slate-100 shadow-sm shadow-slate-200/20 space-y-4">
            <div class="flex items-center justify-between">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-lg italic">Perlu perbaikan</p>
            </div>
            <div>
                <h4 class="text-3xl font-bold text-slate-900 tracking-tight">0</h4>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Berkas Ditolak</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area: Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Recent Activity Table (lg:col-span-2) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="flex items-center justify-between px-2">
                <h4 class="text-base font-bold text-slate-900 italic">Aktivitas Pendaftar Terbaru</h4>
                <a href="#" class="text-xs font-bold text-blue-600 hover:text-blue-700 italic border-b border-blue-200">Lihat Semua Data →</a>
            </div>
            
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm shadow-slate-200/20 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-50">
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">No</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">Nama Pendaftar</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">Asal Sekolah</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">Status Berkas</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest italic">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Empty State -->
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <h5 class="text-sm font-bold text-slate-900 italic">Belum ada data pendaftar</h5>
                                            <p class="text-xs text-slate-400 max-w-xs mx-auto italic leading-relaxed">
                                                Data akan muncul di sini secara otomatis setelah ada calon peserta yang mendaftar dan melengkapi berkas.
                                            </p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Actions (lg:col-span-1) -->
        <div class="space-y-6">
            <h4 class="text-base font-bold text-slate-900 px-2 italic">Aksi Cepat</h4>
            <div class="grid grid-cols-1 gap-4">
                <a href="#" class="group p-5 bg-white border border-slate-100 rounded-3xl flex items-center gap-4 hover:border-blue-200 transition-all shadow-sm shadow-slate-200/20 active:transform active:scale-[0.98]">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.124a11.954 11.954 0 01-8.618 3.86M12 21a9.003 9.003 0 008.367-5.618m-16.734 0A9.003 9.003 0 0012 21" /></svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-slate-900 italic">Validasi Berkas Pending</h5>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 italic">Daftar Tunggu Seleksi</p>
                    </div>
                </a>

                <a href="#" class="group p-5 bg-white border border-slate-100 rounded-3xl flex items-center gap-4 border-dashed hover:border-blue-200 transition-all shadow-sm shadow-slate-200/20 active:transform active:scale-[0.98]">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-amber-50 group-hover:text-amber-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-slate-900 italic">Input Nilai Seleksi</h5>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 italic">Halaman Skor Akademik</p>
                    </div>
                </a>

                <a href="#" class="group p-5 bg-white border border-slate-100 rounded-3xl flex items-center gap-4 border-dashed hover:border-blue-200 transition-all shadow-sm shadow-slate-200/20 active:transform active:scale-[0.98]">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-slate-900 group-hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-slate-900 italic">Kelola Periode PPDB</h5>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 italic">Pengaturan Gelombang</p>
                    </div>
                </a>

                <a href="#" class="group p-5 bg-white border border-slate-100 rounded-3xl flex items-center gap-4 border-dashed hover:border-blue-200 transition-all shadow-sm shadow-slate-200/20 active:transform active:scale-[0.98]">
                    <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-slate-100 group-hover:text-slate-900 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-slate-900 italic">Lihat Audit Log</h5>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 italic">Rekaman Aktivitas Sistem</p>
                    </div>
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
