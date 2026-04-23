<?php
// app/Notifications/NewBookingNotification.php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewBookingNotification extends Notification implements ShouldQueue
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
            'title' => '📚 Peminjaman Baru',
            'message' => "{$this->booking->user->name} mengajukan peminjaman buku \"{$this->booking->book->judul}\" ({$this->booking->jumlah} buku)",
            'booking_id' => $this->booking->id,
            'type' => 'booking_created',
            'icon' => '📚',
            'url' => route('admin.peminjaman.show', $this->booking->id)
        ];
    }
}