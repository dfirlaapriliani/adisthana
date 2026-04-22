<x-layout-admin>
    <x-slot name="title">Kategori Buku</x-slot>
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Kategori Buku</h1>
            <p class="text-[#9a8a80] text-sm mt-1">Kelola kategori untuk mengelompokkan buku</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" 
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kategori
        </a>
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

    {{-- Pencarian --}}
    <div class="mb-6">
        <form method="GET" class="flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" 
                    placeholder="Cari kategori..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
            </div>
            <button type="submit" 
                class="px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm text-[#2C1810] hover:bg-[#F0EBE3] transition">
                Cari
            </button>
            @if(request('cari'))
            <a href="{{ route('admin.kategori.index') }}" 
                class="px-4 py-2.5 text-sm text-[#9a8a80] hover:text-[#2C1810] transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Tabel Kategori --}}
    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F0EBE3]/50 border-b border-[#7B1518]/10">
                    <tr class="text-left">
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">No</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Jumlah Buku</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    @forelse($kategori as $index => $item)
                    <tr class="hover:bg-[#F0EBE3]/30 transition">
                        <td class="px-6 py-4 text-sm text-[#2C1810]">{{ $kategori->firstItem() + $index }}</td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-[#2C1810]">{{ $item->nama }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono text-[#9a8a80]">{{ $item->slug }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-[#7B1518]/10 text-[#7B1518]">
                                {{ $item->books_count ?? $item->books()->count() }} buku
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.kategori.edit', $item) }}" 
                                    class="p-2 rounded-lg text-[#6b5a54] hover:text-[#7B1518] hover:bg-[#7B1518]/5 transition"
                                    title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button onclick="confirmDelete({{ $item->id }}, '{{ $item->nama }}')"
                                    class="p-2 rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition"
                                    title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.kategori.destroy', $item) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-[#9a8a80] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                                </svg>
                                <p class="text-[#2C1810] font-medium text-lg">Belum ada kategori</p>
                                <p class="text-[#9a8a80] text-sm mt-1">Klik "Tambah Kategori" untuk menambahkan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($kategori->hasPages())
        <div class="px-6 py-4 border-t border-[#7B1518]/10">
            {{ $kategori->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id, nama) {
            Swal.fire({
                title: 'Hapus Kategori?',
                html: `Anda akan menghapus kategori "<strong>${nama}</strong>".<br>Buku dengan kategori ini akan menjadi tanpa kategori.`,
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