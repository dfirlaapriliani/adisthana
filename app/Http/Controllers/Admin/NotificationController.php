<?php
// app/Http/Controllers/Admin/NotificationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = UserNotification::where('user_id', auth()->id());
        
        // Filter by type
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }
        
        $notifications = $query->latest()->paginate(15);
            
        return view('admin.notifikasi.index', compact('notifications'));
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
    
    // Untuk AJAX polling
    public function getUnreadCount()
    {
        $count = UserNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }
}