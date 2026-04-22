<x-layout-admin>
    <x-slot name="title">Profil Saya</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Profil Saya</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Informasi akun administrator</p>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm p-6">
        {{-- Avatar --}}
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-[#7B1518]/10">
            <div class="w-20 h-20 rounded-full bg-[#7B1518]/10 border-2 border-[#7B1518]/20 flex items-center justify-center">
                <span class="text-[#7B1518] text-3xl font-semibold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
            <div>
                <h2 class="text-xl font-medium text-[#2C1810]">{{ auth()->user()->name }}</h2>
                <span class="inline-block px-3 py-1 mt-1 text-xs rounded-full bg-[#7B1518]/10 text-[#7B1518]">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>
        </div>

        {{-- Info Detail --}}
        <div class="space-y-4">
            <div class="flex items-center py-2 border-b border-[#7B1518]/5">
                <div class="w-32 flex items-center gap-2 text-[#9a8a80]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 7.89a2 2 0 002.828 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Email</span>
                </div>
                <span class="text-[#2C1810] text-sm font-medium">{{ auth()->user()->email }}</span>
            </div>
            
            <div class="flex items-center py-2 border-b border-[#7B1518]/5">
                <div class="w-32 flex items-center gap-2 text-[#9a8a80]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="text-sm">No. HP</span>
                </div>
                <span class="text-[#2C1810] text-sm font-medium">{{ auth()->user()->phone ?? '-' }}</span>
            </div>
            
            @if(auth()->user()->room_location)
            <div class="flex items-center py-2 border-b border-[#7B1518]/5">
                <div class="w-32 flex items-center gap-2 text-[#9a8a80]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                    <span class="text-sm">Ruangan</span>
                </div>
                <span class="text-[#2C1810] text-sm font-medium">{{ auth()->user()->room_location }}</span>
            </div>
            @endif
            
            @if(auth()->user()->office_hours)
            <div class="flex items-center py-2 border-b border-[#7B1518]/5">
                <div class="w-32 flex items-center gap-2 text-[#9a8a80]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm">Jam Kerja</span>
                </div>
                <span class="text-[#2C1810] text-sm font-medium">{{ auth()->user()->office_hours }}</span>
            </div>
            @endif
            
            <div class="flex items-center py-2">
                <div class="w-32 flex items-center gap-2 text-[#9a8a80]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Bergabung</span>
                </div>
                <span class="text-[#2C1810] text-sm font-medium">{{ auth()->user()->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</x-layout-admin>