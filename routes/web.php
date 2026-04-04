<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SeleksiController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\DataDiriController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Halaman Utama)
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('portal'))->name('home');

/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya Guest / Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest.redirect')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    
    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Private Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'prevent-back'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ─── Grup PENDAFTAR (prefix /dashboard) ─────────────────────────
    Route::middleware('role:PENDAFTAR')
        ->prefix('dashboard')
        ->name('pendaftar.')
        ->group(function () {
            Route::get('/', [PendaftarController::class, 'dashboard'])->name('dashboard');
            
            // Berkas & Data Diri
            Route::get('/berkas', [BerkasController::class, 'index'])->name('berkas');
            Route::post('/berkas', [BerkasController::class, 'storeDocuments'])->name('berkas.store')->middleware('register_period');
            Route::get('/data-diri', [DataDiriController::class, 'index'])->name('data-diri');
            Route::post('/data-diri', [BerkasController::class, 'storeIdentity'])->name('data-diri.store')->middleware('register_period');

            // Hasil Seleksi
            Route::get('/status-seleksi', [SeleksiController::class, 'pendaftarStatus'])->name('status-seleksi');

            // Pengaturan Akun
            Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
            Route::post('/pengaturan/profil', [PengaturanController::class, 'updateProfil'])->name('pengaturan.profil');
            Route::post('/pengaturan/password', [PengaturanController::class, 'updatePassword'])->name('pengaturan.password');
        });

    // ─── Grup PANITIA (prefix /admin) ──────────────────────────────
    Route::middleware('role:PANITIA')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            
            // Verifikasi & CRUD Pendaftar
            Route::get('/pendaftar', [AdminController::class, 'pendaftar'])->name('pendaftar');
            Route::get('/pendaftar/create', [AdminController::class, 'pendaftarCreate'])->name('pendaftar.create');
            Route::post('/pendaftar', [AdminController::class, 'pendaftarStore'])->name('pendaftar.store');
            Route::get('/pendaftar/{id}', [AdminController::class, 'showPendaftar'])->name('pendaftar.show');
            Route::get('/pendaftar/{id}/edit', [AdminController::class, 'pendaftarEdit'])->name('pendaftar.edit');
            Route::put('/pendaftar/{id}', [AdminController::class, 'pendaftarUpdate'])->name('pendaftar.update');
            Route::delete('/pendaftar/{id}', [AdminController::class, 'pendaftarDestroy'])->name('pendaftar.destroy');
            Route::post('/pendaftar/{id}/validate', [AdminController::class, 'validateBerkas'])->name('berkas.validate');
            
            // Penilaian Seleksi
            Route::get('/seleksi', [SeleksiController::class, 'adminIndex'])->name('seleksi');
            Route::post('/seleksi', [SeleksiController::class, 'store'])->name('seleksi.store');
            Route::patch('/seleksi/{id}/status', [SeleksiController::class, 'updateStatus'])->name('seleksi.status');

            // Manajemen Staf Panitia (CRUD Admin)
            Route::get('/staf', [AdminController::class, 'stafIndex'])->name('staf.index');
            Route::post('/staf', [AdminController::class, 'stafStore'])->name('staf.store');
            Route::put('/staf/{id}', [AdminController::class, 'stafUpdate'])->name('staf.update');
            Route::delete('/staf/{id}', [AdminController::class, 'stafDestroy'])->name('staf.destroy');

            // Arsip Seleksi & Reset Sistem
            Route::get('/arsip', [SeleksiController::class, 'archiveIndex'])->name('arsip.index');
            Route::post('/arsip', [SeleksiController::class, 'archiveStore'])->name('arsip.store');
            Route::post('/seleksi/otomatis', [SeleksiController::class, 'archiveOtomatis'])->name('seleksi.otomatis');

            // Manajemen Periode
            Route::get('/periode', [AdminController::class, 'periodeIndex'])->name('periode.index');
            Route::post('/periode', [AdminController::class, 'periodeStore'])->name('periode.store');
            Route::put('/periode/{id}', [AdminController::class, 'periodeUpdate'])->name('periode.update');
            Route::delete('/periode/{id}', [AdminController::class, 'periodeDestroy'])->name('periode.destroy');
        });
});