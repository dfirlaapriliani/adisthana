{{-- resources/views/peminjam/peminjaman/index.blade.php --}}
<x-layout-peminjam>
    <x-slot name="title">Peminjaman Saya</x-slot>
    
    <div class="mb-6 sm:mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-[#4A1C1C] brand">Peminjaman Saya</h1>
        <p class="text-[#8B3A3A] text-xs sm:text-sm mt-1 font-medium">Daftar peminjaman buku yang pernah diajukan</p>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 p-4 bg-green-100 border-2 border-green-400 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
        </div>
        <button @click="show = false" class="text-green-600 hover:text-green-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 p-4 bg-red-100 border-2 border-red-400 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm font-medium text-red-700">{{ session('error') }}</p>
        </div>
        <button @click="show = false" class="text-red-600 hover:text-red-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- Filter Status --}}
    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
        @php
            $statuses = [
                '' => 'Semua',
                'pending' => 'Pending',
                'approved' => 'Disetujui',
                'borrowed' => 'Dipinjam',
                'returned' => 'Dikembalikan',
                'rejected' => 'Ditolak',
                'cancelled' => 'Dibatalkan',
            ];
        @endphp
        @foreach($statuses as $key => $label)
        <a href="{{ route('peminjam.peminjaman.index', ['status' => $key]) }}" 
            class="px-3 py-1.5 text-xs font-bold rounded-full whitespace-nowrap transition
                {{ request('status') == $key || (!request('status') && $key == '') 
                    ? 'bg-[#C75B39] text-white shadow-sm' 
                    : 'bg-white text-[#8B3A3A] border-2 border-[#C75B39]/30 hover:bg-[#FFF5E8]' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Daftar Peminjaman --}}
    <div class="space-y-3">
        @forelse($peminjaman as $item)
        <a href="{{ route('peminjam.peminjaman.show', $item) }}" 
            class="block bg-white border-2 border-[#C75B39]/20 rounded-xl p-4 hover:border-[#C75B39] hover:shadow-md transition">
            <div class="flex gap-3">
                {{-- Foto Buku --}}
                <div class="w-12 h-16 bg-gradient-to-br from-[#FFF5E8] to-[#F5CDA7] rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0 border-2 border-[#C75B39]/30">
                    @if($item->book->foto)
                        <img src="{{ asset('storage/' . $item->book->foto) }}" alt="{{ $item->book->judul }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-5 h-5 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                        </svg>
                    @endif
                </div>
                
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="text-[#4A1C1C] font-bold text-sm line-clamp-1">{{ $item->book->judul }}</h3>
                            <p class="text-[#8B3A3A] text-xs font-medium">{{ $item->jumlah }} buku</p>
                        </div>
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
                                'pending' => 'Pending',
                                'approved' => 'Disetujui',
                                'borrowed' => 'Dipinjam',
                                'returned' => 'Dikembalikan',
                                'rejected' => 'Ditolak',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100 text-gray-800 border-2 border-gray-400' }}">
                            {{ $statusLabels[$item->status] ?? $item->status }}
                        </span>
                    </div>
                    
                    <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-[10px] text-[#8B3A3A] font-medium">
                        <span>Pinjam: {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</span>
                        <span>Kembali: {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</span>
                    </div>
                    
                    @if($item->status == 'pending')
                    <form action="{{ route('peminjam.peminjaman.batal', $item) }}" method="POST" class="mt-2" onclick="event.stopPropagation()">
                        @csrf
                        <button type="submit" 
                            onclick="return confirm('Batalkan peminjaman ini?')"
                            class="text-xs font-bold text-red-600 hover:text-red-800">
                            Batalkan
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </a>
        @empty
        <div class="bg-white border-2 border-[#C75B39]/20 rounded-xl p-8 sm:p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[#FFF5E8] border-2 border-[#C75B39]/30 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                </svg>
            </div>
            <p class="text-[#4A1C1C] font-bold mb-2">Belum ada peminjaman</p>
            <a href="{{ route('peminjam.buku.index') }}" class="mt-2 inline-block px-4 py-2 bg-[#C75B39] text-white text-sm font-bold rounded-lg hover:bg-[#8B3A3A] transition shadow-sm">
                Lihat daftar buku →
            </a>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($peminjaman->hasPages())
    <div class="mt-6">
        {{ $peminjaman->appends(request()->query())->links() }}
    </div>
    @endif
</x-layout-peminjam>