<x-layout-peminjam>
    <x-slot name="title">Detail Peminjaman</x-slot>
    
    <div class="mb-4">
        <a href="{{ route('peminjam.peminjaman.index') }}" class="text-[#8a8a95] hover:text-white text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar
        </a>
    </div>

    <div class="bg-[#111114] border border-white/[0.08] rounded-xl p-4">
        {{-- Status --}}
        <div class="mb-4">
            @php
                $statusColors = [
                    'pending' => 'bg-amber-500/20 text-amber-400 border-amber-500/30',
                    'approved' => 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                    'borrowed' => 'bg-purple-500/20 text-purple-400 border-purple-500/30',
                    'returned' => 'bg-green-500/20 text-green-400 border-green-500/30',
                    'rejected' => 'bg-red-500/20 text-red-400 border-red-500/30',
                    'cancelled' => 'bg-gray-500/20 text-gray-400 border-gray-500/30',
                ];
                $statusLabels = [
                    'pending' => 'Menunggu Persetujuan',
                    'approved' => 'Disetujui - Silakan Ambil Buku',
                    'borrowed' => 'Sedang Dipinjam',
                    'returned' => 'Telah Dikembalikan',
                    'rejected' => 'Ditolak',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp
            <span class="inline-block px-3 py-1.5 text-sm rounded-lg border {{ $statusColors[$peminjaman->status] ?? 'bg-gray-500/20 text-gray-400' }}">
                {{ $statusLabels[$peminjaman->status] ?? $peminjaman->status }}
            </span>
        </div>

        {{-- Info Buku --}}
        <div class="flex gap-3 mb-4 p-3 bg-[#1a1a1f] rounded-lg">
            <div class="w-14 h-20 bg-gradient-to-br from-[#1a1a1f] to-[#0e0e10] rounded flex items-center justify-center overflow-hidden flex-shrink-0">
                @if($peminjaman->book->foto)
                    <img src="{{ asset('storage/' . $peminjaman->book->foto) }}" alt="{{ $peminjaman->book->judul }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-6 h-6 text-[#3d3d45]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                    </svg>
                @endif
            </div>
            <div>
                <h2 class="text-white font-medium">{{ $peminjaman->book->judul }}</h2>
                <p class="text-[#8a8a95] text-sm">{{ $peminjaman->book->pengarang }}</p>
                <p class="text-[#5a5a65] text-xs mt-1">{{ $peminjaman->jumlah }} buku</p>
            </div>
        </div>

        {{-- Detail Peminjaman --}}
        <div class="space-y-2">
            <div class="flex">
                <span class="text-[#5a5a65] w-28 text-sm">Tanggal Pinjam</span>
                <span class="text-white text-sm">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</span>
            </div>
            <div class="flex">
                <span class="text-[#5a5a65] w-28 text-sm">Tanggal Kembali</span>
                <span class="text-white text-sm">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</span>
            </div>
            @if($peminjaman->tanggal_dikembalikan)
            <div class="flex">
                <span class="text-[#5a5a65] w-28 text-sm">Dikembalikan</span>
                <span class="text-white text-sm">{{ \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d M Y') }}</span>
            </div>
            @endif
            @if($peminjaman->catatan)
            <div class="pt-2 mt-2 border-t border-white/[0.08]">
                <p class="text-[#5a5a65] text-xs mb-1">Catatan</p>
                <p class="text-[#c0c0c5] text-sm">{{ $peminjaman->catatan }}</p>
            </div>
            @endif
        </div>

        {{-- Tombol Batal --}}
        @if(in_array($peminjaman->status, ['pending', 'approved']))
        <div class="mt-4 pt-4 border-t border-white/[0.08]">
            <form action="{{ route('peminjam.peminjaman.batal', $peminjaman) }}" method="POST">
                @csrf
                <button type="submit" 
                    onclick="return confirm('Batalkan peminjaman ini?')"
                    class="w-full px-4 py-2.5 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm hover:bg-red-500/20 transition">
                    Batalkan Peminjaman
                </button>
            </form>
        </div>
        @endif
    </div>
</x-layout-peminjam>