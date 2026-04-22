<x-layout-peminjam>
    <x-slot name="title">Daftar Buku</x-slot>
    
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-white" style="font-family: 'Cormorant Garamond', serif;">Daftar Buku</h1>
        <p class="text-[#5a5a65] text-sm mt-1">Cari dan pinjam buku yang tersedia</p>
    </div>

    {{-- Pencarian --}}
    <div class="mb-6">
        <form method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#5a5a65]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" 
                    placeholder="Cari judul, pengarang, atau penerbit..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-[#111114] border border-white/[0.08] rounded-xl text-sm text-white placeholder-[#5a5a65] focus:outline-none focus:border-[#d4af6a]/50 transition">
            </div>
            <button type="submit" 
                class="px-4 py-2.5 bg-[#111114] border border-white/[0.08] rounded-xl text-sm text-white hover:border-[#d4af6a]/50 transition">
                Cari
            </button>
            @if(request('cari'))
            <a href="{{ route('peminjam.buku.index') }}" 
                class="px-4 py-2.5 text-sm text-[#5a5a65] hover:text-white transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Daftar Buku --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($buku as $item)
        <div class="bg-[#111114] border border-white/[0.08] rounded-2xl overflow-hidden hover:border-[#d4af6a]/30 transition-all">
            {{-- Foto Buku --}}
            <div class="aspect-[4/3] bg-gradient-to-br from-[#1a1a1f] to-[#0e0e10] flex items-center justify-center">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-16 h-16 text-[#3d3d45]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                @endif
            </div>
            
            {{-- Info Buku --}}
            <div class="p-5">
                <h3 class="text-white font-semibold text-lg mb-1 line-clamp-1">{{ $item->judul }}</h3>
                <p class="text-[#d4af6a] text-sm mb-2">{{ $item->pengarang }}</p>
                
                <div class="space-y-1 mb-4">
                    <p class="text-[#8a8a95] text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                        </svg>
                        {{ $item->penerbit }} ({{ $item->tahun_terbit }})
                    </p>
                    <p class="text-[#8a8a95] text-sm flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Stok: {{ $item->stok }} buku
                    </p>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="px-2 py-1 text-xs rounded-full bg-green-400/10 text-green-400">
                        Tersedia
                    </span>
                    <a href="{{ route('peminjam.buku.show', $item) }}" 
                        class="px-4 py-2 bg-[#d4af6a] text-[#0e0e10] rounded-xl text-sm font-medium hover:bg-[#c4a05a] transition">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-[#111114] border border-white/[0.08] rounded-2xl p-12 text-center">
            <svg class="w-16 h-16 text-[#3d3d45] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
            </svg>
            <p class="text-[#8a8a95] text-lg mb-2">Belum ada buku tersedia</p>
            <p class="text-[#5a5a65] text-sm">Silakan hubungi admin untuk menambahkan buku.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($buku->hasPages())
    <div class="mt-8">
        {{ $buku->appends(request()->query())->links() }}
    </div>
    @endif
</x-layout-peminjam>