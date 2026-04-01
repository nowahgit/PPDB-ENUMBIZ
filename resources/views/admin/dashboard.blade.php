@extends('layouts.admin')

@section('title', 'Admin Dashboard — Enumbiz School')

@section('content')
<div class="space-y-8 max-w-6xl">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">Ringkasan Pendaftaran</h1>
        <p class="text-sm text-[#6b7280]">Pantau aktivitas dan statistik pendaftar secara real-time.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Pendaftar', 'value' => $totalPendaftar, 'color' => '#111827'],
                ['label' => 'Berkas Valid', 'value' => $valid, 'color' => '#16a34a'],
                ['label' => 'Menunggu Validasi', 'value' => $menunggu, 'color' => '#1e3a8a'],
                ['label' => 'Berkas Ditolak', 'value' => $ditolak, 'color' => '#dc2626'],
            ];
        @endphp

        @foreach($stats as $s)
            <div class="bg-white border border-[#e2e8f0] p-6 rounded-lg shadow-sm">
                <p class="text-xs font-bold text-[#6b7280] uppercase tracking-wider mb-1">{{ $s['label'] }}</p>
                <span class="text-3xl font-extrabold" style="color: {{ $s['color'] }}">{{ $s['value'] }}</span>
            </div>
        @endforeach
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Pendaftar Terbaru -->
        <div class="lg:col-span-2 bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden">
            <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center">
                <h3 class="text-sm font-bold text-[#111827]">Pendaftar Terbaru</h3>
                <a href="{{ route('admin.pendaftar') }}" class="text-xs font-bold text-[#1e3a8a] hover:underline uppercase tracking-tight">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50">
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest">Nama Pendaftar</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest">Status</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @foreach($recentApplicants as $applicant)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-[#111827]">{{ $applicant->berkas->nama_pendaftar ?? ( $applicant->nama_pendaftar ?? $applicant->username) }}</p>
                                    <p class="text-[11px] text-[#6b7280] mt-0.5">ID: {{ $applicant->nomor_pendaftaran }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @php $st = $applicant->berkas->status_validasi ?? 'MENUNGGU'; @endphp
                                    <span class="text-[10px] font-bold px-2 py-1 rounded {{ $st == 'VALID' ? 'bg-green-100 text-green-700' : ($st == 'DITOLAK' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                                        {{ $st }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.pendaftar.show', $applicant->id) }}" class="text-[#1e3a8a] hover:underline font-bold text-xs uppercase tracking-tight">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daftar Panitia / Admin -->
        <div class="lg:col-span-3 bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden">
            <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center bg-slate-50">
                <h3 class="text-xs font-black text-[#111827] uppercase tracking-[0.2em]">Daftar Staf Panitia / Admin</h3>
                <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">{{ $totalAdmin }} Personel Terdaftar</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-white">
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest border-b border-[#f1f5f9]">Nama Lengkap Panitia</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest border-b border-[#f1f5f9]">User Account</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[10px] tracking-widest border-b border-[#f1f5f9]">ID Panitia</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @foreach($admins as $adm)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-[#111827] italic">{{ $adm->nama_panitia }}</td>
                                <td class="px-6 py-4 text-[#6b7280]">{{ $adm->user->username ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 text-[11px] font-mono text-[#1e3a8a]">#ADM-{{ str_pad($adm->id_panitia, 3, '0', STR_PAD_LEFT) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6 lg:col-span-1 hidden"> <!-- Hidden for now to focus on full width admin list if needed, or I can re-enable later -->

            <div class="bg-[#111827] p-8 rounded-lg text-white shadow-sm">
                <h4 class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400 mb-4">Informasi Sesi</h4>
                <div class="space-y-4">
                    <div class="flex justify-between items-center border-b border-gray-800 pb-3">
                        <span class="text-xs text-gray-400">Periode</span>
                        <span class="text-xs font-bold">{{ date('Y') }}/{{ date('Y')+1 }}</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-800 pb-3">
                        <span class="text-xs text-gray-400">Total Admin</span>
                        <span class="text-xs font-bold">{{ $totalAdmin }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-[#e2e8f0] p-8 rounded-lg shadow-sm">
                <h4 class="text-xs font-bold uppercase tracking-widest text-[#6b7280] mb-2">Bantuan</h4>
                <p class="text-xs text-[#6b7280] leading-relaxed">
                    Pastikan verifikasi berkas dilakukan sesuai dengan dokumen asli yang diunggah oleh pendaftar.
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
