<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pendaftar — Enumbiz School')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Nunito', sans-serif; background-color: #f8fafc; color: #111827; }
        .sidebar { background-color: #111827; width: 256px; }
        .nav-item-active { background-color: #1e3a8a; color: white; border-radius: 6px; }
        .nav-item-hover:hover { background-color: #1f2937; color: white; }
    </style>
</head>
<body class="min-h-screen" x-data="{ sidebarOpen: false }">

    <!-- Sidebar Desktop -->
    <aside class="sidebar fixed inset-y-0 left-0 z-50 flex flex-col transition-transform duration-300 transform -translate-x-full lg:translate-x-0"
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        <div class="p-6">
            <h1 class="text-white font-bold text-lg tracking-tight px-2">Enumbiz School</h1>
            <p class="text-gray-500 text-[11px] font-medium uppercase tracking-widest px-2 mt-1">Portal Pendaftar</p>
        </div>

        <nav class="flex-1 flex flex-col gap-1 px-2 mt-4">
            @php
                $nav = [
                    ['name' => 'Dashboard', 'route' => 'pendaftar.dashboard', 'icon' => '<rect x="3" y="3" width="7" height="7" /><rect x="14" y="3" width="7" height="7" /><rect x="14" y="14" width="7" height="7" /><rect x="3" y="14" width="7" height="7" />'],
                    ['name' => 'Data Diri', 'route' => 'pendaftar.data-diri', 'icon' => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" /><circle cx="12" cy="7" r="4" />'],
                    ['name' => 'Berkas Saya', 'route' => 'pendaftar.berkas', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" /><polyline points="14 2 14 8 20 8" /><line x1="16" y1="13" x2="8" y2="13" /><line x1="16" y1="17" x2="8" y2="17" /><polyline points="10 9 9 9 8 9" />'],
                    ['name' => 'Status Seleksi', 'route' => 'pendaftar.status-seleksi', 'icon' => '<circle cx="12" cy="12" r="10" /><path d="m9 12 2 2 4-4" />'],
                    ['name' => 'Pengaturan', 'route' => 'pendaftar.pengaturan', 'icon' => '<path d="M12.22 2a1 1 0 0 0-.97.75l-.33 1.31a7 7 0 0 0-1.84.75l-1.31-.33a1 1 0 0 0-1.15.51l-.77 1.33a1 1 0 0 0 .16 1.25l1.04.83a7.12 7.12 0 0 0 0 1.94l-1.04.83a1 1 0 0 0-.16 1.25l.77 1.33a1 1 0 0 0 1.15.51l1.31-.33a7 7 0 0 0 1.84.75l.33 1.31a1 1 0 0 0 .97.75h1.56a1 1 0 0 0 .97-.75l.33-1.31a7 7 0 0 0 1.84-.75l1.31.33a1 1 0 0 0 1.15-.51l.77-1.33a1 1 0 0 0-.16-1.25l-1.04-.83a7.12 7.12 0 0 0 0-1.94l1.04-.83a1 1 0 0 0 .16-1.25l-.77-1.33a1 1 0 0 0-1.15-.51l-1.31.33a7 7 0 0 0-1.84-.75l-.33-1.31a1 1 0 0 0-.97-.75Z" /><circle cx="12" cy="12" r="3" />'],
                ];
            @endphp

            @foreach($nav as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center gap-3 p-3 mx-2 transition-opacity duration-200 text-sm font-medium {{ $active ? 'nav-item-active' : 'text-gray-400 nav-item-hover' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        {!! $item['icon'] !!}
                    </svg>
                    {{ $item['name'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-auto p-4 mx-2 mb-4 border-t border-gray-800 pt-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-gray-800 text-white flex items-center justify-center rounded text-sm font-bold uppercase">
                    {{ substr(auth()->user()->username, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-white truncate">{{ auth()->user()->username }}</p>
                    <p class="text-[10px] text-gray-500 truncate">{{ auth()->user()->role }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-white transition-opacity duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-[#e2e8f0] flex items-center justify-between px-6 z-40 lg:hidden">
        <h1 class="font-bold text-[#111827]">Enumbiz</h1>
        <button @click="sidebarOpen = !sidebarOpen" class="text-[#111827]">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12" /><line x1="3" y1="6" x2="21" y2="6" /><line x1="3" y1="18" x2="21" y2="18" /></svg>
        </button>
    </header>

    <!-- Main Content -->
    <main class="lg:ml-64 pt-16 lg:pt-0 min-h-screen transition-opacity duration-200 flex flex-col">
        <div class="p-6 lg:p-10 flex-1 w-full">
            @yield('content')
        </div>
    </main>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-[#111827]/40 z-40 lg:hidden transition-opacity duration-200"></div>

    <!-- Global Enterprise Toast (No Emojis) -->
    @if(session('success') || session('error'))
    <div id="global-toast" class="fixed bottom-10 right-10 z-[100] transition-all duration-500 transform translate-y-10 opacity-0">
        <div class="bg-white border-l-4 {{ session('success') ? 'border-[#1e3a8a]' : 'border-red-600' }} shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-lg p-6 flex items-start gap-5 min-w-[350px] max-w-md border border-[#e2e8f0]">
            <div class="{{ session('success') ? 'text-[#1e3a8a]' : 'text-red-600' }} mt-1">
                @if(session('success'))
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                @endif
            </div>
            <div class="flex flex-col gap-1.5 flex-1">
                <span class="text-[10px] font-black uppercase tracking-[0.25em] {{ session('success') ? 'text-[#1e3a8a]' : 'text-red-600' }}">
                    {{ session('success') ? 'System Notification' : 'System Error' }}
                </span>
                <p class="text-sm font-bold text-[#111827] leading-relaxed italic">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>
            <button onclick="document.getElementById('global-toast').remove()" class="text-gray-300 hover:text-gray-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const toast = document.getElementById('global-toast');
            if (toast) {
                // Intro Animation
                setTimeout(() => {
                    toast.classList.remove('translate-y-10', 'opacity-0');
                    toast.classList.add('translate-y-0', 'opacity-100');
                }, 100);

                // Outro Animation after 6s
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-10', 'opacity-0');
                    setTimeout(() => toast.remove(), 500);
                }, 6000);
            }
        });
    </script>
    @endif

</body>
</html>
