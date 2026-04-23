{{-- resources/views/peminjam/dashboard.blade.php --}}
<x-layout-peminjam>
    <x-slot name="title">Dashboard</x-slot>
    
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#4A1C1C] brand">Dashboard</h1>
        <p class="text-[#8B3A3A] text-sm sm:text-base mt-1 font-medium">Selamat datang, {{ auth()->user()->name }}</p>
    </div>

    @if(auth()->user()->hasActivePenalty())
    <div class="bg-red-100 border-2 border-red-400 rounded-2xl p-4 sm:p-5 mb-6 sm:mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-500 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-red-800 font-bold text-sm sm:text-base">Akun Sedang Dalam Penalti</p>
                <p class="text-red-700 text-xs sm:text-sm font-medium">Anda tidak dapat melakukan peminjaman baru selama {{ auth()->user()->remaining_penalty_days }} hari lagi.</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Info Kelas --}}
    <div class="bg-white border-2 border-[#C75B39]/30 rounded-2xl p-5 mb-6 sm:mb-8 shadow-md">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-[#C75B39] to-[#8B3A3A] flex items-center justify-center flex-shrink-0 shadow-md">
                <span class="text-2xl font-bold text-white">{{ substr(auth()->user()->class_code ?? 'KLS', 0, 1) }}</span>
            </div>
            <div class="min-w-0">
                <p class="text-[#8B3A3A] text-xs font-bold uppercase tracking-wider">Kode Kelas</p>
                <p class="text-xl font-mono font-bold text-[#C75B39] truncate">{{ auth()->user()->class_code ?? 'Belum ada' }}</p>
                <p class="text-[#4A1C1C] text-sm font-medium truncate">{{ auth()->user()->class_name ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
        <a href="{{ route('peminjam.buku.index') }}" class="bg-white border-2 border-[#C75B39]/30 rounded-2xl p-6 hover:border-[#C75B39] hover:shadow-lg transition-all group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#C75B39] to-[#8B3A3A] flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-[#4A1C1C] font-bold mb-1 text-base">Lihat Buku</h3>
            <p class="text-[#8B3A3A] text-sm font-medium">Cari dan pinjam buku yang tersedia</p>
        </a>

        <a href="{{ route('peminjam.peminjaman.index') }}" class="bg-white border-2 border-[#C75B39]/30 rounded-2xl p-6 hover:border-[#C75B39] hover:shadow-lg transition-all group">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#C75B39] to-[#8B3A3A] flex items-center justify-center mb-4 group-hover:scale-110 transition shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-[#4A1C1C] font-bold mb-1 text-base">Peminjaman Saya</h3>
            <p class="text-[#8B3A3A] text-sm font-medium">Lihat status peminjaman Anda</p>
        </a>
    </div>

    {{-- Peminjaman Terbaru --}}
    <div class="bg-white border-2 border-[#C75B39]/30 rounded-2xl overflow-hidden shadow-md">
        <div class="px-6 py-4 border-b-2 border-[#C75B39]/20 bg-[#FFF5E8]">
            <h2 class="text-[#4A1C1C] font-bold text-base">Peminjaman Terbaru</h2>
        </div>
        <div class="p-6">
            @php
                $recentBookings = auth()->user()->bookings()->with('book')->latest()->take(5)->get();
            @endphp
            
            @forelse($recentBookings as $booking)
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 border-b-2 border-[#C75B39]/10 last:border-0 gap-2 sm:gap-0">
                <div class="flex items-center gap-4">
                    {{-- Foto Buku --}}
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-[#FFF5E8] to-[#F5CDA7] border-2 border-[#C75B39]/30 flex items-center justify-center flex-shrink-0 overflow-hidden">
                        @if($booking->book && $booking->book->foto)
                            <img src="{{ asset('storage/' . $booking->book->foto) }}" alt="{{ $booking->book->judul }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-[#4A1C1C] text-sm font-bold truncate">{{ $booking->book->judul ?? 'Buku tidak ditemukan' }}</p>
                        <p class="text-[#8B3A3A] text-xs font-medium">
                            {{ $booking->tanggal_pinjam ? \Carbon\Carbon::parse($booking->tanggal_pinjam)->format('d M Y') : '-' }} 
                            • {{ $booking->jumlah }} buku
                        </p>
                    </div>
                </div>
                <div class="sm:ml-4">
                    @php
                        $statusColors = [
                            'pending' => 'text-yellow-800 bg-yellow-100 border-2 border-yellow-400',
                            'approved' => 'text-green-800 bg-green-100 border-2 border-green-400',
                            'borrowed' => 'text-blue-800 bg-blue-100 border-2 border-blue-400',
                            'returned' => 'text-gray-800 bg-gray-100 border-2 border-gray-400',
                            'rejected' => 'text-red-800 bg-red-100 border-2 border-red-400',
                        ];
                        $statusLabels = [
                            'pending' => 'Pending',
                            'approved' => 'Disetujui',
                            'borrowed' => 'Dipinjam',
                            'returned' => 'Dikembalikan',
                            'rejected' => 'Ditolak',
                        ];
                    @endphp
                    <span class="inline-block px-3 py-1 text-xs font-bold rounded-full {{ $statusColors[$booking->status] ?? 'text-gray-800 bg-gray-100 border-2 border-gray-400' }}">
                        {{ $statusLabels[$booking->status] ?? $booking->status }}
                    </span>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[#FFF5E8] border-2 border-[#C75B39]/30 flex items-center justify-center">
                    <svg class="w-8 h-8 text-[#C75B39]/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-[#8B3A3A] font-medium">Belum ada peminjaman</p>
                <p class="text-[#8B3A3A]/70 text-sm mt-1">Yuk mulai pinjam buku sekarang!</p>
            </div>
            @endforelse
            
            @if($recentBookings->count() > 0)
            <div class="mt-4 text-center">
                <a href="{{ route('peminjam.peminjaman.index') }}" class="inline-block px-4 py-2 bg-[#C75B39] text-white text-sm font-bold rounded-lg hover:bg-[#8B3A3A] transition shadow-md">
                    Lihat semua peminjaman →
                </a>
            </div>
            @endif
        </div>
    </div>
</x-layout-peminjam>