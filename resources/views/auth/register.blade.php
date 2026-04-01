<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sekarang — Enumbiz School</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#111827] min-h-screen flex items-center justify-center p-6 selection:bg-blue-100 selection:text-blue-900">

    <div class="max-w-2xl w-full bg-[#1f2937] border border-slate-800 rounded-[2.5rem] shadow-2xl overflow-hidden p-8 lg:p-14">
        <div class="mb-10 lg:mb-14 text-center">
            <h1 class="text-4xl font-black text-white tracking-widest italic">Enumbiz<br/>School.</h1>
            <p class="text-slate-400 text-[11px] font-bold uppercase tracking-[0.4em] mt-4 italic">REGISTRASI PENDAFTAR BARU 2025</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-7">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                <!-- Username -->
                <div class="space-y-1.5 focus-within:translate-x-1 transition-transform">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic group-focus-within:text-blue-400">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" 
                        class="w-full h-14 px-6 rounded-2xl bg-[#111827] border border-slate-800 focus:border-blue-500/50 outline-none transition-all text-sm font-bold text-slate-200 italic placeholder:text-slate-600"
                        placeholder="user_baru_anda" required autofocus>
                    @error('username') <p class="text-[10px] text-red-500 font-bold mt-1 italic ml-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1.5 focus-within:translate-x-1 transition-transform">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic group-focus-within:text-blue-400">Email (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full h-14 px-6 rounded-2xl bg-[#111827] border border-slate-800 focus:border-blue-500/50 outline-none transition-all text-sm font-bold text-slate-200 italic placeholder:text-slate-600"
                        placeholder="email@example.com">
                    @error('email') <p class="text-[10px] text-red-500 font-bold mt-1 italic ml-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Asal Sekolah -->
                <div class="space-y-1.5 focus-within:translate-x-1 transition-transform md:col-span-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic group-focus-within:text-blue-400">Asal Sekolah (Opsional)</label>
                    <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" 
                        class="w-full h-14 px-6 rounded-2xl bg-[#111827] border border-slate-800 focus:border-blue-500/50 outline-none transition-all text-sm font-bold text-slate-200 italic placeholder:text-slate-600"
                        placeholder="SMP Negeri Enumbiz...">
                    @error('asal_sekolah') <p class="text-[10px] text-red-500 font-bold mt-1 italic ml-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1.5 focus-within:translate-x-1 transition-transform" x-data="{ show: false }">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic group-focus-within:text-blue-400">Kata Sandi</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" name="password" 
                            class="w-full h-14 px-6 rounded-2xl bg-[#111827] border border-slate-800 focus:border-blue-500/50 outline-none transition-all text-sm font-bold text-slate-200 italic placeholder:text-slate-600"
                            placeholder="••••••••" required>
                        <button type="button" @click="show = !show" class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-600 hover:text-slate-400 transition-colors">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" /></svg>
                        </button>
                    </div>
                    @error('password') <p class="text-[10px] text-red-500 font-bold mt-1 italic ml-1 uppercase">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1.5 focus-within:translate-x-1 transition-transform">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 italic group-focus-within:text-blue-400">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full h-14 px-6 rounded-2xl bg-[#111827] border border-slate-800 focus:border-blue-500/50 outline-none transition-all text-sm font-bold text-slate-200 italic placeholder:text-slate-600"
                        placeholder="••••••••" required>
                </div>
            </div>

            <div class="pt-8">
                <button type="submit" class="w-full h-16 bg-[#1e3a8a] hover:bg-[#1e40af] text-white rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition-all hover:scale-[1.01] active:scale-[0.99] shadow-2xl shadow-blue-900/40 italic">
                    DAFTAR SEKARANG
                </button>
                
                <p class="text-center mt-10 text-[10px] font-bold text-slate-500 uppercase tracking-widest italic">
                    SUDAH PUNYA AKUN? 
                    <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 ml-1 border-b border-blue-900">MASUK DI SINI</a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>
