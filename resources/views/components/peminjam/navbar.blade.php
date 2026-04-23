{{-- resources/views/components/peminjam/navbar.blade.php --}}
<header class="sticky top-0 z-30 bg-[#FFF9F0]/95 backdrop-blur-xl border-b-2 border-[#C75B39]/20 px-4 sm:px-6 py-3">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2 sm:gap-3">
            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full'); document.getElementById('sidebar-overlay').classList.toggle('hidden')" 
                class="lg:hidden p-2 rounded-lg hover:bg-[#C75B39]/10 transition">
                <svg class="w-5 h-5 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            
            <h2 class="text-base sm:text-lg font-bold text-[#4A1C1C] hidden sm:block brand">
                {{ $title ?? 'Dashboard' }}
            </h2>
        </div>

        <div class="flex items-center gap-2">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 p-1.5 rounded-lg hover:bg-[#C75B39]/10 transition">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#C75B39] to-[#8B3A3A] border-2 border-[#C75B39] flex items-center justify-center shadow-sm">
                        <span class="text-white text-xs font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <span class="hidden md:block text-sm font-medium text-[#4A1C1C]">{{ auth()->user()->name }}</span>
                    <svg class="w-4 h-4 text-[#8B3A3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-56 bg-[#FFF9F0] rounded-xl shadow-xl border-2 border-[#C75B39]/30 overflow-hidden z-50">
                    
                    <div class="px-4 py-3 border-b-2 border-[#C75B39]/20">
                        <p class="text-sm font-bold text-[#4A1C1C]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#8B3A3A] font-medium">{{ auth()->user()->class_code ?? auth()->user()->email }}</p>
                    </div>
                    
                    <div class="py-1">
                        <a href="{{ route('peminjam.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-[#5A2A2A] hover:bg-[#C75B39] hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profil Saya
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>