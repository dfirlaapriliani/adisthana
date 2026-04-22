<x-layout-admin>
    <x-slot name="title">Daftar Buku</x-slot>
    
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Daftar Buku</h1>
            <p class="text-[#9a8a80] text-sm mt-1">Kelola koleksi buku perpustakaan</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" 
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Buku
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

    {{-- Pencarian & Filter --}}
    <div class="mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px] relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" 
                    placeholder="Cari judul, pengarang, atau penerbit..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
            </div>
            
            {{-- Filter Kategori --}}
            <select name="kategori" class="px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] min-w-[150px]">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Kategori::orderBy('nama')->get() as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>
            
            {{-- Filter Status --}}
            <select name="status" class="px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] min-w-[130px]">
                <option value="">Semua Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Kosong</option>
            </select>
            
            <button type="submit" 
                class="px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm text-[#2C1810] hover:bg-[#F0EBE3] transition">
                Cari
            </button>
            @if(request('cari') || request('kategori') || request('status'))
            <a href="{{ route('admin.buku.index') }}" 
                class="px-4 py-2.5 text-sm text-[#9a8a80] hover:text-[#2C1810] transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Tabel Buku dengan DataTable --}}
    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm overflow-hidden" x-data="dataTable()">
        {{-- Info & Per Page --}}
        <div class="px-6 py-3 border-b border-[#7B1518]/10 flex items-center justify-between flex-wrap gap-3">
            <div class="text-sm text-[#9a8a80]">
                Menampilkan <span x-text="filteredData().length"></span> dari {{ $buku->total() }} data
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-[#9a8a80]">Tampilkan</label>
                <select x-model="perPage" @change="currentPage = 1" class="px-2 py-1 bg-white border border-[#7B1518]/20 rounded-lg text-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-[#9a8a80]">data</span>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#F0EBE3]/50 border-b border-[#7B1518]/10">
                    <tr class="text-left">
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Foto</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider cursor-pointer hover:text-[#7B1518]" @click="sort('judul')">
                            Judul 
                            <span x-show="sortField === 'judul'" x-text="sortDirection === 'asc' ? '↑' : '↓'"></span>
                        </th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Pengarang</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Penerbit</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Tahun</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider cursor-pointer hover:text-[#7B1518]" @click="sort('stok')">
                            Stok
                            <span x-show="sortField === 'stok'" x-text="sortDirection === 'asc' ? '↑' : '↓'"></span>
                        </th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-medium text-[#9a8a80] uppercase tracking-wider"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#7B1518]/5">
                    <template x-for="item in paginatedData()" :key="item.id">
                        <tr class="hover:bg-[#F0EBE3]/30 transition">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-lg bg-[#F0EBE3] flex items-center justify-center overflow-hidden">
                                    <template x-if="item.foto">
                                        <img :src="'/storage/' + item.foto" :alt="item.judul" class="w-full h-full object-cover">
                                    </template>
                                    <template x-if="!item.foto">
                                        <svg class="w-6 h-6 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                        </svg>
                                    </template>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-[#2C1810]" x-text="item.judul.length > 30 ? item.judul.substring(0,30) + '...' : item.judul"></p>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#2C1810]" x-text="item.pengarang"></td>
                            <td class="px-6 py-4 text-sm text-[#2C1810]" x-text="item.penerbit"></td>
                            <td class="px-6 py-4">
                                <template x-if="item.kategori">
                                    <span class="px-2 py-1 text-xs rounded-full bg-[#7B1518]/10 text-[#7B1518]" x-text="item.kategori.nama"></span>
                                </template>
                                <template x-if="!item.kategori">
                                    <span class="text-xs text-[#9a8a80]">-</span>
                                </template>
                            </td>
                            <td class="px-6 py-4 text-sm text-[#2C1810]" x-text="item.tahun_terbit"></td>
                            <td class="px-6 py-4 text-sm text-[#2C1810]" x-text="item.stok"></td>
                            <td class="px-6 py-4">
                                <template x-if="item.status === 'available'">
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">Tersedia</span>
                                </template>
                                <template x-if="item.status === 'unavailable'">
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">Kosong</span>
                                </template>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a :href="'/admin/buku/' + item.id" 
                                        class="p-2 rounded-lg text-[#6b5a54] hover:text-[#7B1518] hover:bg-[#7B1518]/5 transition"
                                        title="Lihat">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a :href="'/admin/buku/' + item.id + '/edit'" 
                                        class="p-2 rounded-lg text-[#6b5a54] hover:text-[#7B1518] hover:bg-[#7B1518]/5 transition"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button @click="confirmDelete(item.id, item.judul)"
                                        class="p-2 rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 transition"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="filteredData().length === 0">
                        <td colspan="9" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-16 h-16 text-[#9a8a80] mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                </svg>
                                <p class="text-[#2C1810] font-medium text-lg">Tidak ada data</p>
                                <p class="text-[#9a8a80] text-sm mt-1">Coba ubah filter atau kata kunci pencarian</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-[#7B1518]/10 flex items-center justify-between flex-wrap gap-3">
            <div class="text-sm text-[#9a8a80]">
                Halaman <span x-text="currentPage"></span> dari <span x-text="totalPages()"></span>
            </div>
            <div class="flex items-center gap-2">
                <button @click="currentPage = 1" :disabled="currentPage === 1"
                    class="px-3 py-1.5 text-sm rounded-lg border border-[#7B1518]/20 hover:bg-[#F0EBE3] disabled:opacity-50 disabled:cursor-not-allowed transition">
                    «
                </button>
                <button @click="currentPage--" :disabled="currentPage === 1"
                    class="px-3 py-1.5 text-sm rounded-lg border border-[#7B1518]/20 hover:bg-[#F0EBE3] disabled:opacity-50 disabled:cursor-not-allowed transition">
                    ‹
                </button>
                
                <template x-for="page in visiblePages()" :key="page">
                    <button @click="currentPage = page" 
                        :class="currentPage === page ? 'bg-[#7B1518] text-white border-[#7B1518]' : 'border-[#7B1518]/20 hover:bg-[#F0EBE3]'"
                        class="px-3 py-1.5 text-sm rounded-lg border transition" x-text="page">
                    </button>
                </template>
                
                <button @click="currentPage++" :disabled="currentPage === totalPages()"
                    class="px-3 py-1.5 text-sm rounded-lg border border-[#7B1518]/20 hover:bg-[#F0EBE3] disabled:opacity-50 disabled:cursor-not-allowed transition">
                    ›
                </button>
                <button @click="currentPage = totalPages()" :disabled="currentPage === totalPages()"
                    class="px-3 py-1.5 text-sm rounded-lg border border-[#7B1518]/20 hover:bg-[#F0EBE3] disabled:opacity-50 disabled:cursor-not-allowed transition">
                    »
                </button>
            </div>
        </div>
    </div>

    {{-- Form Delete Tersembunyi --}}
    <form id="delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Data dari server
        const serverData = @json($buku->items());
        
        function dataTable() {
            return {
                data: serverData,
                search: '{{ request('cari') }}',
                perPage: 10,
                currentPage: 1,
                sortField: 'judul',
                sortDirection: 'asc',
                
                filteredData() {
                    let filtered = this.data;
                    
                    // Filter by search
                    if (this.search) {
                        const searchLower = this.search.toLowerCase();
                        filtered = filtered.filter(item => 
                            item.judul.toLowerCase().includes(searchLower) ||
                            item.pengarang.toLowerCase().includes(searchLower) ||
                            item.penerbit.toLowerCase().includes(searchLower)
                        );
                    }
                    
                    // Sort
                    filtered = [...filtered].sort((a, b) => {
                        let aVal = a[this.sortField];
                        let bVal = b[this.sortField];
                        
                        if (this.sortField === 'kategori') {
                            aVal = a.kategori?.nama || '';
                            bVal = b.kategori?.nama || '';
                        }
                        
                        if (typeof aVal === 'string') {
                            return this.sortDirection === 'asc' 
                                ? aVal.localeCompare(bVal)
                                : bVal.localeCompare(aVal);
                        } else {
                            return this.sortDirection === 'asc' 
                                ? aVal - bVal
                                : bVal - aVal;
                        }
                    });
                    
                    return filtered;
                },
                
                paginatedData() {
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    return this.filteredData().slice(start, end);
                },
                
                totalPages() {
                    return Math.ceil(this.filteredData().length / this.perPage) || 1;
                },
                
                visiblePages() {
                    const total = this.totalPages();
                    const current = this.currentPage;
                    const delta = 2;
                    const range = [];
                    
                    for (let i = Math.max(2, current - delta); i <= Math.min(total - 1, current + delta); i++) {
                        range.push(i);
                    }
                    
                    if (current - delta > 2) range.unshift('...');
                    if (current + delta < total - 1) range.push('...');
                    
                    range.unshift(1);
                    if (total > 1) range.push(total);
                    
                    return range.filter((v, i, a) => a.indexOf(v) === i);
                },
                
                sort(field) {
                    if (this.sortField === field) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortField = field;
                        this.sortDirection = 'asc';
                    }
                },
                
                confirmDelete(id, judul) {
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
                            const form = document.getElementById('delete-form');
                            form.action = `/admin/buku/${id}`;
                            form.submit();
                        }
                    });
                }
            }
        }
    </script>
</x-layout-admin>