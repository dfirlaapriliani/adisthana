<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-64 bg-[#111114] border-r border-white/[0.05] flex flex-col z-40 transition-transform duration-300">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-white/[0.05]">
        <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-gradient-to-br from-[#d4af6a] to-[#8a6428] flex items-center justify-center shadow-md shadow-[#d4af6a]/20">
            <svg class="w-4.5 h-4.5 text-[#0e0e10]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14M3 21h18M9 21V12h6v9"/>
            </svg>
        </div>
        <div>
            <span class="text-white font-semibold text-base tracking-wide" style="font-family:'Cormorant Garamond',serif;">Adisthana</span>
            <span class="block text-[#5a5a65] text-[10px] uppercase tracking-widest">Peminjam</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-5 overflow-y-auto space-y-1">

        <p class="text-[#3d3d45] text-[10px] uppercase tracking-widest px-3 pb-2 pt-1">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('peminjam.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('peminjam.dashboard') ? 'bg-[#d4af6a]/10 text-[#d4af6a]' : 'text-[#8a8a95] hover:text-white hover:bg-white/[0.05]' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        {{-- Fasilitas --}}
        <a href="{{ route('peminjam.facilities.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('peminjam.facilities.*') ? 'bg-[#d4af6a]/10 text-[#d4af6a]' : 'text-[#8a8a95] hover:text-white hover:bg-white/[0.05]' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span>Fasilitas</span>
        </a>

        <p class="text-[#3d3d45] text-[10px] uppercase tracking-widest px-3 pb-2 pt-4">Aktivitas</p>

        {{-- Pengajuan Saya --}}
        <a href="{{ route('peminjam.bookings.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('peminjam.bookings.*') ? 'bg-[#d4af6a]/10 text-[#d4af6a]' : 'text-[#8a8a95] hover:text-white hover:bg-white/[0.05]' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Pengajuan Saya</span>
        </a>

        {{-- Jadwal --}}
        <a href="{{ route('peminjam.schedules.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('peminjam.schedules.*') ? 'bg-[#d4af6a]/10 text-[#d4af6a]' : 'text-[#8a8a95] hover:text-white hover:bg-white/[0.05]' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Jadwal</span>
        </a>

        {{-- Riwayat --}}
        <a href="{{ route('peminjam.history.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('peminjam.history.*') ? 'bg-[#d4af6a]/10 text-[#d4af6a]' : 'text-[#8a8a95] hover:text-white hover:bg-white/[0.05]' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Riwayat</span>
        </a>

        {{-- Notifikasi --}}
        <a href="{{ route('peminjam.notifications.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('peminjam.notifications.*') ? 'bg-[#d4af6a]/10 text-[#d4af6a]' : 'text-[#8a8a95] hover:text-white hover:bg-white/[0.05]' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span>Notifikasi</span>
            @php
                $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
            @endphp
            @if($unreadCount > 0)
            <span class="ml-auto bg-[#d4af6a] text-[#0e0e10] text-[10px] font-medium px-1.5 py-0.5 rounded-full">{{ $unreadCount }}</span>
            @endif
        </a>

    </nav>

    {{-- User Info --}}
<div class="px-3 py-4 border-t border-white/[0.05]">
    <div class="flex items-center gap-3 px-3 py-2">
        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#d4af6a]/30 to-[#8a6428]/30 border border-[#d4af6a]/20 flex items-center justify-center flex-shrink-0">
            <span class="text-[#d4af6a] text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-white text-sm font-medium truncate">{{ auth()->user()->name }}</p>
            <p class="text-[#5a5a65] text-xs truncate">{{ auth()->user()->identifier ?? auth()->user()->email }}</p>
        </div>
    </div>
    
    {{-- Logout Button dengan SweetAlert --}}
    <button onclick="confirmLogout()"
        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-[#8a8a95] hover:text-red-400 hover:bg-red-500/[0.05] transition-all duration-200">
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
            text: 'Anda akan keluar dari sesi.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#d4af6a',
            cancelButtonColor: '#5a5a65',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            background: '#111114',
            color: '#fff'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>

</aside>