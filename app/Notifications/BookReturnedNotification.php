<?php
// app/Notifications/BookReturnedNotification.php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookReturnedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => '✅ Buku Dikembalikan',
            'message' => "{$this->booking->user->name} telah mengembalikan buku \"{$this->booking->book->judul}\"",
            'booking_id' => $this->booking->id,
            'type' => 'booking_returned',
            'icon' => '✅',
            'url' => route('admin.peminjaman.show', $this->booking->id)
        ];
    }
}