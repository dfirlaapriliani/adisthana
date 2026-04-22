<x-layout-peminjam>
    <x-slot name="title">Daftar Buku</x-slot>
    
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-white" style="font-family: 'Cormorant Garamond', serif;">Daftar Buku</h1>
        <p class="text-[#5a5a65] text-sm mt-1">Cari dan pinjam buku yang tersedia</p>
    </div>

    {{-- Pencarian & Filter --}}
    <div class="mb-6">
        <form method="GET" class="flex flex-wrap gap-3">
            <div class="flex-1 min-w-[200px] relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#5a5a65]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" 
                    placeholder="Cari judul, pengarang, atau penerbit..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-[#111114] border border-white/[0.08] rounded-xl text-sm text-white placeholder-[#5a5a65] focus:outline-none focus:border-[#d4af6a]/50 transition">
            </div>
            
            <select name="kategori" class="px-4 py-2.5 bg-[#111114] border border-white/[0.08] rounded-xl text-sm text-white focus:outline-none focus:border-[#d4af6a]/50 min-w-[150px]">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Kategori::orderBy('nama')->get() as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="px-4 py-2.5 bg-[#111114] border border-white/[0.08] rounded-xl text-sm text-white hover:border-[#d4af6a]/50 transition">
                Cari
            </button>
            @if(request('cari') || request('kategori'))
            <a href="{{ route('peminjam.buku.index') }}" class="px-4 py-2.5 text-sm text-[#5a5a65] hover:text-white transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Daftar Buku dengan DataTable --}}
    <div x-data="dataTable()" class="space-y-6">
        {{-- Info & Per Page --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="text-sm text-[#5a5a65]">
                Menampilkan <span x-text="filteredData().length"></span> dari <span x-text="data.length"></span> buku
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-[#5a5a65]">Tampilkan</label>
                <select x-model="perPage" @change="currentPage = 1" class="px-2 py-1 bg-[#111114] border border-white/[0.08] rounded-lg text-sm text-white">
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                </select>
            </div>
        </div>

        {{-- Grid Buku --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <template x-for="item in paginatedData()" :key="item.id">
                <div class="bg-[#111114] border border-white/[0.08] rounded-xl overflow-hidden hover:border-[#d4af6a]/40 transition-all group flex flex-col">
                    {{-- Foto Buku dengan Badge Status --}}
                    <a :href="'/peminjam/buku/' + item.id" class="block relative">
                        <div class="aspect-[3/4] bg-gradient-to-br from-[#1a1a1f] to-[#0e0e10] flex items-center justify-center">
                            <template x-if="item.foto">
                                <img :src="'/storage/' + item.foto" :alt="item.judul" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!item.foto">
                                <svg class="w-12 h-12 text-[#3d3d45] group-hover:text-[#d4af6a] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                </svg>
                            </template>
                        </div>
                        {{-- Badge Status di Foto --}}
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-0.5 text-[10px] font-medium rounded-full bg-green-500 text-white shadow-lg">Tersedia</span>
                        </div>
                    </a>
                    
                    {{-- Info Buku --}}
                    <div class="p-3 flex-1 flex flex-col">
                        {{-- Kategori --}}
                        <template x-if="item.kategori">
                            <span class="text-[10px] text-[#d4af6a] uppercase tracking-wider mb-1" x-text="item.kategori.nama"></span>
                        </template>
                        <template x-if="!item.kategori">
                            <span class="text-[10px] text-[#5a5a65] uppercase tracking-wider mb-1">-</span>
                        </template>
                        
                        {{-- Judul --}}
                        <a :href="'/peminjam/buku/' + item.id" class="block">
                            <h3 class="text-white font-medium text-sm leading-tight line-clamp-2 group-hover:text-[#d4af6a] transition" x-text="item.judul"></h3>
                        </a>
                        
                        {{-- Pengarang --}}
                        <p class="text-[#8a8a95] text-xs mt-1 line-clamp-1" x-text="item.pengarang"></p>
                        
                        {{-- Info Tambahan --}}
                        <div class="mt-2 pt-2 border-t border-white/[0.05] flex items-center justify-between">
                            <span class="text-[#5a5a65] text-[10px]" x-text="item.penerbit"></span>
                            <span class="text-[#5a5a65] text-[10px]">Stok: <span x-text="item.stok"></span></span>
                        </div>
                        
                        {{-- Button Detail --}}
                        <a :href="'/peminjam/buku/' + item.id" 
                            class="mt-3 w-full px-3 py-2 bg-white/[0.03] border border-white/[0.08] rounded-lg text-[#c0c0c5] text-xs font-medium hover:bg-[#d4af6a] hover:text-[#0e0e10] hover:border-[#d4af6a] transition text-center flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </template>
            
            {{-- Empty State --}}
            <div x-show="filteredData().length === 0" class="col-span-full">
                <div class="bg-[#111114] border border-white/[0.08] rounded-2xl p-12 text-center">
                    <svg class="w-20 h-20 text-[#3d3d45] mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                    </svg>
                    <p class="text-[#8a8a95] text-lg mb-2">Tidak ada buku ditemukan</p>
                    <p class="text-[#5a5a65] text-sm">Coba ubah kata kunci atau filter kategori</p>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div x-show="totalPages() > 1" class="flex items-center justify-between flex-wrap gap-3 pt-4 border-t border-white/[0.05]">
            <div class="text-sm text-[#5a5a65]">
                Halaman <span x-text="currentPage"></span> dari <span x-text="totalPages()"></span>
            </div>
            <div class="flex items-center gap-2">
                <button @click="currentPage = 1" :disabled="currentPage === 1"
                    class="px-3 py-1.5 text-sm rounded-lg border border-white/[0.08] text-[#8a8a95] hover:bg-white/[0.05] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed transition">
                    «
                </button>
                <button @click="currentPage--" :disabled="currentPage === 1"
                    class="px-3 py-1.5 text-sm rounded-lg border border-white/[0.08] text-[#8a8a95] hover:bg-white/[0.05] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed transition">
                    ‹
                </button>
                
                <template x-for="page in visiblePages()" :key="page">
                    <button @click="currentPage = page" 
                        :class="currentPage === page ? 'bg-[#d4af6a] text-[#0e0e10] border-[#d4af6a]' : 'border-white/[0.08] text-[#8a8a95] hover:bg-white/[0.05] hover:text-white'"
                        class="px-3 py-1.5 text-sm rounded-lg border transition" x-text="page">
                    </button>
                </template>
                
                <button @click="currentPage++" :disabled="currentPage === totalPages()"
                    class="px-3 py-1.5 text-sm rounded-lg border border-white/[0.08] text-[#8a8a95] hover:bg-white/[0.05] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed transition">
                    ›
                </button>
                <button @click="currentPage = totalPages()" :disabled="currentPage === totalPages()"
                    class="px-3 py-1.5 text-sm rounded-lg border border-white/[0.08] text-[#8a8a95] hover:bg-white/[0.05] hover:text-white disabled:opacity-50 disabled:cursor-not-allowed transition">
                    »
                </button>
            </div>
        </div>
    </div>

    <script>
        const serverData = @json($buku->items());
        
        function dataTable() {
            return {
                data: serverData,
                search: '{{ request('cari') }}',
                perPage: 12,
                currentPage: 1,
                
                filteredData() {
                    let filtered = this.data;
                    
                    if (this.search) {
                        const searchLower = this.search.toLowerCase();
                        filtered = filtered.filter(item => 
                            item.judul.toLowerCase().includes(searchLower) ||
                            item.pengarang.toLowerCase().includes(searchLower) ||
                            item.penerbit.toLowerCase().includes(searchLower)
                        );
                    }
                    
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
                }
            }
        }
    </script>
</x-layout-peminjam>