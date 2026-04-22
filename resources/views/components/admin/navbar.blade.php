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
            
            {{-- Page Title --}}
            <h2 class="text-lg font-medium text-[#2C1810] hidden sm:block" style="font-family: 'Cormorant Garamond', serif;">
                {{ $title ?? 'Dashboard' }}
            </h2>
        </div>

        {{-- Right: Profile Menu --}}
        <div class="flex items-center gap-2">
            {{-- Profile Dropdown --}}
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
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-[#7B1518]/10 overflow-hidden z-50">
                    {{-- Profile Info --}}
                    <div class="px-4 py-3 border-b border-[#7B1518]/10">
                        <p class="text-sm font-medium text-[#2C1810]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#9a8a80]">{{ auth()->user()->email }}</p>
                    </div>
                    
                    {{-- Menu --}}
                    <div class="py-1">
                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#2C1810] hover:bg-[#F0EBE3] transition">
                            <svg class="w-4 h-4 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
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
    </div>
</header>