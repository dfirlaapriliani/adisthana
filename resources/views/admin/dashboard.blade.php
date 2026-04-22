<x-layout-admin>
    <x-slot name="title">Dashboard Admin</x-slot>
    
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Dashboard</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        {{-- Total Buku --}}
        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Total Buku</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $totalBuku ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#7B1518]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#7B1518]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Total Peminjam --}}
        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Total Peminjam</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $totalPeminjam ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#7B1518]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#7B1518]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Peminjaman Pending --}}
        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Peminjaman Pending</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $peminjamanPending ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Permohonan Akun --}}
        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Permohonan Akun</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $permohonanPending ?? 0 }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-[#7B1518]/10">
            <h2 class="font-medium text-[#2C1810]">Peminjaman Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F0EBE3]/50">
                    <tr class="text-left">
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    @forelse($peminjamanTerbaru ?? [] as $item)
                    <tr class="hover:bg-[#F0EBE3]/30 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-[#2C1810]">{{ $item->user->name ?? '-' }}</p>
                            <p class="text-xs text-[#9a8a80]">{{ $item->user->class_code ?? $item->user->email ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ $item->book->judul ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">
                            {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}
                            <span class="block text-xs text-[#9a8a80]">s/d {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                    'borrowed' => 'bg-blue-100 text-blue-700',
                                    'returned' => 'bg-gray-100 text-gray-700',
                                    'rejected' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$item->status] ?? 'bg-gray-100' }}">
                                @if($item->status == 'pending') Pending
                                @elseif($item->status == 'approved') Disetujui
                                @elseif($item->status == 'borrowed') Dipinjam
                                @elseif($item->status == 'returned') Dikembalikan
                                @elseif($item->status == 'rejected') Ditolak
                                @else {{ $item->status }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.peminjaman.show', $item) }}" class="text-[#7B1518] hover:text-[#5a0f12] text-sm">Detail →</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-[#9a8a80]">Belum ada peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>