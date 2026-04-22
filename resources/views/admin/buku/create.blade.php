<x-layout-admin>
    <x-slot name="title">Tambah Buku</x-slot>
    
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-[#2C1810]" style="font-family: 'Cormorant Garamond', serif;">Tambah Buku</h1>
        <p class="text-[#9a8a80] text-sm mt-1">Tambahkan buku baru ke perpustakaan</p>
    </div>

    <div class="bg-white rounded-2xl border border-[#7B1518]/10 shadow-sm p-6">
        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Judul --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Judul Buku <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                        placeholder="Masukkan judul buku"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('judul') border-red-300 @enderror">
                    @error('judul')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pengarang --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Pengarang <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="pengarang" value="{{ old('pengarang') }}" required
                        placeholder="Nama pengarang"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('pengarang') border-red-300 @enderror">
                    @error('pengarang')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Penerbit --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Penerbit <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" required
                        placeholder="Nama penerbit"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('penerbit') border-red-300 @enderror">
                    @error('penerbit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
                </div>

                {{-- Tahun Terbit --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Tahun Terbit <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required
                        placeholder="Contoh: 2023"
                        min="1900" max="{{ date('Y') }}"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('tahun_terbit') border-red-300 @enderror">
                    @error('tahun_terbit')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Stok <span class="text-[#7B1518]">*</span>
                    </label>
                    <input type="number" name="stok" value="{{ old('stok', 1) }}" required
                        min="1"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('stok') border-red-300 @enderror">
                    @error('stok')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto --}}
                <div x-data="{ preview: null }">
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Foto Buku
                    </label>
                    
                    {{-- Preview Thumbnail --}}
                    <div class="mb-3" x-show="preview">
                        <p class="text-xs text-[#9a8a80] mb-2">Pratinjau:</p>
                        <div class="w-32 h-32 rounded-xl border-2 border-dashed border-[#7B1518]/20 overflow-hidden bg-[#F0EBE3] flex items-center justify-center">
                            <img :src="preview" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    </div>
                    
                    {{-- Input File --}}
                    <input type="file" name="foto" accept="image/*"
                        @change="preview = URL.createObjectURL($event.target.files[0])"
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('foto') border-red-300 @enderror">
                    <p class="text-xs text-[#9a8a80] mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-[#2C1810] mb-1.5">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" rows="4"
                        placeholder="Deskripsi singkat tentang buku..."
                        class="w-full px-4 py-2.5 bg-white border border-[#7B1518]/20 rounded-xl text-sm focus:outline-none focus:border-[#7B1518] transition @error('deskripsi') border-red-300 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-[#7B1518]/10">
                <a href="{{ route('admin.buku.index') }}" 
                    class="px-4 py-2.5 text-sm text-[#6b5a54] hover:text-[#2C1810] transition">
                    Batal
                </a>
                <button type="submit" 
                    class="px-6 py-2.5 bg-[#7B1518] text-white rounded-xl text-sm font-medium hover:bg-[#5a0f12] transition shadow-sm">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</x-layout-admin>