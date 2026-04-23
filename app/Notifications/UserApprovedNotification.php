<?php
// app/Notifications/UserApprovedNotification.php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => '✅ Akun Disetujui',
            'message' => "Selamat! Akun Anda telah disetujui. Selamat menggunakan Adisthana!",
            'type' => 'user_approved',
            'icon' => '✅',
            'url' => route('peminjam.dashboard')
        ];
    }
}