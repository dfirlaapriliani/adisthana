<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Peminjam\{
    BukuController as PeminjamBukuController,
    PeminjamanController as PeminjamPeminjamanController,
    NotificationController as PeminjamNotificationController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    BukuController as AdminBukuController,
    UserController as AdminUserController,
    PeminjamanController as AdminPeminjamanController,
    AccountRequestController as AdminAccountRequestController,
    NotificationController as AdminNotificationController
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
        Route::post('buku/{id}/restore', [AdminBukuController::class, 'restore'])->name('buku.restore');
        Route::delete('buku/{id}/force-delete', [AdminBukuController::class, 'forceDelete'])->name('buku.force-delete');
        
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

        // Di dalam group admin
    // Di dalam group admin
Route::post('peminjaman/{peminjaman}/diambil', [AdminPeminjamanController::class, 'diambil'])->name('peminjaman.diambil');

        // Account Requests (Permohonan Akun)
        Route::get('/account-requests', [AdminAccountRequestController::class, 'index'])->name('account-requests.index');
        Route::patch('/account-requests/{id}/setujui', [AdminAccountRequestController::class, 'setujui'])->name('account-requests.setujui');
        Route::patch('/account-requests/{id}/tolak', [AdminAccountRequestController::class, 'tolak'])->name('account-requests.tolak');
        
        // Riwayat
        Route::get('riwayat', function () {
            $riwayat = \App\Models\Booking::with(['user', 'book'])
                ->whereIn('status', ['returned', 'rejected', 'cancelled'])
                ->when(request('filter', 'semua') !== 'semua', fn($q) => $q->where('status', request('filter')))
                ->when(request('cari'), fn($q) => $q->where(function($sq) {
                    $sq->whereHas('user', fn($u) => $u->where('name', 'like', '%'.request('cari').'%'))
                    ->orWhereHas('book', fn($b) => $b->where('judul', 'like', '%'.request('cari').'%'));
                }))
                ->latest()
                ->paginate(15);
                
            return view('admin.history.index', compact('riwayat'));
        })->name('riwayat.index');

        // Kategori Management
        Route::resource('kategori', KategoriController::class);
        
        // Notifikasi
        Route::get('notifikasi', [AdminNotificationController::class, 'index'])->name('notifikasi.index');
        Route::post('notifikasi/{id}/baca', [AdminNotificationController::class, 'markAsRead'])->name('notifikasi.baca');
        Route::post('notifikasi/baca-semua', [AdminNotificationController::class, 'markAllAsRead'])->name('notifikasi.baca-semua');
        Route::get('notifikasi/unread-count', [AdminNotificationController::class, 'getUnreadCount'])->name('notifikasi.unread-count');
        
        // Profile
        Route::get('profile', function () {
            return view('admin.profile.index');
        })->name('profile');
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
        Route::get('notifikasi', [PeminjamNotificationController::class, 'index'])->name('notifikasi.index');
        Route::post('notifikasi/{id}/baca', [PeminjamNotificationController::class, 'markAsRead'])->name('notifikasi.baca');
        Route::post('notifikasi/baca-semua', [PeminjamNotificationController::class, 'markAllAsRead'])->name('notifikasi.baca-semua');
        Route::get('notifikasi/unread-count', [PeminjamNotificationController::class, 'getUnreadCount'])->name('notifikasi.unread-count');
        
        // Riwayat
        Route::get('riwayat', function () {
            $query = auth()->user()->bookings()
                ->with('book')
                ->whereIn('status', ['returned', 'rejected', 'cancelled']);
            
            if (request('filter') && in_array(request('filter'), ['returned', 'rejected', 'cancelled'])) {
                $query->where('status', request('filter'));
            }
            
            $riwayat = $query->latest()->paginate(15);
                
            return view('peminjam.history.index', compact('riwayat'));
        })->name('riwayat.index');
        
        // Profile
        Route::get('profile', function () {
            return view('peminjam.profile.index');
        })->name('profile');
    });

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('landing');
});