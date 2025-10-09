<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MuridController;
use App\Http\Controllers\Admin\PresensiController as AdminPresensiController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\KontakController as AdminKontakController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\PresensiController as StudentPresensiController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/check-session', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => Auth::user() ? [
            'id' => Auth::user()->id,
            'role' => Auth::user()->role
        ] : null
    ]);
})->name('check.session');




// ===========================
// LANDING PAGE ROUTES
// ===========================
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/tentang', [LandingController::class, 'tentang'])->name('tentang');
Route::get('/berita', [LandingController::class, 'berita'])->name('berita.public');
Route::get('/berita/{id}', [LandingController::class, 'detailBerita'])->name('berita.detail');
Route::get('/kontak', [LandingController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [LandingController::class, 'submitKontak'])->name('kontak.submit');

// ===========================
// CUSTOM LOGIN ROUTES
// ===========================
Route::get('/admin/login', [AuthenticatedSessionController::class, 'createAdmin'])->name('admin.login');
Route::get('/student/login', [AuthenticatedSessionController::class, 'createStudent'])->name('student.login');

// ===========================
// AUTH ROUTES
// ===========================
require __DIR__.'/auth.php';

// ===========================
// ADMIN ROUTES
// ===========================
Route::middleware(['auth', 'role:admin', 'session.timeout'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Kelas Management
    Route::resource('kelas', KelasController::class)->parameters([
        'kelas' => 'kelas'
    ]);

    // Murid Management
    Route::get('murid/export', [MuridController::class, 'export'])->name('murid.export');
    Route::post('murid/import', [MuridController::class, 'import'])->name('murid.import');
    Route::delete('murid/bulk-delete', [MuridController::class, 'bulkDelete'])->name('murid.bulk-delete');
    Route::put('murid/{murid}/reset-password', [MuridController::class, 'resetPassword'])->name('murid.reset-password');
    Route::resource('murid', MuridController::class);

    // Presensi Management
    Route::get('presensi', [AdminPresensiController::class, 'index'])->name('presensi.index');
    Route::get('presensi/rekap', [AdminPresensiController::class, 'rekap'])->name('presensi.rekap');
    Route::get('presensi/detail/{userId}', [AdminPresensiController::class, 'detail'])->name('presensi.detail');
    Route::get('presensi/export', [AdminPresensiController::class, 'export'])->name('presensi.export');
    Route::get('presensi/approval', [AdminPresensiController::class, 'approval'])->name('presensi.approval');
    Route::post('presensi/{id}/approve', [AdminPresensiController::class, 'approve'])->name('presensi.approve');
    Route::post('presensi/{id}/reject', [AdminPresensiController::class, 'reject'])->name('presensi.reject');



    // Berita Management
    Route::resource('berita', AdminBeritaController::class)->parameters([
        'berita' => 'berita'
    ]);

    // Kontak Management - BARU
    Route::get('kontak', [AdminKontakController::class, 'index'])->name('kontak.index');
    Route::get('kontak/{id}', [AdminKontakController::class, 'show'])->name('kontak.show');
    Route::post('kontak/{id}/toggle-display', [AdminKontakController::class, 'toggleDisplay'])->name('kontak.toggle-display');
    Route::post('kontak/{id}/mark-read', [AdminKontakController::class, 'markAsRead'])->name('kontak.mark-read');
    Route::post('kontak/{id}/mark-unread', [AdminKontakController::class, 'markAsUnread'])->name('kontak.mark-unread');
    Route::delete('kontak/{id}', [AdminKontakController::class, 'destroy'])->name('kontak.destroy');
    Route::delete('kontak-bulk-delete', [AdminKontakController::class, 'bulkDelete'])->name('kontak.bulk-delete');
});

// ===========================
// STUDENT ROUTES
// ===========================
Route::middleware(['auth', 'role:student', 'session.timeout'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [StudentDashboardController::class, 'home'])->name('home');

    // Presensi
    Route::get('/presensi', [StudentPresensiController::class, 'index'])->name('presensi');
    Route::post('/presensi/masuk', [StudentPresensiController::class, 'masuk'])->name('presensi.masuk');
    Route::post('/presensi/keluar', [StudentPresensiController::class, 'keluar'])->name('presensi.keluar');
    Route::post('/presensi/izin', [StudentPresensiController::class, 'izin'])->name('presensi.izin');
    Route::post('/presensi/sakit', [StudentPresensiController::class, 'sakit'])->name('presensi.sakit');

    // Profile
    Route::get('/profile', [StudentProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [StudentProfileController::class, 'updatePassword'])->name('profile.password');
});

// ===========================
// PROFILE ROUTES (Original - jika masih digunakan)
// ===========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
