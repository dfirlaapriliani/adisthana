<x-layout-peminjam>
    <x-slot name="title">Dashboard</x-slot>
    
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-white" style="font-family: 'Cormorant Garamond', serif;">Dashboard</h1>
        <p class="text-[#5a5a65] text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    @if(auth()->user()->hasActivePenalty())
    <div class="bg-red-500/10 border border-red-500/20 rounded-2xl p-5 mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-red-400 font-medium">Akun Sedang Dalam Penalti</p>
                <p class="text-[#8a8a95] text-sm">Anda tidak dapat melakukan peminjaman baru selama {{ auth()->user()->remaining_penalty_days }} hari lagi.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <a href="{{ route('peminjam.facilities.index') }}" class="bg-[#111114] border border-white/[0.08] rounded-2xl p-6 hover:border-[#d4af6a]/30 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#d4af6a]/20 to-[#8a6428]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6 text-[#d4af6a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                </svg>
            </div>
            <h3 class="text-white font-medium mb-1">Lihat Fasilitas</h3>
            <p class="text-[#5a5a65] text-sm">Cek ketersediaan ruangan dan fasilitas</p>
        </a>

        <a href="{{ route('peminjam.bookings.index') }}" class="bg-[#111114] border border-white/[0.08] rounded-2xl p-6 hover:border-[#d4af6a]/30 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#d4af6a]/20 to-[#8a6428]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6 text-[#d4af6a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-white font-medium mb-1">Pengajuan Saya</h3>
            <p class="text-[#5a5a65] text-sm">Lihat status peminjaman Anda</p>
        </a>

        <a href="{{ route('peminjam.schedules.index') }}" class="bg-[#111114] border border-white/[0.08] rounded-2xl p-6 hover:border-[#d4af6a]/30 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#d4af6a]/20 to-[#8a6428]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6 text-[#d4af6a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-white font-medium mb-1">Jadwal</h3>
            <p class="text-[#5a5a65] text-sm">Lihat kalender peminjaman</p>
        </a>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-[#111114] border border-white/[0.08] rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/[0.08]">
            <h2 class="text-white font-medium">Pengajuan Terbaru</h2>
        </div>
        <div class="p-6">
            @php
                $recentBookings = auth()->user()->bookings()->with('facility')->latest()->take(5)->get();
            @endphp
            
            @forelse($recentBookings as $booking)
            <div class="flex items-center justify-between py-3 border-b border-white/[0.05] last:border-0">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-[#d4af6a]/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#d4af6a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-medium">{{ $booking->facility->name }}</p>
                        <p class="text-[#5a5a65] text-xs">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} • {{ $booking->start_time }} - {{ $booking->end_time }}</p>
                    </div>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'pending' => 'text-amber-400 bg-amber-400/10',
                            'approved' => 'text-green-400 bg-green-400/10',
                            'ongoing' => 'text-blue-400 bg-blue-400/10',
                            'waiting_proof' => 'text-purple-400 bg-purple-400/10',
                            'waiting_verification' => 'text-indigo-400 bg-indigo-400/10',
                            'completed' => 'text-gray-400 bg-gray-400/10',
                        ];
                    @endphp
                    <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$booking->status] ?? 'text-gray-400 bg-gray-400/10' }}">
                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-[#5a5a65] text-center py-8">Belum ada pengajuan</p>
            @endforelse
        </div>
    </div>
</x-layout-peminjam>