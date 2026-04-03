<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Enumbiz School</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Public Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen p-6">

    <!-- Login Card -->
    <div class="w-full max-w-xl bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-10 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Login</h1>
                <p class="text-sm text-gray-600 mt-2">
                    Selamat datang di <span class="font-bold text-gray-700 uppercase">Portal PPDB</span> Enumbiz School
                </p>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Username -->
                <div class="space-y-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <input type="text" name="username" value="{{ old('username') }}" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Username" required autofocus>
                    </div>
                    @if($errors->has('username'))
                        <p class="text-xs text-red-500 font-medium ml-1">Username harus diisi</p>
                    @endif
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        <input type="password" name="password" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Password" required>
                    </div>
                    @if($errors->has('password'))
                        <p class="text-xs text-red-500 font-medium ml-1">Password harus diisi</p>
                    @endif
                    @if($errors->any() && !$errors->has('username') && !$errors->has('password'))
                         <p class="text-xs text-red-500 font-medium ml-1">Terjadi kesalahan. Silakan cek data Anda.</p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                    <div class="flex flex-col gap-1 text-center sm:text-left">
                        <a href="{{ route('register') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors">Belum punya akun? Daftar</a>
                        <a href="{{ route('password.request') }}" class="text-xs text-gray-500 hover:text-blue-500 transition-colors">Lupa passsword?</a>
                    </div>
                    <button type="submit" class="w-full sm:w-auto px-8 py-2.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-semibold text-sm rounded-md shadow-sm transition-all transform active:scale-95">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Optional -->
    <div class="mt-8 text-center text-xs text-gray-400">
        &copy; 2026 ENUMBIZ SCHOOL — ALL RIGHTS RESERVED
    </div>

</body>
</html>
