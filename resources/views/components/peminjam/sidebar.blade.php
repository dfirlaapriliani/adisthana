{{-- resources/views/components/peminjam/sidebar.blade.php --}}
<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-64 bg-[#FFF9F0] border-r-2 border-[#C75B39]/30 flex flex-col z-40 transition-transform duration-300 shadow-2xl shadow-[#C75B39]/10 lg:translate-x-0 -translate-x-full">

    {{-- Tombol Close untuk Mobile --}}
    <button onclick="closeSidebar()" class="lg:hidden absolute top-3 right-3 p-2 rounded-lg hover:bg-[#C75B39]/10 transition z-50">
        <svg class="w-5 h-5 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b-2 border-[#C75B39]/20">
        <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-gradient-to-br from-[#C75B39] to-[#8B3A3A] flex items-center justify-center shadow-md shadow-[#C75B39]/40">
            <svg class="w-5 h-5 text-[#FFF9F0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14M3 21h18M9 21V12h6v9"/>
            </svg>
        </div>
        <div>
            <span class="text-[#8B3A3A] font-bold text-base tracking-wide brand">Adisthana</span>
            <span class="block text-[#C75B39] text-[10px] uppercase tracking-widest font-bold">Peminjam</span>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-5 overflow-y-auto space-y-1">
        <p class="text-[#C75B39]/70 text-[10px] uppercase tracking-widest px-3 pb-2 pt-1 font-bold">Menu Utama</p>

        <a href="{{ route('peminjam.dashboard') }}"
            onclick="if(window.innerWidth < 1024) closeSidebar()"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('peminjam.dashboard') ? 'bg-[#C75B39] text-white shadow-md' : 'text-[#5A2A2A] hover:bg-[#C75B39]/10 hover:text-[#C75B39]' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('peminjam.buku.index') }}"
            onclick="if(window.innerWidth < 1024) closeSidebar()"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('peminjam.buku.*') ? 'bg-[#C75B39] text-white shadow-md' : 'text-[#5A2A2A] hover:bg-[#C75B39]/10 hover:text-[#C75B39]' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
            </svg>
            <span>Buku</span>
        </a>

        <p class="text-[#C75B39]/70 text-[10px] uppercase tracking-widest px-3 pb-2 pt-4 font-bold">Aktivitas</p>

        <a href="{{ route('peminjam.peminjaman.index') }}"
            onclick="if(window.innerWidth < 1024) closeSidebar()"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('peminjam.peminjaman.*') ? 'bg-[#C75B39] text-white shadow-md' : 'text-[#5A2A2A] hover:bg-[#C75B39]/10 hover:text-[#C75B39]' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span>Peminjaman Saya</span>
        </a>

        <a href="{{ route('peminjam.riwayat.index') }}"
            onclick="if(window.innerWidth < 1024) closeSidebar()"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('peminjam.riwayat.*') ? 'bg-[#C75B39] text-white shadow-md' : 'text-[#5A2A2A] hover:bg-[#C75B39]/10 hover:text-[#C75B39]' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Riwayat</span>
        </a>

        <a href="{{ route('peminjam.notifikasi.index') }}"
            onclick="if(window.innerWidth < 1024) closeSidebar()"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                {{ request()->routeIs('peminjam.notifikasi.*') ? 'bg-[#C75B39] text-white shadow-md' : 'text-[#5A2A2A] hover:bg-[#C75B39]/10 hover:text-[#C75B39]' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <span>Notifikasi</span>
            @php
                $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
            @endphp
            @if($unreadCount > 0)
            <span class="ml-auto bg-[#C75B39] text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                {{ $unreadCount }}
            </span>
            @endif
        </a>
    </nav>

    {{-- User Info --}}
    <div class="px-3 py-4 border-t-2 border-[#C75B39]/20">
        <div class="flex items-center gap-3 px-3 py-2">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#C75B39] to-[#8B3A3A] border-2 border-[#C75B39] flex items-center justify-center flex-shrink-0 shadow-sm">
                <span class="text-white text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[#4A1C1C] text-sm font-bold truncate">{{ auth()->user()->name }}</p>
                <p class="text-[#8B3A3A] text-xs font-medium truncate">{{ auth()->user()->class_code ?? auth()->user()->email }}</p>
            </div>
        </div>
        
        <button onclick="confirmLogout()"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-[#8B3A3A] hover:text-white hover:bg-[#C75B39] transition-all">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                confirmButtonColor: '#C75B39',
                cancelButtonColor: '#8B3A3A',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                background: '#FFF9F0',
                color: '#4A1C1C'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</aside>