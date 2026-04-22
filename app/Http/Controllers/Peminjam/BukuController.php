<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::where('status', 'available')->where('stok', '>', 0);
        
        if ($request->has('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                  ->orWhere('pengarang', 'like', "%{$cari}%")
                  ->orWhere('penerbit', 'like', "%{$cari}%");
            });
        }
        
        $buku = $query->orderBy('judul')->paginate(12);
        
        return view('peminjam.buku.index', compact('buku'));
    }

    public function show(Book $buku)
    {
        return view('peminjam.buku.show', compact('buku'));
    }
}