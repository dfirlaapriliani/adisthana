<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Book;
use App\Models\Booking;
use App\Models\AccountRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeminjam = User::where('role', 'peminjam')->count();
        $totalBuku = Book::count();
        $peminjamanPending = Booking::where('status', 'pending')->count();
        $permohonanPending = AccountRequest::where('status', 'pending')->count();
        
        $peminjamanTerbaru = Booking::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPeminjam',
            'totalBuku',
            'peminjamanPending',
            'permohonanPending',
            'peminjamanTerbaru'
        ));
    }
}