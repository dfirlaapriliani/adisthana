<x-layout-peminjam>
    <x-slot name="title">Riwayat Peminjaman</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-white" style="font-family: 'Cormorant Garamond', serif;">Riwayat Peminjaman</h1>
        <p class="text-[#5a5a65] text-sm mt-1">Daftar peminjaman yang telah selesai</p>
    </div>

    {{-- Filter Status --}}
    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
        @php
            $filters = [
                '' => 'Semua',
                'returned' => 'Dikembalikan',
                'rejected' => 'Ditolak',
                'cancelled' => 'Dibatalkan',
            ];
        @endphp
        @foreach($filters as $key => $label)
        <a href="{{ route('peminjam.riwayat.index', ['filter' => $key]) }}" 
            class="px-3 py-1.5 text-xs rounded-full whitespace-nowrap transition
                {{ request('filter', '') == $key 
                    ? 'bg-[#d4af6a] text-[#0e0e10]' 
                    : 'bg-[#1a1a1f] text-[#8a8a95] border border-white/[0.08] hover:bg-[#222]' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Daftar Riwayat --}}
    <div class="space-y-3">
        @forelse($riwayat as $item)
        <div class="bg-[#111114] border border-white/[0.08] rounded-xl p-4">
            <div class="flex gap-3">
                {{-- Foto Buku --}}
                <div class="w-12 h-16 bg-gradient-to-br from-[#1a1a1f] to-[#0e0e10] rounded flex items-center justify-center overflow-hidden flex-shrink-0">
                    @if($item->book->foto)
                        <img src="{{ asset('storage/' . $item->book->foto) }}" alt="{{ $item->book->judul }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-5 h-5 text-[#3d3d45]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                        </svg>
                    @endif
                </div>
                
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-white font-medium text-sm">{{ $item->book->judul }}</h3>
                            <p class="text-[#8a8a95] text-xs">{{ $item->jumlah }} buku</p>
                        </div>
                        @php
                            $statusColors = [
                                'returned' => 'bg-green-500/20 text-green-400',
                                'rejected' => 'bg-red-500/20 text-red-400',
                                'cancelled' => 'bg-gray-500/20 text-gray-400',
                            ];
                            $statusLabels = [
                                'returned' => 'Dikembalikan',
                                'rejected' => 'Ditolak',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <span class="px-2 py-0.5 text-[10px] rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-500/20 text-gray-400' }}">
                            {{ $statusLabels[$item->status] ?? $item->status }}
                        </span>
                    </div>
                    
                    <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-[10px] text-[#5a5a65]">
                        <span>Pinjam: {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</span>
                        @if($item->tanggal_dikembalikan)
                            <span>Kembali: {{ \Carbon\Carbon::parse($item->tanggal_dikembalikan)->format('d M Y') }}</span>
                        @endif
                    </div>
                    
                    @if($item->catatan && $item->status == 'rejected')
                    <div class="mt-2 p-2 bg-red-500/5 border border-red-500/10 rounded-lg">
                        <p class="text-[10px] text-[#5a5a65]">Alasan penolakan:</p>
                        <p class="text-xs text-red-400">{{ $item->catatan }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-[#111114] border border-white/[0.08] rounded-xl p-12 text-center">
            <svg class="w-16 h-16 text-[#3d3d45] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-[#8a8a95]">Belum ada riwayat peminjaman</p>
        </div>
        @endforelse
    </div>

    @if($riwayat->hasPages())
    <div class="mt-6">
        {{ $riwayat->links() }}
    </div>
    @endif
</x-layout-peminjam>