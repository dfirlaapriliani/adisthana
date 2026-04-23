<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'peminjam');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('class_code', 'like', "%{$search}%");
            });
        }
        
        $users = $query->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create(Request $request)
    {
        $lastUser = User::where('role', 'peminjam')
                        ->whereNotNull('class_code')
                        ->orderBy('id', 'desc')
                        ->first();
        
        if ($lastUser && $lastUser->class_code) {
            preg_match('/KLS-(\d+)/', $lastUser->class_code, $matches);
            $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        } else {
            $nextNumber = 1;
        }
        
        $generatedCode = 'KLS-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        $generatedPassword = Str::random(10);
        
        return view('admin.users.create', compact('generatedCode', 'generatedPassword'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'class_name' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8',
        ]);

        $classCode = User::generateClassCode();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'class_code' => $classCode,
            'class_name' => $validated['class_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'password' => bcrypt($validated['password']),
            'role' => 'peminjam',
            'is_blocked' => false,
        ]);

        $plainPassword = $validated['password'];
        $fromPermohonan = $request->has('from_permohonan') || $request->input('from') === 'permohonan';
        $noWa = $request->phone_wa ?? $request->phone ?? $user->phone;

        session()->flash('generated_password', $plainPassword);
        session()->flash('new_user_id', $user->id);
        session()->flash('new_user_data', [
            'show_wa_button' => $fromPermohonan && !empty($noWa),
            'phone' => $noWa,
        ]);

        // NOTIFIKASI KE USER BARU
        DB::table('user_notifications')->insert([
            'user_id' => $user->id,
            'title' => '🎉 Selamat Datang di Adisthana!',
            'message' => 'Akun Anda telah dibuat. Kode Kelas: ' . $classCode . '. Silakan login untuk mulai meminjam buku.',
            'type' => 'user_created',
            'icon' => '🎉',
            'url' => route('peminjam.dashboard'),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // NOTIFIKASI KE ADMIN (HARDCODE ID 1)
        DB::table('user_notifications')->insert([
            'user_id' => 1,
            'title' => '👤 Akun Kelas Baru',
            'message' => auth()->user()->name . ' membuat akun untuk ' . $user->name . ' (' . $classCode . ')',
            'type' => 'user_created',
            'icon' => '👤',
            'url' => route('admin.users.show', $user->id),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun kelas berhasil dibuat!');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'class_name' => 'nullable|string|max:100',
            'class_code' => 'nullable|string|max:20|unique:users,class_code,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->class_name = $validated['class_name'] ?? null;
        if (isset($validated['class_code'])) {
            $user->class_code = $validated['class_code'];
        }
        $user->phone = $validated['phone'] ?? null;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }
        
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun kelas berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        $userName = $user->name;
        $classCode = $user->class_code;
        $user->delete();
        
        DB::table('user_notifications')->insert([
            'user_id' => 1,
            'title' => '🗑️ Akun Kelas Dihapus',
            'message' => auth()->user()->name . ' menghapus akun ' . $userName . ' (' . $classCode . ')',
            'type' => 'user_deleted',
            'icon' => '🗑️',
            'url' => route('admin.users.index'),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Akun kelas berhasil dihapus!');
    }

    public function toggleBlock(Request $request, User $user)
    {
        $user->is_blocked = !$user->is_blocked;
        
        if ($user->is_blocked && $request->has('block_reason')) {
            $user->block_reason = $request->block_reason;
        } elseif (!$user->is_blocked) {
            $user->block_reason = null;
        }
        
        $user->save();
        
        $status = $user->is_blocked ? 'diblokir' : 'diaktifkan';
        $icon = $user->is_blocked ? '🚫' : '✅';
        $message = $user->is_blocked 
            ? 'Akun Anda telah diblokir. Alasan: ' . ($user->block_reason ?? 'Tidak ada alasan')
            : 'Akun Anda telah diaktifkan kembali. Selamat menggunakan Adisthana!';
        
        DB::table('user_notifications')->insert([
            'user_id' => $user->id,
            'title' => $icon . ' Status Akun: ' . ucfirst($status),
            'message' => $message,
            'type' => $user->is_blocked ? 'user_blocked' : 'user_activated',
            'icon' => $icon,
            'url' => route('peminjam.dashboard'),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('user_notifications')->insert([
            'user_id' => 1,
            'title' => $icon . ' Akun ' . ucfirst($status),
            'message' => auth()->user()->name . ' ' . ($user->is_blocked ? 'memblokir' : 'mengaktifkan') . ' akun ' . $user->name . ' (' . $user->class_code . ')',
            'type' => $user->is_blocked ? 'user_blocked' : 'user_activated',
            'icon' => $icon,
            'url' => route('admin.users.show', $user->id),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', "Akun kelas berhasil {$status}!");
    }

    public function clearPenalty(User $user)
    {
        $user->penalty_until = null;
        $user->save();
        
        DB::table('user_notifications')->insert([
            'user_id' => $user->id,
            'title' => '🎊 Penalti Dihapus',
            'message' => 'Masa penalti Anda telah dihapus oleh admin. Anda dapat meminjam buku kembali.',
            'type' => 'penalty_cleared',
            'icon' => '🎊',
            'url' => route('peminjam.buku.index'),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('user_notifications')->insert([
            'user_id' => 1,
            'title' => '🎊 Penalti Dihapus',
            'message' => auth()->user()->name . ' menghapus penalti untuk ' . $user->name . ' (' . $user->class_code . ')',
            'type' => 'penalty_cleared',
            'icon' => '🎊',
            'url' => route('admin.users.show', $user->id),
            'is_read' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        return redirect()->back()
            ->with('success', 'Penalti berhasil dihapus!');
    }
}