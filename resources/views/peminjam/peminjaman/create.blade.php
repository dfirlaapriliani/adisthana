<x-layout-peminjam>
    <x-slot name="title">Ajukan Peminjaman</x-slot>
    
    <div class="mb-4">
        <a href="{{ route('peminjam.buku.show', $buku) }}" class="text-[#8a8a95] hover:text-white text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke detail buku
        </a>
    </div>

    <div class="bg-[#111114] border border-white/[0.08] rounded-xl p-5">
        <h1 class="text-xl font-semibold text-white mb-4" style="font-family: 'Cormorant Garamond', serif;">Ajukan Peminjaman</h1>
        
        {{-- Info Buku --}}
        <div class="flex gap-3 mb-6 p-3 bg-[#1a1a1f] rounded-lg">
            <div class="w-12 h-16 bg-gradient-to-br from-[#1a1a1f] to-[#0e0e10] rounded flex items-center justify-center overflow-hidden flex-shrink-0">
                @if($buku->foto)
                    <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-5 h-5 text-[#3d3d45]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                    </svg>
                @endif
            </div>
            <div>
                <h2 class="text-white font-medium">{{ $buku->judul }}</h2>
                <p class="text-[#8a8a95] text-sm">{{ $buku->pengarang }}</p>
                <p class="text-[#5a5a65] text-xs mt-1">Stok tersedia: {{ $buku->stok }} buku</p>
            </div>
        </div>

        <form action="{{ route('peminjam.peminjaman.store') }}" method="POST">
            @csrf
            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
            
            <div class="space-y-4">
                {{-- Jumlah --}}
                <div>
                    <label class="block text-sm font-medium text-[#c0c0c5] mb-1.5">
                        Jumlah Buku <span class="text-red-400">*</span>
                    </label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" required
                        min="1" max="{{ $buku->stok }}"
                        class="w-full px-4 py-2.5 bg-[#1a1a1f] border border-white/[0.08] rounded-lg text-sm text-white focus:outline-none focus:border-[#d4af6a] transition @error('jumlah') border-red-500 @enderror">
                    @error('jumlah')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Pinjam --}}
                <div>
                    <label class="block text-sm font-medium text-[#c0c0c5] mb-1.5">
                        Tanggal Pinjam <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-2.5 bg-[#1a1a1f] border border-white/[0.08] rounded-lg text-sm text-white focus:outline-none focus:border-[#d4af6a] transition @error('tanggal_pinjam') border-red-500 @enderror">
                    @error('tanggal_pinjam')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Kembali --}}
                <div>
                    <label class="block text-sm font-medium text-[#c0c0c5] mb-1.5">
                        Tanggal Kembali <span class="text-red-400">*</span>
                    </label>
                    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                        class="w-full px-4 py-2.5 bg-[#1a1a1f] border border-white/[0.08] rounded-lg text-sm text-white focus:outline-none focus:border-[#d4af6a] transition @error('tanggal_kembali') border-red-500 @enderror">
                    @error('tanggal_kembali')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div>
                    <label class="block text-sm font-medium text-[#c0c0c5] mb-1.5">
                        Catatan (Opsional)
                    </label>
                    <textarea name="catatan" rows="3"
                        placeholder="Tambahan informasi..."
                        class="w-full px-4 py-2.5 bg-[#1a1a1f] border border-white/[0.08] rounded-lg text-sm text-white focus:outline-none focus:border-[#d4af6a] transition @error('catatan') border-red-500 @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 mt-6 pt-4 border-t border-white/[0.08]">
                <a href="{{ route('peminjam.buku.show', $buku) }}" 
                    class="flex-1 px-4 py-2.5 bg-[#1a1a1f] border border-white/[0.08] rounded-lg text-sm text-[#c0c0c5] hover:bg-[#222] transition text-center">
                    Batal
                </a>
                <button type="submit" 
                    class="flex-1 px-4 py-2.5 bg-[#d4af6a] text-[#0e0e10] rounded-lg text-sm font-medium hover:bg-[#c4a05a] transition">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>
</x-layout-peminjam>