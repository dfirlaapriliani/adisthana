<header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-[#7B1518]/10 px-6 py-3">
    <div class="flex items-center justify-between">
        {{-- Left: Mobile Menu Toggle --}}
        <div class="flex items-center gap-3">
            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('sidebar-overlay').classList.toggle('hidden')" 
                class="lg:hidden p-2 rounded-lg hover:bg-[#7B1518]/5 transition">
                <svg class="w-5 h-5 text-[#2C1810]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            
            {{-- Page Title (Optional) --}}
            <h2 class="text-lg font-medium text-[#2C1810] hidden sm:block" style="font-family: 'Cormorant Garamond', serif;">
                {{ $title ?? 'Dashboard' }}
            </h2>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-2">
            {{-- Notification Bell --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="p-2 rounded-lg hover:bg-[#7B1518]/5 transition relative">
                    <svg class="w-5 h-5 text-[#6b5a54]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php
                        $unreadCount = \App\Models\UserNotification::where('user_id', auth()->id())
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    @if($unreadCount > 0)
                    <span class="absolute top-1 right-1 w-2 h-2 bg-[#7B1518] rounded-full"></span>
                    @endif
                </button>
                
                {{-- Dropdown Notifikasi --}}
                <div x-show="open" @click.away="open = false" 
                    class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-[#7B1518]/10 overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-[#7B1518]/10">
                        <h3 class="text-sm font-medium text-[#2C1810]">Notifikasi</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @php
                            $notifications = \App\Models\UserNotification::where('user_id', auth()->id())
                                ->latest()
                                ->take(10)
                                ->get();
                        @endphp
                        @forelse($notifications as $notif)
                        <div class="px-4 py-3 border-b border-[#7B1518]/5 hover:bg-[#F0EBE3]/30 transition {{ $notif->is_read ? '' : 'bg-[#7B1518]/5' }}">
                            <p class="text-sm text-[#2C1810] font-medium">{{ $notif->title }}</p>
                            <p class="text-xs text-[#9a8a80] mt-1">{{ $notif->message }}</p>
                            <p class="text-[10px] text-[#c4a898] mt-2">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                        @empty
                        <p class="text-center text-[#9a8a80] text-sm py-8">Tidak ada notifikasi</p>
                        @endforelse
                    </div>
                    @if($notifications->count() > 0)
                    <div class="px-4 py-2 bg-[#F0EBE3]/50 border-t border-[#7B1518]/10">
                        <a href="#" class="text-xs text-[#7B1518] hover:underline">Lihat semua notifikasi</a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- User Menu --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-[#7B1518]/5 transition">
                    <div class="w-8 h-8 rounded-full bg-[#7B1518]/10 border border-[#7B1518]/20 flex items-center justify-center">
                        <span class="text-[#7B1518] text-xs font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <span class="hidden md:block text-sm text-[#2C1810]">{{ auth()->user()->name }}</span>
                    <svg class="w-4 h-4 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                {{-- Dropdown --}}
                <div x-show="open" @click.away="open = false" 
                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-[#7B1518]/10 overflow-hidden z-50">
                    <div class="px-4 py-3 border-b border-[#7B1518]/10">
                        <p class="text-sm font-medium text-[#2C1810]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#9a8a80]">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50 transition flex items-center gap-2">
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