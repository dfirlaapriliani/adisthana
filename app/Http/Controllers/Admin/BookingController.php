<?php
// app/Http/Controllers/Admin/BookingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Book;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'book']);
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('class_code', 'like', "%{$search}%");
            })->orWhereHas('book', function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        }
        
        $peminjaman = $query->latest()->paginate(15);
        
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function show(Booking $peminjaman)
    {
        $peminjaman->load(['user', 'book']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function approve(Booking $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dapat disetujui.');
        }
        
        // Cek stok
        if ($peminjaman->book->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }
        
        $peminjaman->update(['status' => 'approved']);
        
        // Kurangi stok buku
        $peminjaman->book->decrement('stok', $peminjaman->jumlah);
        
        // ✅ NOTIFIKASI KE USER: Peminjaman Disetujui
        UserNotification::sendToUser(
            $peminjaman->user_id,
            '✅ Peminjaman Disetujui',
            'Peminjaman buku "' . $peminjaman->book->judul . '" telah disetujui. Silakan ambil buku di perpustakaan.',
            'booking_approved',
            [
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'icon' => '✅',
                'url' => route('peminjam.peminjaman.show', $peminjaman->id)
            ]
        );
        
        // ✅ NOTIFIKASI KE ADMIN LAIN
        UserNotification::sendToOtherAdmins(
            '✅ Peminjaman Disetujui',
            auth()->user()->name . ' menyetujui peminjaman buku "' . $peminjaman->book->judul . '" oleh ' . $peminjaman->user->name,
            'booking_approved',
            [
                'booking_id' => $peminjaman->id,
                'icon' => '✅',
                'url' => route('admin.peminjaman.show', $peminjaman->id)
            ]
        );
        
        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject(Request $request, Booking $peminjaman)
    {
        if (!in_array($peminjaman->status, ['pending', 'approved'])) {
            return back()->with('error', 'Peminjaman tidak dapat ditolak.');
        }
        
        $request->validate([
            'catatan_penolakan' => 'required|string|max:500'
        ]);
        
        $peminjaman->update([
            'status' => 'rejected',
            'catatan' => $request->catatan_penolakan
        ]);
        
        // ✅ NOTIFIKASI KE USER: Peminjaman Ditolak
        UserNotification::sendToUser(
            $peminjaman->user_id,
            '❌ Peminjaman Ditolak',
            'Peminjaman buku "' . $peminjaman->book->judul . '" ditolak. Alasan: ' . $request->catatan_penolakan,
            'booking_rejected',
            [
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'icon' => '❌',
                'url' => route('peminjam.peminjaman.show', $peminjaman->id)
            ]
        );
        
        // ✅ NOTIFIKASI KE ADMIN LAIN
        UserNotification::sendToOtherAdmins(
            '❌ Peminjaman Ditolak',
            auth()->user()->name . ' menolak peminjaman buku "' . $peminjaman->book->judul . '" oleh ' . $peminjaman->user->name,
            'booking_rejected',
            [
                'booking_id' => $peminjaman->id,
                'icon' => '❌',
                'url' => route('admin.peminjaman.show', $peminjaman->id)
            ]
        );
        
        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function markAsBorrowed(Booking $peminjaman)
    {
        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Peminjaman harus disetujui terlebih dahulu.');
        }
        
        $peminjaman->update(['status' => 'borrowed']);
        
        // ✅ NOTIFIKASI KE USER: Buku Sedang Dipinjam
        UserNotification::sendToUser(
            $peminjaman->user_id,
            '📖 Buku Sedang Dipinjam',
            'Buku "' . $peminjaman->book->judul . '" telah diambil. Jangan lupa dikembalikan sebelum ' . Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y'),
            'booking_borrowed',
            [
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'icon' => '📖',
                'url' => route('peminjam.peminjaman.show', $peminjaman->id)
            ]
        );
        
        return back()->with('success', 'Buku ditandai sedang dipinjam.');
    }

    public function return(Booking $peminjaman)
    {
        if (!in_array($peminjaman->status, ['approved', 'borrowed'])) {
            return back()->with('error', 'Peminjaman tidak dapat dikembalikan.');
        }
        
        $peminjaman->update([
            'status' => 'returned',
            'tanggal_dikembalikan' => now()
        ]);
        
        // Kembalikan stok
        $peminjaman->book->increment('stok', $peminjaman->jumlah);
        
        // Cek keterlambatan
        $isLate = Carbon::parse($peminjaman->tanggal_kembali)->lt(now());
        $lateMessage = '';
        
        if ($isLate) {
            $lateDays = Carbon::parse($peminjaman->tanggal_kembali)->diffInDays(now());
            $lateMessage = ' (Terlambat ' . $lateDays . ' hari)';
            
            // Beri penalti ke user
            $peminjaman->user->update([
                'penalty_until' => now()->addDays($lateDays * 2)
            ]);
        }
        
        // ✅ NOTIFIKASI KE USER: Buku Dikembalikan
        UserNotification::sendToUser(
            $peminjaman->user_id,
            '📦 Buku Dikembalikan',
            'Buku "' . $peminjaman->book->judul . '" telah dikembalikan.' . $lateMessage,
            'booking_returned',
            [
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'icon' => '📦',
                'url' => route('peminjam.riwayat.index')
            ]
        );
        
        // ✅ NOTIFIKASI KE ADMIN: Buku Dikembalikan
        UserNotification::sendToOtherAdmins(
            '📦 Buku Dikembalikan',
            $peminjaman->user->name . ' mengembalikan buku "' . $peminjaman->book->judul . '"' . $lateMessage,
            'booking_returned',
            [
                'booking_id' => $peminjaman->id,
                'icon' => '📦',
                'url' => route('admin.peminjaman.show', $peminjaman->id)
            ]
        );
        
        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function cancel(Booking $peminjaman)
    {
        if (!in_array($peminjaman->status, ['pending', 'approved'])) {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan.');
        }
        
        $peminjaman->update(['status' => 'cancelled']);
        
        // ✅ NOTIFIKASI KE USER: Peminjaman Dibatalkan Admin
        UserNotification::sendToUser(
            $peminjaman->user_id,
            '❌ Peminjaman Dibatalkan',
            'Admin membatalkan peminjaman buku "' . $peminjaman->book->judul . '"',
            'booking_cancelled',
            [
                'booking_id' => $peminjaman->id,
                'icon' => '❌',
                'url' => route('peminjam.peminjaman.index')
            ]
        );
        
        return back()->with('success', 'Peminjaman dibatalkan.');
    }
}