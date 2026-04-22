<x-layout-admin>
    <x-slot name="title">Edit Buku</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Edit Buku</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Perbarui informasi buku</p>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm p-6">
        <form action="{{ route('admin.buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Judul Buku <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                </div>

                {{-- Pengarang --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Pengarang <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="pengarang" value="{{ old('pengarang', $buku->pengarang) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                </div>

                {{-- Penerbit --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Penerbit <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                </div>

                {{-- Kategori --}}
<div>
    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
        Kategori
    </label>
    <select name="kategori_id" 
        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
        <option value="">-- Pilih Kategori --</option>
        @foreach(\App\Models\Kategori::orderBy('nama')->get() as $kat)
            <option value="{{ $kat->id }}" {{ old('kategori_id', $buku->kategori_id ?? '') == $kat->id ? 'selected' : '' }}>
                {{ $kat->nama }}
            </option>
        @endforeach
    </select>
</div>>

                {{-- Tahun Terbit --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Tahun Terbit <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}" required
                        min="1900" max="{{ date('Y') }}"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Stok <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}" required
                        min="0"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                </div>

                {{-- Foto Saat Ini --}}
                <div x-data="{ preview: null, showPreview: false }">
                {{-- Foto Saat Ini --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">Foto Saat Ini</label>
                    <div class="w-32 h-32 rounded-xl border-2 border-[#7B1518]/10 overflow-hidden bg-[#F0EBE3] flex items-center justify-center">
                        @if($buku->foto)
                            <img src="{{ asset('storage/' . $buku->foto) }}" alt="{{ $buku->judul }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-10 h-10 text-[#9a8a80]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
                            </svg>
                        @endif
                    </div>
                </div>

                {{-- Preview Foto Baru --}}
                <div class="mb-3" x-show="preview">
                    <p class="text-xs text-[#9a8a80] mb-2">Pratinjau Foto Baru:</p>
                    <div class="w-32 h-32 rounded-xl border-2 border-dashed border-green-500/30 overflow-hidden bg-[#F0EBE3] flex items-center justify-center">
                        <img :src="preview" alt="Preview" class="w-full h-full object-cover">
                    </div>
                </div>

                {{-- Upload Foto Baru --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Ganti Foto
                    </label>
                    <input type="file" name="foto" accept="image/*"
                        @change="preview = URL.createObjectURL($event.target.files[0])"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">
                    <p class="text-xs text-[#9a8a80] mt-1">Kosongkan jika tidak ingin mengganti foto</p>
                </div>
            </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" rows="4"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-[#7B1518]/10">
                <a href="{{ route('admin.buku.index') }}" 
                    class="px-4 py-2.5 text-sm text-[#6b5a54] hover:text-[#2C1810] transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
                    Perbarui Buku
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>