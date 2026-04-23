<?php
// app/Notifications/CategoryNotification.php

namespace App\Notifications;

use App\Models\Kategori;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CategoryNotification extends Notification
{
    use Queueable;

    protected $category;
    protected $action;

    public function __construct(Kategori $category, $action)
    {
        $this->category = $category;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $actions = [
            'created' => ['🏷️', 'Kategori Baru'],
            'updated' => ['✏️', 'Kategori Diperbarui'],
            'deleted' => ['🗑️', 'Kategori Dihapus']
        ];

        return [
            'title' => "{$actions[$this->action][0]} {$actions[$this->action][1]}",
            'message' => "Kategori \"{$this->category->nama}\" telah di{$this->action}",
            'category_id' => $this->category->id,
            'type' => "category_{$this->action}",
            'icon' => $actions[$this->action][0],
            'url' => $this->action !== 'deleted' ? route('admin.kategori.index') : null
        ];
    }
}