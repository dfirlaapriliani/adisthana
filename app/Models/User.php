<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'identifier',
        'phone',
        'room_location',
        'office_hours',
        'is_blocked',
        'block_reason',  // tambah ini
        'penalty_until',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_blocked' => 'boolean',
        ];
    }

    public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function isPeminjam(): bool
{
    return $this->role === 'peminjam';
}
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function hasActivePenalty(): bool
    {
        return $this->penalty_until && now()->lt($this->penalty_until);
    }

    public function getRemainingPenaltyDaysAttribute(): int
    {
        if (!$this->hasActivePenalty()) {
            return 0;
        }
        return now()->diffInDays($this->penalty_until) + 1;
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    // Generate kode kelas otomatis
    public static function generateClassCode(): string
    {
        $lastUser = self::whereNotNull('class_code')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastUser || !$lastUser->class_code) {
            return 'KLS-001';
        }

        // Extract angka dari kode terakhir
        preg_match('/KLS-(\d+)/', $lastUser->class_code, $matches);
        $lastNumber = isset($matches[1]) ? (int) $matches[1] : 0;
        $newNumber = $lastNumber + 1;

        return 'KLS-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}