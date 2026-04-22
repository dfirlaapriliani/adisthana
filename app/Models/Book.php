<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'pengarang',
        'tahun_terbit',
        'penerbit',
        'stok',
        'deskripsi',
        'foto',
        'status',
        'kategori_id',  // ← PASTIKAN INI ADA
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'stok' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available' && $this->stok > 0;
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')->where('stok', '>', 0);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}