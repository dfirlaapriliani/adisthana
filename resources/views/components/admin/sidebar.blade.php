{{-- Sidebar - Full Height, Hidden on Mobile by Default --}}
<aside id="sidebar"
    class="fixed top-0 left-0 h-full w-[280px] max-w-[85%] bg-white/95 backdrop-blur-xl shadow-3d border-r border-white/30 flex flex-col z-50 transition-all duration-300 -translate-x-full lg:translate-x-0 overflow-hidden"
    style="transform-style: preserve-3d; perspective: 1000px;">
    
    {{-- Subtle inner shadow untuk depth --}}
    <div class="absolute inset-0 pointer-events-none" 
         style="box-shadow: inset 0 2px 4px rgba(255,255,255,0.8), inset 0 -2px 4px rgba(0,0,0,0.05);">
    </div>

    {{-- Brand --}}
    <div class="relative flex items-center gap-3 px-5 py-5 border-b border-[#7B1518]/10 flex-shrink-0">
        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-[#7B1518] to-[#A52A2A] flex items-center justify-center shadow-lg shadow-[#7B1518]/20"
             style="box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 2px rgba(255,255,255,0.3);">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21V7a2 2 0 012-2h14a2 2 0 012 2v14M3 21h18M9 21V12h6v9"/>
            </svg>
        </div>
        <div>
            <span class="text-[#2C1810] font-semibold text-base tracking-wide brand">Adisthana</span>
            <span class="block text-[#9a8a80] text-[10px] uppercase tracking-widest">Administrator</span>
        </div>
        
        {{-- Close button for mobile --}}
        <button onclick="closeSidebar()" class="lg:hidden ml-auto p-2 rounded-lg hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10 transition">
            <svg class="w-5 h-5 text-[#6b5a54]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Navigation - Scrollable --}}
    <nav class="relative flex-1 px-3 py-4 overflow-y-auto space-y-1">

        <p class="text-[#c4a898] text-[10px] uppercase tracking-widest px-3 pb-2 pt-1">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.dashboard') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/>
            </svg>
            <span>Dashboard</span>
        </a>
        
        {{-- Kategori --}}
        <a href="{{ route('admin.kategori.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.kategori.*') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.kategori.*') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
            </svg>
            <span>Kategori</span>
        </a>
        
        {{-- Buku --}}
        <a href="{{ route('admin.buku.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.buku.*') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.buku.*') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <span>Buku</span>
        </a>

        {{-- Akun Peminjam --}}
        <a href="{{ route('admin.users.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.users.*') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>Akun Peminjam</span>
        </a>

        <p class="text-[#c4a898] text-[10px] uppercase tracking-widest px-3 pb-2 pt-4">Peminjaman</p>

        {{-- Peminjaman --}}
        <a href="{{ route('admin.peminjaman.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.peminjaman.*') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.peminjaman.*') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span>Peminjaman</span>
            @php
                $pendingPeminjaman = \App\Models\Booking::where('status', 'pending')->count();
            @endphp
            @if($pendingPeminjaman > 0)
                <span class="ml-auto bg-white text-[#7B1518] text-xs font-bold px-2 py-0.5 rounded-full shadow-inner"
                      style="box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                    {{ $pendingPeminjaman }}
                </span>
            @endif
        </a>

        {{-- Permohonan Akun --}}
        <a href="{{ route('admin.account-requests.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.account-requests.*') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.account-requests.*') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            <span>Permohonan Akun</span>
            @php
                $pendingCount = \App\Models\AccountRequest::where('status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="ml-auto bg-white text-[#7B1518] text-xs font-bold px-2 py-0.5 rounded-full shadow-inner"
                      style="box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                    {{ $pendingCount }}
                </span>
            @endif
        </a>

        {{-- Riwayat --}}
        <a href="{{ route('admin.riwayat.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.riwayat.*') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.riwayat.*') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
            <svg class="w-4.5 h-4.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Riwayat</span>
        </a>

        {{-- Notifikasi --}}
        <a href="{{ route('admin.notifikasi.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200
                {{ request()->routeIs('admin.notifikasi.*') ? 'bg-gradient-to-r from-[#7B1518] to-[#8B1A1A] text-white shadow-md' : 'text-[#6b5a54] hover:text-[#2C1810] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10' }}"
            style="{{ request()->routeIs('admin.notifikasi.*') ? 'box-shadow: 0 4px 8px -2px rgba(123,21,24,0.3), inset 0 1px 1px rgba(255,255,255,0.2);' : '' }}">
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
                <span class="ml-auto bg-white text-[#7B1518] text-xs font-bold px-2 py-0.5 rounded-full shadow-inner"
                      style="box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                    {{ $unreadCount }}
                </span>
            @endif
        </a>

        {{-- Extra spacer for better scrolling --}}
        <div class="h-4"></div>

    </nav>

    {{-- Logout Button - Fixed at bottom --}}
    <div class="relative px-3 py-4 border-t border-[#7B1518]/10 flex-shrink-0">
        <button onclick="confirmLogout()"
            class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-[#6b5a54] hover:text-[#7B1518] hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10 transition-all duration-200">
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