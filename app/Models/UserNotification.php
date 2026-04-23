<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';
    
    protected $fillable = [
        'user_id',
        'booking_id',
        'book_id',
        'category_id',
        'title',
        'message',
        'type',
        'icon',
        'url',
        'data',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    // Send notification to single user
    public static function sendToUser($userId, $title, $message, $type = 'info', $options = [])
    {
        return self::create([
            'user_id' => $userId,
            'booking_id' => $options['booking_id'] ?? null,
            'book_id' => $options['book_id'] ?? null,
            'category_id' => $options['category_id'] ?? null,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'icon' => $options['icon'] ?? '📋',
            'url' => $options['url'] ?? null,
            'data' => $options['data'] ?? null,
            'is_read' => false,
        ]);
    }

    // Send notification to ALL admins
    public static function sendToAdmins($title, $message, $type = 'info', $options = [])
    {
        $admins = User::where('role', 'admin')->get();
        
        foreach ($admins as $admin) {
            self::sendToUser($admin->id, $title, $message, $type, $options);
        }
    }

    // Send notification to other admins (except current user)
    public static function sendToOtherAdmins($title, $message, $type = 'info', $options = [])
    {
        $admins = User::where('role', 'admin')
            ->where('id', '!=', auth()->id())
            ->get();
        
        foreach ($admins as $admin) {
            self::sendToUser($admin->id, $title, $message, $type, $options);
        }
    }
}