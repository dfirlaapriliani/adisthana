<?php
// app/Notifications/NewUserRegisteredNotification.php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserRegisteredNotification extends Notification implements ShouldQueue
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
            'title' => '👤 User Baru Terdaftar',
            'message' => "{$this->user->name} ({$this->user->class_code}) telah mendaftar dan menunggu persetujuan",
            'user_id' => $this->user->id,
            'type' => 'user_registered',
            'icon' => '👤',
            'url' => route('admin.users.show', $this->user->id)
        ];
    }
}