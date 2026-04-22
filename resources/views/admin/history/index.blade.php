<x-layout-admin>
    <x-slot name="title">Riwayat Peminjaman</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Riwayat Peminjaman</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Daftar peminjaman yang telah selesai atau ditolak</p>
    </div>

    {{-- Filter --}}
    <div class="mb-6 flex gap-2 flex-wrap">
        @php
            $filters = [
                'semua' => 'Semua',
                'returned' => 'Dikembalikan',
                'rejected' => 'Ditolak',
                'cancelled' => 'Dibatalkan',
            ];
        @endphp
        
        @foreach($filters as $key => $label)
        <a href="{{ route('admin.riwayat.index', ['filter' => $key]) }}" 
            class="px-4 py-2 rounded-xl text-sm font-medium transition
                {{ request('filter', 'semua') == $key 
                    ? 'bg-[#7B1518] text-white' 
                    : 'bg-white border border-[#7B1518]/20 text-[#2C1810] hover:bg-[#F0EBE3]' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Pencarian --}}
    <div class="mb-6">
        <form method="GET" class="flex gap-3">
            <input type="hidden" name="filter" value="{{ request('filter', 'semua') }}">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" 
                    placeholder="Cari nama peminjam atau judul buku..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm text-[#2C1810] hover:bg-[#F0EBE3] transition">
                Cari
            </button>
        </form>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F0EBE3]/50 border-b border-[#7B1518]/10">
                    <tr class="text-left">
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Tgl Pinjam</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Tgl Kembali</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    @forelse($riwayat as $item)
                    <tr class="hover:bg-[#F0EBE3]/30 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-[#2C1810]">{{ $item->user->name }}</p>
                            <p class="text-xs text-[#9a8a80]">{{ $item->user->class_code ?? $item->user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-[#2C1810]">{{ $item->book->judul }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">
                            {{ $item->tanggal_dikembalikan ? \Carbon\Carbon::parse($item->tanggal_dikembalikan)->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'returned' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                    'cancelled' => 'bg-gray-100 text-gray-700',
                                ];
                                $statusLabels = [
                                    'returned' => 'Dikembalikan',
                                    'rejected' => 'Ditolak',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100' }}">
                                {{ $statusLabels[$item->status] ?? $item->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center text-[#9a8a80]">
                            Tidak ada data riwayat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($riwayat->hasPages())
        <div class="px-6 py-4 border-t border-[#7B1518]/10">
            {{ $riwayat->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</x-layout-admin>