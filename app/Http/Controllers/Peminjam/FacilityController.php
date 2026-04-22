<?php

namespace App\Http\Controllers\Peminjam;

use App\Models\Facility;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::with(['bookings' => function($q) {
            $q->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification'])
              ->where('booking_date', '>=', now()->toDateString());
        }])->get();

        return view('peminjam.facilities.index', compact('facilities'));
    }

    public function show(Facility $facility)
    {
        $bookings = $facility->bookings()
            ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification'])
            ->where('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('start_time')
            ->get();

        return view('peminjam.facilities.show', compact('facility', 'bookings'));
    }

    public function getAvailableSlots(Request $request, Facility $facility)
    {
        $date = $request->date ?? now()->toDateString();
        
        $bookings = $facility->bookings()
            ->where('booking_date', $date)
            ->whereIn('status', ['approved', 'ongoing', 'waiting_proof', 'waiting_verification'])
            ->get(['start_time', 'end_time']);

        // Generate slots per jam (07:00 - 17:00)
        $slots = [];
        $start = Carbon::createFromTime(7, 0);
        $end = Carbon::createFromTime(17, 0);

        while ($start->lt($end)) {
            $slotEnd = $start->copy()->addHour();
            $isBooked = $bookings->contains(function($booking) use ($start, $slotEnd) {
                $bookingStart = Carbon::parse($booking->start_time);
                $bookingEnd = Carbon::parse($booking->end_time);
                return $start->between($bookingStart, $bookingEnd) || 
                       $slotEnd->between($bookingStart, $bookingEnd) ||
                       ($start->lte($bookingStart) && $slotEnd->gte($bookingEnd));
            });

            $slots[] = [
                'start' => $start->format('H:i'),
                'end' => $slotEnd->format('H:i'),
                'available' => !$isBooked
            ];

            $start->addHour();
        }

        return response()->json($slots);
    }
}