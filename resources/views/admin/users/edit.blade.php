<x-layout-admin>
    <x-slot name="title">Edit Peminjam</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Edit Peminjam</h1>
        <p class="text-[#9a8a80] text-sm mt-1">{{ $user->name }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            {{-- Kode Kelas (Readonly - Permanen) --}}
            <div class="mb-6 p-5 bg-gradient-to-r from-[#7B1518]/5 to-transparent rounded-xl border border-[#7B1518]/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#7B1518] flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-[#6b5a54]">Kode Unik Kelas (Permanen)</p>
                        <div class="flex items-center gap-3">
                            <p class="text-3xl font-bold text-[#7B1518] tracking-wider" style="font-family: 'Courier New', monospace;">
                                {{ $user->class_code ?? 'Belum ada kode' }}
                            </p>
                            <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[10px] rounded-full uppercase tracking-wider">
                                Tidak dapat diubah
                            </span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-[#9a8a80] mt-3 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Kode kelas bersifat permanen dan tidak dapat diubah setelah dibuat
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Nama Kelas <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        placeholder="Contoh: XI IPA 1"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('name') border-red-300 @enderror">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Detail Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Detail Kelas
                        <span class="text-[#9a8a80] text-xs font-normal">(Contoh: Ruang 101, Wali Kelas, dll)</span>
                    </label>
                    <input type="text" name="class_name" value="{{ old('class_name', $user->class_name) }}"
                        placeholder="Contoh: Ruang 101 - Bu Siti"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Email <span class="text-[#7B1518]">*</span>
                        <span class="text-[#9a8a80] text-xs font-normal">(harus @adisthana.com)</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        placeholder="kelas@adisthana.com"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('email') border-red-300 @enderror">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. HP --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">No. HP (Ketua Kelas)</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        placeholder="081234567890"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('phone') border-red-300 @enderror">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Password Baru 
                        <span class="text-[#9a8a80] text-xs font-normal">(Kosongkan jika tidak diubah)</span>
                    </label>
                    <input type="password" name="password"
                        placeholder="Minimal 6 karakter"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('password') border-red-300 @enderror">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status Blokir --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">Status Akun</label>
                    <div class="flex items-center gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_blocked" value="1" {{ old('is_blocked', $user->is_blocked) ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-[#7B1518]/30 text-[#7B1518] focus:ring-[#7B1518]">
                            <span class="text-sm text-[#2C1810]">Blokir akun ini</span>
                        </label>
                    </div>
                    <p class="text-xs text-[#9a8a80] mt-2">Akun yang diblokir tidak dapat login</p>
                </div>
            </div>

            {{-- Info Penalti --}}
            @if($user->hasActivePenalty())
            <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-amber-800">Akun sedang dalam masa penalti</p>
                        <p class="text-xs text-amber-700 mt-0.5">Sisa {{ $user->remaining_penalty_days }} hari lagi. Tidak dapat melakukan peminjaman baru.</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-[#7B1518]/10">
                <a href="{{ route('admin.users.index') }}" 
                    class="px-4 py-2.5 text-sm text-[#6b5a54] hover:text-[#2C1810] transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
                    Update Akun
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>