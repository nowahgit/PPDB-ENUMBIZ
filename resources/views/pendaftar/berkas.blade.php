@extends('layouts.pendaftar')

@section('title', 'Unggah Berkas — Enumbiz School')

@section('content')
<div class="space-y-8 w-full">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">Unggah Dokumen Fisik</h1>
        <p class="text-sm text-[#6b7280]">Silakan unggah pindaian dokumen asli Anda dalam format PDF atau JPG (Masing-masing maks. 5MB).</p>
    </div>

    @include('components.stepper')

    <form id="uploadForm" action="{{ route('pendaftar.berkas.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        @if($berkas && $berkas->status_validasi === 'VALID')
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 border border-blue-200 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 21.241a11.955 11.955 0 01-9.618-7.016m19.236 0A11.955 11.955 0 0112 2.759a11.955 11.955 0 019.618 7.016z"/></svg>
                <span><strong>Berkas Terkunci:</strong> Dokumen Anda telah divalidasi dan tidak dapat diunggah ulang.</span>
            </div>
            <fieldset disabled>
        @endif

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

        @if($berkas && $berkas->status_validasi === 'VALID')
            <div class="bg-gray-100 p-4 border rounded text-center text-xs font-bold text-gray-500 uppercase tracking-widest">
                DOKUMEN SUDAH DIVALIDASI
            </div>
            </fieldset>
        @else
            <div class="flex flex-col gap-4 pt-4 pb-20">
                <!-- Progress Bar Container (Hidden by default) -->
                <div id="progressContainer" class="hidden w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                    <div id="progressBar" class="bg-blue-600 h-2.5 transition-all duration-300" style="width: 0%"></div>
                </div>
                <div id="statusMessage" class="hidden text-[10px] text-gray-500 italic text-right"></div>
                
                <div class="flex justify-end">
                    <button type="submit" id="submitBtn" class="w-full md:w-auto md:px-12 bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold h-12 rounded shadow-sm text-xs uppercase tracking-wider transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Unggah & Verifikasi Berkas</span>
                    </button>
                </div>
            </div>
        @endif

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const statusMessage = document.getElementById('statusMessage');
        
        // Disable UI
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <span>Sedang Mengunggah...</span>
        `;
        submitBtn.classList.add('bg-blue-400');
        
        progressContainer.classList.remove('hidden');
        statusMessage.classList.remove('hidden');

        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                statusMessage.innerText = `Mengunggah: ${percent}% (${(e.loaded / 1048576).toFixed(2)}MB / ${(e.total / 1048576).toFixed(2)}MB)`;
            }
        });

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                window.location.reload();
            } else {
                alert('Gagal mengunggah berkas. Pastikan ukuran file tidak melebihi batas (5MB per file).');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Unggah & Verifikasi Berkas</span>';
                submitBtn.classList.remove('bg-blue-400');
                progressContainer.classList.add('hidden');
                statusMessage.classList.add('hidden');
            }
        };

        xhr.onerror = function() {
            alert('Kesalahan jaringan. Silakan coba lagi.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Unggah & Verifikasi Berkas</span>';
        };

        xhr.open('POST', form.action, true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        // CSRF Token is needed for Laravel
        xhr.send(formData);
    });
});
</script>
@endsection
