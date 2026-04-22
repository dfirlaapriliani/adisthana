<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('kategori')->where('status', 'available')->where('stok', '>', 0);
        
        if ($request->has('cari')) {
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
        
        $buku = $query->orderBy('judul')->paginate(100);
        
        return view('peminjam.buku.index', compact('buku'));
    }

    public function show(Book $buku)
    {
        return view('peminjam.buku.show', compact('buku'));
    }
}