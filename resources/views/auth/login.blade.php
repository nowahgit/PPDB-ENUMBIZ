<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Enumbiz School</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { font-family: 'Nunito', sans-serif; } </style>
</head>
<body class="bg-[#111827] flex items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-md space-y-8 animate-fade-in">
        <!-- Logo & Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-[#1e3a8a] to-blue-600 shadow-xl shadow-blue-900/40 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Portal Pendaftar</h1>
            <p class="text-sm text-gray-400">Masuk untuk melanjutkan proses pendaftaran.</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl p-8 shadow-2xl space-y-6 border border-gray-800">
            @if($errors->any())
                <div class="p-4 bg-red-50 border border-red-100 rounded-lg text-xs font-bold text-red-600 space-y-1">
                    @foreach($errors->all() as $error) <p>• {{ $error }}</p> @endforeach
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                @csrf
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-widest ml-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e3a8a] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}" 
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] outline-none text-sm transition-all shadow-sm"
                            placeholder="Ketik username Anda" required autofocus>
                    </div>
                </div>

                <div class="space-y-1.5" x-data="{ show: false }">
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-widest ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-[#1e3a8a] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input :type="show ? 'text' : 'password'" name="password" 
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1e3a8a] focus:border-[#1e3a8a] outline-none text-sm transition-all shadow-sm"
                            placeholder="Ketik password Anda" required>
                        <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-[#1e3a8a] transition-colors">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-[#1e3a8a] hover:bg-blue-800 text-white font-extrabold text-sm rounded-xl shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-0.5 active:translate-y-0 uppercase tracking-widest">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="text-center pt-2">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Belum punya akun?</p>
                <a href="{{ route('register') }}" class="inline-block mt-1.5 text-sm font-extrabold text-[#1e3a8a] hover:text-blue-800 border-b border-blue-100 italic transition-colors">Daftar Akun Baru</a>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-[10px] text-gray-500 font-bold uppercase tracking-widest italic">&copy; 2026 ENUMBIZ SCHOOL — ALL RIGHTS RESERVED.</p>
    </div>

</body>
</html>
