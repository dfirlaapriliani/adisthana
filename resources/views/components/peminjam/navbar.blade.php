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

        {{-- Right: Profile Menu --}}
        <div class="flex items-center gap-2">
            {{-- Profile Dropdown --}}
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
                    class="absolute right-0 mt-2 w-56 bg-[#111114] rounded-xl shadow-xl border border-white/[0.08] overflow-hidden z-50">
                    
                    {{-- Profile Info --}}
                    <div class="px-4 py-3 border-b border-white/[0.08]">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#8a8a95]">{{ auth()->user()->class_code ?? auth()->user()->email }}</p>
                    </div>
                    
                    {{-- Menu --}}
                    <div class="py-1">
                        {{-- Profil Saya --}}
                        <a href="{{ route('peminjam.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-[#c0c0c5] hover:bg-white/[0.05] transition">
                            <svg class="w-4 h-4 text-[#8a8a95]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>