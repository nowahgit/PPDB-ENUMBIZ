<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Enumbiz School</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Public Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen p-6">

    <!-- Register Card -->
    <div class="w-full max-w-xl bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-10 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h1>
                <p class="text-sm text-gray-600 mt-2">
                    Lengkapi form di bawah ini untuk membuat akun <span class="font-bold text-gray-700 uppercase">Pendaftar</span>.
                </p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Username -->
                <div class="space-y-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <!-- User Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Username" required autofocus maxlength="20">
                    </div>
                    <div class="flex justify-between items-center px-1">
                        <p class="text-[10px] text-gray-500 font-medium italic">Hanya huruf. Tanpa spasi.</p>
                        <span id="username-counter" class="text-[10px] font-bold text-gray-400">0/20</span>
                    </div>
                    @error('username') <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email (Optional) -->
                <div class="space-y-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <!-- Envelope Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.909A2.25 2.25 0 012.25 6.993V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25z" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Email (Opsional)">
                    </div>
                    @error('email') <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- NISN (Required per Perbaikan 4) -->
                <div class="space-y-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <!-- ID Card Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" /></svg>
                        </div>
                        <input type="text" name="nisn_pendaftar" value="{{ old('nisn_pendaftar') }}" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Masukkan NISN Siswa" required>
                    </div>
                    @error('nisn_pendaftar') <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p> @enderror
                </div>

                <!-- Asal Sekolah (Optional) -->
                <div class="space-y-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <!-- Academic Cap Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Asal Sekolah (Opsional)">
                    </div>
                    @error('asal_sekolah') <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div class="space-y-1" x-data="{ show: false }">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <!-- Lock Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input :type="show ? 'text' : 'password'" name="password" 
                                class="w-full pl-12 pr-10 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                                placeholder="Password" required>
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                                <svg x-cloak x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                        </div>
                        @error('password') <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                                <!-- Lock check Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 15l1.5 1.5 3-3" />
                                </svg>
                            </div>
                            <input type="password" name="password_confirmation" 
                                class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                                placeholder="Konfirmasi Password" required>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col-reverse md:flex-row md:items-center justify-between pt-4 gap-4">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition-colors text-center md:text-left">Sudah punya akun? Login</a>
                    <button type="submit" class="w-full md:w-auto px-8 py-2.5 bg-[#2563eb] hover:bg-[#1d4ed8]  text-white font-semibold text-sm rounded-md shadow-sm transition-all transform active:scale-95">
                        Daftar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer Optional -->
    <div class="mt-8 text-center text-xs text-gray-400">
        &copy; 2026 ENUMBIZ SCHOOL — ALL RIGHTS RESERVED
    </div>

    <script>
        const usernameInput = document.getElementById('username');
        const counterDisplay = document.getElementById('username-counter');

        usernameInput.addEventListener('keypress', function(e) {
            // Block anything that isn't alpha_num
            const char = String.fromCharCode(e.which);
            if (!/[a-zA-Z0-0]/.test(char)) {
                e.preventDefault();
            }
        });

        usernameInput.addEventListener('input', function() {
            // Clean up if pasted
            this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
            
            // Counter
            const current = this.value.length;
            counterDisplay.innerText = `${current}/20`;
            
            // Visual Indicator
            if (current > 0 && current < 5) {
                counterDisplay.classList.add('text-red-500');
                counterDisplay.classList.remove('text-green-500', 'text-gray-400');
            } else if (current >= 5) {
                counterDisplay.classList.add('text-green-500');
                counterDisplay.classList.remove('text-red-500', 'text-gray-400');
            } else {
                counterDisplay.classList.add('text-gray-400');
                counterDisplay.classList.remove('text-green-500', 'text-red-500');
            }
        });
    </script>
</body>
</html>
