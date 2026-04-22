<x-layout-admin>
    <x-slot name="title">Detail Peminjaman</x-slot>
    
    <div class="mb-6">
        <a href="{{ route('admin.peminjaman.index') }}" class="text-[#9a8a80] hover:text-[#2C1810] text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="p-6">
            {{-- Status --}}
            <div class="mb-6">
                @php
                    $statusColors = [
                        'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                        'approved' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'borrowed' => 'bg-purple-100 text-purple-700 border-purple-200',
                        'returned' => 'bg-green-100 text-green-700 border-green-200',
                        'rejected' => 'bg-red-100 text-red-700 border-red-200',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu Persetujuan',
                        'approved' => 'Disetujui',
                        'borrowed' => 'Sedang Dipinjam',
                        'returned' => 'Telah Dikembalikan',
                        'rejected' => 'Ditolak',
                    ];
                @endphp
                <span class="inline-block px-4 py-2 rounded-lg border {{ $statusColors[$peminjaman->status] ?? 'bg-gray-100' }}">
                    {{ $statusLabels[$peminjaman->status] ?? $peminjaman->status }}
                </span>
            </div>

            {{-- Info Peminjam & Buku --}}
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="bg-[#F0EBE3]/30 rounded-xl p-4">
                    <h3 class="font-medium text-[#2C1810] mb-3">Info Peminjam</h3>
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">Nama</span>
                            <span class="text-[#2C1810] text-sm font-medium">{{ $peminjaman->user->name }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">Kode Kelas</span>
                            <span class="text-[#2C1810] text-sm">{{ $peminjaman->user->class_code ?? '-' }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">Email</span>
                            <span class="text-[#2C1810] text-sm">{{ $peminjaman->user->email }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">No. HP</span>
                            <span class="text-[#2C1810] text-sm">{{ $peminjaman->user->phone ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#F0EBE3]/30 rounded-xl p-4">
                    <h3 class="font-medium text-[#2C1810] mb-3">Info Buku</h3>
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">Judul</span>
                            <span class="text-[#2C1810] text-sm font-medium">{{ $peminjaman->book->judul }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">Pengarang</span>
                            <span class="text-[#2C1810] text-sm">{{ $peminjaman->book->pengarang }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">Penerbit</span>
                            <span class="text-[#2C1810] text-sm">{{ $peminjaman->book->penerbit }}</span>
                        </div>
                        <div class="flex">
                            <span class="text-[#9a8a80] w-24 text-sm">Stok Tersedia</span>
                            <span class="text-[#2C1810] text-sm">{{ $peminjaman->book->stok }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Detail Peminjaman --}}
            <div class="bg-[#F0EBE3]/30 rounded-xl p-4 mb-6">
                <h3 class="font-medium text-[#2C1810] mb-3">Detail Peminjaman</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="text-[#9a8a80] w-28 text-sm">Jumlah</span>
                            <span class="text-[#2C1810] text-sm">{{ $peminjaman->jumlah }} buku</span>
                        </div>
                        <div class="flex">
                            <span class="text-[#9a8a80] w-28 text-sm">Tgl Pinjam</span>
                            <span class="text-[#2C1810] text-sm">{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y') }}</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex">
                            <span class="text-[#9a8a80] w-28 text-sm">Tgl Kembali</span>
                            <span class="text-[#2C1810] text-sm">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</span>
                        </div>
                        @if($peminjaman->tanggal_dikembalikan)
                        <div class="flex">
                            <span class="text-[#9a8a80] w-28 text-sm">Dikembalikan</span>
                            <span class="text-[#2C1810] text-sm">{{ \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan)->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @if($peminjaman->catatan)
                <div class="mt-4 pt-4 border-t border-[#7B1518]/10">
                    <p class="text-[#9a8a80] text-sm mb-1">Catatan</p>
                    <p class="text-[#2C1810] text-sm">{{ $peminjaman->catatan }}</p>
                </div>
                @endif
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex gap-3">
                @if($peminjaman->status == 'pending')
                <form action="{{ route('admin.peminjaman.setujui', $peminjaman) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" 
                        onclick="return confirm('Setujui peminjaman ini?')"
                        class="w-full px-4 py-2.5 bg-green-600 text-white rounded-xl text-sm font-medium hover:bg-green-700 transition">
                        Setujui Peminjaman
                    </button>
                </form>
                <button onclick="showTolakModal()" 
                    class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700 transition">
                    Tolak Peminjaman
                </button>
                @endif

                @if($peminjaman->status == 'borrowed')
                <form action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" 
                        onclick="return confirm('Konfirmasi pengembalian buku?')"
                        class="w-full px-4 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                        Kembalikan Buku
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Tolak --}}
    <div id="tolakModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50">
        <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-[#2C1810] mb-4">Alasan Penolakan</h3>
            <form action="{{ route('admin.peminjaman.tolak', $peminjaman) }}" method="POST">
                @csrf
                <textarea name="catatan" rows="4" required
                    class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition mb-4"
                    placeholder="Tulis alasan penolakan..."></textarea>
                <div class="flex gap-3">
                    <button type="button" onclick="hideTolakModal()" 
                        class="flex-1 px-4 py-2.5 bg-gray-200 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700 transition">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showTolakModal() {
            document.getElementById('tolakModal').classList.remove('hidden');
            document.getElementById('tolakModal').classList.add('flex');
        }
        function hideTolakModal() {
            document.getElementById('tolakModal').classList.add('hidden');
            document.getElementById('tolakModal').classList.remove('flex');
        }
    </script>
</x-layout-admin>