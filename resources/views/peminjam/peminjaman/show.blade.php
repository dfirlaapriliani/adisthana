{{-- resources/views/peminjam/peminjaman/show.blade.php --}}
<x-layout-peminjam>
    <x-slot name="title">Detail Peminjaman</x-slot>
    
    <div class="mb-4">
        <a href="{{ route('peminjam.peminjaman.index') }}" class="text-[#8B3A3A] hover:text-[#C75B39] text-sm font-medium flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar
        </a>
    </div>

    <div class="bg-white border-2 border-[#C75B39]/20 rounded-xl p-4 sm:p-5 shadow-md">
        {{-- Status --}}
        <div class="mb-4">
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800 border-2 border-yellow-400',
                    'approved' => 'bg-blue-100 text-blue-800 border-2 border-blue-400',
                    'borrowed' => 'bg-purple-100 text-purple-800 border-2 border-purple-400',
                    'returned' => 'bg-green-100 text-green-800 border-2 border-green-400',
                    'rejected' => 'bg-red-100 text-red-800 border-2 border-red-400',
                    'cancelled' => 'bg-gray-100 text-gray-800 border-2 border-gray-400',
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
            <span class="inline-block px-3 py-1.5 text-sm font-bold rounded-lg {{ $statusColors[$peminjaman->status] ?? 'bg-gray-100 text-gray-800 border-2 border-gray-400' }}">
                {{ $statusLabels[$peminjaman->status] ?? $peminjaman->status }}
            </span>
        </div>

        {{-- Info Buku --}}
        <div class="flex gap-3 mb-4 p-3 bg-[#FFF5E8] rounded-lg border-2 border-[#C75B39]/20">
            <div class="w-14 h-20 bg-gradient-to-br from-[#FFF5E8] to-[#F5CDA7] rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0 border-2 border-[#C75B39]/30">
                @if($peminjaman->book->foto)
                    <img src="{{ asset('storage/' . $peminjaman->book->foto) }}" alt="{{ $peminjaman->book->judul }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-6 h-6 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                    </svg>
                @endif
            </div>
            <div>
                <h2 class="text-[#4A1C1C] font-bold">{{ $peminjaman->book->judul }}</h2>
                <p class="text-[#8B3A3A] text-sm font-medium">{{ $peminjaman->book->pengarang }}</p>
                <p class="text-[#C75B39] text-xs font-bold mt-1">{{ $peminjaman->jumlah }} buku</p>
            </div>
        </div>

        {{-- Detail Peminjaman --}}
        <div class="space-y-2">
            <div class="flex">
                <span class="text-[#8B3A3A] w-28 text-sm font-medium">Tanggal Pinjam</span>
                <span class="text-[#4A1C1C] text-sm font-bold">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</span>
            </div>
            <div class="flex">
                <span class="text-[#8B3A3A] w-28 text-sm font-medium">Tanggal Kembali</span>
                <span class="text-[#4A1C1C] text-sm font-bold">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</span>
            </div>
            @if($peminjaman->tanggal_dikembalikan)
            <div class="flex">
                <span class="text-[#8B3A3A] w-28 text-sm font-medium">Dikembalikan</span>
                <span class="text-[#4A1C1C] text-sm font-bold">{{ \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d M Y') }}</span>
            </div>
            @endif
            @if($peminjaman->catatan)
            <div class="pt-2 mt-2 border-t-2 border-[#C75B39]/20">
                <p class="text-[#8B3A3A] text-xs font-bold mb-1">Catatan</p>
                <p class="text-[#4A1C1C] text-sm font-medium">{{ $peminjaman->catatan }}</p>
            </div>
            @endif
        </div>

        {{-- Tombol Batal --}}
        @if(in_array($peminjaman->status, ['pending', 'approved']))
        <div class="mt-4 pt-4 border-t-2 border-[#C75B39]/20">
            <form action="{{ route('peminjam.peminjaman.batal', $peminjaman) }}" method="POST">
                @csrf
                <button type="submit" 
                    onclick="return confirm('Batalkan peminjaman ini?')"
                    class="w-full px-4 py-3 bg-red-100 border-2 border-red-400 rounded-lg text-red-700 text-sm font-bold hover:bg-red-200 transition">
                    Batalkan Peminjaman
                </button>
            </form>
        </div>
        @endif
    </div>
</x-layout-peminjam>