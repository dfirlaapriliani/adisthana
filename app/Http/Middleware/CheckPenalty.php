<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPenalty
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if ($user && $user->hasActivePenalty()) {
            $days = $user->remaining_penalty_days;
            return redirect()->route('peminjam.dashboard')
                ->with('error', "Anda sedang dalam masa penalti selama {$days} hari lagi. Tidak dapat melakukan peminjaman baru.");
        }

        return $next($request);
    }
}