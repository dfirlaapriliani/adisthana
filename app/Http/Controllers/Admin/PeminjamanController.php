<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'book']);
        
        $status = $request->status ?? '';
        
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
        
        return view('admin.peminjaman.index', compact('peminjaman', 'status'));
    }

    public function show(Booking $peminjaman)
    {
        $peminjaman->load(['user', 'book']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function setujui(Booking $peminjaman)
    {
        if ($peminjaman->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak dapat disetujui.');
        }
        
        if ($peminjaman->book->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi.');
        }
        
        $peminjaman->update(['status' => 'approved']);
        $peminjaman->book->decrement('stok', $peminjaman->jumlah);
        
        // NOTIFIKASI KE USER
        DB::table('user_notifications')->insert([
            'user_id' => $peminjaman->user_id,
            'booking_id' => $peminjaman->id,
            'book_id' => $peminjaman->book_id,
            'title' => '✅ Peminjaman Disetujui',
            'message' => 'Peminjaman buku "' . $peminjaman->book->judul . '" telah disetujui. Silakan ambil buku di perpustakaan.',
            'type' => 'booking_approved',
            'icon' => '✅',
            'url' => route('peminjam.peminjaman.show', $peminjaman->id),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // NOTIFIKASI KE ADMIN LAIN
        $admins = \App\Models\User::where('role', 'admin')->where('id', '!=', auth()->id())->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'title' => '✅ Peminjaman Disetujui',
                'message' => auth()->user()->name . ' menyetujui peminjaman buku "' . $peminjaman->book->judul . '" oleh ' . $peminjaman->user->name,
                'type' => 'booking_approved',
                'icon' => '✅',
                'url' => route('admin.peminjaman.show', $peminjaman->id),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function tolak(Request $request, Booking $peminjaman)
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
        
        // NOTIFIKASI KE USER
        DB::table('user_notifications')->insert([
            'user_id' => $peminjaman->user_id,
            'booking_id' => $peminjaman->id,
            'book_id' => $peminjaman->book_id,
            'title' => '❌ Peminjaman Ditolak',
            'message' => 'Peminjaman buku "' . $peminjaman->book->judul . '" ditolak. Alasan: ' . $request->catatan_penolakan,
            'type' => 'booking_rejected',
            'icon' => '❌',
            'url' => route('peminjam.peminjaman.show', $peminjaman->id),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // NOTIFIKASI KE ADMIN LAIN
        $admins = \App\Models\User::where('role', 'admin')->where('id', '!=', auth()->id())->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'title' => '❌ Peminjaman Ditolak',
                'message' => auth()->user()->name . ' menolak peminjaman buku "' . $peminjaman->book->judul . '" oleh ' . $peminjaman->user->name,
                'type' => 'booking_rejected',
                'icon' => '❌',
                'url' => route('admin.peminjaman.show', $peminjaman->id),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function diambil(Booking $peminjaman)
    {
        if ($peminjaman->status !== 'approved') {
            return back()->with('error', 'Peminjaman harus disetujui terlebih dahulu.');
        }
        
        $peminjaman->update(['status' => 'borrowed']);
        
        // NOTIFIKASI KE USER
        DB::table('user_notifications')->insert([
            'user_id' => $peminjaman->user_id,
            'booking_id' => $peminjaman->id,
            'book_id' => $peminjaman->book_id,
            'title' => '📖 Buku Sedang Dipinjam',
            'message' => 'Buku "' . $peminjaman->book->judul . '" telah diambil. Jangan lupa dikembalikan sebelum ' . Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y'),
            'type' => 'booking_borrowed',
            'icon' => '📖',
            'url' => route('peminjam.peminjaman.show', $peminjaman->id),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return back()->with('success', 'Buku ditandai sudah diambil.');
    }

    public function kembalikan(Request $request, Booking $peminjaman)
    {
        if (!in_array($peminjaman->status, ['approved', 'borrowed'])) {
            return back()->with('error', 'Peminjaman tidak dapat dikembalikan.');
        }
        
        $peminjaman->update([
            'status' => 'returned',
            'tanggal_dikembalikan' => now()
        ]);
        
        $peminjaman->book->increment('stok', $peminjaman->jumlah);
        
        // Cek keterlambatan
        $isLate = Carbon::parse($peminjaman->tanggal_kembali)->lt(now());
        $lateMessage = '';
        
        if ($isLate) {
            $lateDays = Carbon::parse($peminjaman->tanggal_kembali)->diffInDays(now());
            $lateMessage = ' (Terlambat ' . $lateDays . ' hari)';
            
            $peminjaman->user->update([
                'penalty_until' => now()->addDays($lateDays * 2)
            ]);
        }
        
        // NOTIFIKASI KE USER
        DB::table('user_notifications')->insert([
            'user_id' => $peminjaman->user_id,
            'booking_id' => $peminjaman->id,
            'book_id' => $peminjaman->book_id,
            'title' => '📦 Buku Dikembalikan',
            'message' => 'Buku "' . $peminjaman->book->judul . '" telah dikembalikan.' . $lateMessage,
            'type' => 'booking_returned',
            'icon' => '📦',
            'url' => route('peminjam.riwayat.index'),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // NOTIFIKASI KE ADMIN LAIN
        $admins = \App\Models\User::where('role', 'admin')->where('id', '!=', auth()->id())->get();
        foreach ($admins as $admin) {
            DB::table('user_notifications')->insert([
                'user_id' => $admin->id,
                'booking_id' => $peminjaman->id,
                'book_id' => $peminjaman->book_id,
                'title' => '📦 Buku Dikembalikan',
                'message' => $peminjaman->user->name . ' mengembalikan buku "' . $peminjaman->book->judul . '"' . $lateMessage,
                'type' => 'booking_returned',
                'icon' => '📦',
                'url' => route('admin.peminjaman.show', $peminjaman->id),
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}