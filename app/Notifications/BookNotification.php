<?php
// app/Notifications/BookNotification.php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookNotification extends Notification
{
    use Queueable;

    protected $book;
    protected $action;

    public function __construct(Book $book, $action)
    {
        $this->book = $book;
        $this->action = $action;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $actions = [
            'created' => ['📖', 'Buku Baru Ditambahkan'],
            'updated' => ['✏️', 'Buku Diperbarui'],
            'deleted' => ['🗑️', 'Buku Dihapus']
        ];

        return [
            'title' => "{$actions[$this->action][0]} {$actions[$this->action][1]}",
            'message' => "Buku \"{$this->book->judul}\" telah di{$this->action}",
            'book_id' => $this->book->id,
            'type' => "book_{$this->action}",
            'icon' => $actions[$this->action][0],
            'url' => $this->action !== 'deleted' ? route('admin.buku.show', $this->book->id) : null
        ];
    }
}