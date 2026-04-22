<x-layout-peminjam>
    <x-slot name="title">Profil Kelas</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white" style="font-family: 'Cormorant Garamond', serif;">Profil Kelas</h1>
        <p class="text-[#5a5a65] text-sm mt-1">Informasi akun kelas</p>
    </div>

    <div class="bg-[#111114] border border-white/[0.08] rounded-xl p-6">
        {{-- Kode Kelas --}}
        <div class="mb-6 p-4 bg-[#1a1a1f] rounded-xl border border-white/[0.05]">
            <p class="text-[#5a5a65] text-xs uppercase tracking-wider mb-1">Kode Kelas</p>
            <p class="text-3xl font-mono font-bold text-[#d4af6a]">{{ auth()->user()->class_code ?? 'Belum ada' }}</p>
        </div>

        {{-- Info --}}
        <div class="space-y-4">
            <div class="flex items-center py-2 border-b border-white/[0.05]">
                <div class="w-32 flex items-center gap-2 text-[#5a5a65]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                    <span class="text-sm">Nama Kelas</span>
                </div>
                <span class="text-white text-sm">{{ auth()->user()->name }}</span>
            </div>
            
            @if(auth()->user()->class_name)
            <div class="flex items-center py-2 border-b border-white/[0.05]">
                <div class="w-32 flex items-center gap-2 text-[#5a5a65]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm">Detail</span>
                </div>
                <span class="text-white text-sm">{{ auth()->user()->class_name }}</span>
            </div>
            @endif
            
            <div class="flex items-center py-2 border-b border-white/[0.05]">
                <div class="w-32 flex items-center gap-2 text-[#5a5a65]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 7.89a2 2 0 002.828 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Email</span>
                </div>
                <span class="text-white text-sm">{{ auth()->user()->email }}</span>
            </div>
            
            <div class="flex items-center py-2 border-b border-white/[0.05]">
                <div class="w-32 flex items-center gap-2 text-[#5a5a65]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="text-sm">No. HP</span>
                </div>
                <span class="text-white text-sm">{{ auth()->user()->phone ?? '-' }}</span>
            </div>
            
            <div class="flex items-center py-2">
                <div class="w-32 flex items-center gap-2 text-[#5a5a65]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Terdaftar</span>
                </div>
                <span class="text-white text-sm">{{ auth()->user()->created_at->format('d M Y') }}</span>
            </div>
        </div>
        
        {{-- Status Penalti --}}
        @if(auth()->user()->hasActivePenalty())
        <div class="mt-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
            <p class="text-red-400 text-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Sedang dalam masa penalti hingga {{ \Carbon\Carbon::parse(auth()->user()->penalty_until)->format('d M Y') }}
            </p>
        </div>
        @endif
    </div>
</x-layout-peminjam>