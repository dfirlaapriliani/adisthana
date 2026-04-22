<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Peminjam\{
    FacilityController as PeminjamFacilityController,
    BookingController as PeminjamBookingController,
    ScheduleController as PeminjamScheduleController,
    NotificationController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    FacilityController as AdminFacilityController,
    UserController as AdminUserController,
    BookingController as AdminBookingController,
    VerificationController,
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
        
        // Facilities Management
        Route::resource('facilities', AdminFacilityController::class);
        
        // Users Management (Akun Peminjam)
        Route::resource('users', AdminUserController::class);
        Route::post('users/{user}/toggle-block', [AdminUserController::class, 'toggleBlock'])->name('users.toggle-block');
        Route::post('users/{user}/clear-penalty', [AdminUserController::class, 'clearPenalty'])->name('users.clear-penalty');
        
        // Bookings Management
        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::post('bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
        Route::post('bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
        
        // Photo Verification
        Route::get('verifications', [VerificationController::class, 'index'])->name('verifications.index');
        Route::post('verifications/{booking}/verify', [VerificationController::class, 'verify'])->name('verifications.verify');
        Route::post('verifications/{booking}/reject', [VerificationController::class, 'reject'])->name('verifications.reject');
        Route::post('verifications/{booking}/force-complete', [VerificationController::class, 'forceComplete'])->name('verifications.force-complete');
        
        // Account Requests (Permohonan Akun)
        Route::get('/account-requests', [AdminAccountRequestController::class, 'index'])->name('account-requests.index');
        Route::patch('/account-requests/{id}/approve', [AdminAccountRequestController::class, 'approve'])->name('account-requests.approve');
        Route::patch('/account-requests/{id}/reject', [AdminAccountRequestController::class, 'reject'])->name('account-requests.reject');
        
        // History
        Route::get('history', function () {
            return view('admin.history.index');
        })->name('history.index');
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
        
        // Facilities
        Route::get('facilities', [PeminjamFacilityController::class, 'index'])->name('facilities.index');
        Route::get('facilities/{facility}', [PeminjamFacilityController::class, 'show'])->name('facilities.show');
        Route::get('facilities/{facility}/slots', [PeminjamFacilityController::class, 'getAvailableSlots'])->name('facilities.slots');
        
        // Bookings
        Route::resource('bookings', PeminjamBookingController::class)->except(['destroy']);
        Route::post('bookings/{booking}/cancel', [PeminjamBookingController::class, 'cancel'])->name('bookings.cancel');
        Route::get('bookings/{booking}/upload-photo', [PeminjamBookingController::class, 'uploadPhoto'])->name('bookings.upload-photo');
        Route::post('bookings/{booking}/store-photo', [PeminjamBookingController::class, 'storePhoto'])->name('bookings.store-photo');
        
        // Schedules
        Route::get('schedules', [PeminjamScheduleController::class, 'index'])->name('schedules.index');
        Route::get('schedules/events', [PeminjamScheduleController::class, 'calendarEvents'])->name('schedules.events');
        
        // Notifications
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        
        // History
        Route::get('history', function () {
            return view('peminjam.history.index');
        })->name('history.index');
    });

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('landing');
});