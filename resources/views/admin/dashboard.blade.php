@extends('layouts.admin')

@section('title', 'Enterprise Dashboard — Enumbiz Admin')

@section('content')
<div class="space-y-8 max-w-[2800px]">
    
    <!-- Dashboard Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#f1f5f9] pb-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-[#111827]">Ringkasan Sistem Dashboard</h1>
            <p class="text-sm text-[#6b7280]">Pantau aktivitas, analisis & statistik pendaftar secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="bg-white border border-[#f1f5f9] px-4 py-3 rounded shadow-sm text-right">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sesi Aktif</p>
                <p class="text-xs font-bold text-[#1e3a8a]">{{ strtoupper($activePeriod->nama_periode ?? 'TIDAK ADA PERIODE AKTIF') }}</p>
            </div>
        </div>
    </div>

    <!-- 1. Card Total (Primary Stats) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                [
                    'label' => 'Total Pendaftar', 
                    'value' => $totalPendaftar, 
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
                    'color' => 'bg-white border border-[#e2e8f0]',
                    'accent' => 'bg-slate-50',
                    'text'  => 'text-slate-600'
                ],
                [
                    'label' => 'Lolos Berkas', 
                    'value' => $valid, 
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    'color' => 'bg-white border border-[#e2e8f0]',
                    'accent' => 'bg-green-50/30',
                    'text'  => 'text-green-600'
                ],
                [
                    'label' => 'Lolos Seleksi', 
                    'value' => $lolosSeleksi, 
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z"/></svg>',
                    'sub'   => $activePeriod->nama_periode ?? 'Draft',
                    'color' => 'bg-white border border-[#e2e8f0]',
                    'accent' => 'bg-blue-50/30',
                    'text'  => 'text-blue-600'
                ],
                [
                    'label' => 'Total Admin', 
                    'value' => $totalAdmin, 
                    'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
                    'color' => 'bg-white border border-[#e2e8f0]',
                    'accent' => 'bg-slate-50',
                    'text'  => 'text-slate-600'
                ],
            ];
        @endphp

        @foreach($cards as $c)
            <div class="{{ $c['color'] }} p-6 rounded-lg shadow-sm relative overflow-hidden group hover:border-[#1e3a8a]/20 transition-all">
                <div class="flex justify-between items-start relative z-10">
                    <div class="space-y-3">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#6b7280]">{{ $c['label'] }}</p>
                        <h2 class="text-3xl font-bold text-[#111827]">{{ number_format($c['value']) }}</h2>
                        @if(isset($c['sub']))
                            <div class="bg-blue-50 px-2 py-0.5 rounded inline-block border border-blue-100">
                                <p class="text-[9px] font-bold text-[#1e3a8a] uppercase tracking-tight">{{ $c['sub'] }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="{{ $c['text'] }} opacity-10 group-hover:opacity-100 transition-all transform group-hover:scale-110 duration-500">
                        {!! $c['icon'] !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 2 & 3. Overview Pendaftar Terbaru & Periode Seleksi -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Pendaftar Terbaru -->
        <div class="lg:col-span-2 bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center">
                <h3 class="text-sm font-bold text-[#111827]">Aktivitas Pendaftar Terbaru</h3>
                <a href="{{ route('admin.pendaftar') }}" class="text-[10px] font-bold text-[#1e3a8a] uppercase hover:underline">Lihat Semua Data →</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-[#f1f5f9]">
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[9px] tracking-widest">Pendaftar</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[9px] tracking-widest">Tahapan Berkas</th>
                            <th class="px-6 py-4 font-bold text-[#6b7280] uppercase text-[9px] tracking-widest text-right">Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f1f5f9]">
                        @forelse($recentApplicants as $applicant)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-slate-50 flex items-center justify-center font-bold text-[10px] text-[#1e3a8a] border border-slate-200">
                                            {{ strtoupper(substr($applicant->nama_pendaftar ?? $applicant->username, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-[#111827] leading-none">{{ $applicant->nama_pendaftar ?? $applicant->username }}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 font-mono tracking-tighter">{{ $applicant->nomor_pendaftaran }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php $st = $applicant->berkas->status_validasi ?? 'MENUNGGU'; @endphp
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full @if($st == 'VALID') bg-green-500 @elseif($st == 'DITOLAK') bg-red-500 @else bg-amber-500 @endif"></div>
                                        <span class="text-[10px] font-bold @if($st == 'VALID') text-green-700 @elseif($st == 'DITOLAK') text-red-700 @else text-amber-700 @endif uppercase tracking-wider">
                                            {{ $st }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.pendaftar.show', $applicant->id) }}" class="text-[10px] font-bold text-[#1e3a8a] hover:underline uppercase tracking-widest">Periksa</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-10 text-center text-gray-400 italic text-xs">Belum ada aktivitas pendaftaran hari ini.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Periode yang Aktif -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm overflow-hidden">
            <div class="p-5 border-b border-[#f1f5f9]">
                <h3 class="text-sm font-bold text-[#111827]">Periode Seleksi Aktif</h3>
            </div>
            <div class="p-6">
                @if($activePeriod)
                    <div class="space-y-6">
                        <div class="bg-blue-50/50 border-l-2 border-[#1e3a8a] p-4 rounded-r">
                            <p class="text-xs font-bold text-[#1e3a8a] uppercase tracking-widest mb-1">{{ $activePeriod->nama_periode }}</p>
                            <p class="text-[11px] text-slate-500 leading-relaxed">{{ $activePeriod->deskripsi ?? 'Pendaftaran sedang berlangsung untuk periode ini.' }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Mulai</p>
                                <p class="text-xs font-bold text-[#111827]">{{ $activePeriod->tanggal_buka->format('d M Y') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Selesai</p>
                                <p class="text-xs font-bold text-[#111827]">{{ $activePeriod->tanggal_tutup->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="pt-4">
                            @php
                                $total_days = $activePeriod->tanggal_buka->diffInDays($activePeriod->tanggal_tutup);
                                $remaining = now()->diffInDays($activePeriod->tanggal_tutup, false);
                                $percent = $total_days > 0 ? max(0, min(100, 100 - ($remaining / $total_days * 100))) : 100;
                            @endphp
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-[10px] font-bold text-[#111827] uppercase">Progress Waktu</span>
                                <span class="text-[10px] font-bold text-[#1e3a8a]">{{ round($percent) }}%</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-[#1e3a8a] h-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <p class="text-[9px] text-gray-400 mt-2 font-medium text-center uppercase tracking-widest">Sisa waktu: {{ $remaining > 0 ? $remaining . ' hari lagi' : 'Telah berakhir' }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-10">
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tidak ada periode aktif</p>
                        <a href="{{ route('admin.periode.index') }}" class="mt-4 inline-block text-[10px] font-bold text-[#1e3a8a] hover:underline uppercase">BUKA PERIODE BARU →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 4, 5, 6. Grafik Analitik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
        
        <!-- Grafik Jenis Kelamin -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm p-6 flex flex-col h-[400px]">
            <div class="mb-6">
                <h3 class="text-xs font-bold text-[#111827] uppercase tracking-widest mb-1">Grafik Jenis Kelamin</h3>
                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">Distribusi Pendaftar</p>
            </div>
            <div class="flex-1 min-h-0 relative flex items-center justify-center">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        <!-- Grafik Umur -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm p-6 flex flex-col h-[400px]">
            <div class="mb-6">
                <h3 class="text-xs font-bold text-[#111827] uppercase tracking-widest mb-1">Distribusi Umur</h3>
                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">Analisis Kelompok Usia</p>
            </div>
            <div class="flex-1 min-h-0 relative">
                <canvas id="ageChart"></canvas>
            </div>
        </div>

        <!-- Grafik Nilai -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm p-6 flex flex-col h-[400px]">
            <div class="mb-6">
                <h3 class="text-xs font-bold text-[#111827] uppercase tracking-widest mb-1">Populasi Nilai</h3>
                <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tight">Rerata Nilai Pendaftar</p>
            </div>
            <div class="flex-1 min-h-0 relative">
                <canvas id="scoreChart"></canvas>
            </div>
        </div>

    </div>

</div>

<!-- Scripts for Charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Gender Chart (Doughnut)
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($genderChart->pluck('jenis_kelamin')->map(fn($v) => $v == 'L' ? 'LAKI-LAKI' : ($v == 'P' ? 'PEREMPUAN' : 'LAINNYA'))) !!},
                datasets: [{
                    data: {!! json_encode($genderChart->pluck('total')) !!},
                    backgroundColor: ['#1e3a8a', '#ec4899', '#94a3b8'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: { size: 9, weight: '900', family: 'Nunito' },
                            padding: 20
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // 2. Age Chart (Bar)
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ageChart->keys()) !!},
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: {!! json_encode($ageChart->values()) !!},
                    backgroundColor: '#111827',
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { display: false }, ticks: { font: { size: 9 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 9 } } }
                }
            }
        });

        // 3. Score Chart (Line)
        const scoreCtx = document.getElementById('scoreChart').getContext('2d');
        new Chart(scoreCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($scoreCharts->pluck('avg_score')) !!},
                datasets: [{
                    label: 'Populasi Nilai',
                    data: {!! json_encode($scoreCharts->pluck('total')) !!},
                    borderColor: '#1e3a8a',
                    backgroundColor: 'rgba(30, 58, 138, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { font: { size: 9 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 9 } } }
                }
            }
        });
    });
</script>

<style>
    /* Premium aesthetics override */
    canvas { width: 100% !important; height: 100% !important; }
</style>
@endsection
