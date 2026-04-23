{{-- resources/views/admin/peminjaman/show.blade.php --}}
<x-layout-admin>
    <x-slot name="title">Detail Peminjaman #{{ $peminjaman->id }}</x-slot>
    
    <div class="mb-4">
        <a href="{{ route('admin.peminjaman.index') }}" class="text-[#8B3A3A] hover:text-[#7B1518] text-sm font-medium flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar
        </a>
    </div>

    <div class="bg-white border-2 border-[#7B1518]/20 rounded-xl p-5 sm:p-6 shadow-md">
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
                    'approved' => 'Disetujui - Belum Diambil',
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

        {{-- Info Buku & Peminjam --}}
        <div class="flex flex-col md:flex-row gap-4 mb-4">
            <div class="flex-1">
                <div class="flex gap-3 p-3 bg-[#FFF5E8] rounded-lg border-2 border-[#7B1518]/20">
                    <div class="w-14 h-20 bg-gradient-to-br from-[#FFF5E8] to-[#F5CDA7] rounded-lg flex items-center justify-center overflow-hidden flex-shrink-0 border-2 border-[#7B1518]/30">
                        @if($peminjaman->book->foto)
                            <img src="{{ asset('storage/' . $peminjaman->book->foto) }}" alt="{{ $peminjaman->book->judul }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-[#7B1518]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-[#2C1810] font-bold">{{ $peminjaman->book->judul }}</h2>
                        <p class="text-[#6b5a54] text-sm">{{ $peminjaman->book->pengarang }}</p>
                        <p class="text-[#6b5a54] text-sm">{{ $peminjaman->book->penerbit }} ({{ $peminjaman->book->tahun_terbit }})</p>
                        <p class="text-[#7B1518] font-bold text-sm mt-1">Jumlah: {{ $peminjaman->jumlah }} buku</p>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <div class="p-3 bg-[#FFF5E8] rounded-lg border-2 border-[#7B1518]/20">
                    <h3 class="text-[#2C1810] font-bold mb-2">👤 Info Peminjam</h3>
                    <p class="text-[#6b5a54] text-sm">Nama: {{ $peminjaman->user->name }}</p>
                    <p class="text-[#6b5a54] text-sm">Kode Kelas: {{ $peminjaman->user->class_code ?? '-' }}</p>
                    <p class="text-[#6b5a54] text-sm">Email: {{ $peminjaman->user->email }}</p>
                    <p class="text-[#6b5a54] text-sm">No. HP: {{ $peminjaman->user->phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Detail Peminjaman --}}
        <div class="p-4 bg-white rounded-lg border-2 border-[#7B1518]/10 mb-4">
            <h3 class="text-[#2C1810] font-bold mb-3">📋 Detail Peminjaman</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <p class="text-[#6b5a54] text-sm"><span class="font-medium">Tanggal Pinjam:</span> {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-[#6b5a54] text-sm"><span class="font-medium">Tanggal Kembali:</span> {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</p>
                </div>
                @if($peminjaman->tanggal_dikembalikan)
                <div class="sm:col-span-2">
                    <p class="text-[#6b5a54] text-sm"><span class="font-medium">Dikembalikan pada:</span> {{ \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d M Y H:i') }}</p>
                </div>
                @endif
                @if($peminjaman->catatan && $peminjaman->status != 'rejected')
                <div class="sm:col-span-2">
                    <p class="text-[#6b5a54] text-sm"><span class="font-medium">Catatan:</span> {{ $peminjaman->catatan }}</p>
                </div>
                @endif
                @if($peminjaman->status == 'rejected' && $peminjaman->catatan)
                <div class="sm:col-span-2">
                    <p class="text-[#6b5a54] text-sm"><span class="font-medium text-red-600">Alasan Ditolak:</span> {{ $peminjaman->catatan }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- TOMBOL AKSI --}}
        @if($peminjaman->status != 'returned' && $peminjaman->status != 'rejected' && $peminjaman->status != 'cancelled')
        <div class="flex flex-wrap gap-3">
            {{-- PENDING: Setujui & Tolak --}}
            @if($peminjaman->status == 'pending')
            <form action="{{ route('admin.peminjaman.setujui', $peminjaman) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg text-sm font-bold hover:bg-green-700 transition shadow-md">
                    ✅ Setujui Peminjaman
                </button>
            </form>
            
            <button onclick="document.getElementById('modalTolak').classList.remove('hidden')" 
                class="flex-1 px-4 py-3 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition shadow-md">
                ❌ Tolak Peminjaman
            </button>
            @endif

            {{-- APPROVED: Buku Diambil --}}
            @if($peminjaman->status == 'approved')
            <form action="{{ route('admin.peminjaman.diambil', $peminjaman) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" onclick="return confirm('Konfirmasi buku sudah diambil oleh peminjam?')" 
                    class="w-full px-4 py-3 bg-purple-600 text-white rounded-lg text-sm font-bold hover:bg-purple-700 transition shadow-md">
                    📖 Buku Sudah Diambil
                </button>
            </form>
            @endif

            {{-- BORROWED: Kembalikan --}}
            @if($peminjaman->status == 'borrowed')
            <form action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit" onclick="return confirm('Konfirmasi pengembalian buku?')" 
                    class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition shadow-md">
                    📦 Kembalikan Buku
                </button>
            </form>
            @endif
        </div>
        @endif
    </div>

    {{-- Modal Tolak --}}
    @if($peminjaman->status == 'pending')
    <div id="modalTolak" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl p-6 max-w-md w-full">
            <h3 class="text-xl font-bold text-[#2C1810] mb-4">Alasan Penolakan</h3>
            <form action="{{ route('admin.peminjaman.tolak', $peminjaman) }}" method="POST">
                @csrf
                <textarea name="catatan_penolakan" rows="3" required
                    class="w-full px-4 py-3 bg-white border-2 border-[#7B1518]/30 rounded-lg text-sm text-[#2C1810] focus:outline-none focus:border-[#7B1518] mb-4"
                    placeholder="Tulis alasan penolakan..."></textarea>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('modalTolak').classList.add('hidden')"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-bold hover:bg-red-700 transition">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</x-layout-admin>