<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Booking;
use App\Models\Book;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->bookings()->with('book');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $peminjaman = $query->latest()->paginate(10);

        return view('peminjam.peminjaman.index', compact('peminjaman'));
    }

    public function create(Request $request)
    {
        $buku = Book::findOrFail($request->buku_id);
        
        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang kosong.');
        }

        return view('peminjam.peminjaman.create', compact('buku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:books,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'catatan' => 'nullable|string|max:500',
        ]);

        $buku = Book::findOrFail($validated['buku_id']);
        
        if ($buku->stok < $validated['jumlah']) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        $peminjaman = Booking::create([
            'user_id' => auth()->id(),
            'book_id' => $validated['buku_id'],
            'jumlah' => $validated['jumlah'],
            'tanggal_pinjam' => $validated['tanggal_pinjam'],
            'tanggal_kembali' => $validated['tanggal_kembali'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'pending',
        ]);

        // Notifikasi ke admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            UserNotification::sendNotification(
                $admin->id,
                'Pengajuan Peminjaman Baru',
                auth()->user()->name . ' mengajukan peminjaman buku "' . $buku->judul . '"',
                'info',
                $peminjaman->id
            );
        }

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function show(Booking $peminjaman)
    {
        // Cek kepemilikan
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }
        
        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }

    public function batal(Booking $peminjaman)
    {
        // Cek kepemilikan
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        
        if (!in_array($peminjaman->status, ['pending', 'approved'])) {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan.');
        }

        $peminjaman->update(['status' => 'cancelled']);

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibatalkan.');
    }
}