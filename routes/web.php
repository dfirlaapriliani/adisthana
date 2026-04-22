<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peminjam\{
    BukuController as PeminjamBukuController,
    PeminjamanController as PeminjamPeminjamanController,
    NotificationController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    BukuController as AdminBukuController,
    UserController as AdminUserController,
    PeminjamanController as AdminPeminjamanController,
    AccountRequestController as AdminAccountRequestController
};


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('landing');

// Public routes - Permohonan Akun
Route::get('/permohonan', [AccountRequestController::class, 'create'])->name('permohonan.create');
Route::post('/permohonan', [AccountRequestController::class, 'store'])->name('permohonan.store');
Route::get('/permohonan/sukses', [AccountRequestController::class, 'sukses'])->name('permohonan.sukses');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Buku Management
        Route::resource('buku', AdminBukuController::class);
        
        // Users Management (Akun Peminjam)
        Route::resource('users', AdminUserController::class);
        Route::post('users/{user}/toggle-block', [AdminUserController::class, 'toggleBlock'])->name('users.toggle-block');
        Route::post('users/{user}/clear-penalty', [AdminUserController::class, 'clearPenalty'])->name('users.clear-penalty');
        
        // Peminjaman Management
        Route::get('peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('peminjaman/{peminjaman}', [AdminPeminjamanController::class, 'show'])->name('peminjaman.show');
        Route::post('peminjaman/{peminjaman}/setujui', [AdminPeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
        Route::post('peminjaman/{peminjaman}/tolak', [AdminPeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
        Route::post('peminjaman/{peminjaman}/kembalikan', [AdminPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
        
        // Account Requests (Permohonan Akun)
        Route::get('/account-requests', [AdminAccountRequestController::class, 'index'])->name('account-requests.index');
        Route::patch('/account-requests/{id}/setujui', [AdminAccountRequestController::class, 'setujui'])->name('account-requests.setujui');
        Route::patch('/account-requests/{id}/tolak', [AdminAccountRequestController::class, 'tolak'])->name('account-requests.tolak');
        
        // Riwayat
        Route::get('riwayat', function () {
            return view('admin.history.index');
        })->name('riwayat.index');
    });

/*
|--------------------------------------------------------------------------
| Peminjam Routes
|--------------------------------------------------------------------------
*/

Route::prefix('peminjam')
    ->name('peminjam.')
    ->middleware(['auth', 'peminjam', 'check.blocked'])
    ->group(function () {
        
        Route::get('/dashboard', function () {
            return view('peminjam.dashboard');
        })->name('dashboard');
        
        // Buku
        Route::get('buku', [PeminjamBukuController::class, 'index'])->name('buku.index');
        Route::get('buku/{buku}', [PeminjamBukuController::class, 'show'])->name('buku.show');
        
        // Peminjaman
        Route::resource('peminjaman', PeminjamPeminjamanController::class)->except(['destroy']);
        Route::post('peminjaman/{peminjaman}/batal', [PeminjamPeminjamanController::class, 'batal'])->name('peminjaman.batal');
        
        // Notifikasi
        Route::get('notifikasi', [NotificationController::class, 'index'])->name('notifikasi.index');
        Route::post('notifikasi/{id}/baca', [NotificationController::class, 'markAsRead'])->name('notifikasi.baca');
        Route::post('notifikasi/baca-semua', [NotificationController::class, 'markAllAsRead'])->name('notifikasi.baca-semua');
        
        // Riwayat
        Route::get('riwayat', function () {
            return view('peminjam.history.index');
        })->name('riwayat.index');
    });

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('landing');
});