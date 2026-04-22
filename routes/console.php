<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\Schedule;
use App\Models\Booking;
use App\Models\Facility;
use Carbon\Carbon;

Schedule::call(function () {
    // Update approved -> ongoing (jam mulai tiba)
    Booking::where('status', 'approved')
        ->whereRaw("CONCAT(booking_date, ' ', start_time) <= ?", [now()])
        ->each(function ($booking) {
            $booking->update(['status' => 'ongoing']);
            
            // Update fasilitas jadi not_available
            $booking->facility->update(['status' => 'not_available']);
        });

    // Update ongoing -> waiting_proof (jam selesai tiba)
    Booking::where('status', 'ongoing')
        ->whereRaw("CONCAT(booking_date, ' ', end_time) <= ?", [now()])
        ->each(function ($booking) {
            $booking->update(['status' => 'waiting_proof']);
        });

    // Cek telat upload (jam selesai + 1 hari)
    $yesterday = now()->subDay();
    Booking::where('status', 'waiting_proof')
        ->whereRaw("CONCAT(booking_date, ' ', end_time) <= ?", [$yesterday])
        ->each(function ($booking) {
            // Auto reject dan kasih penalti
            $booking->update([
                'status' => 'completed',
                'admin_note' => 'Otomatis selesai karena tidak mengupload foto bukti tepat waktu.'
            ]);
            
            $user = $booking->user;
            $user->update(['penalty_until' => now()->addDays(3)]);
            
            \App\Models\Notification::sendNotification(
                $user->id,
                'Penalti 3 Hari',
                'Anda mendapatkan penalti 3 hari karena tidak mengupload foto bukti tepat waktu.',
                'error',
                $booking->id
            );
        });

    // Cek fasilitas yang bisa di-set available
    Facility::where('status', 'not_available')->each(function ($facility) {
        $activeBooking = $facility->bookings()
            ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification'])
            ->exists();
        
        if (!$activeBooking) {
            $facility->update(['status' => 'available']);
        }
    });
})->everyMinute();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
