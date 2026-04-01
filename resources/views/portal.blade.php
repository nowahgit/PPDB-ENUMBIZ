<!DOCTYPE html>
<html lang="id" class="light">

<head>
    <script>
        // Check local storage or system preference to apply the theme before everything else
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        }
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal PPDB Enumbiz School</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite + Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom white theme */
        .bg-snpmb { background-color: #ffffff; }
        .text-snpmb-gray { color: #64748b; }
        .btn-snpmb-blue { background-color: #2563eb; }
        .btn-snpmb-blue:hover { background-color: #1d4ed8; }
        .btn-snpmb-dark { background-color: #f8fafc; }
        .btn-snpmb-dark:hover { background-color: #f1f5f9; }

        /* Dark mode overrides */
        .dark .bg-snpmb { background-color: #171d2b; }
        .dark .text-snpmb-gray { color: #8e9aab; }
        .dark .btn-snpmb-blue { background-color: #3b82f6; } /* Standard Tailwind Blue 500 equivalent */
        .dark .btn-snpmb-blue:hover { background-color: #2563eb; }
        .dark .btn-snpmb-dark { background-color: #262c38; }
        .dark .btn-snpmb-dark:hover { background-color: #323a49; }
    </style>
</head>

<body class="bg-snpmb text-gray-900 dark:text-white min-h-screen flex flex-col antialiased transition-colors duration-300">

    <!-- Header -->
    <header class="flex justify-between items-center px-8 py-6 lg:px-16 w-full">
        <div class="flex items-center">
          
        </div>

        <div>
            <!-- Dark/Light Mode Toggle Icon -->
            <button id="theme-toggle" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors p-2 rounded-lg bg-gray-100 dark:bg-gray-800 focus:outline-none">
                <!-- Moon icon (for light mode) -->
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <!-- Sun icon (for dark mode) -->
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-8 lg:px-16 w-full relative">
        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            <!-- Left Side: Copywriting -->
            <div class="space-y-6 z-10">


                <h1 class="text-4xl lg:text-5xl font-extrabold leading-[1.1] tracking-tight text-gray-900 dark:text-white mb-4">
                    Raih masa depanmu di Portal PPDB Enumbiz
                </h1>

                <p class="text-snpmb-gray text-base lg:text-lg max-w-lg leading-relaxed">
                    Bergabunglah dengan ratusan siswa yang telah mewujudkan impian mereka. Akses informasi lengkap,
                    pendaftaran, dan seleksi untuk memasuki sekolah impianmu.
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-4">
                    <a href="{{ route('register') }}"
                        class="btn-snpmb-blue text-white px-6 py-3 rounded-lg text-sm font-bold transition-colors flex items-center gap-2">
                        Mulai Pendaftaran
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="{{ route('login') }}"
                        class="btn-snpmb-dark border border-gray-200 dark:border-gray-700/50 text-gray-700 dark:text-white px-6 py-3 rounded-lg text-sm font-bold transition-colors">
                        Sudah Memiliki Akun? Masuk
                    </a>
                </div>

                <div class="pt-8 space-y-3 text-sm text-snpmb-gray transition-colors duration-300">
                    <p>Baca pengumuman terbaru dan informasi penting di <a href="#"
                            class="text-[#3f79ff] dark:text-blue-400 hover:underline transition-colors">Beranda Enumbiz ↗</a></p>
                    <p>Untuk mengakses laman panduan PPDB bisa melalui link berikut <a href="#"
                            class="text-[#3f79ff] dark:text-blue-400 hover:underline transition-colors">https://ppdb.enumbiz.sch.id/panduan ↗</a></p>
                </div>
            </div>

            <!-- Right Side: Illustration -->
            <div class="hidden lg:flex justify-end items-center relative h-full">
                <!-- Large soft glowing background behind the illustration -->
                <div class="absolute inset-0 bg-blue-50 dark:bg-blue-900/20 blur-3xl rounded-[100px] transform scale-90 z-0 transition-colors duration-300"></div>

               

                    <!-- Placeholder for the actual Vector Illustration -->
                    <div
                        class="relative z-20 ">
                        <img src="{{ asset('images/college-students-rafiki.svg') }}" alt="Ilustrasi PPDB Enumbiz" class="w-full h-auto">
                      
                    </div>

                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="py-8 text-center text-xs text-snpmb-gray w-full mt-auto transition-colors duration-300">
        <p>&copy; {{ date('Y') }} Tim Pelaksana PPDB Enumbiz. v2.0.2. Ilustrasi pendidikan oleh Storyset.</p>
    </footer>

    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('theme')) {
                if (localStorage.getItem('theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }

            // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        });
    </script>
</body>

</html>