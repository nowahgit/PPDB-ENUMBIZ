<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel — Enumbiz School')</title>
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
<body class="min-h-screen" x-data="{ 
        sidebarOpen: false, 
        confirmModal: false, 
        confirmTitle: '', 
        confirmAction: null,
        triggerConfirm(title, action) {
            this.confirmTitle = title;
            this.confirmAction = action;
            this.confirmModal = true;
        },
        // Modal states moved to global for stacking context fix
        showOtomatis: false,
        showArchiveConfirm: {{ session('show_force_option') ? 'true' : 'false' }},
        showAddPeriod: false,
        editPeriod: null,
        selectedArchive: null,
        showAddStaff: false,
        editStaff: null,
        showManagePeriods: false,
        showArchives: false
    }">

    <!-- Sidebar Desktop -->
    <aside class="sidebar fixed inset-y-0 left-0 z-50 flex flex-col transition-transform duration-300 transform -translate-x-full lg:translate-x-0"
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        <div class="p-6">
            <h1 class="text-white font-bold text-lg tracking-tight px-2">Enumbiz School</h1>
            <p class="text-gray-500 text-[11px] font-medium uppercase tracking-widest px-2 mt-1">Panel Administrasi</p>
        </div>

        <nav class="flex-1 flex flex-col gap-1 px-2 mt-4">
            @php
                $nav = [
                    ['name' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => '<rect x="3" y="3" width="7" height="7" /><rect x="14" y="3" width="7" height="7" /><rect x="14" y="14" width="7" height="7" /><rect x="3" y="14" width="7" height="7" />'],
                    ['name' => 'Data Pendaftar', 'route' => 'admin.pendaftar', 'icon' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.87" /><path d="M16 3.13a4 4 0 0 1 0 7.75" />'],
                    ['name' => 'Seleksi', 'route' => 'admin.seleksi', 'icon' => '<circle cx="12" cy="12" r="10" /><path d="m9 12 2 2 4-4" />'],
                    ['name' => 'Manajemen Staf', 'route' => 'admin.staf.index', 'icon' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M17 3.13a4 4 0 0 1 0 7.75"/>'],
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
                    <p class="text-[10px] text-gray-400 truncate uppercase tracking-tighter">{{ auth()->user()->role }}</p>
                </div>
                <button type="button" @click="triggerConfirm('Keluar dari Akun Admin?', () => document.getElementById('logout-form').submit())" class="text-gray-500 hover:text-white transition-opacity duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" /><polyline points="16 17 21 12 16 7" /><line x1="21" y1="12" x2="9" y2="12" /></svg>
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </div>
    </aside>

    <!-- Mobile Header -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white border-b border-[#e2e8f0] flex items-center justify-between px-6 z-40 lg:hidden">
        <h1 class="font-bold text-[#111827]">Enumbiz Admin</h1>
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

    <!-- Modal Konfirmasi Global -->
    <div x-show="confirmModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#111827]/60 backdrop-blur-sm" style="display: none;" x-transition>
        <div class="bg-white border border-[#e2e8f0] rounded-lg shadow-2xl w-full max-w-sm overflow-hidden animate-in fade-in zoom-in duration-200">
            <div class="p-4 border-b border-[#f1f5f9] flex justify-between items-center bg-slate-50">
                <span class="text-[10px] font-black text-[#111827] uppercase tracking-widest">Sistem Validasi Tindakan</span>
                <button @click="confirmModal = false" class="text-gray-400 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="p-8 text-center space-y-4">
                <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <h4 class="text-sm font-bold text-[#111827]" x-text="confirmTitle"></h4>
                <p class="text-xs text-gray-500">Tindakan ini permanen dan tidak dapat dibatalkan. Apakah Anda yakin ingin melanjutkan?</p>
            </div>
            <div class="p-4 bg-slate-50 border-t border-[#f1f5f9] grid grid-cols-2 gap-3">
                <button @click="confirmModal = false" class="px-4 py-3 bg-white border border-[#d1d5db] rounded text-[10px] font-bold uppercase tracking-widest hover:bg-gray-100 transition-colors">Batal</button>
                <button @click="confirmAction(); confirmModal = false" class="px-4 py-3 bg-[#dc2626] text-white rounded text-[10px] font-bold uppercase tracking-widest hover:bg-black transition-colors shadow-lg shadow-red-900/20">Lanjutkan</button>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-[#111827]/40 z-40 lg:hidden transition-opacity duration-200"></div>

    @stack('modals')
</body>
</html>
