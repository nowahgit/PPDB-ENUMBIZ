@extends('layouts.pendaftar')

@section('title', 'Status Seleksi — Enumbiz School')

@section('content')
<div class="space-y-10 max-w-5xl">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">Log Hasil Seleksi Akademik</h1>
        <p class="text-sm text-[#6b7280]">Pantau keputusan resmi panitia seleksi dan rincian skor rapor Anda.</p>
    </div>

    <!-- Status Decision Table -->
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-[#f1f5f9]">
        <div class="p-8 flex-1 flex flex-col items-center justify-center text-center gap-4">
            <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Keputusan Akhir</span>
            @php $st = $seleksi->status_seleksi ?? 'MENUNGGU'; @endphp
            <div class="px-8 py-3 rounded font-extrabold text-sm uppercase tracking-widest 
                @if($st === 'LULUS') bg-[#dcfce7] text-[#15803d] @elseif($st === 'TIDAK_LULUS') bg-[#fee2e2] text-[#b91c1c] @else bg-[#fef9c3] text-[#a16207] @endif">
                {{ $st === 'MENUNGGU' ? 'Sedang Ditinjau' : $st }}
            </div>
            <p class="text-[10px] text-gray-400 italic">Perubahan terakhir: {{ $seleksi ? $seleksi->updated_at->format('d/m/Y') : '-' }}</p>
        </div>
        
        <div class="p-8 flex-1 flex flex-col items-center justify-center text-center gap-2">
            <span class="text-[10px] font-bold text-[#6b7280] uppercase tracking-widest">Rata-rata Terverifikasi</span>
            @php $avg = $seleksi ? ($seleksi->nilai_smt1 + $seleksi->nilai_smt2 + $seleksi->nilai_smt3 + $seleksi->nilai_smt4 + $seleksi->nilai_smt5) / 5 : 0; @endphp
            <p class="text-4xl font-extrabold text-[#111827] tracking-tighter">{{ number_format($avg, 2) }}</p>
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Skala 100.00</p>
        </div>
    </div>

    <!-- Breakdown Table -->
    <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
        <div class="p-6 border-b border-[#f1f5f9]">
            <h3 class="text-sm font-bold text-[#111827] uppercase tracking-tight">Rincian Skor Semester</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#f9fafb] border-b border-[#f1f5f9]">
                    <tr>
                        <th class="px-8 py-4 text-[11px] font-bold text-[#6b7280] uppercase tracking-widest">Uraian Akademik</th>
                        <th class="px-8 py-4 text-[11px] font-bold text-[#6b7280] uppercase tracking-widest text-right">Skor Verifikasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f1f5f9]">
                    @foreach(['smt1' => 'Semester 1', 'smt2' => 'Semester 2', 'smt3' => 'Semester 3', 'smt4' => 'Semester 4', 'smt5' => 'Semester 5'] as $key => $label)
                        <tr class="transition-opacity duration-200">
                            <td class="px-8 py-4 text-xs font-bold text-[#111827] uppercase tracking-tight">{{ $label }}</td>
                            <td class="px-8 py-4 text-sm font-bold text-[#1e3a8a] text-right font-mono">{{ number_format($seleksi->{'nilai_' . $key} ?? 0, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Official Note -->
    <div class="bg-[#f1f5f9] border border-[#e2e8f0] rounded-lg p-8">
        <div class="flex items-start gap-4">
            <div class="mt-0.5 text-[#111827]">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </div>
            <div class="space-y-2">
                <h4 class="text-[11px] font-bold text-[#111827] uppercase tracking-widest leading-none">Memorandum Panitia</h4>
                <p class="text-sm text-[#6b7280] italic leading-relaxed">
                    "{{ $seleksi->catatan ?? 'Menunggu peninjauan lebih lanjut oleh panitia seleksi akademik.' }}"
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
