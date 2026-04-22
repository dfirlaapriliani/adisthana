<x-layout-admin>
    <x-slot name="title">Detail Buku</x-slot>
    
    <div class="mb-6">
        <a href="{{ route('admin.buku.index') }}" class="text-[#9a8a80] hover:text-[#2C1810] text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar buku
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="grid md:grid-cols-2 gap-6 p-6">
            {{-- Foto --}}
            <div class="aspect-[4/3] bg-[#F0EBE3] rounded-xl flex items-center justify-center overflow-hidden">
                @if($buku->foto)
                    <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-24 h-24 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                    </svg>
                @endif
            </div>
            
            {{-- Info --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">{{ $buku->judul }}</h1>
                    <span class="px-3 py-1 text-xs rounded-full {{ $buku->status == 'available' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $buku->status == 'available' ? 'Tersedia' : 'Kosong' }}
                    </span>
                </div>
                <p class="text-[#7B1518] text-lg mb-4">{{ $buku->pengarang }}</p>
                
                <div class="space-y-3 mb-6">
                    <div class="flex">
                        <span class="text-[#9a8a80] w-32">Penerbit</span>
                        <span class="text-[#2C1810] font-medium">{{ $buku->penerbit }}</span>
                    </div>
                    <div class="flex">
                        <span class="text-[#9a8a80] w-32">Tahun Terbit</span>
                        <span class="text-[#2C1810] font-medium">{{ $buku->tahun_terbit }}</span>
                    </div>
                    <div class="flex">
                        <span class="text-[#9a8a80] w-32">Stok</span>
                        <span class="text-[#2C1810] font-medium">{{ $buku->stok }} buku</span>
                    </div>
                </div>
                
                @if($buku->deskripsi)
                <div class="mb-6">
                    <p class="text-[#9a8a80] text-sm mb-2">Deskripsi</p>
                    <p class="text-[#2C1810] text-sm leading-relaxed">{{ $buku->deskripsi }}</p>
                </div>
                @endif
                
                <div class="flex gap-3 pt-4 border-t border-[#7B1518]/10">
                    <a href="{{ route('admin.buku.edit', $buku) }}" 
                        class="px-4 py-2 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition">
                        Edit Buku
                    </a>
                    <button onclick="confirmDelete({{ $buku->id }}, '{{ $buku->judul }}')"
                        class="px-4 py-2 bg-red-50 text-red-600 rounded-xl text-sm font-medium hover:bg-red-100 transition">
                        Hapus Buku
                    </button>
                    <form id="delete-form-{{ $buku->id }}" action="{{ route('admin.buku.destroy', $buku) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, judul) {
            Swal.fire({
                title: 'Hapus Buku?',
                html: `Anda akan menghapus buku "<strong>${judul}</strong>".<br>Data tidak dapat dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b5a54',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
</x-layout-admin>