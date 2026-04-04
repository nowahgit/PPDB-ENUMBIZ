<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Terkirim — Enumbiz School</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Public Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col items-center justify-center min-h-screen p-6 text-center">

    <div class="w-full max-w-xl bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-10 space-y-6">
            <div class="flex justify-center">
                <div class="p-4 bg-green-100 text-green-600 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488a4.5 4.5 0 01-4.178 0L3.433 11.887A2.25 2.25 0 012.25 9.906V9m19.5 0a2.25 2.25 0 00-2.25-2.25h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                    </svg>
                </div>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-gray-800">Email Pemulihan Terkirim</h1>
                <p class="text-sm text-gray-600 mt-2">
                    Instruksi reset password telah dikirim ke alamat email terdaftar Anda.
                </p>
            </div>

            <div class="pt-6">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-500">
                    Selesai & Kembali ke Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>
