<?php
// app/Http/Controllers/Peminjam/NotificationController.php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = UserNotification::where('user_id', auth()->id());
        
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        $notifications = $query->latest()->paginate(15);
            
    return view('peminjam.notifications.index', compact('notifications'));
    }
    
    public function markAsRead($id)
    {
        $notif = UserNotification::where('user_id', auth()->id())->findOrFail($id);
        $notif->markAsRead();
        
        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }
    
    public function markAllAsRead()
    {
        UserNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
            
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }
    
    // ✅ TAMBAHKAN METHOD INI
    public function getUnreadCount()
    {
        $count = UserNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
}