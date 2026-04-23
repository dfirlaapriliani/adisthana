<?php
// app/Http/Controllers/Peminjam/PeminjamanController.php

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
        
        // Cek stok
        if ($buku->stok <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang kosong.');
        }
        
        // Cek penalti
        if (auth()->user()->hasActivePenalty()) {
            return back()->with('error', 'Anda sedang dalam masa penalti. Tidak dapat mengajukan peminjaman.');
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
        
        // Cek stok
        if ($buku->stok < $validated['jumlah']) {
            return back()->with('error', 'Stok buku tidak mencukupi. Stok tersedia: ' . $buku->stok);
        }
        
        // Cek penalti
        if (auth()->user()->hasActivePenalty()) {
            return back()->with('error', 'Anda sedang dalam masa penalti.');
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

        // ✅ NOTIFIKASI KE ADMIN: Peminjaman Baru
        UserNotification::sendToAdmins(
            '📚 Pengajuan Peminjaman Baru',
            auth()->user()->name . ' (' . (auth()->user()->class_code ?? 'KLS-') . ') mengajukan peminjaman buku "' . $buku->judul . '" (' . $validated['jumlah'] . ' buku)',
            'booking_created',
            [
                'booking_id' => $peminjaman->id,
                'book_id' => $buku->id,
                'icon' => '📚',
                'url' => route('admin.peminjaman.show', $peminjaman->id)
            ]
        );

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function show(Booking $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke peminjaman ini.');
        }
        
        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }

    public function batal(Booking $peminjaman)
    {
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses.');
        }
        
        if (!in_array($peminjaman->status, ['pending', 'approved'])) {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan.');
        }

        $peminjaman->update(['status' => 'cancelled']);

        // ✅ NOTIFIKASI KE ADMIN: Peminjaman Dibatalkan
        UserNotification::sendToAdmins(
            '❌ Peminjaman Dibatalkan',
            auth()->user()->name . ' membatalkan peminjaman buku "' . $peminjaman->book->judul . '"',
            'booking_cancelled',
            [
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'icon' => '❌',
                'url' => route('admin.peminjaman.show', $peminjaman->id)
            ]
        );

        return redirect()->route('peminjam.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dibatalkan.');
    }
}