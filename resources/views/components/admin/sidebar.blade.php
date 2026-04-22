<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-64 bg-white border-r border-[#7B1518]/10 flex flex-col z-40 transition-transform duration-300 shadow-sm">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-[#7B1518]/10">
        <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-[#7B1518] flex items-center justify-center shadow-md shadow-[#7B1518]/20">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14M3 21h18M9 21V12h6v9"/>
            </svg>
        </div>
        <div>
            <span class="text-[#2C1810] font-semibold text-base tracking-wide" style="font-family:'Cormorant Garamond',serif;">Adisthana</span>
            <span class="block text-[#9a8a80] text-[10px] uppercase tracking-widest">Administrator</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-5 overflow-y-auto space-y-1">

        <p class="text-[#c4a898] text-[10px] uppercase tracking-widest px-3 pb-2 pt-1">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.dashboard') ? 'bg-[#7B1518]/10 text-[#7B1518] font-medium' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Fasilitas --}}
        <a href="{{ route('admin.facilities.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.facilities.*') ? 'bg-[#7B1518]/10 text-[#7B1518] font-medium' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span>Fasilitas</span>
        </a>

        {{-- Akun Peminjam --}}
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.users.*') ? 'bg-[#7B1518]/10 text-[#7B1518] font-medium' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Akun Peminjam</span>
        </a>

        <p class="text-[#c4a898] text-[10px] uppercase tracking-widest px-3 pb-2 pt-4">Peminjaman</p>

        {{-- Pengajuan --}}
        <a href="{{ route('admin.bookings.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.bookings.*') ? 'bg-[#7B1518]/10 text-[#7B1518] font-medium' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Pengajuan</span>
        </a>

        {{-- Verifikasi Foto --}}
        <a href="{{ route('admin.verifications.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.verifications.*') ? 'bg-[#7B1518]/10 text-[#7B1518] font-medium' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Verifikasi Foto</span>
        </a>

        {{-- Permohonan Akun --}}
        <a href="{{ route('admin.account-requests.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.account-requests.*') ? 'bg-[#7B1518]/10 text-[#7B1518] font-medium' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            <span>Permohonan Akun</span>
            @php
                $pendingCount = \App\Models\AccountRequest::where('status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="ml-auto bg-[#7B1518] text-white text-xs font-medium px-2 py-0.5 rounded-full">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>

        {{-- Riwayat --}}
        <a href="{{ route('admin.history.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.history.*') ? 'bg-[#7B1518]/10 text-[#7B1518] font-medium' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Riwayat</span>
        </a>

    </nav>

    {{-- User Info --}}
<div class="px-3 py-4 border-t border-[#7B1518]/10">
    <div class="flex items-center gap-3 px-3 py-2">
        <div class="w-8 h-8 rounded-full bg-[#7B1518]/10 border border-[#7B1518]/20 flex items-center justify-center flex-shrink-0">
            <span class="text-[#7B1518] text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-[#2C1810] text-sm font-medium truncate">{{ auth()->user()->name }}</p>
            <p class="text-[#9a8a80] text-xs truncate">{{ auth()->user()->email }}</p>
        </div>
    </div>
    
    {{-- Logout Button dengan SweetAlert --}}
    <button onclick="confirmLogout()"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-[#6b5a54] hover:text-[#7B1518] hover:bg-[#7B1518]/5 transition-all duration-200">
        <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        <span>Keluar</span>
    </button>
    
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Keluar dari Adisthana?',
            text: 'Anda akan keluar dari sesi administrator.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7B1518',
            cancelButtonColor: '#6b5a54',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

</aside>