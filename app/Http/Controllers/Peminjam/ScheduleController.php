<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Facility;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $facilityId = $request->facility_id;
        $facilities = Facility::orderBy('name')->get();
        
        $bookings = collect();
        $selectedFacility = null;
        
        if ($facilityId) {
            $selectedFacility = Facility::find($facilityId);
            $bookings = Booking::with(['user', 'facility'])
                ->where('facility_id', $facilityId)
                ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification', 'completed'])
                ->whereMonth('booking_date', now()->month)
                ->whereYear('booking_date', now()->year)
                ->get()
                ->groupBy('booking_date');
        }

        return view('peminjam.schedules.index', compact('facilities', 'selectedFacility', 'bookings'));
    }

    public function calendarEvents(Request $request)
    {
        $month = $request->month ?? now()->month;
        $year = $request->year ?? now()->year;
        $facilityId = $request->facility_id;

        $query = Booking::with(['user', 'facility'])
            ->whereMonth('booking_date', $month)
            ->whereYear('booking_date', $year)
            ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification']);

        if ($facilityId) {
            $query->where('facility_id', $facilityId);
        }

        $bookings = $query->get();

        // Hitung status telat (merah)
        $events = $bookings->map(function($booking) {
            $color = '#d4af6a'; // Kuning default
            
            // Cek telat (jam selesai lewat tapi belum upload foto)
            $bookingEnd = Carbon::parse($booking->booking_date->format('Y-m-d') . ' ' . $booking->end_time);
            if ($bookingEnd->isPast() && in_array($booking->status, ['ongoing', 'approved'])) {
                $color = '#ef4444'; // Merah
            }
            
            return [
                'id' => $booking->id,
                'title' => $booking->facility->name,
                'start' => $booking->booking_date->format('Y-m-d'),
                'color' => $color,
                'extendedProps' => [
                    'user' => $booking->user->name,
                    'facility' => $booking->facility->name,
                    'time' => $booking->start_time . ' - ' . $booking->end_time,
                    'purpose' => $booking->purpose,
                    'status' => $booking->status,
                ]
            ];
        });

        return response()->json($events);
    }
}