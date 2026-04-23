<?php
// app/Notifications/BookingStatusChangedNotification.php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingStatusChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $status;

    public function __construct(Booking $booking, $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $statusMessages = [
            'approved' => 'disetujui',
            'rejected' => 'ditolak',
            'borrowed' => 'sedang dipinjam',
            'returned' => 'dikembalikan'
        ];

        return [
            'title' => '📋 Status Peminjaman',
            'message' => "Admin {$statusMessages[$this->status]} peminjaman buku \"{$this->booking->book->judul}\"",
            'booking_id' => $this->booking->id,
            'type' => 'booking_status_changed',
            'icon' => '📋',
            'url' => route('peminjam.peminjaman.show', $this->booking->id)
        ];
    }
}