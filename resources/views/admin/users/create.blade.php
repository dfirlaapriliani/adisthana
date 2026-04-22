<x-layout-admin>
    <x-slot name="title">Tambah Peminjam</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Tambah Peminjam</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Buat akun baru untuk kelas</p>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm p-6">
        <form action="{{ route('admin.users.store') }}" method="POST" x-data="{ password: '{{ $generatedPassword }}', showPassword: false }">
            @csrf
            
            {{-- Hidden field untuk permohonan --}}
            @if(request()->has('from') && request()->from === 'permohonan')
                <input type="hidden" name="from_permohonan" value="1">
                <input type="hidden" name="phone_wa" value="{{ request()->phone }}">
                
                {{-- Alert info kalau dari permohonan --}}
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-green-800">Membuat akun dari permohonan</p>
                            <p class="text-xs text-green-600 mt-0.5">Data akan otomatis terisi dari form permohonan</p>
                        </div>
                    </div>
                </div>
            @endif
            
            {{-- Kode Unik Kelas (Auto Generate) --}}
            <div class="mb-6 p-5 bg-gradient-to-r from-[#7B1518]/5 to-transparent rounded-xl border border-[#7B1518]/10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-[#7B1518] flex items-center justify-center shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-[#6b5a54]">Kode Unik Kelas (Auto Generate)</p>
                       <p class="text-3xl font-bold text-[#7B1518] tracking-wider" style="font-family: 'Courier New', monospace;">
                        @php
                            $lastUser = \App\Models\User::where('role', 'peminjam')->whereNotNull('class_code')->orderBy('id', 'desc')->first();
                            if ($lastUser && $lastUser->class_code) {
                                preg_match('/KLS-(\d+)/', $lastUser->class_code, $matches);
                                $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
                            } else {
                                $nextNumber = 1;
                            }
                            echo 'KLS-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                        @endphp
                    </p>
                    </div>
                </div>
                <p class="text-xs text-[#9a8a80] mt-3">Kode ini akan otomatis dibuat sistem dan tidak dapat diubah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Kelas --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Nama Kelas <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', request()->nama ?? '') }}" required
                        placeholder="Contoh: XI IPA 1"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('name') border-red-300 @enderror">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Detail Kelas (Opsional) --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Detail Kelas
                        <span class="text-[#9a8a80] text-xs font-normal">(Contoh: Ruang 101, Wali Kelas, dll)</span>
                    </label>
                    <input type="text" name="class_name" value="{{ old('class_name', request()->kelas ?? '') }}"
                        placeholder="Contoh: Ruang 101 - Bu Siti"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Email <span class="text-[#7B1518]">*</span>
                        <span class="text-[#9a8a80] text-xs font-normal">(harus @adisthana.com)</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        placeholder="kelas@adisthana.com"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('email') border-red-300 @enderror">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No. HP --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">No. HP (Ketua Kelas)</label>
                    <input type="text" name="phone" value="{{ old('phone', request()->phone ?? '') }}"
                        placeholder="081234567890"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('phone') border-red-300 @enderror">
                    @error('phone')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password (Auto Generate + Bisa Edit) --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Password <span class="text-[#7B1518]">*</span>
                        <span class="text-[#9a8a80] text-xs font-normal">(Auto generate, bisa diubah)</span>
                    </label>
                    <div class="flex gap-2">
                        <div class="flex-1 relative">
                            <input 
                                :type="showPassword ? 'text' : 'password'" 
                                name="password" 
                                x-model="password"
                                required
                                class="w-full px-4 py-2.5 pr-20 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition font-mono">
                            <button 
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 text-[#9a8a80] hover:text-[#2C1810] transition">
                                <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>
                        <button 
                            type="button"
                            @click="navigator.clipboard.writeText(password); $dispatch('copied')"
                            class="px-4 py-2.5 bg-[#7B1518]/10 text-[#7B1518] rounded-xl text-sm font-medium hover:bg-[#7B1518]/20 transition flex items-center gap-2"
                            x-data="{ copied: false }"
                            @copied.window="copied = true; setTimeout(() => copied = false, 2000)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            <span x-show="!copied">Copy</span>
                            <span x-show="copied" class="text-green-600">Tercopy!</span>
                        </button>
                        <button 
                            type="button"
                            @click="password = Array(8).fill(0).map(() => 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'[Math.floor(Math.random() * 62)]).join('')"
                            class="px-4 py-2.5 bg-[#F0EBE3] text-[#2C1810] rounded-xl text-sm font-medium hover:bg-[#e5ddd2] transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Generate
                        </button>
                    </div>
                    <p class="text-xs text-[#9a8a80] mt-1">Password ini akan diberikan ke murid untuk login</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-[#7B1518]/10">
                <a href="{{ route('admin.users.index') }}" 
                    class="px-4 py-2.5 text-sm text-[#6b5a54] hover:text-[#2C1810] transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
                    Buat Akun Kelas
                </button>
            </div>
        </form>
    </div>

    {{-- SweetAlert2 untuk notifikasi dari permohonan --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('new_user_data') && session('new_user_data.show_wa_button'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userData = @json(session('new_user_data'));
        
        let message = `Akun kelas berhasil dibuat!\n\n`;
        message += `Kode Kelas: ${userData.class_code}\n`;
        message += `Nama Kelas: ${userData.name}\n`;
        message += `Email: ${userData.email}\n`;
        message += `Password: ${userData.password}`;
        
        const phoneNumber = userData.phone.replace(/\D/g, '');
        const waMessage = `Halo ${userData.name}, akun Adisthana kamu sudah aktif!%0A%0AKode Kelas: ${userData.class_code}%0AEmail: ${userData.email}%0APassword: ${userData.password}%0A%0ALogin: http://127.0.0.1:8000/login`;
        const waLink = `https://wa.me/62${phoneNumber}?text=${waMessage}`;
        
        // Delay sedikit biar modal bawaan nggak tabrakan
        setTimeout(() => {
            Swal.fire({
                title: '✅ Akun Kelas Berhasil Dibuat!',
                text: message,
                icon: 'success',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: 'OK',
                denyButtonText: '<i class="fab fa-whatsapp"></i> Kirim via WhatsApp',
                cancelButtonText: '<i class="fas fa-copy"></i> Salin Password',
                confirmButtonColor: '#7B1518',
                denyButtonColor: '#25D366',
                cancelButtonColor: '#6B7280',
                reverseButtons: true
            }).then((result) => {
                if (result.isDenied) {
                    window.open(waLink, '_blank');
                    Swal.fire({
                        title: 'Membuka WhatsApp...',
                        text: 'Kirim pesan ke peminjam',
                        icon: 'info',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    navigator.clipboard.writeText(userData.password);
                    Swal.fire({
                        title: 'Password Disalin!',
                        text: 'Password sudah tersalin ke clipboard',
                        icon: 'success',
                        confirmButtonColor: '#7B1518',
                        timer: 2000
                    });
                }
            });
        }, 300);
    });
</script>
@endif

    @if(session('success') && !session('new_user_data'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonColor: '#7B1518'
            });
        });
    </script>
    @endif

</x-layout-admin>