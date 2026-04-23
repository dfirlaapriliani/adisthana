<?php
// app/Http/Controllers/Peminjam/BukuController.php

namespace App\Http\Controllers\Peminjam;

use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        // ✅ Hanya tampilkan buku yang TIDAK dihapus
        $query = Book::with('kategori');
        
        if ($request->has('cari') && $request->cari != '') {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('pengarang', 'like', "%{$cari}%")
                  ->orWhere('penerbit', 'like', "%{$cari}%");
            });
        }
        
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }
        
        $buku = $query->where('status', 'available')
            ->where('stok', '>', 0)
            ->orderBy('judul')
            ->paginate(12);
            
        return view('peminjam.buku.index', compact('buku'));
    }

    public function show(Book $buku)
    {
        // ✅ Buku yang sudah dihapus tidak bisa diakses peminjam
        if ($buku->trashed()) {
            abort(404);
        }
        
        $buku->load('kategori');
        return view('peminjam.buku.show', compact('buku'));
    }
}