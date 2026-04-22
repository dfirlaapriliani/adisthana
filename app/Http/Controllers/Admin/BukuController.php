<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
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
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $buku = $query->orderBy('judul')->paginate(100); // Ambil semua untuk DataTable client-side
        
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('admin.buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'penerbit' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'kategori_id' => 'nullable|exists:kategori,id',  // ← TAMBAHKAN
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $validated['status'] = 'available';

        Book::create($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $buku)
    {
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Book $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function update(Request $request, Book $buku)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'penerbit' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'kategori_id' => 'nullable|exists:kategori,id',  // ← TAMBAHKAN
        ]);

        if ($request->hasFile('foto')) {
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $validated['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $validated['status'] = $validated['stok'] > 0 ? 'available' : 'unavailable';

        $buku->update($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $buku)
    {
        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }
        
        $buku->delete();
        
        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}