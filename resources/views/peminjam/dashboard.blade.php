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

    {{-- Info Kelas --}}
    <div class="bg-[#111114] border border-white/[0.08] rounded-2xl p-5 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#d4af6a]/20 to-[#8a6428]/20 flex items-center justify-center">
                <span class="text-2xl font-bold text-[#d4af6a]">{{ substr(auth()->user()->class_code ?? 'KLS', 0, 1) }}</span>
            </div>
            <div>
                <p class="text-[#5a5a65] text-xs">Kode Kelas</p>
                <p class="text-xl font-mono font-bold text-[#d4af6a]">{{ auth()->user()->class_code ?? 'Belum ada' }}</p>
                <p class="text-white text-sm">{{ auth()->user()->class_name ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
        {{-- Lihat Buku --}}
        <a href="{{ route('peminjam.buku.index') }}" class="bg-[#111114] border border-white/[0.08] rounded-2xl p-6 hover:border-[#d4af6a]/30 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#d4af6a]/20 to-[#8a6428]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6 text-[#d4af6a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-white font-medium mb-1">Lihat Buku</h3>
            <p class="text-[#5a5a65] text-sm">Cari dan pinjam buku yang tersedia</p>
        </a>

        {{-- Peminjaman Saya --}}
        <a href="{{ route('peminjam.peminjaman.index') }}" class="bg-[#111114] border border-white/[0.08] rounded-2xl p-6 hover:border-[#d4af6a]/30 transition-all group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#d4af6a]/20 to-[#8a6428]/20 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                <svg class="w-6 h-6 text-[#d4af6a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-white font-medium mb-1">Peminjaman Saya</h3>
            <p class="text-[#5a5a65] text-sm">Lihat status peminjaman Anda</p>
        </a>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div class="bg-[#111114] border border-white/[0.08] rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/[0.08]">
            <h2 class="text-white font-medium">Peminjaman Terbaru</h2>
        </div>
        <div class="p-6">
            @php
                $recentBookings = auth()->user()->bookings()->with('book')->latest()->take(5)->get();
            @endphp
            
            @forelse($recentBookings as $booking)
            <div class="flex items-center justify-between py-3 border-b border-white/[0.05] last:border-0">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-[#d4af6a]/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#d4af6a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-medium">{{ $booking->book->judul ?? 'Buku tidak ditemukan' }}</p>
                        <p class="text-[#5a5a65] text-xs">
                            {{ $booking->tanggal_pinjam ? \Carbon\Carbon::parse($booking->tanggal_pinjam)->format('d M Y') : '-' }} 
                            • {{ $booking->jumlah }} buku
                        </p>
                    </div>
                </div>
                <div>
                    @php
                        $statusColors = [
                            'pending' => 'text-amber-400 bg-amber-400/10',
                            'approved' => 'text-green-400 bg-green-400/10',
                            'borrowed' => 'text-blue-400 bg-blue-400/10',
                            'returned' => 'text-gray-400 bg-gray-400/10',
                            'rejected' => 'text-red-400 bg-red-400/10',
                        ];
                        $statusLabels = [
                            'pending' => 'Pending',
                            'approved' => 'Disetujui',
                            'borrowed' => 'Dipinjam',
                            'returned' => 'Dikembalikan',
                            'rejected' => 'Ditolak',
                        ];
                    @endphp
                    <span class="px-2 py-1 text-xs rounded-full {{ $statusColors[$booking->status] ?? 'text-gray-400 bg-gray-400/10' }}">
                        {{ $statusLabels[$booking->status] ?? $booking->status }}
                    </span>
                </div>
            </div>
            @empty
            <p class="text-[#5a5a65] text-center py-8">Belum ada peminjaman</p>
            @endforelse
            
            @if($recentBookings->count() > 0)
            <div class="mt-4 text-center">
                <a href="{{ route('peminjam.peminjaman.index') }}" class="text-[#d4af6a] text-sm hover:underline">
                    Lihat semua peminjaman →
                </a>
            </div>
            @endif
        </div>
    </div>
</x-layout-peminjam>