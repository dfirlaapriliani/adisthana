<x-layout-admin>
    <x-slot name="title">Akun Peminjam</x-slot>
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Akun Peminjam</h1>
            <p class="text-[#9a8a80] text-sm mt-1">Kelola akun kelas yang terdaftar</p>
        </div>
        <a href="{{ route('admin.users.create') }}" 
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kelas
        </a>
    </div>

    {{-- Alert Success --}}
    @if(session('success') && !session('generated_password'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-green-800">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-green-600 hover:text-green-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-red-800">{{ session('error') }}</p>
        </div>
        <button @click="show = false" class="text-red-600 hover:text-red-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- Modal Password (Muncul setelah create akun) --}}
    @if(session('generated_password') && session('new_user_id'))
    @php
        $newUser = \App\Models\User::find(session('new_user_id'));
        $showWaButton = session('new_user_data.show_wa_button') ?? false;
        $userPhone = session('new_user_data.phone') ?? '';
    @endphp
    
    @if($newUser)
    <div x-data="{ show: true, copied: false }" x-show="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-cloak>
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6" @click.away="show = false">
            <div class="text-center mb-4">
                <div class="w-16 h-16 rounded-full bg-green-100 mx-auto flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-[#2C1810]">Akun Berhasil Dibuat!</h3>
                <p class="text-sm text-[#9a8a80] mt-1">Berikan informasi ini ke murid untuk login</p>
            </div>
            
            <div class="bg-[#F0EBE3] rounded-xl p-4 mb-4">
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-[#9a8a80] mb-1">Kode Kelas</p>
                        <p class="text-sm font-mono font-medium text-[#7B1518]">{{ $newUser->class_code ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#9a8a80] mb-1">Nama Kelas</p>
                        <p class="text-sm font-medium text-[#2C1810]">{{ $newUser->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#9a8a80] mb-1">Email</p>
                        <p class="text-sm font-medium text-[#2C1810]">{{ $newUser->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-[#9a8a80] mb-1">Password</p>
                        <div class="flex items-center gap-2">
                            <code class="flex-1 bg-white px-3 py-2 rounded-lg text-lg font-mono text-[#7B1518] text-center tracking-wider">
                                {{ session('generated_password') }}
                            </code>
                            <button 
                                @click="navigator.clipboard.writeText('{{ session('generated_password') }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="p-2.5 bg-[#7B1518] text-white rounded-lg hover:bg-[#5a0f12] transition">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <svg x-show="copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 mb-4">
                <p class="text-xs text-yellow-800 flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Simpan password ini! Tidak akan ditampilkan lagi.
                </p>
            </div>
            
            @if($showWaButton && $userPhone)
                <div class="flex gap-2">
                    <button @click="show = false" 
                        class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-300 transition">
                        Nanti
                    </button>
                    <button 
                        onclick="kirimWhatsApp('{{ $userPhone }}', '{{ $newUser->name }}', '{{ $newUser->class_code }}', '{{ $newUser->email }}', '{{ session('generated_password') }}'); show = false"
                        class="flex-1 px-4 py-2.5 bg-green-500 text-white rounded-xl text-sm font-medium hover:bg-green-600 transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.101.116-.202.24-.087.462.115.217.505.836 1.084 1.354.744.663 1.371.869 1.566.966.195.097.308.082.424-.05.116-.13.491-.577.622-.779.13-.202.26-.173.447-.087.187.087 1.183.558 1.386.663.202.105.337.159.389.245.052.087.052.491-.093.896z"/>
                        </svg>
                        Kirim WhatsApp
                    </button>
                </div>
            @else
                <button @click="show = false" 
                    class="w-full px-4 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition">
                    Selesai
                </button>
            @endif
        </div>
    </div>
    @endif
    @endif

    {{-- Search & Filter --}}
    <div class="mb-6">
        <form method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari kode kelas, nama kelas, atau email..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
            </div>
            <button type="submit" 
                class="px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm text-[#2C1810] hover:bg-[#F0EBE3] transition">
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('admin.users.index') }}" 
                class="px-4 py-2.5 text-sm text-[#9a8a80] hover:text-[#2C1810] transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Users Table --}}
    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F0EBE3]/50 border-b border-[#7B1518]/10">
                    <tr class="text-left">
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Kode Kelas</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Nama Kelas</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">No. HP</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    @forelse($users as $user)
                    <tr class="hover:bg-[#F0EBE3]/30 transition">
                        <td class="px-6 py-4">
                            <span class="text-sm font-mono font-medium text-[#7B1518] bg-[#7B1518]/5 px-2.5 py-1 rounded-lg">
                                {{ $user->class_code ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#7B1518]/10 border border-[#7B1518]/20 flex items-center justify-center flex-shrink-0">
                                    <span class="text-[#7B1518] text-sm font-semibold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-[#2C1810]">{{ $user->name }}</p>
                                    @if($user->class_name)
                                    <p class="text-xs text-[#9a8a80]">{{ $user->class_name }}</p>
                                    @endif
                                    @if($user->hasActivePenalty())
                                    <p class="text-xs text-red-500 flex items-center gap-1 mt-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Penalti {{ $user->remaining_penalty_days }} hari
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-[#2C1810]">{{ $user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-[#2C1810]">{{ $user->phone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($user->is_blocked)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 text-red-700 text-xs rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Diblokir
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Aktif
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                    class="p-2 rounded-lg text-[#6b5a54] hover:text-[#7B1518] hover:bg-[#7B1518]/5 transition"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                
                                @if($user->hasActivePenalty())
                                <button 
                                    onclick="confirmClearPenalty({{ $user->id }}, '{{ $user->name }}', '{{ $user->class_code }}')"
                                    class="p-2 rounded-lg text-amber-600 hover:text-amber-700 hover:bg-amber-50 transition"
                                    title="Hapus Penalti">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                                <form id="clear-penalty-{{ $user->id }}" action="{{ route('admin.users.clear-penalty', $user) }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                @endif
                                
                                <button 
                                    onclick="confirmToggleBlock({{ $user->id }}, '{{ $user->name }}', '{{ $user->class_code }}', {{ $user->is_blocked ? 'true' : 'false' }})"
                                    class="p-2 rounded-lg {{ $user->is_blocked ? 'text-green-600 hover:text-green-700 hover:bg-green-50' : 'text-red-600 hover:text-red-700 hover:bg-red-50' }} transition"
                                    title="{{ $user->is_blocked ? 'Aktifkan' : 'Blokir' }}">
                                    @if($user->is_blocked)
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                    </svg>
                                    @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    @endif
                                </button>
                                <form id="toggle-block-{{ $user->id }}" action="{{ route('admin.users.toggle-block', $user) }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                                
                                <button 
                                    onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}', '{{ $user->class_code }}')"
                                    class="p-2 rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition"
                                    title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 rounded-full bg-[#7B1518]/5 flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-[#2C1810] font-medium text-lg">Belum ada akun kelas</p>
                                <p class="text-[#9a8a80] text-sm mt-1">Klik tombol "Tambah Kelas" untuk membuat akun baru</p>
                                <a href="{{ route('admin.users.create') }}" 
                                    class="mt-6 inline-flex items-center gap-2 px-5 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Kelas Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-[#7B1518]/10">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    @if($users->count() > 0)
    <div class="mt-4 flex items-center gap-4 text-xs text-[#9a8a80]">
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-green-500"></span>
            <span>Aktif: {{ $users->where('is_blocked', false)->count() }}</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-red-500"></span>
            <span>Diblokir: {{ $users->where('is_blocked', true)->count() }}</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
            <span>Kena Penalti: {{ $users->filter(fn($u) => $u->hasActivePenalty())->count() }}</span>
        </div>
        <div class="ml-auto">
            Total {{ $users->total() }} akun kelas
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    function kirimWhatsApp(phone, name, classCode, email, password) {
        const phoneNumber = phone.replace(/\D/g, '');
        const waMessage = `Halo ${name}, akun Adisthana kamu sudah aktif!%0A%0AKode Kelas: ${classCode}%0AEmail: ${email}%0APassword: ${password}%0A%0ALogin: http://127.0.0.1:8000/login`;
        window.open(`https://wa.me/62${phoneNumber}?text=${waMessage}`, '_blank');
    }
    
    function confirmDelete(id, name, code) {
        Swal.fire({
            title: 'Hapus Akun Kelas?',
            html: `
                <p class="mb-2">Anda akan menghapus akun:</p>
                <div class="bg-gray-100 rounded-lg p-3 text-left">
                    <p class="font-mono text-[#7B1518] text-sm">${code}</p>
                    <p class="font-medium">${name}</p>
                </div>
                <p class="text-red-500 text-sm mt-3">⚠️ Semua data peminjaman kelas ini juga akan terhapus!</p>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b5a54',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }

    function confirmToggleBlock(id, name, code, isBlocked) {
        if (isBlocked) {
            Swal.fire({
                title: 'Aktifkan Akun Kelas?',
                html: `
                    <p class="mb-2">Aktifkan kembali akun kelas:</p>
                    <div class="bg-gray-100 rounded-lg p-3 text-left">
                        <p class="font-mono text-[#7B1518] text-sm">${code}</p>
                        <p class="font-medium">${name}</p>
                    </div>
                    <p class="text-sm text-green-600 mt-3">✅ Kelas akan dapat login kembali.</p>
                `,
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b5a54',
                confirmButtonText: 'Ya, Aktifkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/users/${id}/toggle-block`;
                    form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">';
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        } else {
            Swal.fire({
                title: 'Blokir Akun Kelas?',
                html: `
                    <p class="mb-2">Blokir akun kelas:</p>
                    <div class="bg-gray-100 rounded-lg p-3 text-left mb-3">
                        <p class="font-mono text-[#7B1518] text-sm">${code}</p>
                        <p class="font-medium">${name}</p>
                    </div>
                    <label class="block text-left text-sm font-medium text-gray-700 mb-1">Alasan Pemblokiran <span class="text-red-500">*</span></label>
                    <textarea id="swal-block-reason" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-[#7B1518]" rows="3" placeholder="Contoh: Melanggar aturan peminjaman, tidak mengembalikan kunci, dll."></textarea>
                    <p class="text-xs text-gray-500 mt-1">🔒 Kelas tidak akan bisa login sampai diaktifkan kembali.</p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b5a54',
                confirmButtonText: 'Ya, Blokir!',
                cancelButtonText: 'Batal',
                preConfirm: () => {
                    const reason = document.getElementById('swal-block-reason').value;
                    if (!reason) {
                        Swal.showValidationMessage('Alasan pemblokiran wajib diisi');
                        return false;
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/users/${id}/toggle-block`;
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="block_reason" value="${result.value}">
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    }

    function confirmClearPenalty(id, name, code) {
        Swal.fire({
            title: 'Hapus Penalti?',
            html: `
                <p class="mb-2">Hapus masa penalti untuk kelas:</p>
                <div class="bg-gray-100 rounded-lg p-3 text-left">
                    <p class="font-mono text-[#7B1518] text-sm">${code}</p>
                    <p class="font-medium">${name}</p>
                </div>
                <p class="text-sm text-green-600 mt-3">✅ Kelas akan dapat meminjam fasilitas kembali.</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#eab308',
            cancelButtonColor: '#6b5a54',
            confirmButtonText: 'Ya, Hapus Penalti!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`clear-penalty-${id}`).submit();
            }
        });
    }
    </script>
</x-layout-admin>