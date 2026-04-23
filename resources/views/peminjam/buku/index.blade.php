{{-- resources/views/peminjam/buku/index.blade.php --}}
<x-layout-peminjam>
    <x-slot name="title">Daftar Buku</x-slot>
    
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#4A1C1C] brand">Daftar Buku</h1>
        <p class="text-[#8B3A3A] text-sm sm:text-base mt-1 font-medium">Cari dan pinjam buku yang tersedia</p>
    </div>

    {{-- Pencarian & Filter --}}
    <div class="mb-6">
        <form method="GET" class="flex flex-col sm:flex-row flex-wrap gap-3">
            <div class="flex-1 min-w-[200px] relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" 
                    placeholder="Cari judul, pengarang, atau penerbit..." 
                    class="w-full pl-10 pr-4 py-3 bg-white border-2 border-[#C75B39]/30 rounded-xl text-sm text-[#4A1C1C] placeholder-[#8B3A3A]/60 focus:outline-none focus:border-[#C75B39] transition font-medium">
            </div>
            
            <select name="kategori" class="px-4 py-3 bg-white border-2 border-[#C75B39]/30 rounded-xl text-sm text-[#4A1C1C] focus:outline-none focus:border-[#C75B39] min-w-[150px] font-medium">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Kategori::orderBy('nama')->get() as $kat)
                    <option value="{{ $kat->id }}" {{ request('kategori') == $kat->id ? 'selected' : '' }}>
                        {{ $kat->nama }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="px-6 py-3 bg-[#C75B39] border-2 border-[#C75B39] rounded-xl text-sm text-white font-bold hover:bg-[#8B3A3A] hover:border-[#8B3A3A] transition shadow-md">
                Cari
            </button>
            @if(request('cari') || request('kategori'))
            <a href="{{ route('peminjam.buku.index') }}" class="px-4 py-3 text-sm font-bold text-[#8B3A3A] hover:text-[#C75B39] transition inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Daftar Buku dengan DataTable --}}
    <div x-data="dataTable()" class="space-y-6">
        {{-- Info & Per Page --}}
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div class="text-sm font-medium text-[#4A1C1C]">
                Menampilkan <span x-text="filteredData().length" class="font-bold text-[#C75B39]"></span> dari <span x-text="data.length" class="font-bold"></span> buku
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm font-medium text-[#8B3A3A]">Tampilkan</label>
                <select x-model="perPage" @change="currentPage = 1" class="px-3 py-1.5 bg-white border-2 border-[#C75B39]/30 rounded-lg text-sm font-medium text-[#4A1C1C] focus:outline-none focus:border-[#C75B39]">
                    <option value="12">12</option>
                    <option value="24">24</option>
                    <option value="48">48</option>
                </select>
            </div>
        </div>

        {{-- Grid Buku --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            <template x-for="item in paginatedData()" :key="item.id">
                <div class="bg-white border-2 border-[#C75B39]/30 rounded-xl overflow-hidden hover:border-[#C75B39] hover:shadow-lg transition-all group flex flex-col">
                    {{-- Foto Buku dengan Badge Status --}}
                    <a :href="'/peminjam/buku/' + item.id" class="block relative">
                        <div class="aspect-[3/4] bg-gradient-to-br from-[#FFF5E8] to-[#F5CDA7] flex items-center justify-center">
                            <template x-if="item.foto">
                                <img :src="'/storage/' + item.foto" :alt="item.judul" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!item.foto">
                                <svg class="w-12 h-12 text-[#C75B39]/40 group-hover:text-[#C75B39] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                                </svg>
                            </template>
                        </div>
                        {{-- Badge Status di Foto --}}
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-green-500 text-white shadow-lg">Tersedia</span>
                        </div>
                    </a>
                    
                    {{-- Info Buku --}}
                    <div class="p-3 flex-1 flex flex-col">
                        {{-- Kategori --}}
                        <template x-if="item.kategori">
                            <span class="text-[10px] text-[#C75B39] uppercase tracking-wider mb-1 font-bold" x-text="item.kategori.nama"></span>
                        </template>
                        <template x-if="!item.kategori">
                            <span class="text-[10px] text-[#8B3A3A]/50 uppercase tracking-wider mb-1">-</span>
                        </template>
                        
                        {{-- Judul - FIX: ganti text-white ke text-[#4A1C1C] --}}
                        <a :href="'/peminjam/buku/' + item.id" class="block">
                            <h3 class="text-[#4A1C1C] font-bold text-sm leading-tight line-clamp-2 group-hover:text-[#C75B39] transition" x-text="item.judul"></h3>
                        </a>
                        
                        {{-- Pengarang --}}
                        <p class="text-[#8B3A3A] text-xs mt-1 line-clamp-1 font-medium" x-text="item.pengarang"></p>
                        
                        {{-- Info Tambahan --}}
                        <div class="mt-2 pt-2 border-t-2 border-[#C75B39]/10 flex items-center justify-between">
                            <span class="text-[#8B3A3A] text-[10px] font-medium truncate max-w-[100px]" x-text="item.penerbit"></span>
                            <span class="text-[#8B3A3A] text-[10px] font-medium">
                                <span class="font-bold text-[#C75B39]" x-text="item.stok"></span> buku
                            </span>
                        </div>
                        
                        {{-- Button Detail - FIX: ganti warna --}}
                        <a :href="'/peminjam/buku/' + item.id" 
                            class="mt-3 w-full px-3 py-2 bg-[#FFF5E8] border-2 border-[#C75B39] rounded-lg text-[#C75B39] text-xs font-bold hover:bg-[#C75B39] hover:text-white transition text-center flex items-center justify-center gap-1.5">
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
                <div class="bg-white border-2 border-[#C75B39]/30 rounded-2xl p-8 sm:p-12 text-center shadow-md">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-[#FFF5E8] border-2 border-[#C75B39]/30 flex items-center justify-center">
                        <svg class="w-10 h-10 text-[#C75B39]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                        </svg>
                    </div>
                    <p class="text-[#4A1C1C] text-lg font-bold mb-2">Tidak ada buku ditemukan</p>
                    <p class="text-[#8B3A3A] text-sm font-medium">Coba ubah kata kunci atau filter kategori</p>
                </div>
            </div>
        </div>

        {{-- Pagination --}}
        <div x-show="totalPages() > 1" class="flex flex-col sm:flex-row items-center justify-between flex-wrap gap-3 pt-4 border-t-2 border-[#C75B39]/20">
            <div class="text-sm font-medium text-[#8B3A3A]">
                Halaman <span x-text="currentPage" class="font-bold text-[#C75B39]"></span> dari <span x-text="totalPages()" class="font-bold"></span>
            </div>
            <div class="flex items-center gap-2">
                <button @click="currentPage = 1" :disabled="currentPage === 1"
                    class="px-3 py-1.5 text-sm rounded-lg border-2 border-[#C75B39]/30 text-[#8B3A3A] font-bold hover:bg-[#C75B39]/10 hover:text-[#C75B39] disabled:opacity-40 disabled:cursor-not-allowed transition">
                    «
                </button>
                <button @click="currentPage--" :disabled="currentPage === 1"
                    class="px-3 py-1.5 text-sm rounded-lg border-2 border-[#C75B39]/30 text-[#8B3A3A] font-bold hover:bg-[#C75B39]/10 hover:text-[#C75B39] disabled:opacity-40 disabled:cursor-not-allowed transition">
                    ‹
                </button>
                
                <template x-for="page in visiblePages()" :key="page">
                    <button @click="currentPage = page" 
                        :class="currentPage === page ? 'bg-[#C75B39] text-white border-[#C75B39]' : 'border-[#C75B39]/30 text-[#8B3A3A] hover:bg-[#C75B39]/10 hover:text-[#C75B39]'"
                        class="px-3 py-1.5 text-sm rounded-lg border-2 font-bold transition" x-text="page">
                    </button>
                </template>
                
                <button @click="currentPage++" :disabled="currentPage === totalPages()"
                    class="px-3 py-1.5 text-sm rounded-lg border-2 border-[#C75B39]/30 text-[#8B3A3A] font-bold hover:bg-[#C75B39]/10 hover:text-[#C75B39] disabled:opacity-40 disabled:cursor-not-allowed transition">
                    ›
                </button>
                <button @click="currentPage = totalPages()" :disabled="currentPage === totalPages()"
                    class="px-3 py-1.5 text-sm rounded-lg border-2 border-[#C75B39]/30 text-[#8B3A3A] font-bold hover:bg-[#C75B39]/10 hover:text-[#C75B39] disabled:opacity-40 disabled:cursor-not-allowed transition">
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