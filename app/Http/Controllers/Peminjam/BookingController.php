<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.penalty')->except(['index', 'show', 'uploadPhoto', 'storePhoto']);
    }

    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with('facility')
            ->latest()
            ->paginate(10);

        return view('peminjam.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $facility = Facility::findOrFail($request->facility_id);
        $date = $request->date ?? now()->toDateString();
        $startTime = $request->start_time;
        $endTime = $request->end_time;

        return view('peminjam.bookings.create', compact('facility', 'date', 'startTime', 'endTime'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'facility_id' => 'required|exists:facilities,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:500',
        ]);

        // Cek bentrok jam
        $exists = Booking::where('facility_id', $request->facility_id)
            ->where('booking_date', $request->booking_date)
            ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification'])
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('start_time', '<=', $request->start_time)
                         ->where('end_time', '>=', $request->end_time);
                  });
            })->exists();

        if ($exists) {
            return back()->with('error', 'Jam yang dipilih sudah dibooking. Silakan pilih jam lain.');
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'facility_id' => $request->facility_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        // Notifikasi ke admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            UserNotification::sendNotification(
                $admin->id,
                'Pengajuan Baru',
                auth()->user()->name . ' mengajukan peminjaman ' . $booking->facility->name,
                'info',
                $booking->id
            );
        }

        return redirect()->route('peminjam.bookings.index')
            ->with('success', 'Pengajuan berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('peminjam.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan dengan status pending yang bisa diedit.');
        }

        return view('peminjam.bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan dengan status pending yang bisa diedit.');
        }

        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'purpose' => 'required|string|max:500',
        ]);

        // Cek bentrok (kecuali booking sendiri)
        $exists = Booking::where('facility_id', $booking->facility_id)
            ->where('booking_date', $request->booking_date)
            ->where('id', '!=', $booking->id)
            ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification'])
            ->where(function($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                  ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                  ->orWhere(function($q2) use ($request) {
                      $q2->where('start_time', '<=', $request->start_time)
                         ->where('end_time', '>=', $request->end_time);
                  });
            })->exists();

        if ($exists) {
            return back()->with('error', 'Jam yang dipilih sudah dibooking.');
        }

        $booking->update($request->only(['booking_date', 'start_time', 'end_time', 'purpose']));

        return redirect()->route('peminjam.bookings.index')
            ->with('success', 'Pengajuan berhasil diperbarui.');
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        if (!in_array($booking->status, ['pending', 'approved'])) {
            return back()->with('error', 'Pengajuan tidak dapat dibatalkan.');
        }

        $booking->update(['status' => 'cancelled']);

        UserNotification::sendNotification(
            $booking->user_id,
            'Pengajuan Dibatalkan',
            'Pengajuan peminjaman ' . $booking->facility->name . ' telah dibatalkan.',
            'warning',
            $booking->id
        );

        return redirect()->route('peminjam.bookings.index')
            ->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function uploadPhoto(Booking $booking)
    {
        $this->authorize('update', $booking);
        
        if ($booking->status !== 'waiting_proof' && $booking->status !== 'photo_rejected') {
            return back()->with('error', 'Tidak dapat upload foto untuk status ini.');
        }

        return view('peminjam.bookings.upload-photo', compact('booking'));
    }

    public function storePhoto(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        
        $request->validate([
            'photos.*' => 'required|image|max:5120', // max 5MB
        ]);

        $photoCount = $booking->photos()->count();
        
        foreach ($request->file('photos') as $index => $photo) {
            if ($photoCount + $index >= 2) break; // Max 2 foto
            
            $path = $photo->store('booking-photos', 'public');
            
            $booking->photos()->create([
                'photo_path' => $path,
                'order' => $photoCount + $index + 1,
            ]);
        }

        $booking->update(['status' => 'waiting_verification']);

        // Notifikasi ke admin
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            UserNotification::sendNotification(
                $admin->id,
                'Foto Bukti Menunggu Verifikasi',
                auth()->user()->name . ' telah mengupload foto bukti untuk ' . $booking->facility->name,
                'info',
                $booking->id
            );
        }

        return redirect()->route('peminjam.bookings.index')
            ->with('success', 'Foto bukti berhasil diupload. Menunggu verifikasi admin.');
    }
}