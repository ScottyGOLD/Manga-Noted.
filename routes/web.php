<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MangaController;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. ROUTE KHUSUS TAMU (Belum Login)
// =========================================================================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// =========================================================================
// 2. ROUTE KHUSUS USER TERDAFTAR (Sudah Login)
// =========================================================================
Route::middleware('auth')->group(function () {
    // Halaman Utama / Dashboard Tracker
    Route::get('/', [MangaController::class, 'index'])->name('manga.index');
    
    // Rute Pencarian Library Eksternal (AniList / Manga Database)
    Route::get('/manga/search-library', [MangaController::class, 'searchLibrary'])->name('manga.search.library');
    Route::get('/manga/proxy-cover', [MangaController::class, 'proxyCover'])->name('manga.proxy.cover');

    // Rute Custom untuk Fitur Tambah Chapter (Taruh di atas resource)
    Route::patch('/manga/{manga}/increment-chapter', [MangaController::class, 'incrementChapter'])->name('manga.increment');

    // Rute CRUD Otomatis (Create, Store, Edit, Update, Destroy, Show)
    Route::resource('manga', MangaController::class)->except(['index']);

    // Tombol Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});