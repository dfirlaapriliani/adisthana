<x-layout-peminjam>
    <x-slot name="title">{{ $buku->judul }}</x-slot>
    
    <div class="mb-6">
        <a href="{{ route('peminjam.buku.index') }}" class="text-[#8a8a95] hover:text-white text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar buku
        </a>
    </div>

    <div class="bg-[#111114] border border-white/[0.08] rounded-2xl overflow-hidden">
        <div class="grid md:grid-cols-2 gap-6 p-6">
            {{-- Foto --}}
            <div class="aspect-[4/3] bg-gradient-to-br from-[#1a1a1f] to-[#0e0e10] rounded-xl flex items-center justify-center">
                @if($buku->foto)
                    <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover rounded-xl">
                @else
                    <svg class="w-24 h-24 text-[#3d3d45]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                @endif
            </div>
            
            {{-- Info --}}
            <div>
                <h1 class="text-2xl font-semibold text-white mb-2" style="font-family: 'Cormorant Garamond', serif;">{{ $buku->judul }}</h1>
                <p class="text-[#d4af6a] text-lg mb-4">{{ $buku->pengarang }}</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center gap-3">
                        <span class="text-[#5a5a65] w-28">Penerbit</span>
                        <span class="text-white">{{ $buku->penerbit }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[#5a5a65] w-28">Tahun Terbit</span>
                        <span class="text-white">{{ $buku->tahun_terbit }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[#5a5a65] w-28">Stok</span>
                        <span class="text-white">{{ $buku->stok }} buku</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-[#5a5a65] w-28">Status</span>
                        <span class="px-2 py-1 text-xs rounded-full bg-green-400/10 text-green-400">Tersedia</span>
                    </div>
                </div>
                
                @if($buku->deskripsi)
                <div class="mb-6">
                    <p class="text-[#5a5a65] text-sm mb-2">Deskripsi</p>
                    <p class="text-[#8a8a95] text-sm leading-relaxed">{{ $buku->deskripsi }}</p>
                </div>
                @endif
                
                @if(!auth()->user()->hasActivePenalty())
                <a href="{{ route('peminjam.peminjaman.create', ['buku_id' => $buku->id]) }}" 
                    class="inline-block px-6 py-3 bg-[#d4af6a] text-[#0e0e10] rounded-xl font-medium hover:bg-[#c4a05a] transition">
                    Ajukan Peminjaman
                </a>
                @else
                <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-xl">
                    <p class="text-red-400 text-sm">Anda sedang dalam masa penalti, tidak dapat mengajukan peminjaman.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout-peminjam>