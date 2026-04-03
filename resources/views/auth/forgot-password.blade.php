<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — Enumbiz School</title>
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
                <h1 class="text-2xl font-bold text-gray-800">Lupa Password</h1>
                <p class="text-sm text-gray-600 mt-2">
                    Masukkan <span class="font-bold">Email</span> atau <span class="font-bold">Username</span> Anda untuk mereset password.
                </p>
            </div>

            @if(session('error'))
                <div class="p-4 rounded-md bg-red-50 text-xs text-red-600 font-medium border border-red-100">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="space-y-1">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <input type="text" name="email_or_username" 
                            class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all text-gray-700 placeholder-gray-400 shadow-sm"
                            placeholder="Email atau Username" required autofocus>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors">Kembali ke Login</a>
                    <button type="submit" class="w-full sm:w-auto px-8 py-2.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-semibold text-sm rounded-md shadow-sm transition-all transform active:scale-95">
                        Lanjutkan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
