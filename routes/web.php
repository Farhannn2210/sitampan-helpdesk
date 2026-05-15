<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;

// 1. Halaman Login Utama
Route::get('/', function () {
    return view('welcome'); 
})->name('login');

// 2. Dashboard ADMIN FAKULTAS
Route::get('/admin/dashboard', [LaporanController::class, 'adminIndex'])
    ->name('admin.dashboard');

Route::patch('/admin/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])
    ->name('laporan.updateStatus');

Route::delete('/admin/laporan/{laporan}', [LaporanController::class, 'destroy'])
    ->name('laporan.destroy');

// Route Laporan Mahasiswa
Route::post('/mahasiswa/laporan', [LaporanController::class, 'store'])
    ->name('laporan.store');

// 3. Dashboard MAHASISWA
Route::get('/mahasiswa/dashboard', [LaporanController::class, 'mahasiswaIndex'])
    ->name('mahasiswa.dashboard');

// 4. Halaman Form Pengaduan
Route::get('/mahasiswa/buat-aduan', function () {
    return view('pengaduan');
})->name('mahasiswa.buat-aduan');