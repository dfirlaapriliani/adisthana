<x-layout-admin>
    <x-slot name="title">Dashboard Admin</x-slot>
    
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Dashboard</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Total Fasilitas</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $stats['total_facilities'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#7B1518]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#7B1518]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Total Peminjam</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#7B1518]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#7B1518]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Pengajuan Pending</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $stats['pending_bookings'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-[#7B1518]/10 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#9a8a80] text-xs uppercase tracking-wider">Menunggu Verifikasi</p>
                    <p class="text-3xl font-semibold text-[#2C1810] mt-1">{{ $stats['waiting_verification'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-[#7B1518]/10">
            <h2 class="font-medium text-[#2C1810]">Pengajuan Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F0EBE3]/50">
                    <tr class="text-left">
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Peminjam</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Fasilitas</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-[#9a8a80] uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    @forelse($recentBookings as $booking)
                    <tr class="hover:bg-[#F0EBE3]/30 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-[#2C1810]">{{ $booking->user->name }}</p>
                            <p class="text-xs text-[#9a8a80]">{{ $booking->user->identifier ?? $booking->user->email }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ $booking->facility->name }}</td>
                        <td class="px-6 py-4 text-sm text-[#2C1810]">
                            {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                            <span class="block text-xs text-[#9a8a80]">{{ $booking->start_time }} - {{ $booking->end_time }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                    'ongoing' => 'bg-blue-100 text-blue-700',
                                    'waiting_proof' => 'bg-purple-100 text-purple-700',
                                    'waiting_verification' => 'bg-indigo-100 text-indigo-700',
                                    'completed' => 'bg-gray-100 text-gray-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$booking->status] ?? 'bg-gray-100' }}">
                                {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="text-[#7B1518] hover:text-[#5a0f12] text-sm">Detail →</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-[#9a8a80]">Belum ada pengajuan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout-admin>