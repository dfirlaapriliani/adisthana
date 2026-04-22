<x-layout-admin>
    <x-slot name="title">Peminjaman</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Peminjaman Buku</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Kelola pengajuan peminjaman buku</p>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-green-800">{{ session('success') }}</p>
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
        class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center justify-between">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-sm text-red-800">{{ session('error') }}</p>
        </div>
        <button @click="show = false" class="text-red-600 hover:text-red-800">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    {{-- Filter Status --}}
    <div class="mb-6 flex gap-2 flex-wrap">
        @php
            $statuses = [
                'semua' => ['label' => 'Semua', 'color' => 'bg-gray-100 text-gray-700'],
                'pending' => ['label' => 'Pending', 'color' => 'bg-amber-100 text-amber-700'],
                'approved' => ['label' => 'Disetujui', 'color' => 'bg-blue-100 text-blue-700'],
                'borrowed' => ['label' => 'Dipinjam', 'color' => 'bg-purple-100 text-purple-700'],
                'returned' => ['label' => 'Dikembalikan', 'color' => 'bg-green-100 text-green-700'],
                'rejected' => ['label' => 'Ditolak', 'color' => 'bg-red-100 text-red-700'],
            ];
        @endphp
        
        @foreach($statuses as $key => $item)
        <a href="{{ route('admin.peminjaman.index', ['status' => $key]) }}" 
            class="px-4 py-2 rounded-xl text-sm font-medium transition
                {{ $status == $key 
                    ? 'bg-[#7B1518] text-white' 
                    : 'bg-white border border-[#7B1518]/20 text-[#2C1810] hover:bg-[#F0EBE3]' }}">
            {{ $item['label'] }}
            <span class="ml-1.5 px-2 py-0.5 rounded-full text-xs {{ $status == $key ? 'bg-white/20 text-white' : 'bg-[#F0EBE3] text-[#7B1518]' }}">
                {{ $jumlah[$key] ?? 0 }}
            </span>
        </a>
        @endforeach
    </div>

    {{-- Tabel Peminjaman --}}
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
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    @forelse($peminjaman as $item)
                    <tr class="hover:bg-[#F0EBE3]/30 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-[#2C1810]">{{ $item->user->name }}</p>
                            <p class="text-xs text-[#9a8a80]">{{ $item->user->class_code ?? $item->user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-[#2C1810]">{{ $item->book->judul }}</p>
                            <p class="text-xs text-[#9a8a80]">{{ $item->book->pengarang }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ $item->jumlah }}</td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-blue-100 text-blue-700',
                                    'borrowed' => 'bg-purple-100 text-purple-700',
                                    'returned' => 'bg-green-100 text-green-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                ];
                                $statusLabels = [
                                    'pending' => 'Pending',
                                    'approved' => 'Disetujui',
                                    'borrowed' => 'Dipinjam',
                                    'returned' => 'Dikembalikan',
                                    'rejected' => 'Ditolak',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100' }}">
                                {{ $statusLabels[$item->status] ?? $item->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.peminjaman.show', $item) }}" 
                                class="text-[#7B1518] hover:text-[#5a0f12] text-sm font-medium">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-[#9a8a80]">
                            Tidak ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($peminjaman->hasPages())
        <div class="px-6 py-4 border-t border-[#7B1518]/10">
            {{ $peminjaman->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</x-layout-admin>