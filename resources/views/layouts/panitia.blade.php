<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50/50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Panitia — PPDB Enumbiz School')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Google Sans', sans-serif; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="h-full text-slate-900 antialiased">
    <div class="flex h-full overflow-hidden">
        
        <!-- SIDEBAR -->
        <aside class="hidden lg:flex w-64 bg-white border-r border-slate-100 flex-col flex-shrink-0 relative z-20">
            <!-- Sidebar Header -->
            <div class="h-20 px-6 border-b border-slate-50 flex items-center gap-3">
                <div class="w-10 h-10 bg-[#1e40af] rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-sm shadow-[#1e40af]/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <h1 class="text-base font-bold text-gray-900 truncate tracking-tight">Enumbiz Admin</h1>
                    <p class="text-[10px] text-[#1e40af] font-bold uppercase tracking-widest truncate italic">Panel Panitia</p>
                </div>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 italic {{ request()->routeIs('admin.dashboard') ? 'bg-[#1e40af]/5 text-[#1e40af]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#1e40af]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Kelola Pendaftar -->
                <a href="{{ route('admin.pendaftar') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 italic {{ request()->routeIs('admin.pendaftar') ? 'bg-[#1e40af]/5 text-[#1e40af]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('admin.pendaftar') ? 'text-[#1e40af]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Data Pendaftar</span>
                </a>

                <!-- Seleksi -->
                <a href="{{ route('admin.seleksi') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 italic {{ request()->routeIs('admin.seleksi') ? 'bg-[#1e40af]/5 text-[#1e40af]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('admin.seleksi') ? 'text-[#1e40af]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.124a11.954 11.954 0 01-8.618 3.86M12 21a9.003 9.003 0 008.367-5.618m-16.734 0A9.003 9.003 0 0012 21" />
                    </svg>
                    <span>Seleksi Siswa</span>
                </a>

                <!-- Periode -->
                <a href="{{ route('admin.periode.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 italic {{ request()->routeIs('admin.periode.index') ? 'bg-[#1e40af]/5 text-[#1e40af]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('admin.periode.index') ? 'text-[#1e40af]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span>Manajemen Periode</span>
                </a>

                <!-- Staf Panitia -->
                <a href="{{ route('admin.staf.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 italic {{ request()->routeIs('admin.staf.index') ? 'bg-[#1e40af]/5 text-[#1e40af]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('admin.staf.index') ? 'text-[#1e40af]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Staf Panitia</span>
                </a>

                <!-- Arsip -->
                <a href="{{ route('admin.arsip.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold transition-all duration-200 italic {{ request()->routeIs('admin.arsip.index') ? 'bg-[#1e40af]/5 text-[#1e40af]' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ request()->routeIs('admin.arsip.index') ? 'text-[#1e40af]' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span>Arsip Seleksi</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="mt-auto p-4 border-t border-slate-50 space-y-4">
                <!-- User Card -->
                <div class="p-3.5 bg-slate-50 rounded-2xl flex items-center gap-3 border border-slate-100/50">
                    <div class="w-10 h-10 bg-white border border-slate-200/50 rounded-full flex items-center justify-center font-bold text-[#1e40af] text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->admin?->nama_panitia ?? auth()->user()->username, 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="text-xs font-bold text-slate-900 truncate italic">
                            {{ auth()->user()->admin?->nama_panitia ?? auth()->user()->username }}
                        </h4>
                        <span class="px-2 py-0.5 bg-indigo-100 text-[#1e40af] text-[10px] font-bold uppercase rounded leading-none italic">Panitia</span>
                    </div>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full h-12 flex items-center justify-center gap-3 px-4 bg-white border border-slate-200 text-sm font-bold text-slate-700 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all duration-200 italic">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Keluar Akun</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- MAIN -->
        <main class="flex-1 flex flex-col min-w-0 bg-white overflow-hidden">
            <!-- Header Topbar -->
            <header class="h-20 bg-white border-b border-slate-100 px-6 sm:px-10 flex items-center justify-between flex-shrink-0 relative z-10 shadow-sm shadow-slate-400/[0.02]">
                <h2 class="text-lg font-bold text-slate-900 tracking-tight italic">@yield('page-title', 'Dashboard')</h2>
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex text-right flex-col">
                        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest leading-none italic">Admin Session Active ✅</p>
                        <p class="text-sm font-bold text-slate-700 italic">{{ auth()->user()->admin?->nama_panitia ?? auth()->user()->username }}</p>
                    </div>
                    <div class="h-10 w-px bg-slate-100 hidden sm:block"></div>
                    <div class="h-10 w-10 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-6 sm:p-10">
                <!-- Flash Messages Area -->
                @if(session('success'))
                    <div class="mb-8 p-4 bg-indigo-50 border border-indigo-100 text-indigo-700 rounded-2xl flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <p class="text-sm font-semibold italic">{{ session('success') }}</p>
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-8 p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <p class="text-sm font-semibold italic">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
