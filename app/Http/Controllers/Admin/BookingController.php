<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status ?? 'pending';
        
        $bookings = Booking::with(['user', 'facility'])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(15);

        $counts = [
            'pending' => Booking::where('status', 'pending')->count(),
            'approved' => Booking::where('status', 'approved')->count(),
            'ongoing' => Booking::where('status', 'ongoing')->count(),
            'waiting_verification' => Booking::where('status', 'waiting_verification')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'status', 'counts'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'facility', 'photos']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan pending yang bisa diapprove.');
        }

        // Cek fasilitas available
        $facility = $booking->facility;
        if ($facility->status !== 'available') {
            return back()->with('error', 'Fasilitas sedang tidak tersedia.');
        }

        $booking->update(['status' => 'approved']);

        // Update status fasilitas
        $facility->update(['status' => 'not_available']);

        UserNotification::sendNotification(
            $booking->user_id,
            'Pengajuan Disetujui',
            'Pengajuan peminjaman ' . $booking->facility->name . ' telah disetujui admin.',
            'success',
            $booking->id
        );

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate(['admin_note' => 'required|string']);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan pending yang bisa direject.');
        }

        $booking->update([
            'status' => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        UserNotification::sendNotification(
            $booking->user_id,
            'Pengajuan Ditolak',
            'Pengajuan peminjaman ' . $booking->facility->name . ' ditolak. Alasan: ' . $request->admin_note,
            'error',
            $booking->id
        );

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}