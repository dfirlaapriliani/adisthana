<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = UserNotification::where('user_id', auth()->id())
            ->latest()
            ->paginate(15);
            
        return view('admin.notifikasi.index', compact('notifications'));
    }
    
    public function markAsRead($id)
    {
        $notif = UserNotification::where('user_id', auth()->id())->findOrFail($id);
        $notif->update(['is_read' => true]);
        
        return back()->with('success', 'Notifikasi ditandai sudah dibaca');
    }
    
    public function markAllAsRead()
    {
        UserNotification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca');
    }
}