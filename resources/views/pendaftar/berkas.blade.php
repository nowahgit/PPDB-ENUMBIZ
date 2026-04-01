@extends('layouts.pendaftar')

@section('title', 'Unggah Berkas — Enumbiz School')

@section('content')
<div class="space-y-8 max-w-4xl">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">Unggah Dokumen Fisik</h1>
        <p class="text-sm text-[#6b7280]">Silakan unggah pindaian dokumen asli Anda dalam format PDF atau JPG (Masing-masing maks. 5MB).</p>
    </div>

    <form action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
            <div class="p-5 border-b border-[#f1f5f9]">
                <h3 class="text-sm font-bold text-[#111827]">Dokumen Persyaratan</h3>
            </div>
            <div class="p-6 space-y-8">
                
                @foreach([
                    'file_kk' => 'Kartu Keluarga (KK)',
                    'file_akte' => 'Akte Kelahiran',
                    'file_skl' => 'SKL / Ijazah SMP'
                ] as $name => $label)
                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-[#374151]">{{ $label }}</label>
                            @if($berkas && $berkas->$name)
                                <a href="{{ Storage::url($berkas->$name) }}" target="_blank" class="text-[10px] font-bold text-[#1e3a8a] py-1 border-b border-[#1e3a8a] italic hover:text-blue-800 transition-colors">Lihat File Terunggah</a>
                            @else
                                <span class="text-[10px] font-bold text-red-400 italic">Belum diunggah</span>
                            @endif
                        </div>
                        <input type="file" name="{{ $name }}" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded file:border-0 file:text-[11px] file:font-bold file:uppercase file:tracking-widest file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition-colors">
                        @error($name) <p class="text-[9px] text-red-600 font-bold ml-1 uppercase">{{ $message }}</p> @enderror
                    </div>
                @endforeach

            </div>
        </div>

        <div class="flex justify-end pt-4 pb-20">
            <button type="submit" class="w-full md:w-auto md:px-12 bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold h-12 rounded shadow-sm text-xs uppercase tracking-wider transition-opacity duration-200">
                Unggah & Verifikasi Berkas
            </button>
        </div>

    </form>
</div>
@endsection
