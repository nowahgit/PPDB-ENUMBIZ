<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PPDB Enumbiz School')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Google Sans', sans-serif; }
    </style>
</head>
<body class="h-full bg-white text-gray-900 antialiased">
    <div class="flex min-h-full">
        <!-- LEFT PANEL (Desktop Only) -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#1e40af] relative overflow-hidden flex-col justify-center px-16">
            <!-- Decorative Circles -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-24 -mt-24"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full -ml-16 -mb-16"></div>
            <div class="absolute top-1/2 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16"></div>

            <div class="relative z-10 space-y-10">
                <!-- Icon & Brand -->
                <div class="space-y-6">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-white tracking-tight">PPDB Enumbiz School</h1>
                        <p class="mt-3 text-lg text-white/80 leading-relaxed max-w-md italic">
                            Sistem Informasi Penerimaan Peserta Didik Baru Terpadu, Transparan, dan Akuntabel.
                        </p>
                    </div>
                </div>

                <!-- Feature Pills -->
                <div class="flex flex-wrap gap-3">
                    <span class="px-5 py-2 bg-white/10 rounded-full text-white text-sm font-medium border border-white/10">Pendaftaran Online Mudah</span>
                    <span class="px-5 py-2 bg-white/10 rounded-full text-white text-sm font-medium border border-white/10">Upload Berkas Digital</span>
                    <span class="px-5 py-2 bg-white/10 rounded-full text-white text-sm font-medium border border-white/10">Pantau Status Real-time</span>
                    <span class="px-5 py-2 bg-white/10 rounded-full text-white text-sm font-medium border border-white/10">Pengumuman Transparan</span>
                </div>

                <!-- Footer -->
                <div class="pt-10 border-t border-white/10 w-fit">
                    <p class="text-white/60 text-sm italic">© {{ date('Y') }} Enumbiz School — Modern Learning Center</p>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL -->
        <div class="flex-1 flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50/50">
            <div class="w-full max-w-md">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm font-medium italic">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <p class="text-sm font-medium italic">{{ session('error') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <p class="text-sm font-medium italic">{{ $error }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Content Area -->
                <div class="bg-white p-6 sm:p-10 rounded-2xl shadow-sm border border-gray-100">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
