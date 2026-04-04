@php
    /**
     * Reusable Stepper Component
     * $steps: Array of objects with [label, icon, status]
     * status options: 'completed', 'current', 'pending'
     */
    $user = Auth::user()->load('berkas');
    $seleksi = \App\Models\Seleksi::where('user_id', $user->id)->first();

    $steps = [
        [
            'label' => 'Buat Akun',
            'status' => 'completed',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>'
        ],
        [
            'label' => 'Data Diri & Rapor',
            'status' => ($user->nisn_pendaftar && $user->nama_ortu && $user->alamat_pendaftar) ? 'completed' : 'current',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'
        ],
        [
            'label' => 'Unggah Berkas',
            'status' => ($user->berkas && $user->berkas->file_path != '') ? 'completed' : (($user->nisn_pendaftar && $user->nama_ortu && $user->alamat_pendaftar) ? 'current' : 'pending'),
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>'
        ],
        [
            'label' => 'Verifikasi Admin',
            'status' => ($user->berkas && $user->berkas->status_validasi !== 'MENUNGGU') ? 'completed' : (($user->berkas && $user->berkas->file_path != '') ? 'current' : 'pending'),
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        ],
    ];
@endphp

<div class="w-full py-4 px-2">
    <!-- Desktop Horizontal Stepper -->
    <div class="hidden md:flex items-center justify-between relative">
        <!-- Connecting Line Background -->
        <div class="absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -translate-y-1/2 z-0"></div>
        
        @foreach($steps as $index => $step)
            <div class="relative z-10 flex flex-col items-center bg-transparent group">
                <div @class([
                    'w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 border-2',
                    'bg-green-600 border-green-600 text-white shadow-sm' => $step['status'] === 'completed',
                    'bg-blue-700 border-blue-700 text-white shadow-none' => $step['status'] === 'current',
                    'bg-white border-gray-300 text-gray-400' => $step['status'] === 'pending',
                ])>
                    @if($step['status'] === 'completed')
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {!! $step['icon'] !!}
                    @endif
                </div>
                <div @class([
                    'mt-2 text-[10px] font-bold uppercase tracking-wider',
                    'text-green-600' => $step['status'] === 'completed',
                    'text-blue-600' => $step['status'] === 'current',
                    'text-gray-400' => $step['status'] === 'pending',
                ])>
                    {{ $step['label'] }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Mobile Vertical Stepper -->
    <div class="flex flex-col space-y-4 md:hidden">
        @foreach($steps as $index => $step)
            <div class="flex items-center space-x-4">
                <div @class([
                    'w-8 h-8 rounded-full flex items-center justify-center border-2',
                    'bg-green-600 border-green-600 text-white' => $step['status'] === 'completed',
                    'bg-blue-700 border-blue-700 text-white shadow-none' => $step['status'] === 'current',
                    'bg-white border-gray-300 text-gray-400' => $step['status'] === 'pending',
                ])>
                    @if($step['status'] === 'completed')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {!! str_replace('w-5 h-5', 'w-4 h-4', $step['icon']) !!}
                    @endif
                </div>
                <div class="flex flex-col">
                    <span @class([
                        'text-xs font-bold uppercase tracking-tight',
                        'text-green-600' => $step['status'] === 'completed',
                        'text-blue-700' => $step['status'] === 'current',
                        'text-gray-400' => $step['status'] === 'pending',
                    ])>
                        {{ $step['label'] }}
                    </span>
                    @if($step['status'] === 'current')
                        <span class="text-[9px] text-blue-500 font-medium">Langkah saat ini</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
