<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'peminjam');
        
        // Search
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
        // Hitung kode kelas berikutnya untuk preview
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

        // Generate class_code (KLS-001, KLS-002, dst)
        $lastUser = User::where('role', 'peminjam')
                        ->whereNotNull('class_code')
                        ->orderBy('id', 'desc')
                        ->first();
        
        if ($lastUser && $lastUser->class_code) {
            preg_match('/KLS-(\d+)/', $lastUser->class_code, $matches);
            $lastNumber = isset($matches[1]) ? intval($matches[1]) : 0;
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        $classCode = 'KLS-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

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

        // Check if from permohonan
        $fromPermohonan = $request->has('from_permohonan');
        $noWa = $request->phone_wa ?? $user->phone;

        // Simpan password asli untuk ditampilkan di popup
        $plainPassword = $validated['password'];

        if ($fromPermohonan && $noWa) {
            session()->flash('new_user_data', [
                'name' => $user->name,
                'email' => $user->email,
                'class_code' => $user->class_code,
                'password' => $plainPassword,
                'phone' => $noWa,
                'show_wa_button' => true,
            ]);
            
            // Juga flash untuk modal password
            session()->flash('generated_password', $plainPassword);
            session()->flash('new_user_id', $user->id);
        } else {
            // Flash data untuk modal password (sesuai sistem yang sudah ada)
            session()->flash('generated_password', $plainPassword);
            session()->flash('new_user_id', $user->id);
            
            // Flash data tambahan untuk popup SweetAlert2 (buat jaga-jaga)
            session()->flash('new_user_data', [
                'name' => $user->name,
                'email' => $user->email,
                'class_code' => $user->class_code,
                'password' => $plainPassword,
                'phone' => null,
                'show_wa_button' => false,
            ]);
        }

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
        $user->delete();
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
        return redirect()->back()
            ->with('success', "Akun kelas berhasil {$status}!");
    }

    public function clearPenalty(User $user)
    {
        $user->penalty_until = null;
        $user->save();
        
        return redirect()->back()
            ->with('success', 'Penalti berhasil dihapus!');
    }
}