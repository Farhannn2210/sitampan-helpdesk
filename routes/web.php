<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AuthController;

// ==========================================================
// 1. HALAMAN UTAMA (Handle Pengalihan Otomatis)
// ==========================================================
Route::get('/', function () { 
    if (Auth::check()) {
        return Auth::user()->role === 'admin' 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('mahasiswa.dashboard');
    }
    return view('welcome'); 
})->name('index');

// ==========================================================
// 2. HALAMAN PUBLIK (Hanya Untuk yang BELUM Login)
// ==========================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', function () { return view('welcome'); })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', function () { return view('register'); })->name('register');
    Route::post('/register', [AuthController::class, 'registerMahasiswa'])->name('register.post');

    Route::get('/register-admin', function () { return view('register_admin'); })->name('register.admin');
    Route::post('/register-admin', [AuthController::class, 'registerAdmin'])->name('register.admin.post');
});

// ==========================================================
// 3. AREA PROTEKSI (Wajib Login)
// ==========================================================
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/profile', function () { return view('profile'); })->name('profile');
    Route::get('/edit-profile', function () { return view('edit-profile'); })->name('profile.edit');
    Route::post('/edit-profile', function () {
        return redirect()->route('profile')->with('success', 'Data profil berhasil diperbarui!');
    })->name('profile.update');

    // REVISI: Route Cetak PDF (Diletakkan di luar prefix agar bisa diakses Admin & Mahasiswa)
    Route::get('/laporan/{laporan}/cetak', [LaporanController::class, 'cetakPdf'])->name('laporan.cetak');

    // --- AREA MAHASISWA ---
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [LaporanController::class, 'mahasiswaIndex'])->name('mahasiswa.dashboard');
        Route::get('/buat-aduan', function () { return view('pengaduan'); })->name('mahasiswa.buat-aduan');
        
        Route::get('/riwayat', function () {
            $laporans = \App\Models\Laporan::where('user_id', Auth::id())->latest()->get();
            return view('riwayat', compact('laporans'));
        })->name('mahasiswa.riwayat');

        Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
        Route::post('/laporan/{laporan}/pesan', [LaporanController::class, 'mahasiswaSendMessage'])->name('mahasiswa.send_message');
    });

    // --- AREA ADMIN ---
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [LaporanController::class, 'adminIndex'])->name('admin.dashboard');
        Route::post('/laporan/{laporan}/status', [LaporanController::class, 'updateStatus'])->name('admin.laporan.updateStatus');
        Route::post('/laporan/{laporan}/message', [LaporanController::class, 'adminSendMessage'])->name('admin.laporan.sendMessage');
        Route::post('/laporan/{laporan}/respon-ai', [LaporanController::class, 'generateResponAi'])->name('laporan.generateResponAi');
        Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    });
});