<header class="sticky top-0 z-30 bg-[#0e0e10]/80 backdrop-blur-xl border-b border-white/[0.05] px-6 py-3">
    <div class="flex items-center justify-between">
        {{-- Left: Mobile Menu Toggle --}}
        <div class="flex items-center gap-3">
            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('sidebar-overlay').classList.toggle('hidden')" 
                class="lg:hidden p-2 rounded-lg hover:bg-white/[0.05] transition">
                <svg class="w-5 h-5 text-[#8a8a95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            
            {{-- Page Title --}}
            <h2 class="text-lg font-medium text-white hidden sm:block" style="font-family: 'Cormorant Garamond', serif;">
                {{ $title ?? 'Dashboard' }}
            </h2>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-2">
            {{-- Notification Bell --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="p-2 rounded-lg hover:bg-white/[0.05] transition relative">
                    <svg class="w-5 h-5 text-[#8a8a95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php
                        $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="absolute top-1 right-1 w-2 h-2 bg-[#d4af6a] rounded-full"></span>
                    @endif
                </button>
                
                {{-- Dropdown Notifikasi --}}
                <div x-show="open" @click.away="open = false" 
                    class="absolute right-0 mt-2 w-80 bg-[#111114] rounded-xl shadow-xl border border-white/[0.08] overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-white/[0.08]">
                        <h3 class="text-sm font-medium text-white">Notifikasi</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @php
                            $notifications = \App\Models\UserNotification::where('user_id', auth()->id())
                                ->latest()
                                ->take(10)
                                ->get();
                        @endphp
                        @forelse($notifications as $notif)
                        <a href="{{ route('peminjam.notifications.index') }}" class="block px-4 py-3 border-b border-white/[0.05] hover:bg-white/[0.03] transition {{ $notif->is_read ? '' : 'bg-[#d4af6a]/5' }}">
                            <p class="text-sm text-white font-medium">{{ $notif->title }}</p>
                            <p class="text-xs text-[#8a8a95] mt-1">{{ $notif->message }}</p>
                            <p class="text-[10px] text-[#5a5a65] mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                        </a>
                        @empty
                        <p class="text-center text-[#5a5a65] text-sm py-8">Tidak ada notifikasi</p>
                        @endforelse
                    </div>
                    @if($notifications->count() > 0)
                    <div class="px-4 py-2 bg-[#0e0e10] border-t border-white/[0.08]">
                        <a href="{{ route('peminjam.notifications.index') }}" class="text-xs text-[#d4af6a] hover:underline">Lihat semua notifikasi</a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- User Menu --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-white/[0.05] transition">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#d4af6a]/30 to-[#8a6428]/30 border border-[#d4af6a]/20 flex items-center justify-center">
                        <span class="text-[#d4af6a] text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <span class="hidden md:block text-sm text-white">{{ auth()->user()->name }}</span>
                    <svg class="w-4 h-4 text-[#5a5a65]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                {{-- Dropdown --}}
                <div x-show="open" @click.away="open = false" 
                    class="absolute right-0 mt-2 w-48 bg-[#111114] rounded-xl shadow-xl border border-white/[0.08] overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-white/[0.08]">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#8a8a95]">{{ auth()->user()->identifier ?? auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 text-left text-sm text-red-400 hover:bg-red-500/10 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>