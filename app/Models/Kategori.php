<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    
    protected $fillable = [
        'nama',
        'slug',
    ];

    // Auto generate slug saat create/update
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama);
        });
        
        static::updating(function ($kategori) {
            $kategori->slug = Str::slug($kategori->nama);
        });
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}