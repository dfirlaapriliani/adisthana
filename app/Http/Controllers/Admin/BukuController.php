<?php
// app/Http/Controllers/Admin/BukuController.php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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
        
        $buku = $query->orderBy('judul')->paginate(100);
        $kategori = \App\Models\Kategori::orderBy('nama')->get();
        
        return view('admin.buku.index', compact('buku', 'kategori'));
    }

    public function create()
    {
        $kategori = \App\Models\Kategori::orderBy('nama')->get();
        return view('admin.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|min:1900|max:' . date('Y'),
            'penerbit' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'kategori_id' => 'nullable|exists:kategori,id',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $validated['status'] = 'available';

        $buku = Book::create($validated);

        // NOTIFIKASI: BUKU BARU
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'book_id' => $buku->id,
                'title' => '📖 Buku Baru Ditambahkan',
                'message' => auth()->user()->name . ' menambahkan buku "' . $buku->judul . '" oleh ' . $buku->pengarang,
                'type' => 'book_created',
                'icon' => '📖',
                'url' => route('admin.buku.show', $buku->id),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Book $buku)
    {
        $buku->load('kategori');
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Book $buku)
    {
        $kategori = \App\Models\Kategori::orderBy('nama')->get();
        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Book $buku)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|numeric|min:1900|max:' . date('Y'),
            'penerbit' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'kategori_id' => 'nullable|exists:kategori,id',
        ]);

        if ($request->hasFile('foto')) {
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $validated['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $validated['status'] = $validated['stok'] > 0 ? 'available' : 'unavailable';

        $buku->update($validated);

        // NOTIFIKASI: BUKU DIEDIT
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'book_id' => $buku->id,
                'title' => '✏️ Buku Diperbarui',
                'message' => auth()->user()->name . ' memperbarui buku "' . $buku->judul . '"',
                'type' => 'book_updated',
                'icon' => '✏️',
                'url' => route('admin.buku.show', $buku->id),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $buku)
    {
        $judul = $buku->judul;
        $pengarang = $buku->pengarang;
        
        // ✅ SOFT DELETE (tidak benar-benar hapus)
        $buku->delete();

        // NOTIFIKASI: BUKU DIHAPUS
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'title' => '🗑️ Buku Dihapus',
                'message' => auth()->user()->name . ' menghapus buku "' . $judul . '" oleh ' . $pengarang,
                'type' => 'book_deleted',
                'icon' => '🗑️',
                'url' => route('admin.buku.index'),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
    
    // ✅ METHOD RESTORE (Optional - untuk mengembalikan buku yang dihapus)
    public function restore($id)
    {
        $buku = Book::withTrashed()->findOrFail($id);
        $buku->restore();
        
        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dikembalikan.');
    }
    
    // ✅ METHOD FORCE DELETE (Optional - hapus permanen)
    public function forceDelete($id)
    {
        $buku = Book::withTrashed()->findOrFail($id);
        
        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }
        
        $buku->forceDelete();
        
        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku dihapus permanen.');
    }
}