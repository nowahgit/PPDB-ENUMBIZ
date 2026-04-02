<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Ditutup — Enumbiz School</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white border border-slate-200 rounded-2xl p-8 sm:p-10 text-center shadow-xl shadow-slate-200/50">
        <div class="w-20 h-20 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>

        <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">Pendaftaran Akun<br>Belum Dibuka</h1>
        
        <p class="text-slate-500 mt-4 text-sm leading-relaxed">
            Maaf, saat ini tidak ada periode pendaftaran aktif yang tersedia. Mohon kembali lagi sesuai jadwal yang ditentukan oleh sekolah.
        </p>

        @if($periode)
            <div class="mt-8 p-4 bg-slate-50 border border-slate-100 rounded-xl">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Jadwal Periode Terdekat</p>
                <p class="text-sm font-bold text-slate-700">{{ $periode->nama_periode }}</p>
                <p class="text-xs text-[#1e3a8a] font-bold mt-1">Buka: {{ $periode->tanggal_buka->format('d M Y') }}</p>
            </div>
        @endif

        <div class="mt-10">
            <a href="/" class="inline-flex items-center gap-2 text-sm font-bold text-[#111827] hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
