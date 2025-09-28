<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MuridController;
use App\Http\Controllers\Admin\PresensiController as AdminPresensiController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\PresensiController as StudentPresensiController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// Landing Page Routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/tentang', [LandingController::class, 'tentang'])->name('tentang');
Route::get('/berita', [LandingController::class, 'berita'])->name('berita.public');
Route::get('/berita/{id}', [LandingController::class, 'detailBerita'])->name('berita.detail');
Route::get('/kontak', [LandingController::class, 'kontak'])->name('kontak');

// Custom Login Routes
Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
Route::get('/student/login', [AuthenticatedSessionController::class, 'createStudent'])->name('student.login');

require __DIR__.'/auth.php';

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelas Management
    Route::resource('kelas', KelasController::class);

    // Murid Management
    Route::resource('murid', MuridController::class);
    Route::post('murid/import', [MuridController::class, 'import'])->name('murid.import');

    // Presensi Management
    Route::get('presensi', [AdminPresensiController::class, 'index'])->name('presensi.index');
    Route::get('presensi/rekap', [AdminPresensiController::class, 'rekap'])->name('presensi.rekap');
    Route::get('presensi/export', [AdminPresensiController::class, 'export'])->name('presensi.export');

    // Berita Management
    Route::resource('berita', AdminBeritaController::class);
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [StudentDashboardController::class, 'home'])->name('home');

    // Presensi
    Route::get('/presensi', [StudentPresensiController::class, 'index'])->name('presensi');
    Route::post('/presensi/masuk', [StudentPresensiController::class, 'masuk'])->name('presensi.masuk');
    Route::post('/presensi/keluar', [StudentPresensiController::class, 'keluar'])->name('presensi.keluar');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
