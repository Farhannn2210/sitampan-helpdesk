<?php

use Illuminate\Support\Facades\Route;

// 1. Halaman Login Utama
Route::get('/', function () {
    return view('welcome'); 
})->name('login');

// 2. Dashboard ADMIN FAKULTAS
Route::get('/admin/dashboard', function () {
    return view('dashboard'); 
})->name('admin.dashboard');

// 3. Dashboard MAHASISWA
Route::get('/mahasiswa/dashboard', function () {
    return view('mahasiswa_dashboard'); 
})->name('mahasiswa.dashboard');

// 4. Halaman Form Pengaduan
Route::get('/mahasiswa/buat-aduan', function () {
    return view('pengaduan');
})->name('mahasiswa.buat-aduan');