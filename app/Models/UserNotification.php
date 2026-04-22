<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';
    
    protected $fillable = [
        'user_id',
        'booking_id',
        'title',
        'message',
        'type',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public static function sendNotification($userId, $title, $message, $type = 'info', $bookingId = null)
    {
        return self::create([
            'user_id' => $userId,
            'booking_id' => $bookingId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }
}