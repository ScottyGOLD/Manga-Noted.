<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MangaController;
use Illuminate\Support\Facades\Route;

// Halaman utama (Daftar Manga)
Route::get('/', [MangaController::class, 'index'])->name('manga.index');

// Halaman & Proses Tambah Data
Route::get('/manga/create', [MangaController::class, 'create'])->name('manga.create');
Route::post('/manga', [MangaController::class, 'store'])->name('manga.store');

// Halaman & Proses Edit Data
Route::get('/manga/{manga}/edit', [MangaController::class, 'edit'])->name('manga.edit');
Route::put('/manga/{manga}', [MangaController::class, 'update'])->name('manga.update');

// Proses Hapus Data
Route::delete('/manga/{manga}', [MangaController::class, 'destroy'])->name('manga.destroy');

// Proses Increment Chapter
Route::patch('/manga/{manga}/increment-chapter', [MangaController::class, 'incrementChapter'])->name('manga.increment');

// Route untuk halaman login dan register hanya bisa diakses oleh guest (belum login)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk halaman yang hanya bisa diakses oleh user yang sudah login
Route::middleware('auth')->group(function () {
    
    // Halaman utama Tracker kamu masukkan ke dalam sini
    Route::get('/', [MangaController::class, 'index'])->name('manga.index');
    Route::resource('manga', MangaController::class)->except(['index']);

    // Tombol Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});