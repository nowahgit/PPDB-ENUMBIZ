<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandi Baru — Enumbiz School</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Public Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-xl bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-10 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Password Baru</h1>
                <p class="text-sm text-gray-600 mt-2">
                    Silakan masukkan password baru untuk akun Anda.
                </p>
            </div>

            @if($errors->any())
                <div class="p-4 rounded-md bg-red-50 text-xs text-red-600 font-medium border border-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="space-y-4">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input type="password" name="password" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Password Baru" required autofocus>
                    </div>

                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="password" name="password_confirmation" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Konfirmasi Password Baru" required>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="w-full sm:w-auto px-8 py-2.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-semibold text-sm rounded-md shadow-sm transition-all transform active:scale-95">
                        Simpan Password Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
