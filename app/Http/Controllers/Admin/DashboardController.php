<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\User;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_facilities' => Facility::count(),
            'total_users' => User::where('role', 'peminjam')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'waiting_verification' => Booking::where('status', 'waiting_verification')->count(),
            'ongoing_bookings' => Booking::where('status', 'ongoing')->count(),
        ];

        $recentBookings = Booking::with(['user', 'facility'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }
}