<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class VerificationController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'facility', 'photos'])
            ->whereIn('status', ['waiting_verification', 'photo_rejected'])
            ->latest()
            ->paginate(15);

        return view('admin.verifications.index', compact('bookings'));
    }

    public function verify(Request $request, Booking $booking)
    {
        $booking->update(['status' => 'completed']);

        UserNotification::sendNotification(
            $booking->user_id,
            'Foto Diverifikasi',
            'Foto bukti untuk peminjaman ' . $booking->facility->name . ' telah diverifikasi.',
            'success',
            $booking->id
        );

        // Cek apakah fasilitas bisa di-set available lagi
        $this->checkFacilityAvailability($booking->facility);

        return back()->with('success', 'Foto berhasil diverifikasi.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate(['admin_note' => 'required|string']);

        $booking->update([
            'status' => 'photo_rejected',
            'admin_note' => $request->admin_note,
        ]);

        UserNotification::sendNotification(
            $booking->user_id,
            'Foto Ditolak',
            'Foto bukti ditolak. Alasan: ' . $request->admin_note . '. Silakan upload ulang.',
            'error',
            $booking->id
        );

        return back()->with('success', 'Foto berhasil ditolak.');
    }

    public function forceComplete(Request $request, Booking $booking)
    {
        // Untuk admin yang mau force complete walau gak ada foto
        // Tapi kasih penalti 3 hari ke user
        
        $booking->update(['status' => 'completed', 'admin_note' => $request->admin_note]);
        
        // Kasih penalti 3 hari
        $user = $booking->user;
        $user->update(['penalty_until' => now()->addDays(3)]);

        UserNotification::sendNotification(
            $user->id,
            'Penalti 3 Hari',
            'Anda mendapatkan penalti 3 hari karena tidak mengupload foto bukti tepat waktu.',
            'error',
            $booking->id
        );

        $this->checkFacilityAvailability($booking->facility);

        return back()->with('success', 'Peminjaman ditandai selesai. User mendapat penalti 3 hari.');
    }

    private function checkFacilityAvailability($facility)
    {
        // Cek apakah ada booking aktif di fasilitas ini
        $activeBooking = Booking::where('facility_id', $facility->id)
            ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification'])
            ->exists();

        if (!$activeBooking) {
            $facility->update(['status' => 'available']);
        }
    }
}