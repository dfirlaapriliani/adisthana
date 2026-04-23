<?php
// app/Models/Book.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'stok',
        'deskripsi',
        'foto',
        'status',
        'kategori_id',
    ];
    
    protected $dates = ['deleted_at'];
    
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
    
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}