{{-- Navbar - Full Width 3D Floating dengan Border Melengkung --}}
<header class="relative z-30">
    <div class="w-full">
        <div class="bg-white/90 backdrop-blur-xl rounded-full shadow-3d-nav border border-white/40 px-4 md:px-6 lg:px-8 py-3"
             style="box-shadow: 0 15px 30px -8px rgba(0,0,0,0.15), 0 4px 10px -3px rgba(0,0,0,0.1), inset 0 1px 2px rgba(255,255,255,0.8);">
            
            <div class="flex items-center justify-between">
                {{-- Left: Mobile Menu Toggle & Title --}}
                <div class="flex items-center gap-3 md:gap-4">
                    <button onclick="openSidebar()" 
                        class="lg:hidden p-2 -ml-1 rounded-full hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10 transition">
                        <svg class="w-5 h-5 text-[#2C1810]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <h2 class="text-lg md:text-xl font-medium text-[#2C1810] brand">
                        {{ $title ?? 'Dashboard' }}
                    </h2>
                </div>

                {{-- Right: Profile --}}
                <div class="flex items-center gap-2 md:gap-3">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                            class="flex items-center gap-2 md:gap-3 p-1 md:p-1.5 rounded-full hover:bg-[#7B1518]/5 active:bg-[#7B1518]/10 transition">
                            <div class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-gradient-to-br from-[#7B1518] to-[#A52A2A] flex items-center justify-center flex-shrink-0 shadow-md"
                                 style="box-shadow: 0 4px 6px -2px rgba(123,21,24,0.3), inset 0 1px 2px rgba(255,255,255,0.3);">
                                <span class="text-white text-xs md:text-sm font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-xs md:text-sm font-medium text-[#2C1810]">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] md:text-xs text-[#9a8a80]">Administrator</p>
                            </div>
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-[#9a8a80] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        {{-- Dropdown --}}
                        <div x-show="open" 
                             x-cloak
                             @click.away="open = false" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-3d border border-white/40 overflow-hidden z-50">
                            
                            <div class="px-4 py-3 border-b border-[#7B1518]/10 bg-gradient-to-b from-white to-[#F0EBE3]/30">
                                <p class="text-sm font-medium text-[#2C1810] truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-[#9a8a80] truncate">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <div class="py-1">
                                <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-[#2C1810] hover:bg-[#F0EBE3] transition">
                                    <svg class="w-4 h-4 text-[#9a8a80] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Profil Saya</span>
                                </a>
                                
                                <div class="border-t border-[#7B1518]/10 my-1"></div>
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        <span>Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>