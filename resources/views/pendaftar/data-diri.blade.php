@extends('layouts.pendaftar')

@section('title', 'Data Diri — Enumbiz School')

@section('content')
<div class="space-y-8 w-full">
    
    <div class="flex flex-col gap-1">
        <h1 class="text-2xl font-bold text-[#111827]">Lengkapi Data Diri & Nilai Rapor</h1>
        <p class="text-sm text-[#6b7280]">Pastikan data yang Anda masukkan sudah sesuai dengan dokumen asli.</p>
    </div>

    @include('components.stepper')

    <form action="{{ route('pendaftar.data-diri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 pb-12">
        @csrf
        
        @if($user->berkas && $user->berkas->status_validasi === 'VALID')
            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 border border-blue-200 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v2m0-2h2m-2 0h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                <span><strong>Data Terkunci:</strong> Dokumen Anda telah divalidasi oleh panitia. Data tidak dapat diubah lagi.</span>
            </div>
            <fieldset disabled>
        @endif

        <!-- Section 1: Data Diri -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
            <div class="p-5 border-b border-[#f1f5f9]">
                <h3 class="text-sm font-bold text-[#111827]">01. Profil Calon Siswa</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <!-- ID Terverifikasi -->
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-[10px] font-black text-[#1e3a8a] uppercase tracking-widest leading-none">Nomor Pendaftaran (ID Resmi Anda)</label>
                    <div class="flex items-center gap-4 bg-slate-50 border border-slate-200 p-4 rounded-md">
                        <div class="flex flex-shrink-0 w-12 h-12 bg-blue-900 text-white rounded items-center justify-center shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-black text-slate-800 tracking-widest leading-none">{{ $user->nomor_pendaftaran }}</span>
                            <span class="text-[9px] text-slate-400 font-bold uppercase mt-1 tracking-tighter">Gunakan nomor ini untuk verifikasi kartu ujian dan pengumuman.</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">NISN</label>
                    <input type="text" name="nisn_pendaftar" value="{{ old('nisn_pendaftar', $user->berkas->nisn_pendaftar ?? '') }}" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required>
                    @error('nisn_pendaftar') <p class="text-[10px] text-red-600 font-bold">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Nama Lengkap</label>
                    <input type="text" name="nama_pendaftar" value="{{ old('nama_pendaftar', $user->nama_pendaftar ?? $user->username) }}" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none bg-white" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="LAKI-LAKI" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'LAKI-LAKI' ? 'selected' : '' }}>LAKI-LAKI</option>
                        <option value="PEREMPUAN" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'PEREMPUAN' ? 'selected' : '' }}>PEREMPUAN</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Tanggal Lahir</label>
                    <input type="date" name="tanggallahir_pendaftar" value="{{ old('tanggallahir_pendaftar', ($user->berkas && $user->berkas->tanggallahir_pendaftar) ? \Carbon\Carbon::parse($user->berkas->tanggallahir_pendaftar)->format('Y-m-d') : '') }}" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Agama</label>
                    <select name="agama" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none bg-white" required>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $val)
                            <option value="{{ $val }}" {{ old('agama', $user->berkas->agama ?? '') == $val ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1.5 md:col-span-2">
                    <label class="text-xs font-bold text-[#374151]">Alamat Lengkap (Sesuai KK)</label>
                    <textarea name="alamat_pendaftar" rows="2" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required>{{ old('alamat_pendaftar', $user->berkas->alamat_pendaftar ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 2: Data Orang Tua -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
            <div class="p-5 border-b border-[#f1f5f9]">
                <h3 class="text-sm font-bold text-[#111827]">02. Data Orang Tua / Wali</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Nama Ortu/Wali</label>
                    <input type="text" name="nama_ortu" value="{{ old('nama_ortu', $user->berkas->nama_ortu ?? '') }}" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Nomor HP WhatsApp</label>
                    <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu', $user->berkas->no_hp_ortu ?? '') }}" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required placeholder="08...">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Pekerjaan Ortu</label>
                    <input type="text" name="pekerjaan_ortu" value="{{ old('pekerjaan_ortu', $user->berkas->pekerjaan_ortu ?? '') }}" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-[#374151]">Alamat Ortu</label>
                    <textarea name="alamat_ortu" rows="1" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" required>{{ old('alamat_ortu', $user->berkas->alamat_ortu ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 3: Nilai Rapor -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
            <div class="p-5 border-b border-[#f1f5f9]">
                <h3 class="text-sm font-bold text-[#111827]">03. Nilai Rapor 5 Semester (Skala 100)</h3>
            </div>
            <div class="p-6 grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach(['nilai_smt1' => 'Smt 1', 'nilai_smt2' => 'Smt 2', 'nilai_smt3' => 'Smt 3', 'nilai_smt4' => 'Smt 4', 'nilai_smt5' => 'Smt 5'] as $key => $label)
                    <div class="flex flex-col gap-1.5">
                        <label class="text-xs font-bold text-[#374151]">{{ $label }}</label>
                        <input type="text" name="{{ $key }}" value="{{ old($key, $seleksi->$key ?? '') }}" 
                            class="score-input border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" 
                            required placeholder="85.50">
                        <span class="text-[9px] text-gray-400 font-medium italic">Gunakan titik ( . )</span>
                    </div>
                @endforeach
            </div>
            <div id="score-error" class="px-6 pb-4 hidden text-[10px] text-red-600 font-bold uppercase tracking-tight">Format nilai tidak valid (Gunakan . dan range 0-100)</div>

            <script>
                document.querySelectorAll('.score-input').forEach(input => {
                    input.addEventListener('input', function() {
                        const errorDiv = document.getElementById('score-error');
                        // Only numbers and dot
                        this.value = this.value.replace(/[^0-9.]/g, '');
                        
                        // Limit to 1 dot
                        if ((this.value.match(/\./g) || []).length > 1) {
                            this.value = this.value.replace(/\.+$/, "");
                        }

                        // Validate Range
                        const val = parseFloat(this.value);
                        if (val > 100 || isNaN(val) && this.value !== '') {
                            this.classList.add('border-red-500');
                            errorDiv.classList.remove('hidden');
                        } else {
                            this.classList.remove('border-red-500');
                            errorDiv.classList.add('hidden');
                        }
                    });
                });
            </script>
        </div>

        <!-- Section 4: Prestasi Mandiri (Opsional) -->
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-sm">
            <div class="p-5 border-b border-[#f1f5f9] flex justify-between items-center">
                <h3 class="text-sm font-bold text-[#111827]">04. Prestasi & Penghargaan (Opsional - Maks 3)</h3>
                <span class="text-[10px] uppercase font-bold text-gray-400">PDF/JPG Maks 5MB</span>
            </div>
            <div class="p-6 space-y-6">
                @for($i = 1; $i <= 3; $i++)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-6 {{ $i < 3 ? 'border-b border-gray-50' : '' }}">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-[#6b7280]">Nama Prestasi {{ $i }}</label>
                            <input type="text" name="prestasi_{{ $i }}" value="{{ old('prestasi_'.$i, $user->berkas->{'prestasi_'.$i} ?? '') }}" class="border border-[#d1d5db] rounded-md text-sm py-2.5 px-3 focus:border-[#1e3a8a] outline-none" placeholder="Contoh: Juara 1 Karate Tingkat Provinsi">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <div class="flex justify-between">
                                <label class="text-xs font-bold text-[#6b7280]">Sertifikat Bukti {{ $i }}</label>
                                @if($user->berkas && $user->berkas->{'prestasi_'.$i.'_file'})
                                    <a href="{{ Storage::url($user->berkas->{'prestasi_'.$i.'_file'}) }}" target="_blank" class="text-[10px] font-bold text-[#1e3a8a] hover:underline">Lihat Bukti</a>
                                @endif
                            </div>
                            <input type="file" name="prestasi_{{ $i }}_file" accept=".pdf,.jpg,.jpeg,.png" class="border border-[#d1d5db] rounded-md text-[11px] py-1.5 px-3 focus:border-[#1e3a8a] outline-none bg-gray-50">
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        @if($user->berkas && $user->berkas->status_validasi === 'VALID')
            <div class="bg-gray-100 p-4 border rounded text-center text-xs font-bold text-gray-500 uppercase tracking-widest">
                DATA TIDAK DAPAT DIUBAH (VALID)
            </div>
            </fieldset>
        @else
            <div class="flex justify-end transition-opacity duration-200">
                <button type="submit" class="w-full md:w-auto md:px-12 bg-[#1e3a8a] hover:bg-blue-800 text-white font-bold h-12 rounded shadow-sm text-xs uppercase tracking-wider">
                    Simpan & Update Data Diri
                </button>
            </div>
        @endif

    </form>
</div>
@endsection
