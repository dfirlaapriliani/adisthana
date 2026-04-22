<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Book;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? 'pending';
        
        $peminjaman = Booking::with(['user', 'book'])
            ->when($status !== 'semua', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        $jumlah = [
            'pending' => Booking::where('status', 'pending')->count(),
            'disetujui' => Booking::where('status', 'approved')->count(),
            'dipinjam' => Booking::where('status', 'borrowed')->count(),
            'dikembalikan' => Booking::where('status', 'returned')->count(),
        ];

        return view('admin.peminjaman.index', compact('peminjaman', 'status', 'jumlah'));
    }

    public function show(Booking $peminjaman)
    {
        $peminjaman->load(['user', 'book']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function setujui(Booking $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman pending yang bisa disetujui.');
        }

        $buku = $peminjaman->book;
        
        if ($buku->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }

        // Kurangi stok
        $buku->stok -= $peminjaman->jumlah;
        if ($buku->stok == 0) {
            $buku->status = 'unavailable';
        }
        $buku->save();

        $peminjaman->update(['status' => 'borrowed']);

        UserNotification::sendNotification(
            $peminjaman->user_id,
            'Peminjaman Disetujui',
            'Peminjaman buku "' . $buku->judul . '" telah disetujui. Silakan ambil buku di perpustakaan.',
            'success',
            $peminjaman->id
        );

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak(Request $request, Booking $peminjaman)
    {
        $request->validate(['catatan' => 'required|string']);

        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman pending yang bisa ditolak.');
        }

        $peminjaman->update([
            'status' => 'rejected',
            'catatan' => $request->catatan,
        ]);

        UserNotification::sendNotification(
            $peminjaman->user_id,
            'Peminjaman Ditolak',
            'Peminjaman buku "' . $peminjaman->book->judul . '" ditolak. Alasan: ' . $request->catatan,
            'error',
            $peminjaman->id
        );

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function kembalikan(Booking $peminjaman)
    {
        if ($peminjaman->status !== 'borrowed') {
            return back()->with('error', 'Hanya peminjaman aktif yang bisa dikembalikan.');
        }

        $buku = $peminjaman->book;
        
        // Tambah stok
        $buku->stok += $peminjaman->jumlah;
        $buku->status = 'available';
        $buku->save();

        $peminjaman->update([
            'status' => 'returned',
            'tanggal_dikembalikan' => now(),
        ]);

        // Cek keterlambatan
        if (now()->gt($peminjaman->tanggal_kembali)) {
            $terlambat = now()->diffInDays($peminjaman->tanggal_kembali);
            $user = $peminjaman->user;
            $user->penalty_until = now()->addDays($terlambat);
            $user->save();
        }

        UserNotification::sendNotification(
            $peminjaman->user_id,
            'Buku Dikembalikan',
            'Buku "' . $buku->judul . '" telah dikembalikan.',
            'info',
            $peminjaman->id
        );

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}