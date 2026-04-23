<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\UserNotification;
class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::withCount('books');
        
        if ($request->has('cari') && $request->cari != '') {
            $cari = $request->cari;
            $query->where('nama', 'like', "%{$cari}%");
        }
        
        $kategori = $query->orderBy('nama')->paginate(10);
        
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        
        $kategori = Kategori::create($validated);

        // NOTIFIKASI KE ADMIN LAIN
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'category_id' => $kategori->id,
                'title' => '🏷️ Kategori Baru',
                'message' => auth()->user()->name . ' menambahkan kategori "' . $kategori->nama . '"',
                'type' => 'category_created',
                'icon' => '🏷️',
                'url' => route('admin.kategori.index'),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100|unique:kategori,nama,' . $kategori->id
        ]);

        $oldName = $kategori->nama;
        $validated['slug'] = Str::slug($validated['nama']);
        $kategori->update($validated);

        // NOTIFIKASI KE ADMIN LAIN
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'category_id' => $kategori->id,
                'title' => '✏️ Kategori Diperbarui',
                'message' => auth()->user()->name . ' mengubah kategori "' . $oldName . '" menjadi "' . $kategori->nama . '"',
                'type' => 'category_updated',
                'icon' => '✏️',
                'url' => route('admin.kategori.index'),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $nama = $kategori->nama;
        $kategori->delete();

        // NOTIFIKASI KE ADMIN LAIN
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'title' => '🗑️ Kategori Dihapus',
                'message' => auth()->user()->name . ' menghapus kategori "' . $nama . '"',
                'type' => 'category_deleted',
                'icon' => '🗑️',
                'url' => route('admin.kategori.index'),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}